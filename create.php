<?php
include "sql.php";

function check_id_exists($conn, $id){
	$stat = $conn->prepare("SELECT COUNT(id) AS cnt FROM links WHERE id = :id");
	$stat->execute(array(
		'id' => $id
	));
	$result = $stat->fetch(PDO::FETCH_ASSOC);
	return (int)$result['cnt']>0;
}

if(!isset($_POST["url"])){
	die("Invalid parameter");
}
$url = $_POST["url"];
$delete_code = uniqid();
$id = substr($delete_code, 0, 7);
while(check_id_exists($conn, $id)){
	$delete_code = uniqid();
	$id = substr($delete_code, 0, 7);
}

$stat=$conn->prepare("INSERT INTO links (url, id, delete_code) VALUES (:url, :id, :delete_code)");
if(is_bool($stat)){
	var_dump($conn->errorInfo());
	die();
}
$stat->execute(array(
	'url' => $url,
	'id' => $id,
	'delete_code' => $delete_code
));

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>URL Shortener</title>
</head>

<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-6">
				<div class="form-group mb-3">
					<label for="url">Result url</label>
					<input class="form-control" id="url" type="text">
				</div>
				<div class="form-group mb-3">
					<label for="delete_url">Delete url</label>
					<input class="form-control" id="delete_url" type="text">
				</div>
			</div>
		</div>
	</div>
	<script>
		var id = <?php echo json_encode($id); ?>

		var delete_code = <?php echo json_encode($delete_code); ?>

		document.getElementById('url').value = location.protocol + '//' +location.host + '/' + id
		document.getElementById('delete_url').value = location.protocol + '//' +location.host + '/delete.php?delete_code=' + delete_code
		var ar=document.querySelectorAll('input')
		for(var i=0;i<ar.length;i++){
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
