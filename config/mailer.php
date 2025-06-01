<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../PHPMailer/PHPMailer.php';
require_once '../PHPMailer/SMTP.php';
require_once '../PHPMailer/Exception.php';

function sendMail($to,$subject,$message){
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
        return true;
    }
    catch(Exception $e){
        return false;
    }
}
?>