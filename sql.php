<?php
$conn = NULL;
if (isset($_ENV['DB_CONN'])) {
	$conn = new PDO($_ENV['DB_CONN'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
} else {
	$conn = new PDO("sqlite:database.db");
}
$conn->exec("
	CREATE TABLE IF NOT EXISTS links(
		id varchar(10) NOT NULL,
		url varchar(1000) NOT NULL,
		delete_code varchar(20) NOT NULL
	);
");
