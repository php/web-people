<?php
/* $Id$ */

function site_header($title) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html
  xml:lang="en"
  xmlns="http://www.w3.org/1999/xhtml" 
  xmlns:foaf="http://xmlns.com/foaf/0.1/"
  xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#"
>
<head>
    <title><?php echo $title ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" media="all" rel="stylesheet" href="styles.css" />
    <link rel="shortcut icon" href="http://php.net/favicon.ico" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.autocomplete.min.js"></script>
    <script type="text/javascript" src="js/userlisting.php"></script>
</head>

<body>
    <h1 id="header"><a href="http://php.net/index.php">PHP: Hypertext Preprocessor</a> - <a href="http://people.php.net/index.php" rel="home">Developers Profile pages</a></h1>
    <div id="searchbox">
        <label for="search">User search</label>
        <input type="text" name="q" id="search" />
    </div>
    <script type="text/javascript" src="js/search.js"></script>
    <ul id="mainmenu">
        <li><a href="http://php.net/downloads.php">Downloads</a></li>
        <li><a href="http://php.net/docs.php">Documentation</a></li>
        <li><a href="http://php.net/FAQ.php">Faq</a></li>
        <li><a href="http://php.net/support.php">Getting Help</a></li>
        <li><a href="http://php.net/mailing-lists.php">Mailing Lists</a></li>
        <li><a href="http://bugs.php.net">Reporting Bugs</a></li>
        <li><a href="http://php.net/sites.php">Php.net Sites</a></li>
        <li><a href="http://php.net/links.php">Links</a></li>
        <li><a href="http://php.net/conferences/">Conferences</a></li>
        <li><a href="http://php.net/my.php">My Php.net</a></li>
    </ul>
<?php
}

function site_footer() {
?>
    <p id="copyright">
        <a href="http://php.net/copyright.php">Copyright &copy; 2009 The PHP Group</a><br />
        All rights reserved.
    </p>
</body>
</html>
<?php
}

// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 : 

