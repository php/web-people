<?php

function findKarma($username)
{
    $karma = fetchKarma();
    if ($karma === FALSE) {
        return false;
    }

    $mykarma = $karma[$username];
    $retval = array(
        "avail"   => $mykarma["avail"],
        "unavail" => $mykarma["unavail"],
    );
    return $retval;
}

function fetchKarma()
{
    $ctx = stream_context_create(array("http" => array("ignore_errors" => true)));
    $content = cached("https://svn.php.net/repository/SVNROOT/global_avail", false, $ctx);
    $phpKarma = parseKarma(explode("\n", $content));

    $ctx = stream_context_create(array("http" => array("ignore_errors" => true)));
    $content = cached("https://svn.php.net/repository/SVNROOT/pear_avail", false, $ctx);
    $pearKarma = parseKarma(explode("\n", $content));

    $allKarma = $phpKarma;
    foreach ($pearKarma as $user => $userKarma) {
        if (!array_key_exists($user, $allKarma)) {
            $allKarma[$user] = $userKarma;
        } else {
            foreach (array('avail', 'unavail') as $type) {
                $allKarma[$user][$type] = array_merge($allKarma[$user][$type], $userKarma[$type]);
            }
        }
    }

    return $allKarma;
}

function parseKarma(array $avail_lines)
{
    $users = array();

    // First pass, build array of rules
    foreach ($avail_lines as $key => $acl_line) {
        $acl_line = trim($acl_line);
        if ('' === $acl_line || '#' === $acl_line{0}) {
            continue;
        }
        list($avail_str, $user_str, $path_str) = explode("|", $acl_line, 3) + array("", "", "");
        if (!in_array($avail_str, array("avail", "unavail"))) {
            continue;
        }
        if (empty($path_str)) {
            $curr_paths = array("*");
        } else {
            $curr_paths = explode(",", $path_str);
        }
        if (empty($user_str)) {
            $curr_users = null;
        } else {
            $curr_users = explode(",", $user_str);
            // Start populating the users array
            foreach ($curr_users as $user) {
                $users[$user] = array();
            }
        }
        $avail_lines[$key] = array($avail_str, $curr_users, $curr_paths);
    }

    // Remove unwanted lines
    $avail_lines = array_filter($avail_lines, "is_array");

    // We will use this later
    $all_users = array_keys($users);

    // Second pass, assemble user karma
    foreach ($avail_lines as $key => $acl_line) {
        list($curr_avail, $curr_users, $curr_paths) = $acl_line;
        if (empty($curr_users)) {
            $curr_users = $all_users;
        }
        foreach ($curr_users as $user) {
            foreach ($curr_paths as $path) {
                $users[$user][$curr_avail][$path] = $path;
                // If this path exists in the other avail type then nuke it
                $other_avail = ($curr_avail === 'avail' ? 'unavail' : 'avail');
                if (isset($users[$user][$other_avail][$path])) {
                    unset($users[$user][$other_avail][$path]);
                }
            }
        }
    }

    // Sort by username, ascending
    ksort($users);

    return $users;
}

function formatKarma($karma)
{
    $lines = array();
    foreach ($karma["avail"] as $avail) {
        $line = $avail;
        $unavails = preg_grep("/^".preg_quote($avail, "/")."/", $karma["unavail"]);
        $unavails = preg_replace("/^".preg_quote($avail, "/")."/", "…", $unavails);
        if ($unavails) {
            $line .= " (excluding ";
            $line .= implode(", ", $unavails);
            $line .= ")";
        }
        $lines[] = $line;
    }
    // Remove sub-paths (e.g php-src.git/TSRM) if there is a
    // lower level path (e.g. php-src.git)
    foreach ($lines as $key => $line) {
        $lines = preg_grep("/^".preg_quote($line, "/")."./", $lines, PREG_GREP_INVERT);
    }
    natcasesort($lines);
    $lines = array_map("formatKarmaLinks", $lines);
    return $lines;
}

function formatKarmaLinks($line)
{
    @list($path, $extra) = explode(" ", $line, 2);
    // Git
    if (strpos($path, ".git") !== FALSE) {
        @list($repo, $subpath) = explode(".git", $path, 2);
        $url = "https://git.php.net/?p=".urlencode($repo.".git");
        if ($subpath != "") {
            // Remove wildcard patterns (fall back to one directory up)
            if (strpos($subpath, "*") !== FALSE) {
                $subpath = preg_replace("#[^/]*\*.*#", "", $subpath);
            }
            $url .= ";a=tree;f=".urlencode(trim($subpath, "/"));
        }
    // SVN
    } else {
        // PHP Group members, such as Rasmus, got access to everything. This
        // check prevents broken links to /viewvc/*
        if ($path === '*') {
            return '<strong>This user has karma for everything!</strong>';
        }

        $url = "https://svn.php.net/viewvc/".strtr($path, array("/*/" => "/trunk/"));

    }
    $line = sprintf('<a href="%s" title="%s %s">%s</a>', $url, $path, $extra, $path);
    return $line;
}
