<?php 
include 'conn.php'; 
try
{
    $fullname = "Denis Pavlovic";
    $email = "denis.pavlovic@continental-corporation.com";
    $inputPassword = "De123fgh";
    $pass = PASSWORD_HASH($inputPassword, PASSWORD_DEFAULT);
    $location = "Los Angeles";
    $UID = 1;
    $statement = $conn->prepare("UPDATE users SET Fullname = :fullname, Email = :email, Password=:pass, Location=:location WHERE User_id = :uid");
    $statement->execute(array(
        ":fullname" => $fullname,
        ":email" => $email,
        ":pass" => $pass,
        ":location" => $location,
        ":uid" => $UID
    ));
    echo "Success";
}catch(PDOException $e)
{
    echo $e->getMessage();
}
?>