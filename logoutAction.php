<?php
include_once 'conn.php'; 

if(isset($_SESSION['user']))
{
    if($user->logout($_SESSION['user']))
    {
       return true;
    }
}
elseif(isset($_SESSION['admin']))
{
    if($user->logout($_SESSION['admin']))
    {
       return true;
    }
}
else
{
    return false;
}


?>