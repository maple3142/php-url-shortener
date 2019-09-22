<?php
if (session_id() == "") {
	session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="/">Url Shortener</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbar">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == '/') {
									echo 'active';
								} ?>">
				<a class="nav-link" href="/">Home</a>
			</li>
			<?php if (isset($_SESSION['user_id'])) : ?>
				<li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == '/profile.php') {
											echo 'active';
										} ?>">
					<a class="nav-link" href="/profile.php">Profile</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/logout.php">Logout</a>
				</li>
			<?php else : ?>
				<li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == '/login.php') {
											echo 'active';
										} ?>">
					<a class="nav-link" href="/login.php">Login</a>
				</li>
			<?php endif; ?>
	</div>
</nav>