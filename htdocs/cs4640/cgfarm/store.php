<?php

//header('Access-Control-Allow-Origin: http://localhost:4200');
//header('Access-Control-Allow-Origin: http://localhost');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');  
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

include('connectdb.php');

// echo($_GET['operation'] . " " . $_GET['email'] . " " . $_GET['table'] . " " . $_GET['item']);

if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
        isset($_GET['operation']) &&
        isset($_GET['email']) &&
        isset($_GET['table']) &&
        isset($_GET['item']) &&
        isset($_GET['price'])) {

    if ($_GET['operation'] === 'insert')
        $helper = ' into ';
    else $helper = ' from ';
    $query = $_GET['operation'] . $helper . $_GET['table']; 

    if ($_GET['operation'] === 'insert')
        $query = $query . ' (email, item, price, quantity) values ("' . $_GET['email'] . '", "' . $_GET['item'] . '", "' . $_GET['price'] . '", "1");';

    //echo($query);
    $result = $db->query($query);
            

    }
?>