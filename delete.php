<?php
include "sql.php";

if(!isset($_GET["delete_code"])){
	die("Invalid parameter");
}

$delete_code = $_GET['delete_code'];

$stat=$conn->prepare("DELETE FROM links WHERE delete_code = :delete_code");
$stat->execute(array(
	'delete_code' => $delete_code
));
if($stat->rowCount()>0){
	echo "Successfully deleted the url.";
}
else{
	echo "delete_code not found.";
}
header("Refresh: 3; url=/", true, 303);
?>
