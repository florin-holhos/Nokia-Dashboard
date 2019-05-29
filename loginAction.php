<?php
include 'conn.php';

if($user->loginAccount($_POST['email'], $_POST['password']))
{
    echo 1;
}
else
{
    echo 2;
}

?>