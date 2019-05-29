<?php

include 'conn.php';

if(isset($_SESSION['admin']))
{
    $uid = $_SESSION['admin'];
}
else if(isset($_SESSION['user']))
{
    $uid = $_SESSION['user'];
}
else
{
    //
}

try
{
    $statement = $conn->prepare("UPDATE users SET Fullname=:fullname, Email=:email, Location=:location WHERE User_id=:uid");
    $statement->execute(array(
        ':fullname' => $_POST['fullname'],
        ':email' => $_POST['email'],
        ':location' => $_POST['location'],
        ':uid' => $uid
    ));

    $statement2 = $conn->prepare("UPDATE user_settings SET Email_notification=:emailNot WHERE User_id=:uid");
    $statement2->execute(array(
        ':emailNot' => $_POST['emailNot'], 
        ':uid' => $uid
    ));

} catch (PDOException $e) {
    echo $e->getMessage();
}