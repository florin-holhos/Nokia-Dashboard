
<!-- Header -->
<?php 
include_once 'conn.php';

if(!isset($_SESSION['admin']))
{
    $user->redirect("index.php");
}

$conn = "";

include 'header.inc.php';
//Fetch data from BD
try
{
    $statement = $conn->prepare('SELECT * FROM users WHERE Active = 1 AND User_id=:uid');
    $statement->bindParam(':uid', $_GET['uid'], PDO::PARAM_INT);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if($statement->rowCount() > 0)
    {
        $UID = $row['User_id'];
        $fullname = $row['Fullname'];
        $email = $row['Email'];
        $password = $row['Password'];
        $gender = $row['Sex'];
        $location = $row['Location'];
    }
}catch(PDOException $e)
{
    echo $e->getMessage();
}

if(isset($_POST['UpdateUser']))
{
    try
    {
        $update = $conn->prepare('UPDATE users SET Fullname=:fullname, Email=:email, Password=:password, Sex=:sex, Location=:location WHERE Active = 1 AND User_id=:uid');
        $hashedPassword = password_hash($_POST['password'],PASSWORD_DEFAULT);
        $statement->execute(array(
            ":fullname" => $_POST['fullname'],
            ":email" => $_POST['email'],
            ":password" => $hashedPassword,
            ':location' => $_POST['location'],
            ':sex' => $_POST['gender']
        ));
    } catch(PDOException $e)
    {
        echo $e->getMessage();
    }
}

?>
<!-- End Header -->

<!-- Content -->
<div class="container postContent">
    <div class="jumbotron login">
        <h2>Update User</h2>
        <hr />
        <form id="login" method="POST" action="">
            <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Full name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $fullname; ?>"
                        placeholder="John Doe">
                </div>
            </div>
            <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="email" value="<?php echo $email; ?>"
                        placeholder="johndoe@domain.com">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>"
                        placeholder="Enter password">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label">Location</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="location" name="location" value="<?php echo $location; ?>"
                        placeholder="Enter location">
                </div>
            </div>
            <div class="form-group row">
                <label  class="col-sm-3 col-form-label" for="gender">Gender</label>
                <div class="row gender">
                    <div class="col">
                        <input type="checkbox" class="form-control" value="M" name="gender[]" <?php echo ($gender == 'Male' ? 'Checked' : ''); ?>> Male
                    </div>
                    <div class="col">
                        <input type="checkbox" class="form-control" value="F" name="gender[]" <?php echo ($gender == 'Female' ? 'Checked' : ''); ?>> Female
                    </div>
                </div>
            </div>
            <input type="submit" value="Update" name="UpdateUser" id="regButton" class="btn btn-success" />
        </form>
    </div>
</div>
</div>
</main>
<!-- End Content -->
<!-- Footer -->
<?php include 'footer.inc.php'; ?>
<!-- End Footer -->