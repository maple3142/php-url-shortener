<?php
function check_exists($conn, $col, $val)
{
	// $col should never accept user-input variable
	$stat = $conn->prepare("SELECT COUNT(id) AS cnt FROM links WHERE $1 = :$1");
	$stat->execute(array(
		$col => $val
	));
	$result = $stat->fetch();
	return (int) $result['cnt'] > 0;
}

$url = $_POST["url"];
if (!isset($url)) {
	die("Invalid parameter.");
}
if (preg_match("/^https?:\/\//", $url) != 1) {
	die("Url must starts with http(s)://");
}
if (strlen($url) <= 10) {
	die("Url is shorturl enough already.");
}

include "sql.php";
include "utils.php";

session_start();

$delete_code = generateRandomString(20);
while (check_exists($conn, 'delete_code', $delete_code)) {
	$delete_code = generateRandomString(20);
}
$id = generateRandomString(rand(4, 7));
while (check_exists($conn, 'id', $id)) {
	$id = generateRandomString(rand(4, 7));
}

$stat = $conn->prepare("INSERT INTO links (url, id, delete_code, creator) VALUES (:url, :id, :delete_code, :creator)");
if (is_bool($stat)) {
	var_dump($conn->errorInfo());
	die();
}
$stat->execute(array(
	'url' => $url,
	'id' => $id,
	'delete_code' => $delete_code,
	'creator' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null
));

$base_url = get_base_url();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include "head.php"; ?>
</head>

<body>
	<?php include "nav.php"; ?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="form-group mb-3">
					<label for="url">Result url</label>
					<input class="form-control" id="url" type="text" value="<?php echo $base_url . '/' . $id ?>">
				</div>
				<div class="form-group mb-3">
					<label for="delete_url">Delete url</label>
					<input class="form-control" id="delete_url" type="text" value="<?php echo $base_url . '/delete.php?code=' . $delete_code ?>">
				</div>
			</div>
		</div>
	</div>
	<script>
		var ar = document.querySelectorAll('input')
		for (var i = 0; i < ar.length; i++) {
			(function(input) {
				input.onfocus = function() {
					input.select()
					document.execCommand('copy')
				}
			})(ar[i])
		}
	</script>
</body>

</html>