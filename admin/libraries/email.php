<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function send_mail($sent_to_email, $sent_to_fullname, $subject, $content, $option = array()) {
    global $config;
    $config_email = $config['email'];
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                                                      // Enable verbose debug output
        $mail->isSMTP();                                                                           // Send using SMTP
        $mail->Host = $config_email['smtp_host'];                                                 // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                                                  // Enable SMTP authentication
        $mail->Username = $config_email['smtp_username'];                                             // SMTP username
        $mail->Password = $config_email['smtp_password'];                                             // SMTP password
        $mail->SMTPSecure = $config_email['smtp_secure'];                                          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port = $config_email['smtp_port'];                                                 // TCP port to connect to
        $mail->CharSet = 'UTF-8';

        //Recipients
        $mail->setFrom($config_email['smtp_username'], $config_email['smtp_fullname']);                       // Add a recipient
        $mail->addAddress($sent_to_email, $sent_to_fullname);                                       // $mail->addAddress('ellen@example.com');                                       
        $mail->addReplyTo($config_email['smtp_username'], $config_email['smtp_fullname']);                    // Name is optional
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        // Content
        $mail->isHTML(true);                                                                        // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $content;                                                                  // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Email không được gửi: Chi tiết lỗi" . $mail->ErrorInfo;
    }
}

// Instantiation and passing `true` enables exceptions

