<?php
require "./include/layout.php";
require "./include/misc.php";
$USERNAME = filter_input(INPUT_GET, "username", FILTER_SANITIZE_ENCODED, FILTER_FLAG_STRIP_HIGH);

site_header("Developers Profile Pages; $USERNAME");

$NFO      = findPHPUser($USERNAME);
$PROFILE  = findPHPUserProfile($USERNAME);
$BUGS     = findAssignedBugs($USERNAME);
$email    = $NFO["username"].'@php.net';
$gravatar = "//www.gravatar.com/avatar/" . md5($email) . ".jpg?s=460";

$bugs_url   = "https://bugs.php.net/search.php?cmd=display&order_by=ts2&direction=DESC&status=Open&assign=" . urlencode($USERNAME);
$main_url = "https://main.php.net/manage/users.php?username=" . urlencode($USERNAME);
?>
<section class="mainscreen">
    <div class="profile-main">
        <div class="profile-name">
            <h1 property="foaf:name"><?php echo $NFO["name"] ?></h1>
            <h2 property="foaf:nick"><?php echo $NFO["username"]?></h2>
        </div>

    <?php if ($PROFILE) { ?>
        <h2 id="blurb">About</h2>
        <div class="nudge blurb">
            <?php echo $PROFILE; ?>
        </div>
    <?php } ?>

    <?php if ($BUGS) { ?>
        <h2 id="bugs">Assigned (open) bugs</h2>
        <ul>
        <?php foreach ($BUGS as $bug) { ?>
            <li><a href="<?php echo $bug["link"]?>"><?php echo htmlspecialchars($bug["title"], ENT_QUOTES, 'UTF-8'); ?></a></li>
        <?php } ?>
        </ul>
    <?php } ?>

    <?php if (!empty($NFO["notes"])) { ?>
        <h2 id="notes">Notes</h2>
        <?php foreach($NFO["notes"] as $note) { ?>
        <div class="note">
            <?php echo $note["entered"] ?>:
            <?php echo htmlspecialchars($note["note"], ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <?php } ?>
    <?php } ?>
    </div>
</section>

<section class="secondscreen">
    <div class="profile-side">
        <div rel="foaf:img">
            <img rel="foaf:img" src="<?php echo $gravatar ?>"
                 alt="Picture of <?php echo $NFO["name"] ?>"
                 height="230" width="230" />
        </div>
        <ul class="profile-details">
            <li><span class="icon-mail"></span> <?php echo $email ?></li>
            <?php if (is_array($BUGS)) { ?>
            <li>
                <span class="icon-bug"></span>
                <a href="<?php echo $bugs_url ?>"><?php echo number_format(count($BUGS)) ?> open bugs assigned</a>
            </li>
            <?php } ?>
            <li>
                <span class="icon-edit"></span>
                <a href="<?php echo $main_url ?>">edit on main</a>
            </li>
        </ul>
    </div>
</section>

<?php
site_footer();

// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 :
