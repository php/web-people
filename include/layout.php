<?php
/* $Id$ */

function site_header($title) {
    include dirname(__FILE__) . "/header.inc";
}

function site_footer() {
    include dirname(__FILE__) . "/footer.inc";
}

function site_panel($data) {
    include dirname(__FILE__) . "/sidebar.inc";
}


// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 : 

