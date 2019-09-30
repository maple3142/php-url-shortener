<?php
if (session_id() == "") {
	session_start();
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
			<div class="col-lg-6">
				<form action="/create.php" method="POST">
					<div class="form-group">
						<label for="url">Long URL</label>
						<input required type="url" name="url" id="url" class="form-control">
					</div>
					<button type="submit" class="btn btn-primary">Shorten it!</button>
				</form>
			</div>
		</div>
	</div>
</body>

</html>