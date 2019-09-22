<?php
session_start();

if (!isset($_SESSION['user_id'])) {
	header('Location: /login.php');
}
include 'sql.php';
include 'utils.php';

$stat = $conn->query("SELECT id, url, delete_code FROM links WHERE creator = " . $_SESSION['user_id']);
$list = $stat->fetchAll();
$base = get_base_url();
foreach ($list as $k=>$v) {
	$list[$k]['short'] = $base . '/' . $v['id'];
	$delete_url= $base . '/delete.php?redirect=/profile.php&code=' . $v['delete_code'];
	$list[$k]['confirm_delete'] = 'javascript: confirm("Are you sure?") && (location.href='.json_encode($delete_url).')';
}
function anchor($url, $text = NULL)
{
	if ($text == NULL) {
		$text = $url;
	}
	return '<a href="' . htmlspecialchars($url) . '">' . $text . '</a>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include 'head.php'; ?>
</head>

<body>
	<?php include "nav.php"; ?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Id</th>
								<th scope="col">Url</th>
								<th scope="col">Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($list as $k => $v) : ?>
								<tr>
									<td scope="row"><?php echo $k + 1; ?></td>
									<td><?php echo anchor($v['short']); ?></td>
									<td><?php echo anchor($v['url']); ?></td>
									<td><?php echo anchor($v['confirm_delete'], 'delete'); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>

</html>