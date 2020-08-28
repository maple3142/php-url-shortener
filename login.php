<?php
session_start();

if (isset($_SESSION['user_id'])) {
	header('Location: /');
	exit();
}

include 'sql.php';

$login_failed = false;
if (isset($_POST['username']) && isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$stat = $conn->prepare("SELECT id, password_hash FROM users WHERE username = :username");
	$stat->execute([
		'username' => $username
	]);
	$result = $stat->fetch();
	if (password_verify($password, $result['password_hash'])) {
		$_SESSION['user_id'] = $result['id'];
		header('Location: /');
	} else {
		$login_failed = true;
	}
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
				<?php if ($login_failed) : ?>
					<div class="alert alert-danger" role="alert">
						Failed to login
					</div>
				<?php endif; ?>
				<form action="/login" method="POST">
					<div class="form-group">
						<label for="username">Username</label>
						<input required type="text" class="form-control" name="username" placeholder="Enter username">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input required type="password" class="form-control" name="password" placeholder="Enter password">
					</div>
					<button type="submit" class="btn btn-primary">Login</button>
					<a href="/register">No account? Register Here!</a>
				</form>
			</div>
		</div>
	</div>
</body>

</html>