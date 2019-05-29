<?php
include 'conn.php';
try
{
    $doneStatus = "Done";
    $getTicketStatement = $conn->prepare("SELECT * FROM tickets WHERE Status <> :stat AND Issued_by = :uid ORDER BY Priority");
    $getTicketStatement->bindParam(":stat", $doneStatus, PDO::PARAM_STR);
    $getTicketStatement->bindParam(":uid", $_SESSION['admin'], PDO::PARAM_INT);
    $getTicketStatement->execute();

    //Foreach
    $getTicket = $getTicketStatement->fetchAll();

    if($getTicketStatement->rowCount() > 0)
    {
        echo 1;
    }
    else
    {
        echo 0;
    }
    
}catch(PDOException $e)
{
    echo $e->getMessage();
}
?>