<?php
/* $Id$ */

function getDOMNodeFrom($url, $nodename)
{
    $dom = new DOMDocument;
    $dom->preserveWhiteSpace = false;
    if (@!$dom->load($url)) {
        return;
    }
    $search = $dom->getElementsByTagName($nodename);
    if ($search->length < 1) {
        return;
    }
    return $search->item(0);
}

function findPHPUser($username)
{
    $opts = array("ignore_errors" => true);
    $ctx = stream_context_create(array("http" => $opts));
    $token = getenv("TOKEN");
    if (!$token) {
        $token = trim(file_get_contents("token"));
    }
    $retval = @file_get_contents("https://master.php.net/fetch/user.php?username=" . $username . "&token=" . rawurlencode($token), false, $ctx);
    if (!$retval) {
        if (isset($http_response_header) && $http_response_header) {
            list($protocol, $errcode, $errmsg) = explode(" ", $http_response_header[0], 3);
        } else {
            $error   = error_get_last();
            // Remove the function name, arguments and all that stuff... we 
            // really only care about whatever comes after the last colon
            $message = explode(":", $error["message"]);
            $errmsg  = array_pop($message);
        }
        error($errmsg);
    }
    $json = json_decode($retval, true);
    if (!is_array($json)) {
        error("Something happend to master");
    }
    if (isset($json["error"])) {
        error($json["error"]);
    }
    return $json;
}

function findGitHubUser($fullname)
{
    // Hiding this for now, since nothing here can be trusted as real. Names are not unique. :)
    // Possible todo: Allow users to customize this via master/people.
    return false;
    $username = getDOMNodeFrom("http://github.com/api/v2/xml/user/search/" . urlencode($fullname), "username");
    if (!$username) {
        return;
    }

    $content = file_get_contents("http://github.com/api/v2/xml/user/show/" . $username->nodeValue);

    $r = new XMLReader;
    $r->XML($content);

    $retval = array();
    while($r->read()) {
        if ($r->nodeType == XMLReader::ELEMENT) {
            $key = $r->name;
        } elseif ($r->nodeType == XMLReader::TEXT) {
            $retval[$key] = $r->value;
        }
    }
    return $retval;
}

function findPEARUser($username)
{
    $geo = getDOMNodeFrom("http://pear.php.net/map/locationREST.php?handle=" . $username, "based_near");
    if (!$geo) {
        return;
    }
    return array(
        "lat"  => $geo->getAttribute("geo:lat"),
        "long" => $geo->getAttribute("geo:long"),
    );
}

function findPHPUserProfile($username)
{
    $opts = array("ignore_errors" => true);
    $ctx = stream_context_create(array("http" => $opts));
    $token = getenv("TOKEN");
    if (!$token) {
        $token = trim(file_get_contents("token"));
    }
    $retval = @file_get_contents("http://master.php.local/fetch/user-profile.php?username=" . $username . "&token=" . rawurlencode($token), false, $ctx);
    if (!$retval) {
        if (isset($http_response_header) && $http_response_header) {
            list($protocol, $errcode, $errmsg) = explode(" ", $http_response_header[0], 3);
        } else {
            $error   = error_get_last();
            // Remove the function name, arguments and all that stuff... we
            // really only care about whatever comes after the last colon
            $message = explode(":", $error["message"]);
            $errmsg  = array_pop($message);
        }
        error($errmsg);
    }
    $json = json_decode($retval, true);
    if (!is_array($json)) {
        error("Something happend to master");
    }
    if (isset($json["error"])) {
        error($json["error"]);
    }
    return $json["html"];
}

function error($errormsg)
{
    echo '<p class="warning error">', $errormsg, "</p>";
    site_footer();
    exit;
}

// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 : 

