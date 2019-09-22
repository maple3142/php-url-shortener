<?php
// preferbly mysql
$conn = new PDO(getenv('DB_CONN'), getenv('DB_USER'), getenv('DB_PASS'));
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$conn->exec("
	CREATE TABLE IF NOT EXISTS links(
		id varchar(10) NOT NULL,
		url nvarchar(1000) NOT NULL,
		delete_code varchar(20) NOT NULL,
		creator int
	);
");
$conn->exec("
	CREATE TABLE IF NOT EXISTS users(
		id int AUTO_INCREMENT NOT NULL,
		username varchar(20) NOT NULL,
		email varchar(255) NOT NULL,
		password_hash char(60) NOT NULL,
		is_admin boolean NOT DEFAULT 0,
		PRIMARY KEY(id)
	);
");
