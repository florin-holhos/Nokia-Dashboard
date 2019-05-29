<?php
class User
{
    function __construct($conn)
    {
        $this->db = $conn;
    }

    //Creating account
    public function createAccount($Fullname, $email, $password, $Sex, $Location)
    {

        function createRandomPassword() { 

            $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
            srand((double)microtime()*1000000); 
            $i = 0; 
            $pass = '' ; 
        
            while ($i <= 15) { 
                $num = rand() % 33; 
                $tmp = substr($chars, $num, 1); 
                $pass = $pass . $tmp; 
                $i++; 
            } 
        
            return $pass; 
        
        }

        //Verificatm daca Email-ul nu este deja ocupat
        $verifyEmail = $this->db->prepare("SELECT Email FROM users WHERE Email = :email");
        $verifyEmail->bindParam(':email', $email, PDO::PARAM_STR);
        $verifyEmail->execute();

        //
        if($verifyEmail->rowCount() > 0)
        {
            return false;
        }
        else
        {
            try
            {
                $registerStatement = $this->db->prepare('INSERT INTO users(Fullname,Email,Password, Sex, Location) VALUES(:fullname, :email, :password, :sex, :location)');
                //HASHED PASSWORD
                $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
                $registerStatement->execute(array(
                    ':fullname' => $Fullname,
                    ':email' => $email,
                    ':password' => $hashedPassword,
                    ':sex' => $Sex,
                    ':location' => $Location
                ));

                if($registerStatement->rowCount() > 0)
                {
                    //Dupa generare un cod
                    $generatedNumber = createRandomPassword();

                    $getUidStatement = $this->db->prepare("SELECT * FROM users WHERE Email=:email");
                    $getUidStatement->bindParam(":email", $email, PDO::PARAM_STR);
                    $getUidStatement->execute();
                    $row = $getUidStatement->fetch(PDO::FETCH_ASSOC);
                    if($getUidStatement->rowCount() > 0)
                    {
                        $getUID = $row['User_id'];

                        //Insert into creation_code
                        $creationCodeStatement = $this->db->prepare('INSERT INTO creation_code(uid, activation_code) VALUES(:uid, :activation_code)');
                        $creationCodeStatement->execute(array(
                            ':uid' => $getUID,
                            ':activation_code' => $generatedNumber
                        ));

                        return true;

                        //Mail SMTPT

                    }
                }



            }catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
    }

    public function ticketDone($ticketID)
    {
        $statement = $this->db->prepare("SELECT * FROM tickets WHERE Ticket_id=:ticketid");
        $statement->bindParam(":ticketid", $ticketID, PDO::PARAM_INT);
        $statement->execute();
        if($statement->rowCount() > 0)
        {
            $updateStatement = $this->db->prepare("UPDATE tickets SET Status='Done' WHERE Ticket_id=:tickid");
            $updateStatement->bindParam(":tickid", $ticketID, PDO::PARAM_INT);
            $updateStatement->execute();
            return true;
        }
    }

    //Function for sending emails
    public function sendEmails($recipient, $fullname, $subject, $text)
    {
        // Import PHPMailer classes into the global namespace
        // These must be at the top of your script, not inside a function
        //use PHPMailer\PHPMailer\PHPMailer;
        //use PHPMailer\PHPMailer\Exception;

        // Load Composer's autoloader
        require '../vendor/autoload.php';

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com;';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'denisthepavlovic@gmail.com';                     // SMTP username
            $mail->Password   = 'D3n1s&4ndr334f0r3v3r55321755';                               // SMTP password
            $mail->SMTPSecure = 'tsl';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->ClearAllRecipients();
            $mail->setFrom('from@dashboard.com', 'Dashboard Nokia');

            //Set email and fullname
            $mail->addAddress($recipient, $fullname);     // Add a recipient

            // Content
            $mail->isHTML(true); 
            
            
            // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    =  $text . '</b>';
            $mail->AltBody = $text;

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    //Activate Account
    public function activateAccount($code, $uid)
    {
        //Verify if the uid exist in table creation_code
        try
        {
            $verifyStatement = $this->db->prepare("SELECT * FROM creation_code WHERE activation_code=:activation_code AND uid=:uid");
            $verifyStatement->bindParam(':activation_code', $code, PDO::PARAM_STR);
            $verifyStatement->bindParam(":uid", $uid, PDO::PARAM_INT);
            $verifyStatement->execute();

            if($verifyStatement->rowCount() > 0)
            {
                    //If this is true activate account
                    $activateAccount = $this->db->prepare("UPDATE users SET Active=1 WHERE User_id = :uid");
                    $activateAccount->bindParam(":uid", $uid, PDO::PARAM_INT);
                    $activateAccount->execute();

                    //Account is activated successfully!
                    //Working on this 
                    /*
                    $getStatement = $this->db->prepare("SELECT * FROM users WHERE User_id=:uid");
                    $getStatement->bindParam(":uid", $uid, PDO::PARAM_INT);
                    $getStatement->execute();

                    $row = fetch(PDO::FETCH_ASSOC);

                    if($getStatement->rowCount() > 0)
                    {
                        $email = $row['Email'];
                        $fullname = $row['Fullname'];
                        //SMTP
                        //Send an Email that the Account is activated
                        if($this->sendEmails($email, $fullname, 'Dashboard: Activation Account', 'Here is the activation code: ' . $code))
                        {
                            return true;
                        }
                        else
                        {
                            return true;
                        }
                    }

                    */
                    


                    return true;
            }
                else
                {
                    //Display an error message, that the code is not correct written
                    return false;
                }
            }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }


    //Activated Account
    public function isActive($uid)
    {
        try
        {
            $statement = $this->db->prepare("SELECT * FROM users WHERE User_id=:uid AND Active=1");
            $statement->bindParam(":uid", $uid, PDO::PARAM_INT);
            $statement->execute();
            if($statement->rowCount() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    //Admin list ID
    public function isAdmin($email)
    {
        //List of email Admin
        $adminEmail = array("denis.pavlovic@continental-corporation.com", "bogdan.vladutu@nokia.com","florin.holhos92@gmail.com");
        if(in_array($email, $adminEmail))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //Is Logged in
    public function isLoggedin()
    {
        if(isset($_SESSION['admin']))
        {
            return true;
        }
        else if(isset($_SESSION['user']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //Login Account
    public function loginAccount($email, $password)
    {
        if(!empty($email) || !empty($password))
        {
            try {
                $statement = $this->db->prepare("SELECT * FROM users WHERE Email = :email");
                $statement->bindParam(":email", $email, PDO::PARAM_STR);
                $statement->execute();
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                if($statement->rowCount() > 0)
                {
                    if(password_verify($password, $row['Password']))
                    {
                        //Pentru admini
                        if($this->isAdmin($email))
                        {
                            $_SESSION['admin'] = $row['User_id'];
                            echo true;
                        }
                        else
                        {
                            $_SESSION['user'] = $row['User_id'];
                            echo true;
                        }
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    //Get fullname
    public function getFullName()
    {
        try
        {
            if(isset($_SESSION['admin']))
            {
                $uid = $_SESSION['admin'];
            }
            else
            {
                $uid = $_SESSION['user'];
            }
            $statement = $this->db->prepare("SELECT * FROM users WHERE User_id = :uid");
            $statement->bindParam(":uid", $uid, PDO::PARAM_INT);
            $statement->execute();
            if($statement->rowCount() > 0)
            {
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                return $row['Fullname'];
            }
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getname($uid)
    {
        try
        {
            $statement = $this->db->prepare("SELECT * FROM users WHERE User_id = :uid");
            $statement->bindParam(":uid", $uid, PDO::PARAM_INT);
            $statement->execute();
            if($statement->rowCount() > 0)
            {
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                return $row['Fullname'];
            }
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getIssuedBy($uid)
    {
        try
        {
            $statement = $this->db->prepare("SELECT * FROM users WHERE User_id = :uid");
            $statement->bindParam(":uid", $uid, PDO::PARAM_INT);
            $statement->execute();
            if($statement->rowCount() > 0)
            {
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                return $row['Fullname'];
            }
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    //Redirect
    public function redirect($url)
    {
        header("Location: " . $url);
    }

    //Logout
    public function logout($sess)
    {
        session_destroy();
        unset($sess);
        return true;
    }

     //get seconds
     public function getSeconds($ticketID)
     {
         try
         {
            date_default_timezone_set('Europe/Bucharest');
            $stat = "Done";
            $statement = $this->db->prepare('SELECT * FROM tickets WHERE Ticket_id = :tickID AND Status <> :statTicket');
            $statement->bindParam(':statTicket', $stat, PDO::PARAM_STR);
            $statement->bindParam(':tickID', $ticketID, PDO::PARAM_INT);
            $statement->execute();
            $row=$statement->fetch(PDO::FETCH_ASSOC);
            $date1 = new DateTime($row['Deadline']);
            $now = new DateTime();
            $difference_in_seconds = $date1->format('U') - $now->format('U');
            //echo $row['timp'];
            return $difference_in_seconds;
        } catch(PDOException $e)
         {
             echo $e->getMessage();
         }
     }

     //get total nr of seconds for timer background
     public function getSecondsTotal($ticketID)
     {
         try
         {
            date_default_timezone_set('Europe/Bucharest');
            $stat = "Done";
            $statement = $this->db->prepare('SELECT * FROM tickets WHERE Ticket_id = :tickID AND Status <> :statTicket');
            $statement->bindParam(':statTicket', $stat, PDO::PARAM_STR);
            $statement->bindParam(':tickID', $ticketID, PDO::PARAM_INT);
            $statement->execute();
            $row=$statement->fetch(PDO::FETCH_ASSOC);
            $date1 = new DateTime($row['Data_created']);
            $date2 = new DateTime($row['Deadline']);
            $difference_in_seconds = $date2->format('U') - $date1->format('U');
            //echo $row['timp'];
            return $difference_in_seconds;

         } catch(PDOException $e) 
         {
            echo $e->getMessage();
         }
     }

    //Create a ticket {{if user is logged in and have an account}}
    public function sendTicket($ticketname, $issuedby, $priority, $client, $shortDesc, $Location)
    {
        try
        {
            foreach ($priority as $prio)
            {
                //Insert
                //For addTicket
                date_default_timezone_set('Europe/Bucharest');
                $datetime = new DateTime();
                //
                $total = $prio * 2;
                $datetime->modify('+'.$total.' hour');
                $deadline = $datetime->format('Y-m-d H:i:s');
            $statement = $this->db->prepare("INSERT INTO tickets(Ticket_name, Issued_by, Priority, Deadline, Client, shortDesc, Location) VALUES(:ticketname, :issuedby, :priority, :deadline, :client, :shortdesc, :loc)");
            $statement->execute(array(
                ':ticketname' => $ticketname,
                ':issuedby' => $issuedby,
                ':priority' => $prio,
                ':deadline' => $deadline,
                ':client' => $client,
                ':shortdesc' => $shortDesc,
                ':loc' => $Location
            ));
            }
            return true;
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}
?>
