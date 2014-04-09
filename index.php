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

<table>
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
        <td class="gravatar"><img src="//www.gravatar.com/avatar/<?php echo md5($user["username"] . "@php.net")?>.jpg" alt="Picture of <?php $user["name"] ?>" height="80" width="80" /></td>
        <td class="username"><a href="/<?php echo $user["username"]?>"><?php echo $user["username"] ?></a></td>
        <td class="name"><?php echo $user["name"] ?></td>
    </tr>
<?php endforeach ?>
</tbody>
<tfoot>
<tr>
<th>
    <?php if ($page > 1): ?>
    <a href="?page=<?php echo $page-1?>">Previous page</a></th>
    <?php endif ?>
</th>
<th></th>
<th>
    <?php if ($x == 49): ?>
    <a href="?page=<?php echo ++$page?>">Next page</a></th>
    <?php endif ?>
</th>
</tr>
</tfoot>
</table>

<?php
site_footer();
// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 : 
