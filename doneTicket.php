<?php

include 'conn.php';

$TID = $_GET['TID'];

if($user->ticketDone($TID))
{
    return true;
}
else
{
    return false;
}

?>