<?php

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

    include('config.php');
    include('connectdb.php');

    

    if (!isset($_SESSION['access_token'])) {
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        global $db;
        echo($_GET['command'] === 'buy');
        if ($_GET['command'] === 'buy') {
            $stm = $db->prepare("DELETE FROM item WHERE email = :email");
            $stm->bindParam(":email", $_SESSION['user_email_address'], PDO::PARAM_STR);
            $stm->execute();
            echo('email: |' . $_SESSION['user_email_address'] . '|');
        } else {
            echo("VALUES('" . $_SESSION['user_email_address'] . "', '" . $_GET['addr'] . "')");
            $stm = $db->prepare("INSERT INTO address(email, address) VALUES(:email, :address)");
            $stm->bindParam(":email", $_SESSION['user_email_address'], PDO::PARAM_STR);
            $stm->bindParam(":address", $_GET['addr'], PDO::PARAM_STR);
            $stm->execute();
            echo('<br>|' . $_SESSION['user_email_address'] . '|' . $_GET['addr'] . '|');
        }
    }

?>