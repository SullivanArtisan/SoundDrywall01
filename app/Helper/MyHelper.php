<?php

namespace App\Helper;

use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Models\Booking;
use App\Models\Container;

class MyHelper
{  
    // All OPS Codes
    static $allOpsCodes = ["Local", "Highway", "Admin"];

    // All Job Types
    static $allJobTypes = ["Import", "Export", "Empty Repo", "Yard Move", "Other", "CBSA"];

    // All Movement Types
    static $allMovementTypes = ["Container Pickup", "Container Drop", "Chassis Pickup", "Chassis Drop", "Port Pickup", "Port Drop",
                                 "Customer Pickup", "Customer Drop", "Other Pickup", "Other Drop", "Live Pickup", "Live Drop", "HarbourLink Pickup", "HarbourLink Drop", 
                                 "Empty Pickup", "Empty Drop", "Bobtail Pickup", "Bobtail Drop", "Cancelled Leg", "Dead Run", "Street Turn"];

    //=================================================================================================================================================================

    // Get all Job Types
    public static function GetAllOpsCodes() {
        return(MyHelper::$allOpsCodes);
    }  

    // Get all Job Types
    public static function GetAllJobTypes() {
        return(MyHelper::$allJobTypes);
    }  

    // Get all Movement Types
    public static function GetAllMovementTypes() {
        return(MyHelper::$allMovementTypes);
    }  
                                 
    // Get commonly used Movement Types
    public static function GetCommonMovementTypes() {
        $commonMTs = [];
        for ($i=0; $i<12; $i++) {
            $commonMTs[$i] = MyHelper::$allMovementTypes[$i];
        }

        return($commonMTs);
    }  

    //============================================== for bookings status =============================================
    // Get the 'created' booking status
    public static function BkCreatedStaus() {
        return "bk_created";
    }  

    // Get the 'completed' booking status
    public static function BkCompletedStaus() {
        return "completed";
    }  

    //============================================== for containers status =============================================
    // Get the 'created' container status
    public static function CntnrCreatedStaus() {
        return "cntnr_created";
    }  

    // Get the 'sent' container status
    public static function CntnrSentStaus() {
        return "cntnr_sent";
    }  

    // Get the 'dispatched' container status
    public static function CntnrDispatchedStaus() {
        return "cntnr_dispatched";
    }  

    // Get the 'completed' container status
    public static function CntnrCompletedStaus() {
        return "cntnr_completed";
    }  

    //============================================== for dbg log types =============================================
    // Get the 'created' booking status
    public static function DbgErrorType() {
        return "dbg_error";
    }  

    // Get the 'completed' booking status
    public static function DbgInfoType() {
        return "dbg_info";
    }  





    // Get the hyphen separated phone number
    public static function GetHyphenedPhoneNo($digitalNo) {
        $len = strlen($digitalNo);
        
        if ($len == 7) {
            return substr($digitalNo, 0, 3).'-'.substr($digitalNo, 3, 4);
        } elseif ($len == 10) {
            return substr($digitalNo, 0, 3).'-'.substr($digitalNo, 3, 3).'-'.substr($digitalNo, 6, 4);
        } elseif ($len == 11) {
            return substr($digitalNo, 0, 1).'-'.substr($digitalNo, 1, 3).'-'.substr($digitalNo, 4, 3).'-'.substr($digitalNo, 7, 4);
        } else {
            return $digitalNo;
        }
    } 

    // Get the numerice phone number only (no hyphen, no parantheses, no space...)
    public static function GetNumericPhoneNo($inPhoneNo) {
        $len = strlen($inPhoneNo);
        $numericPhoneNo = "";
        
        for ($idx=0; $idx<$len; $idx++) {
            $currentChar = substr($inPhoneNo, $idx, 1);
            if ($currentChar >= chr(48) && $currentChar <= chr(57)) {
                $numericPhoneNo .= $currentChar;
            }
        }

        return $numericPhoneNo;
    } 

    // Send an email ....
    public static function SendThisEmail($rec_email, $rec_name, $subject, $body) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();            
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;                          
        //Provide username and password     
        $mail->Username = "nuecosoftware@gmail.com";                 
        $mail->Password = "uqxsdttvfmajplvh";                           
        //If SMTP requires TLS encryption then set it
        $mail->SMTPSecure = "tls";                           
        //Set TCP port to connect to
        $mail->Port = 587;                                   
    
        $mail->From = "nuecosoftware@gmail.com";
        $mail->FromName = "Quasar Dispatching Administrator";
    
        $mail->addAddress($rec_email, $rec_name);
    
        $mail->isHTML(false);
    
        $mail->Subject = $subject;
        $mail->Body = $body."\r\n\r\n\r\nRegards,\r\n\r\n".$mail->FromName;
        // $mail->AltBody = "This is the plain text version of the email content";
    
        try {
            $mail->send();
            Log::Info("Message has been sent successfully");
        } catch (Exception $e) {
            Log::Info("Mailer Error: " . $mail->ErrorInfo);
        }
    } 
}

?>