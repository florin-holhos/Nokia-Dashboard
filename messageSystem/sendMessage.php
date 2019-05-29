<?php

include '../conn.php';

if(isset($_SESSION['admin']))
{
    $uid = $_SESSION['admin'];
}
else
{
    $uid = $_SESSION['user'];
}

$sender = $uid;

try
{
    $statement = $conn->prepare("INSERT INTO message(sender, receiver, message) VALUES(:sender, :receiver, :message)");
    $statement->execute(array(
        ':sender' => $sender,
        ':receiver' => 2,
        ':message' => $_GET['messageContent']
    ));
}catch(PDOException $e)
{
    echo $e->getMessage();
}

?>