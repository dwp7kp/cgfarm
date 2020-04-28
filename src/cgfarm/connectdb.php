<?php

// connecting to DB on XAMPP (local)

$username = 'root';
$password = '';
$host = 'localhost:3306';
$dbname = 'cgfarm';

$dsn = "mysql:host=$host;dbname=$dbname";

$db = new PDO($dsn, $username, $password);


?>

<?php 
// To close a connection, uncomment the following line
//$db = null;
?>