<?php
session_start();
//$_SESSION['user_id'] = 1;

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

header("Cache-Control: no-cache, must-revalidate");
?>
<html>
  <head>
    <title>Voting Poll</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  <body>
    <div id="container">
      <div id="header">
        <h1><img src="cybercat1.jpg" title=" " alt=" " /></h1>
      </div>
			