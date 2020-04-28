<?php

require_once 'vendor/autoload.php';

$google_client = new Google_Client();
$google_client->setClientId('125514294766-t6vnda17dej5v92ihj4u3snoiq5gaeal.apps.googleusercontent.com');
$google_client->setClientSecret('pY9-UdAt92Er_hS4xA8mhf3c');
$google_client->setRedirectUri('http://localhost/cs4640/cgfarm/profile.php');


$google_client->addScope('email');
$google_client->addScope('profile');

session_start();

?>