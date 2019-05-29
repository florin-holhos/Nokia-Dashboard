<?php
include('conn.php');

$doneStatus = 'Done';
$stmt=$conn->prepare('SELECT * FROM tickets WHERE Status = :stat AND Issued_by = :uid');
$stmt->bindParam(':stat', $doneStatus, PDO::PARAM_STR);
$stmt->bindParam(':uid', $_SESSION['admin'], PDO::PARAM_INT);
$stmt->execute();


$columnHeader ='';
$columnHeader = "Ticket ID,".""."Ticket Name,".""."Issued By,".""."Status,".""."Priority,".""."Deadline,".""."Short Description,".""."Client,".""."Location,".""."Date Created"."";


$setData='';

while($rec =$stmt->FETCH(PDO::FETCH_ASSOC))
{
  $rowData = '';
  foreach($rec as $value)
  {
    $value = '' . $value . ',' . "";
    $rowData .= $value;
  }
  $setData .= trim($rowData)."\n";
}


header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=Tickets.csv");

echo ucwords($columnHeader)."\n".$setData."\n";

?>