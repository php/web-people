<?php
/* $Id$ */

function site_header($title) {
    $SUBDOMAIN = "people";
    $TITLE = "Header";
    $LINKS = array(
        array("href" => "/user.php", "text" => "Users"),
        array("href" => "https://master.php.net/manage/users.php", "text" => "Master"),
    );
    $CSS[] = "/shared/styles/user-autocomplete.css";
    $SEARCH = array("method" => "get", "action" => "user.php", "placeholder" => "Search profiles", "name" => "username");
    include dirname(__FILE__) . "/../shared/templates/header.inc";
}

function site_footer() {
    $JS = array(
        "//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js",
        "//people.php.net/js/jquery.autocomplete.min.js",
        "//people.php.net/js/userlisting.php",
        "//people.php.net/js/search.js",
    );
    include dirname(__FILE__) . "/../shared/templates/footer.inc";
}

function site_panel($data) {
    include dirname(__FILE__) . "/sidebar.inc";
}


// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 : 

