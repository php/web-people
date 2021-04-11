<?php

function getDOMNodeFrom($url, $nodename)
{
    $content = cached($url);
    $dom = new DOMDocument;
    $dom->preserveWhiteSpace = false;
    if (@!$dom->loadXML($content)) {
        return;
    }
    $search = $dom->getElementsByTagName($nodename);
    if ($search->length < 1) {
        return;
    }
    return $search->item(0);
}

function fetchAllUsers() {
    $opts = array("ignore_errors" => true);
    $ctx = stream_context_create(array("http" => $opts));
    $token = getenv("TOKEN");
    if (!$token) {
        $token = trim(file_get_contents("token"));
    }
    $url = "https://main.php.net/fetch/allusers.php?token=" . rawurlencode($token);
    $retval = cached($url, $ctx, "-1 hour");
    $json = json_decode($retval, true);
    if (!is_array($json)) {
        error("Something happened to main");
    }
    if (isset($json["error"])) {
        error($json["error"]);
    }
    return $json;
}

function findAllUsers($page) {
    $json = fetchAllUsers();

    usort($json, function ($a, $b) {
        return strcmp($a["username"], $b["username"]);
    });

    $offset = ($page - 1) * 50;
    return array_slice($json, $offset, 50);
}

function findPHPUser($username)
{
    $json = fetchAllUsers();

    foreach($json as $k) {
        if ($k["username"] == $username) {
            return $k;
        }
    }
    error("No such user");
}

function cached($url, $ctx = null, $timeout = "-1 day")
{
    $tmpdir = sys_get_temp_dir();
    $user = sha1($url);

    $tmpfile = $tmpdir . "/" . $user;
    if (file_exists($tmpfile) && filemtime($tmpfile) > strtotime($timeout)) {
        return file_get_contents($tmpfile);
    }
    $content = file_get_contents($url, false, $ctx);
    if ($content) {
        file_put_contents($tmpfile, $content);
    }

    return $content;

}
function findPHPUserProfile($username)
{
    $opts = array("ignore_errors" => true);
    $ctx = stream_context_create(array("http" => $opts));
    $token = getenv("TOKEN");
    if (!$token) {
        $token = trim(file_get_contents("token"));
    }
    $retval = cached("https://main.php.net/fetch/user-profile.php?username=" . $username . "&token=" . rawurlencode($token), $ctx);
    if (!$retval) {
        $error   = error_get_last();
        // Remove the function name, arguments and all that stuff... we
        // really only care about whatever comes after the last colon
        $message = explode(":", $error["message"]);
        $errmsg  = array_pop($message);
        error($errmsg);
    }
    $json = json_decode($retval, true);
    if (!is_array($json)) {
        error("Something happend to main");
    }
    if (isset($json["error"])) {
        error($json["error"]);
    }
    return $json["html"];
}

function findAssignedBugs($username)
{
    $url = "https://bugs.php.net/rss/search.php?status=Open&cmd=display&assign=$username";
    $contents = cached($url);
    $sxe = simplexml_load_string($contents);
    $items = array();
    foreach($sxe->item as $item) {
        $items[] = array(
            "title" => $item->title,
            "link"  => $item->link,
        );
    }
    return $items;
}

function error($errormsg)
{
    echo '<p class="warning">', $errormsg, "</p></section>";
    site_footer();
    exit;
}

// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 :
