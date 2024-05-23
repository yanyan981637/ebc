<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require './vendor/autoload.php';

session_start();
$post = json_decode(file_get_contents('php://input'), true);
if (isset($post) && $_SESSION['csrf_token'] !== $post['csrf']) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

unset($_SESSION['csrf_token']);
//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.site.taipei';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'service@tyanvirtual.com';                     //SMTP username
    $mail->Password   = 'wUcqZ8Hice7zVf7';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->Charset    = "UTF-8"; // 中文編碼
    //Recipients
    $mail->setFrom('service@tyanvirtual.com', 'TYAN Sender');
    $mail->addAddress('tyanvirtual2021@gmail.com', 'TYAN Receiver');     //Add a recipient
    // $mail->addAddress('salmon918@gmail.com', 'Handsome Simon');               //Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

    //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "=?utf-8?B?" . base64_encode("TYAN 測試用標題") . "?=";
    $mail->Body    = "COMPANY: {$post['company']}<br/> E-MAIL: {$post['email']}<br/> NAME:{$post['name']}<br/> AREA:{$post['area']}";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'ok';
} catch (Exception $e) {
    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
