<?php

include '../conn.php';

$statement = $conn->prepare("SELECT User_id, Fullname FROM users WHERE Active=1");
$statement->execute();

//Initialize array variable
$data = array();

//Fetch info associative array
while($row=$statement->fetch(PDO::FETCH_ASSOC))
{
    $data[] = $row;
}


//Print array in JSON format
echo " var data = " . json_encode($data);
?>