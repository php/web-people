<?php
/* $Id$ */

require "./include/layout.php";
require "./include/misc.php";
require "./include/karma.php";
$USERNAME = filter_input(INPUT_GET, "username", FILTER_SANITIZE_ENCODED, FILTER_FLAG_STRIP_HIGH);

site_header("Developers Profile Pages; $USERNAME");

$NFO      = findPHPUser($USERNAME);
$KARMA    = findKarma($USERNAME);
$PROFILE  = findPHPUserProfile($USERNAME);
$BUGS     = findAssignedBugs($USERNAME);
$email    = $NFO["username"].'@php.net';
$gravatar = "//www.gravatar.com/avatar/" . md5($email) . ".jpg?s=460";
?>

<div class="container">
<div about="#me" typeof="foaf:Person" id="profile" class="columns">
<div class="profile-side column">
    <div rel="foaf:img">
        <img rel="foaf:img" src="<?php echo $gravatar ?>"
             alt="Picture of <?php echo $NFO["name"] ?>"
             height="180" width="180" />
     </div>
</div>
<div class="profile-main column">

    <div class="profile-name">
        <h1 property="foaf:name"><?php echo $NFO["name"] ?></h1>
        <h2 property="foaf:nick"><?php echo $NFO["username"]?></h2>
    </div>

    <h2 id="contact">Contact:</h2>
    <p class="nudge"><a rel="foaf:mbox" href="mailto:<?php echo $email ?>"><?php echo $email ?></a></p>

<?php if ($PROFILE) { ?>
    <h2 id="blurb">About:</h2>
    <div class="nudge blurb">
        <?php echo $PROFILE; ?>
    </div>
<?php } ?>

<?php if ($KARMA) { ?>
    <?php $KARMA = formatKarma($KARMA); ?>
    <h2 id="karma">Karma:</h2>
    <ul>
    <?php if (count($KARMA) > 0) { ?>
        <?php foreach ($KARMA as $path) { ?>
            <li><?php echo $path ?></li>
        <?php } ?>
    <?php } ?>
    </ul>
<?php } ?>

<?php if ($BUGS) { ?>
    <h2 id="bugs">Assigned (open) bugs:</h2>
    <ul>
    <?php foreach ($BUGS as $bug) { ?>
        <li><a href="<?php echo $bug["link"]?>"><?php echo $bug["title"] ?></a></li>
    <?php } ?>
    </ul>
<?php } ?>

<?php if (!empty($NFO["notes"])) { ?>
    <h2 id="notes">Notes:</h2>
    <?php foreach($NFO["notes"] as $note) { ?>
    <div class="note">
        <?php echo $note["entered"] ?>:
        <?php echo htmlspecialchars($note["note"], ENT_QUOTES, 'UTF-8'); ?>
    </div>
    <?php } ?>
<?php } ?>
</div>
</div>
<?php
$SIDEBAR = <<< SIDEBAR
    <p class="panel">
        <a href="https://master.php.net/manage/users.php?username=$USERNAME">Edit $USERNAME on master</a>
    </p>
SIDEBAR;

site_footer(array("SIDEBAR" => $SIDEBAR));
// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 : 

