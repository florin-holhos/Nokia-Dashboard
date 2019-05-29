<?php

include 'conn.php';

if($user->activateAccount($_POST['verifyCode'], $_SESSION['user']))
{
    echo 1;
}
else
{
    echo 2;
}