<?php
include 'conn.php'; 


$doneStatus = "Done";
$getTicketStatement = $conn->prepare("SELECT * FROM tickets WHERE Status <> :stat AND Issued_by = :uid ORDER BY Priority");
$getTicketStatement->bindParam(":stat", $doneStatus, PDO::PARAM_STR);
$getTicketStatement->bindParam(":uid", $_SESSION['admin'], PDO::PARAM_INT);
$getTicketStatement->execute();

echo $getTicketStatement->rowCount();


?>