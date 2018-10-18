<?php

function site_header($TITLE) {
    $SUBDOMAIN = "people";
    $LINKS = array(
        array("href" => "https://master.php.net/manage/users.php", "text" => "Master"),
        array("href" => "https://wiki.php.net/web/people", "text" => "Help"),
    );
    $CSS[] = "/styles/user-autocomplete.css";
    $CSS[] = "/styles/people.css";
    $SEARCH = array("method" => "get", "action" => "user.php", "placeholder" => "Search profiles", "name" => "username");
    include __DIR__ . "/../shared/templates/header.inc";
}

function site_footer($config = array()) {
    $JS = array(
        "//people.php.net/js/jquery.autocomplete.min.js",
        "//people.php.net/js/userlisting.php",
        "//people.php.net/js/search.js",
    );
    if (isset($config["SIDEBAR"])) {
        $SECONDSCREEN = $config["SIDEBAR"];
    }
    include __DIR__ . "/../shared/templates/footer.inc";
}



// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 :
