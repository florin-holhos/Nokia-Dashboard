<?php 
include 'conn.php'; 
try
{
    $fullname = "Bogdan Vladutu";
    $email = "bogdan.vladutu@nokia.com";
    $inputPassword = "Bogdan123";
    $pass = PASSWORD_HASH($inputPassword, PASSWORD_DEFAULT);
    $location = "Romania";
    $UID = 2;
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
