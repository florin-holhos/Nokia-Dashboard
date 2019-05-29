<?php

include '../conn.php';

$uid=2;

try
{
    $statement = $conn->prepare("SELECT * FROM message ORDER BY id DESC");
    $statement->execute();

    $rows=$statement->fetchAll();

    if($statement->rowCount() > 0)
    {
        foreach($rows as $message)
        {
            echo $message['message_sent'] . ": " . $message['message'] . "<br/>";
        }
    }
}catch(PDOException $e)
{
    echo $e->getMessage();
}

?>