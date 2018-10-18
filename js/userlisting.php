<?php

function getAllUsers() {
    $opts = array("ignore_errors" => true);
    $ctx = stream_context_create(array("http" => $opts));
    $token = getenv("TOKEN");
    if (!$token) {
        $token = trim(file_get_contents("../token"));
    }
    $retval = file_get_contents("https://master.php.net/fetch/allusers.php?&token=" . rawurlencode($token), false, $ctx);
    if (!$retval) {
        return;
    }
    $json = json_decode($retval, true);
    if (!is_array($json)) {
        return;
    }
    if (isset($json["error"])) {
        return;
    }
    return $json;
}

$now = $_SERVER["REQUEST_TIME"];
if (isset($_SERVER["HTTP_IF_MODIFIED_SINCE"])) {
    $last = strtotime($_SERVER["HTTP_IF_MODIFIED_SINCE"]);

    /* Cache the user list for a week */
    if (strtotime("+1 week", $last) > $now) {
        header("HTTP/1.1 304 Not Modified");
        exit;
    }
}

$json = getAllUsers();

if (!$json) { return; }

$future = strtotime("+1 week", $now);
$tsstring = gmdate("D, d M Y H:i:s ", $now) . "GMT";

header("Last-Modified: " . $tsstring);
header("Expires: " . date(DATE_RSS, $future));
header("Content-Type: text/javascript");


$lookup = $user = array();

foreach($json as $row) {
    $lookup[] = $row["name"];
    $lookup[] = $row["username"];

    $data = array(
        "email"    => md5($row["username"] . "@php.net"),
        "name"     => $row["name"],
        "username" => $row["username"],
    );

    $user[$row["username"]] = $data;
    $user[$row["name"]]     = $data;
}
echo 'var users = ' . json_encode($user) . ';';
echo 'var lookup = ' . json_encode($lookup) . ';';


// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 :
