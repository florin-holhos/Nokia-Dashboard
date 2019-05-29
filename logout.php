<?php
    include_once 'conn.php';

    if(isset($_SESSION['admin']))
    {
        if($user->logout($_SESSION['admin']))
        {
            $user->redirect("index.php");
        }
    }
    elseif(isset($_SESSION['user']))
    {
        if($user->logout($_SESSION['user']))
        {
            $user->redirect("index.php");
        }
    }
    else
    {
        $user->redirect("index.php");
    }
?>