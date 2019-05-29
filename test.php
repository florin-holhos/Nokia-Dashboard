<?php
foreach ($_POST['priority'] as $prio)
{
    //Insert
    //For addTicket
    date_default_timezone_set('Europe/Bucharest');
    $datetime = new DateTime();
    //
    $total = $prio * 2;
    $datetime->modify('+'.$total.' hour');
    echo $datetime->format('Y-m-d H:i:s');
}
?>