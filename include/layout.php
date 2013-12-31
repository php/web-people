<?php
/* $Id$ */

function site_header($title) {
    $SUBDOMAIN = "people";
    $TITLE = "Header";
    $LINKS = array(
        array("href" => "/user.php", "text" => "Users"),
        array("href" => "https://master.php.net/manage/users.php", "text" => "Master"),
    );
    $CSS[] = "/styles/user-autocomplete.css";
    $SEARCH = array("method" => "get", "action" => "user.php", "placeholder" => "Search profiles", "name" => "username");
    include dirname(__FILE__) . "/../shared/templates/header.inc";
    echo '<section class="mainscreen">';
}

function site_footer($config = array()) {
    $JS = array(
        "//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js",
        "//people.php.net/js/jquery.autocomplete.min.js",
        "//people.php.net/js/userlisting.php",
        "//people.php.net/js/search.js",
    );
    echo '</section>';
    if (isset($config["SIDEBAR"])) {
        $SECONDSCREEN = $config["SIDEBAR"];
    }
    include dirname(__FILE__) . "/../shared/templates/footer.inc";
}



// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 : 

