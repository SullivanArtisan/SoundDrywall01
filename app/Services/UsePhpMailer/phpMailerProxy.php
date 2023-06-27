<?php

namespace App\Services\UsePhpMailer;

use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PhpMailerProxy
{
	public function SendBasicEmail(String $smtpUserName, String $smtpPass, String $mailFromAddr, String $mailFromName, String $mailToAddr, String $subject, String $contents) {
		$mail = new PHPMailer(true);

		//Enable SMTP debugging.
		// $mail->SMTPDebug = 3;                               
		//Set PHPMailer to use SMTP.
		$mail->isSMTP();            
		//Set SMTP host name                          
		$mail->Host = "smtp.gmail.com";
		//Set this to true if SMTP host requires authentication to send email
		$mail->SMTPAuth = true;                          
		//Provide username and password     
		$mail->Username = $smtpUserName;                 
		$mail->Password = $smtpPass;                           
		//If SMTP requires TLS encryption then set it
		$mail->SMTPSecure = "tls";                           
		//Set TCP port to connect to
		$mail->Port = 587;                                   

		$mail->From = $mailFromAddr;
		$mail->FromName = $mailFromName;

		$mail->addAddress($mailToAddr, "");

		$mail->isHTML(false);

		$mail->Subject = $subject;
		$mail->Body = $contents;
		// $mail->AltBody = "This is the plain text version of the email content";

		try {
			$mail->send();
		} catch (Exception $e) {
			Log::info("Mailer Error2: " . $mail->ErrorInfo);
		}
   }
}

?>