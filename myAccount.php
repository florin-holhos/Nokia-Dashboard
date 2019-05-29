<!-- Header -->
<?php 
include_once 'conn.php';

if(!$user->isLoggedin())
{
    $user->redirect("index.php");
}

$conn = "";
$currentPage='myaccount';
include 'header.inc.php'; 

if(isset($_SESSION['admin']))
{
    $uid = $_SESSION['admin'];
}
else
{
    $uid = $_SESSION['user'];
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

    $statement2 = $conn->prepare('SELECT * FROM user_settings WHERE User_id=:uid');
    $statement2->bindParam(':uid', $uid, PDO::PARAM_INT);
    $statement2->execute();
    $row2=$statement2->fetch(PDO::FETCH_ASSOC);
    if($statement2->rowCount() > 0)
    {
        $getImageUrl = $row2['Avatar'];
        $getEmailNotification = $row2['Email_notification'];
    }
}catch(PDOException $e)
{
    echo $e->getMessage();
}

?>
<style>

</style>
<!-- End Header -->

<!-- Content -->
<div class="container postContent">
    <div class="alert alert-dismissible alert-success updateSuccess" style="display: none;">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4 class="alert-heading">Success!</h4>
        <p class="mb-0">Your Account settings has been updated!</p>
    </div>
    <div class="jumbotron ticket">
        <h2><?php echo $getFullname . " (uid" . $uid . ")"; ?></h2>
        <hr />
        <form enctype="multipart/form-data">
            <div class="file-field">
                <div class="mb-4">
                    <?php if($statement2->rowCount() > 0)
        {
            ?>   
                    <img src="<?php echo $getImageUrl; ?>" class="rounded-circle z-depth-1-half avatar-pic"
                        alt="<?php echo $getFullname; ?>">

                    <?php

        }
        else
        {
            ?>
                    <img src="https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg"
                        class="rounded-circle z-depth-1-half avatar-pic" alt="example placeholder avatar">
                    <?php
        }
        ?>

                </div>
                <div class="d-flex justify-content-center">
                    <div class="btn btn-mdb-color btn-rounded float-left">
                        <span>Add photo</span>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label for="ticketName" class="col-sm-3 col-form-label">Fullname</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="ticketName" name="fullname"
                        value="<?php echo $getFullname; ?>" placeholder="Enter fullname">
                </div>
            </div>
            <div class="form-group row">
                <label for="ticketName" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control sssss" name="email" readonly value="<?php echo $getEmail; ?>"
                        placeholder="Enter fullname">
                </div>
            </div>
            <div class="form-group row">
                <label for="client" class="col-sm-3 col-form-label">Location</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="location" name="location"
                        value="<?php echo $getLocation; ?>" placeholder="Enter location">
                </div>
            </div>
            <div class="form-group row">
                <label for="client" class="col-sm-3 col-form-label">Email notification</label>
                <div class="col-sm-9">
                    <select class="form-control" name="emailNot" id="emailNot">
                        <?php if($getEmailNotification) { ?>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        <?php } else { ?>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <input type="submit" id="update" value="UPDATE" name="submit" class="btn btn-info">

        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('#update').unbind('click').bind('click', function (event) {
                event.preventDefault();
                //Serialize the entire form
                var data = new FormData(this.form);
                $.ajax
                    ({
                        url: 'updateProfile.php',
                        type: 'POST',
                        data: data,
                        processData: false,
                        cache: false,
                        contentType: false,
                        success: function (response) {
                            $('.updateSuccess').fadeIn(300);
                        }
                    });
            });

            $(':file').change(function(event){
                event.preventDefault();
                // image file input
                let file = this.files[0];
                let fileType = file['type'];
                let validImageFormats = ['image/jpeg', 'image/gif', 'image/png'];
                if($.inArray(fileType, validImageFormats) < 0){
                    alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                    $(this).val('');
                } else {
                    var data = new FormData(this.form);
                    $.ajax({
                        url: 'updateAvatar.php',
                        type: 'POST',
                        data: data,
                        processData: false,
                        cache: false,
                        contentType: false,
                        success: function(response) {
                            if(response.startsWith('users/')){
                                $("img.rounded-circle").fadeOut(300);
                                setTimeout(function(){
                                    $('img.rounded-circle').attr('src', response);
                                    $("img.rounded-circle").fadeIn(300);
                                }, 300);
                            } else if(!response.trim()) {
                                return;
                            } else {
                                alert(response);
                            }
                        }
                    });
                }

            });
        });
    </script>
</div>
</div>
</main>
<!-- End Content -->
<!-- Footer -->
<?php include 'footer.inc.php'; ?>
<!-- End Footer -->