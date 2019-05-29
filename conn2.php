<?php
@session_start();
try
{
    $user = "denispav_admin";
    $pass = "0Qn19)b^;yp#";
    $conn = new PDO("mysql:host=localhost;dbname=denispav_dashboard;charset=utf8", $user, $pass);
} catch(PDOException $e)
{
    echo $e->getMessage();
}

//Include clasa
include_once 'class/User.php';
$user = new User($conn);


?>
