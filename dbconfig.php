<?php

$DB_host = "localhost";
$DB_user = "gillilandr";
$DB_pass = "12345";
$DB_name = "gillilandr";

try
{
	$db = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo $e->getMessage();
}

?>