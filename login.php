<!-- Header -->
<?php 
include 'header.inc.php'; 

if($user->isLoggedin())
{
    $user->redirect("index.php");
}
?>
<!-- End Header -->

<!-- Content -->
<div class="container postContent">
<div class="alert alert-dismissible alert-primary loginAlert" style="display: none;">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h4 class="alert-heading">Error!</h4>
  <p class="mb-0">You have entered wrong credentials!</p>
</div>
    <div class="jumbotron login">
        <h2>Welcome back!</h2>
        <hr />
        <form id="login">
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
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
            </div>
            <input type="submit" value="Login" id="logButton" class="btn btn-success" />
        </form>
        <hr />
        Don't have an account? <a href="createAccount">Create one</a>
    </div>
</div>
</div>
</main>
<script>
    $(document).ready(function () {
        $('.close').click(function() {
            $('.loginAlert').hide();
        });
        $('#logButton').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $.ajax
                ({
                    type: 'POST',
                    url: 'loginAction.php',
                    data: $('#login').serialize(),
                    success: function (response) {
                        if(response == 2)
                        {
                            $('.loginAlert').show();
                        }
                        else
                        {
                            window.location.href = "index.php";
                        }
                    }
                });
        });
    });
</script>
<!-- End Content -->
<!-- Footer -->
<?php include 'footer.inc.php'; ?>
<!-- End Footer -->