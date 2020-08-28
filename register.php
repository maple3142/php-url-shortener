<?php
session_start();

if (isset($_SESSION['user_id'])) {
	header('Location: /');
	exit();
}

include 'sql.php';

$failed_message = '';
function do_username_or_email_exist($conn, $username, $email)
{
	$stat = $conn->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
	$stat->execute([
		'username' => $username,
		'email' => $email
	]);
	$result = $stat->fetch();
	return !!$result;
}
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	if (strlen($username) < 6 || strlen($username) > 20) {
		$failed_message = 'Username length should be 6~20 characters.';
	} else if (!mb_check_encoding($username, 'ASCII')) {
		$failed_message = 'Username can only contain ASCII characters.';
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$failed_message = 'Invalid email.';
	} else if (strlen($password) < 8 || strlen($password) > 50) {
		$failed_message = "Password length should be 8~50 characters.";
	} else if ($password != $confirm_password) {
		$failed_message = "Confirm password is not the same as password.";
	} else if (do_username_or_email_exist($conn, $username, $email)) {
		$failed_message = 'Username or email already exists.';
	}
	if (!$failed_message) {
		$hashed = password_hash($password, PASSWORD_BCRYPT);
		$stat = $conn->prepare("INSERT INTO users(username, email, password_hash) VALUES(:username, :email, :password_hash)");
		$stat->execute([
			'username' => $username,
			'email' => $email,
			'password_hash' => $hashed
		]);
		$_SESSION['user_id'] = $conn->lastInsertId();
		header('Location: /');
	}
}
function value_attr($val)
{
	return 'value="' . htmlspecialchars($val) . '"';
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
				<?php if ($failed_message) : ?>
					<div class="alert alert-danger" role="alert">
						<?php echo $failed_message; ?>
					</div>
				<?php endif; ?>
				<form action="/register" method="POST">
					<div class="form-group">
						<label for="username">Username</label>
						<input required type="text" class="form-control" name="username" placeholder="Enter username" <?php if (isset($_POST['username'])) {
																															echo value_attr($_POST['username']);
																														} ?>>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input required type="email" class="form-control" name="email" placeholder="Enter email" <?php if (isset($_POST['email'])) {
																														echo value_attr($_POST['email']);
																													} ?>>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input required type="password" class="form-control" name="password" placeholder="Enter password">
					</div>
					<div class="form-group">
						<label for="password">Confirm Password</label>
						<input required type="password" class="form-control" name="confirm_password" placeholder="Enter password again">
					</div>
					<button type="submit" class="btn btn-primary">Register</button>
					<a href="/login">Already have an account? Login Here!</a>
				</form>
			</div>
		</div>
	</div>
</body>

</html>