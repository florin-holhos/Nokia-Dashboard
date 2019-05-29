<?php 

include 'conn.php';

if(isset($_SESSION['admin']))
{
    $uid = $_SESSION['admin'];
}
else if(isset($_SESSION['user']))
{
    $uid = $_SESSION['user'];
}
else
{
    //
}

    //If $_FILES is not empty continue
    if($_FILES['fileToUpload']['error'] != 4) {
        $path = "users/uid".$uid."avatar/";

        if(!is_dir($path))
        {
            mkdir($path, 0755, true);
        }
        
        // image and image_tmp
        $img = $_FILES["fileToUpload"]["name"];
        $img_tmp = $_FILES["fileToUpload"]["tmp_name"];
        $path = $path . $img;

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 50000000) {
            die("Sorry, your file is too large.");
        } else {
            // if everything is ok, try to upload file
            if (move_uploaded_file($img_tmp, $path)) {
                //Update only
                $updateSettings = $conn->prepare("UPDATE user_settings SET Avatar=:avatar WHERE User_id = :uid");
                $updateSettings->execute(array(
                    ':uid' => $uid,
                    ':avatar' => $path
                ));

                echo $path;
            } else {
                die("Sorry, there was an error uploading your file.");
            }
        }
    }
    else // do nothing
    {
        return;
    }