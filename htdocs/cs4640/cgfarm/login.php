<?php

// header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');  
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

include('config.php');
$data = [];

// If we are being called by my login button
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = file_get_contents('php://input');
    if ($request === 'login=true') {

    $loginurl = $google_client->createAuthUrl();
    echo json_encode($loginurl);
    }
}

// If being redirected from google auth
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["data"])) {
    // Get the token
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    // Check if the token failed
    if (!isset($token['error'])) {
        // Use the token to get the data from google
        $google_client->setAccessToken($token['access_token']);
        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get();

        // Use the data from google and set session variables to track basic data
        $_SESSION['access_token'] = $token['access_token'];
        $_SESSION['user_first_name'] = $data['given_name'];
        $_SESSION['user_last_name'] = $data['family_name'];
        $_SESSION['user_email_address'] = $data['email'];
        $_SESSION['user_image'] = $data['picture'];
    }
}
?>