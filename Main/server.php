<?php
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Your SMTP host
    $mail->Port = 587; // SMTP port
    $mail->SMTPAuth = true;
    $mail->Username = 'kushagra.work0426@gmail.com'; // Your SMTP username
    $mail->Password = 'mponogeajnmtaeyh'; // Your SMTP password
    $mail->SMTPSecure = 'tls'; // Encryption type (ssl or tls)
    
    $mail->setFrom($email, $username);
    $mail->addAddress('kushagrasaxena0426@gmail.com'); // Recipient's email
    
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;
    
    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent successfully.';
    }
    header("Location: index.html");
    exit;
}
?>
