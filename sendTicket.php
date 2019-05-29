<?php
include 'conn.php';

if($user->sendTicket($_POST['ticketName'], $_POST['issuedBy'], $_POST['priority'], $_POST['client'], $_POST['shortDesc'], $_POST['Location']))
{
    echo 1;
}
else
{
    echo 2;
}

?>