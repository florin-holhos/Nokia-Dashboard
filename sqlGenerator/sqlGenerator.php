<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Generate SQL Code</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php

$myFile = fopen("names.txt", "r") or die("Unable to open file!");

$nameList = array();

//Output one line until EOF
while(!feof($myFile)) {
    array_push($nameList, fgets($myFile));
}

//Sample SQL Code
//INSERT INTO tickets(Ticket_name, Issued_by, Status, Priority, Client, Location) VALUES("Ticket i", 1, "Done", 1, {{CLIENTNAME}}, "Los Angeles");

//Read from list
for($i = 0; $i<2000; $i++)
{
    $n = $i+1;
    echo "INSERT INTO tickets(Ticket_name, Issued_by, Status, Priority, Client, Location) VALUES('Ticket " . $n . "', 1, 'Done', 1, '" . $nameList[$i] . "', 'Los Angeles'); <br />";
    //echo "INSERT INTO ticket_history (Ticket_id, Done_by) VALUES(".$n.", 1); <br />";
}

fclose($myFile);

?>    
</body>
</html>
