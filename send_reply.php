<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $to = $_POST['email'];
    $message = $_POST['message'];
    $subject = "Doctor's Response to Your Check-up";

    $mail = new PHPMailer(true);

    try{
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username ='ashiqxavier4@gmail.com';
        $mail->Password = 'bglb ioux paap zycg';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->SMTPOptions =[
            'ssl' =>[
                'verify_peer'=> false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
            ];

        $mail->setfrom('ashiqxavier4@gmail.com','Hospital Doctor');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo "Email sent";
    }
    catch(Exception $e){
        echo "Email could not be sent. Error:{$mail->ErrorInfo}";
    }
}
?>