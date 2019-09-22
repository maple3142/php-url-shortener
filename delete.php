<?php
include "sql.php";

if (!isset($_GET["code"])) {
	die("Invalid parameter.");
}

$delete_code = $_GET['code'];

$stat = $conn->prepare("DELETE FROM links WHERE delete_code = :delete_code");
$stat->execute(array(
	'delete_code' => $delete_code
));
if ($stat->rowCount() > 0) {
	echo "Successfully deleted the url.";
} else {
	echo "delete_code not found.";
}
if (!isset($_GET['redirect']) && !preg_match("/^\//", $_GET['redirect'])) {
	// redirect url should start with "/" only
	header("Refresh: 3; url=/", true, 303);
} else {
	$r = $_GET['redirect'];
	header("Location: $r", true, 303);
}
