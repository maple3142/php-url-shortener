<?php
include "sql.php";
include "utils.php";

if (!isset($_GET['id'])) {
	die("Invalid parameter.");
}

$stat = $conn->prepare("SELECT url FROM links WHERE id = :id");
$stat->execute(array(
	'id' => $_GET['id']
));
$result = $stat->fetch();
if (!$result) {
	header("Refresh: 3; url=/", true, 303);
	echo 'The id doesn\'t exists.';
} else {
	header("Location: " . $result['url']);
}
