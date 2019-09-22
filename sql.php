<?php
$conn = new PDO(getenv('DB_CONN'), getenv('DB_USER'), getenv('DB_PASS'));
$conn->exec("
	CREATE TABLE IF NOT EXISTS links(
		id varchar(10) NOT NULL,
		url nvarchar(1000) NOT NULL,
		delete_code varchar(20) NOT NULL
	);
");
