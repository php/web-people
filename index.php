<?php
require "./include/layout.php";
require "./include/misc.php";
$USERNAME = filter_input(INPUT_GET, "username", FILTER_SANITIZE_ENCODED, FILTER_FLAG_STRIP_HIGH);

if ($USERNAME) {
    header("Location: /user.php?username=$USERNAME");
    exit;
}

site_header("PHP: Developers Profile Pages");
$page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT, array("options" => array("min_range" => 1))) ?: 1;
?>
<div class="twrapper">
<table class="people">
	<thead>
		<tr>
			<th></th>
			<th>Username</th>
			<th>Full name</th>
		</tr>
	</thead>
	<tbody>

	<?php $x = 0 ?>
	<?php foreach (findAllUsers($page) as $x => $user): ?>
		<tr>
			<td class="gravatar"><a href="/<?= $user['username'] ?>"><img src="//www.gravatar.com/avatar/<?php echo md5($user["username"] . "@php.net")?>.jpg" alt="Picture of <?= $user['name'] ?>"/></a></td>
			<td class="username"><a href="/<?= $user['username']?>"><?= $user['username'] ?></a></td>
			<td class="name"><a href="/<?= $user['username'] ?>"><?= $user['name'] ?></a></td>
		</tr>
	<?php endforeach ?>
	</tbody>
	<tfoot>
	<tr>
		<th colspan="3">
			<?php if ($page > 1): ?>
			<a class="pagination prev" href="?page=<?php echo $page-1?>">&laquo; Previous page</a>
			<?php endif ?>
			<span class="page"><?php echo $page ?></span>
			<?php if ($x == 49): ?>
			<a class="pagination next" href="?page=<?php echo ++$page?>">Next page &raquo;</a>
			<?php endif ?>
		</th>
	</tr>
	</tfoot>
</table>
</div>
<?php
site_footer();
// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 :
