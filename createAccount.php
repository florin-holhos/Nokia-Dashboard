<!-- Header -->
<?php include 'header.inc.php'; ?>
<!-- End Header -->

<!-- password_strength -->
<script type="text/javascript" src="password_strength/password_strength_lightweight.js"></script>
<!-- <script type="text/javascript" src="password_strength/password_strength.js"></script> -->
<!-- <script type="text/javascript" src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script> -->
<link rel="stylesheet" type="text/css" href="password_strength/password_strength.css">


<script>
    $(document).ready(function($) {
        $('#myPassword').strength_meter();

        $('#mySecondPassword').strength_meter({
            inputClass: 'c_strength_input',
            strengthMeterClass: 'c_strength_meter',
            toggleButtonClass: 'c_button_strength'
        });

        $("#myThirdPassword").strength_meter({
            strengthMeterClass: 't_strength_meter'
        });
    });
</script>
<!-- Content -->
<div class="container postContent">
<div class="alert alert-dismissible alert-success registerSuccess" style="display: none;">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h4 class="alert-heading">Success!</h4>
  <p class="mb-0">You have created your account successfully!</p>
</div>
    <div class="jumbotron login">
        <h2>Create a new Account</h2>
        <hr />
        <form id="reg">
            <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Full name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="fullname" name="fullname" value=""
                        placeholder="John Doe">
                </div>
            </div>
            <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="email" value=""
                        placeholder="johndoe@domain.com">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                <div id="myThirdPassword"></div>
                </div>
            </div>
            <div class="form-group row">
                <label  class="col-sm-3 col-form-label" for="gender">Gender</label>
                <div class="row gender">
                    <div class="col">
                        <input type="checkbox" class="form-control" value="Male" name="gender[]"> Male
                    </div>
                    <div class="col">
                        <input type="checkbox" class="form-control" value="Female" name="gender[]"> Female
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Location</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="location" name="location" value=""
                        placeholder="Enter your location">
                </div>
            </div>
            <input type="submit" value="Register" id="regButton" class="btn btn-success" />
        </form>
        <hr />
        Have an account? <a href="login">Login</a>
    </div>
</div>
</div>
<script>
$(document).ready(function() {
    $('.close').click(function() {
        $('.registerSuccess').hide();
    });
    $('#regButton').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $.ajax
                ({
                    type: 'POST',
                    url: 'reg.php',
                    data: $('#reg').serialize(),
                    success: function (response) {
                        if(response == 1)
                        {
                            $('.registerSuccess').show();
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