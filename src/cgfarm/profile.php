<?php

include('config.php');
include('connectdb.php');

// If we are redirecting from the URL
if (isset($_GET["code"])) {
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
        $_SESSION['address'] = '';

        $stm = $db->prepare("SELECT email, address FROM address WHERE email = :email");
        $stm->bindParam(":email", $_SESSION['user_email_address'], PDO::PARAM_STR);
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_ASSOC);

        if ($row['email'] === $_SESSION['user_email_address']) {
            $_SESSION['address'] = $row['address'];
        }
        
            
    }
}

// TODO: Hookup with Square API
function purchaseItems()
{
    return true;
}

function checkInput() {
    $dom = new DOMDocument('1.0', 'iso-8859-1'); 
    $email = $dom->getElementById('email_rec')->textContent;
    $address = $dom->getElementById('address')->textContent;

    if (! strpos($email, "@")) {
        $dom->getElementById('error-email')->innerHtml = "Please provide a valid email address";
    }
}

?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PHP Login using Google Account</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport' />
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #1C2331;
        }
    </style>
</head>

<body>
    <div class="container">
        <br />
        <h2 align="center">
            <a href="http://localhost:4200/home">
                <img class="mr-3 mb-2 mt-2" src="cypress_grove_cropped.png" height="mr-auto" alt="cypress grove logo">
            </a>
            <img src="<?php echo ($_SESSION["user_image"]); ?>" class="img-responsive img-circle img-thumbnail" style="width: 100px; height: 100px" /> </h2>
        <br />
        <div class="container">
            <div class="panel panel-default">
                <?php
                if (isset($_SESSION['access_token'])) {
                    echo '<div class="panel-heading">Welcome ' . $_SESSION['user_first_name'] . '</div><div class="panel-body">';
                    echo '<h3><b>Name :</b> ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h3>';
                    echo '<h3><b>Email :</b> ' . $_SESSION['user_email_address'] . '</h3>';
                    echo '<h3><a href="http://localhost:4200/home">Home</a></h3></div>';
                    // TODO: Logout changed from actual log out to redirect back to main page
                } else {
                    $button = '<a href="' . $google_client->createAuthUrl() . '"><img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" /></a>';
                    echo '<div align="center">' . $button . '</div>';
                }
                ?>
            </div>
            <div class="panel panel-default">
                <div class="mt-3 panel-heading">
                    Cart
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Item</th>
                                <th scope='col'>Unit Price</th>
                                <th scope='col'>Quantity</th>
                                <th scope='col'>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('connectdb.php');
                            $query = "select * from item where email='" . $_SESSION['user_email_address'] . "';";
                            $result = $db->query($query);
                            $n = 1;
                            while ($row = $result->fetch()) {
                                echo ('<tr><th scope="row">' . $n . '</th>');
                                echo ('<td>' . $row['item'] . '</td>');
                                echo ('<td>' . $row['price'] . '</td>');
                                echo ('<td>' . $row['quantity'] . '</td>');
                                echo ('<td>' . intval($row['price']) * intval($row['quantity']) . '</td>');
                                echo ('</tr>');
                                $n++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- TODO: Put tax + total stuff here counting the price of items -->
                    <form ng-app="" ng-init='deliver=false; check_email_rec=false; save_addr = false' method="post">
                        <div class="form-group">
                            <label for="email_rec"><input type="checkbox" ng-model='check_email_rec' /> Email Receipt</label>
                            <input type="email" ng-hide='!check_email_rec' class="form-control" id="email_rec" aria-describedby="subtext" value="<?php echo ($_SESSION['user_email_address']) ?>" placeholder="Enter Email" style="width: 50%;">
                            <small id="error-email" ng-hide='!check_email_rec' class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="address"><input type="checkbox" ng-model='deliver' /> Home Delivery</label>
                            <input type="address" ng-hide='!deliver' class="form-control" id="address" aria-describedby="subtext" value="<?php echo ($_SESSION['address']) ?>" placeholder="Enter Address" style="width: 50%;">
                            <small id="subtext" ng-hide='!deliver' class="form-text text-muted"><input type="checkbox" id="save_addr" ng-model='save_addr' /> Save address? We'll never share your email with anyone else.</small>
                            <br><br>
                            

                            <button type="submit" class="btn btn-success" id="submit">Order Now!</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--
            <style>
        #container {
            width: 100%;
        }
        #left {
            float: left;
            width: 100px;
        }
        #right {
            float: right;
            width: 100px;
        }
        #center {
            margin: 0 auto;
            width: 100px;
        }
    </style>
            <div id="left">A</div>
            <div id="center">B</div>
            <div id="right">C</div>
                    -->
        </div>

    </div>
    <script type="text/javascript" src="update.js"></script>
</body>

</html>