<?php
/* $Id$ */

require "./include/layout.php";
require "./include/misc.php";
require "./include/karma.php";
$USERNAME = filter_input(INPUT_GET, "username", FILTER_SANITIZE_ENCODED, FILTER_FLAG_STRIP_HIGH);

site_header("Developers Profile Pages; $USERNAME");

$NFO      = findPHPUser($USERNAME);
$PEAR     = findPEARUser($USERNAME);
$GITHUB   = findGitHubUser($NFO["name"]);
$KARMA    = findKarma($USERNAME);
$PROFILE  = findPHPUserProfile($USERNAME);
$email    = $NFO["enable"] ? $NFO["username"].'@php.net' : "";
$location = isset($PEAR["long"], $PEAR["lat"]) ? $PEAR["lat"] . ", " . $PEAR["long"] : null;
?>

<section class="mainscreen">
<div about="#me" typeof="foaf:Person" id="profile">
<?php
if ($email) {
    echo '<span rel="foaf:img"><img rel="foaf:img" src="http://www.gravatar.com/avatar/', md5($email), '.jpg" alt="Picture of ', $NFO["name"], '" height="80" width="80" /></span>';
}
?>
	<dl>
		<dt>Summary</dt>
		<dd>
<?php
if ($NFO["name"]) {
    echo '<span property="foaf:name">', $NFO["name"], '</span>';
}
?>
    (<span property="foaf:nick"><?php echo $NFO["username"]?></span>)
    a member of <a href="http://www.php.net" rel="foaf:Organization">PHP</a>
<?php
if (isset($GITHUB["company"])) {
    echo ', currently working for ', $GITHUB["company"];
}
if (isset($GITHUB["location"])) {
    echo ', living in ';
    if ($location) {
        $q = urlencode($location);
        echo '<a href="http://maps.google.com/?q=', $q, '">', $GITHUB["location"], '</a>';
    } else {
        echo $GITHUB["location"];
    }
}
?>
.
		</dd>
<?php if ($email) { ?>
	<dt>Email</dt>
	<dd><a rel="foaf:mbox" href="mailto:<?php echo $email ?>"><?php echo $email ?></a></dd>
<?php } ?>

<?php if (isset($GITHUB["blog"])) { ?>
    <dt>Weblog</dt>
    <dd><a rel="foaf:weblog" href="<?php echo $GITHUB["blog"]?>"><?php echo $GITHUB["blog"]?></a></dd>
<?php } ?>

<?php if (isset($GITHUB["company"])) { ?>
	<dt>Employer</dt>
	<dd><?php echo $GITHUB["company"]?></dd>
<?php } ?>

<?php if (isset($GITHUB["location"])) { ?>
	<dt>Location</dt>
	<dd><?php echo $GITHUB["location"] ?></dd>
<?php } ?>

<?php if (isset($PEAR["long"], $PEAR["lat"])) { ?>
    <dt>Geo location</dt>
	<?php $q = urlencode($location) ?>
    <dd><a href="http://maps.google.com/?q=<?php echo $q ?>"><span property="geo:lat"><?php echo $PEAR["lat"]?></span>, <span property="geo:long"><?php echo $PEAR["long"]?></span></a></dt>
<?php } ?>

</dl>

<?php if ($PROFILE) { ?>
    <h2 id="blurb">About:</h2>
    <div class="blurb">
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

<?php if ($NFO["notes"]) { ?>
    <h2 id="notes">Notes:</h2>
<?php } ?>
<?php foreach($NFO["notes"] as $note) { ?>
    <div class="note">
        <?php echo $note["entered"] ?>:
        <?php echo htmlspecialchars($note["note"], ENT_QUOTES, 'UTF-8'); ?>
    </div>
<?php } ?>
</div>

</section>
<?php
$SIDEBAR = <<< SIDEBAR
    <p class="panel"><a href="https://master.php.net/manage/users.php?username=$USERNAME">Edit $USERNAME on master</a></p>
SIDEBAR;

site_footer(array("SIDEBAR" => $SIDEBAR));
// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 : 

