<!-- Header -->
<?php 

include 'header.inc.php'; 


if(isset($_SESSION['admin']))
{
    $uid = $_SESSION['admin'];
}
else
{
    $uid = $_SESSION['user'];
}

if($user->isActive($uid))
{
    $user->redirect("index");
}

try
{
    $statement = $conn->prepare('SELECT * FROM users WHERE User_id=:uid');
    $statement->bindParam(":uid", $uid, PDO::PARAM_INT);
    $statement->execute();
    $row=$statement->fetch(PDO::FETCH_ASSOC);
    if($statement->rowCount() > 0)
    {
        $getFullname = $row['Fullname'];
        $getLocation = $row['Location'];
        $getEmail = $row['Email'];
    }

    $statement2 = $conn->prepare('SELECT * FROM user_settings WHERE Id=:uid');
    $statement2->bindParam(':uid', $uid, PDO::PARAM_INT);
    $statement2->execute();
    $row2=$statement2->fetch(PDO::FETCH_ASSOC);
    if($statement2->rowCount() > 0)
    {
        $getImageUrl = $row2['Avatar'];
    }
}catch(PDOException $e)
{
    echo $e->getMessage();
}

?>
<!-- End Header -->



<style>
    input.form-control.col-md-6 {
        width: 50%;
        margin-right: 1em;
        display: inline;
    }

    div#notes {
        margin-top: 2%;
        width: 98%;
        margin-left: 1%;
    }

    @media (min-width: 991px) {
        .col-md-9.col-sm-12 {
            margin-left: 12%;
        }
    }
</style>

<!-- Content -->
<div class="container postContent">
    <div class="alert alert-dismissible alert-success activateSuccess" style="display: none;">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4 class="alert-heading">Success!</h4>
        <p class="mb-0">Your Account is now Active!</p>
    </div>
    <div class="jumbotron text-center">
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron text-center">
                    <h2><?php echo $getFullname . " (uid" . $uid . ")"; ?></h2>
                    <hr />
                    <h4>Before using this platform, activate your account.</h4>
                    <form id="ff">
                        <div class="col-md-9 col-sm-12">
                            <div class="form-group form-group-lg">
                                <input type="text" placeholder="Enter activation code" maxlength="16"
                                    class="form-control col-md-6 col-sm-6 col-sm-offset-2 inpAct" name="verifyCode"
                                    required="">
                                <input class="btn btn-primary btn-lg col-md-2 col-sm-2 inpAct" id="act" type="submit" value="Verify">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.close').click(function () {
            $('.activateSuccess').hide();
        });
        $('#act').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $.ajax
                ({
                    type: 'POST',
                    url: 'activateAccount.php',
                    data: $('#ff').serialize(),
                    success: function (response) {
                        alert(response);
                        if (response == 1) {
                            $('.activateSuccess').show();
                            $('.inpAct').prop('disabled', true);
                        }
                    }
                });
        });
    });
</script>
</main>
<!-- End Content -->
<!-- Footer -->
<?php include 'footer.inc.php'; ?>
<!-- End Footer -->