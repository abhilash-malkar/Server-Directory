<?php


//Destroy entire session data.
session_destroy();

setcookie("fm_email", "", time() - 3600, '/');

unset($_COOKIE['fm_email']);

//redirect page to index.php
header('location: ./login');

?>