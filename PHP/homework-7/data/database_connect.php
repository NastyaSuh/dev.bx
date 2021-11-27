<?php

function connectToDataBase(array $dbConfig): mysqli
{
	$database = mysqli_init();
	$dbConnect = $database -> real_connect($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbName']);
	$dbChangeEncoding = mysqli_set_charset($database, "utf8mb4");
	$error = mysqli_errno($database). ":" .mysqli_error($database);
	if(!$dbConnect || !$dbChangeEncoding)
	{
		trigger_error($error);
	}
	return $database;
}