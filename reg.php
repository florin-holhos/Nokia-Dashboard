<?php
include 'conn.php';
$fullName = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];
$location = $_POST['location'];
foreach($_POST['gender'] as $value){
    if($user->createAccount($fullName, $email, $password, $value, $location))
    {
        echo 1;
    }
    else
    {
        echo 2;
    }
}
    



?>