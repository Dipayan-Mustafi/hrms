<?php
$to = "TO@to.com";
$sub = "SUBJECT";

require("class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host = "mail.domain.com"; // SMTP server
$mail->SMTPAuth = true;
$mail->Username = "xyz@domain.com";
$mail->Password = "XXXXXXXX";

$body    = " BODY ";

$mail->From = "xyz@domain.com";
$mail->FromName = "FROM NAME";

$mail->AddAddress($to);
$mail->Subject = $sub;
$mail->Body = $body;
$mail->WordWrap = 50;

if(!$mail->Send())
{
   echo 'Message was not sent.';
   echo 'Mailer error:  ' . $mail->ErrorInfo;
}
else
{
   echo 'Message has been sent.';
}
?> 