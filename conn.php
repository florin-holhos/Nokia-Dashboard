<?php
@session_start();
try
{
    $user = "root";
    $pass = "";
    $conn = new PDO("mysql:host=localhost;dbname=dashboard;charset=utf8", $user, $pass);
} catch(PDOException $e)
{
    echo $e->getMessage();
}

//Include clasa
include_once 'class/User.php';
$user = new User($conn);


?>
