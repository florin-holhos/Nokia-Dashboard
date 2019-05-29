<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Exporting excel....</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        .Excelloader {
            width: 400px;
            height: 100px;
            text-align: center;
            z-index: 500;
            color: white;

            position: absolute;
            top: 50%;
            left: 50%;

            margin: -150px 0 0 -200px;

        }
    </style>
</head>

<body>
    <script>
    $(document).ready(function() {
        setTimeout(function() {
            if(window.open("exportExcel.php"))
            {
                window.location.href = "index.php";
            }
        }, 2000);
    });
    </script>
    <div class="Excelloader">
        <h4><img src="content/excel-loader.gif" />Exporting excel...</h4>
    </div>
</body>

</html>