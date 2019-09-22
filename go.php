<?php
include "sql.php";
include "utils.php";

if (!isset($_GET['id'])) {
	die("Invalid parameter.");
}

$stat = $conn->prepare("SELECT url FROm links WHERE id = :id");
$stat->execute(array(
	'id' => $_GET['id']
));
$result = $stat->fetch(PDO::FETCH_ASSOC);
if (!$result) {
	echo 'The id doesn\'t exists.';
	header("Refresh: 3; url=/", true, 303);
} else {
	header("Location: " . $result['url']);
}
