<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

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
    $mail->addAddress('gratiela.corha99@e-uvt.ro', 'Gratiela Corha');     // Add a recipient

    // Content
    $mail->isHTML(true); 
    
    
    // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'Test!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}