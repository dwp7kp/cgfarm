<?php

include('config.php');

$google_client->revokeToken();
session_destroy();

// Jump back. TODO: This will need to jump to the Angular homepage buuuut can't do that now
header('location:profile.php');

?>