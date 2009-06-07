<?php
/* $Id$ */

require "./include/layout.php";
$USERNAME = filter_input(INPUT_GET, "username", FILTER_SANITIZE_ENCODED, FILTER_FLAG_STRIP_HIGH);

if ($USERNAME) {
    header("Location: /user.php?username=$USERNAME");
    exit;
}

site_header("PHP: Developers Profile Pages");
?>

    <p class="warning smaller"><strong>WARNING</strong>: This is obviously work in progress :)</p>
    <p>Use the searchbox to search for usernames/names</p>

<?php
site_footer();
// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 : 

