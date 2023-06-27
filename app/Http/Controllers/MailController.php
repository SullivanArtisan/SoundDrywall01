<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// use App\Http\Controllers\Controller;

	class MailController extends Controller {
	   const TO_ADDR = "nuecosoftware@gmail.com";
	   
	   public static function basic_email(Request $request) {
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
			$mail->Username = "nuecosoftware@gmail.com";                 
			$mail->Password = "uqxsdttvfmajplvh";                           
			//If SMTP requires TLS encryption then set it
			$mail->SMTPSecure = "tls";                           
			//Set TCP port to connect to
			$mail->Port = 587;                                   

			$mail->From = "nuecosoftware@gmail.com";
			$mail->FromName = "HOHOHO";

			$mail->addAddress("nuecosoftware@gmail.com", "HAHAHA");

			$mail->isHTML(false);

			$mail->Subject = "Laravel Testing Mail in text mode";
			$mail->Body = "How are you today?";
			// $mail->AltBody = "This is the plain text version of the email content";

			try {
				$mail->send();
				echo "Message has been sent successfully";
			} catch (Exception $e) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
	   }
	   
	   public static function html_email(Request $request) {
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
			$mail->Username = "nuecosoftware@gmail.com";                 
			$mail->Password = "uqxsdttvfmajplvh";                           
			//If SMTP requires TLS encryption then set it
			$mail->SMTPSecure = "tls";                           
			//Set TCP port to connect to
			$mail->Port = 587;                                   

			$mail->From = "nuecosoftware@gmail.com";
			$mail->FromName = "HOHOHO";

			$mail->addAddress("nuecosoftware@gmail.com", "HAHAHA");

			$mail->isHTML(true);

			$mail->Subject = "Laravel Testing Mail in HTML mode";
			$mail->Body = "<i>Mail body in HTML</i>";
			// $mail->AltBody = "This is the plain text version of the email content";

			try {
				$mail->send();
				echo "Message has been sent successfully";
			} catch (Exception $e) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
	   }
	   
	   public static function attachment_email(Request $request) {
		  echo "Email Sent with attachment will be implemented later.";
	   }
	}
?>