<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>PHP: <?=$title ?></title>
  <link type="text/css" media="all" rel="stylesheet" href="/styles.css?v=3">
  <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,400italic,600italic|Source+Code+Pro&subset=latin,latin-ext" rel="stylesheet" type="text/css">
  <link rel="shortcut icon" href="//php.net/favicon.ico">
</head>
<body>

<header>
  <div id="mainmenu-toggle-overlay"></div>
  <input type="checkbox" id="mainmenu-toggle">
  <nav class="fullscreen">
    <div class="mainscreen">
      <a href="/" class="home"><img src="//php.net/images/logo.php" width="48" height="24" alt="php"><span class="subdomain">people</span></a>
      <ul>
        <li><a href="/user.php">Users</a></li>
      </ul>
    </div>
    <div class="secondscreen">
      <form method="get" action="user.php">
        <input type="search" placeholder="Search profiles" name="username" class="search">
      </form>
    </div>
  </nav>
</header>

<section class="fullscreen">
