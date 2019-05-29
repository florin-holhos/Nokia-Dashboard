<?php
include '../conn.php';

if($user->isloggedin())
{
    echo "yes";
}
else
{
    echo "no";
}

//Current receiver va fi hardcodat
$receiver = 2;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title><?php if(isset($_SESSION['admin']))
        {
            $uid = $_SESSION['admin'];
        }
        else
        {
            $uid = $_SESSION['user'];
        } echo "uid" . $uid; ?></title>

    <style>
        .messages {
            border: 1px solid black;
            height: 100%;
        }
    </style>
</head>

<body>
    <input type="text" id="textbox" name="messageContent" placeholder="Write a message">

    <div class="messages"></div>

    <script>
        $(document).ready(function () {

            $("#textbox").keypress(function (event) {

                var keycode = (event.keyCode ? event.keyCode : event.which);
                if (keycode == '13') {
                    var messageCont = $('#textbox').val();
                    $.ajax({
                        url: "sendMessage.php",
                        type: "GET",
                        data: {
                            "messageContent": messageCont
                        },
                        success: function (response) {
                            $('#textbox').val("");
                        }
                    });
                }
            });

            $('.messages').load("loadMessages.php");

            setInterval(function () {
                $('.messages').load("loadMessages.php");
            }, 1000);
        });
    </script>
</body>

</html>