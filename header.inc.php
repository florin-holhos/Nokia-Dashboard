<?php 
include 'conn.php'; 

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/site.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datepicker3.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="script/liveTimer.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <link rel="stylesheet" href="css/mdb.min.css">
    
    <!-- added -->
    <link rel="stylesheet" type="text/css" href="DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" type="text/css" href="DataTables/Buttons-1.5.6/css/buttons.bootstrap4.min.css"/>
    <link rel="stylesheet" type="text/css" href="DataTables/Responsive-2.2.2/css/responsive.bootstrap4.min.css"/>
    <style>
        body {
            background-color: #181C30;
        }
    </style>
</head>
<body>
    <div class="loaderWw"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index">Dashboard V1.0</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02"
            aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if(@$currentPage=='home') {echo 'active';} ?>">
                    <a class="nav-link" href="index">Home <span class="sr-only">(current)</span></a>
                </li>
                <?php if(!$user->isLoggedin()) { ?>
                <li class="nav-item <?php if(@$currentPage=='login') {echo 'active';} ?>">
                    <a class="nav-link" href="login">Login</a>
                </li>
                <li class="nav-item <?php if(@$currentPage=='register') {echo 'active';} ?>">
                    <a class="nav-link" href="createAccount">Register</a>
                </li>
                <?php } else { 
                if($user->isActive(@$_SESSION['user']) || $user->isActive(@$_SESSION['admin']))
                {    
                ?>
                <li class="nav-item <?php if(@$currentPage=='newTick') {echo 'active';} ?>">
                    <a class="nav-link" href="createTicket">Create new Ticket</a>
                </li>
                <li class="nav-item <?php if(@$currentPage=='myaccount') {echo 'active';} ?>">
                    <a class="nav-link" href="myAccount">My Account</a>
                </li>
                <?php }
                else
                {
                    ?>
                <li class="nav-item <?php if(@$currentPage=='verify') {echo 'active';} ?>">
                    <a class="nav-link" href="verify">Activate</a>
                </li>
                <?php
                } 
                }?>
                <li class="nav-item  <?php if(@$currentPage=='about') {echo 'active';} ?>">
                    <a class="nav-link" href="about">About</a>
                </li>
            </ul>
            <?php if($user->isLoggedin()) { ?>
            <a href="logout.php" class="logout form-inline my-2 my-lg-0">
                Logout&nbsp;<i class="fas fa-sign-out-alt"></i>
            </a>
            <?php } ?>
        </div>
    </nav>
    <script>
        $(document).ready(function () {
            $('.loader').fadeOut();
            $('.loaderWw').fadeOut();
        });
    </script>
    <div class="container-fluid">
        <div class="loader">
            <img src="content/loader.gif" />
            <h4>Loading the best Dashboard ever!</h4>
        </div>