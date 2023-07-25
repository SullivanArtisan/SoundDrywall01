<?php

namespace App\Helper;

use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Models\StaffAction;

class MyHelper
{  
    // All Job Types
    static $allJobTypes = ["wwww", "xxxx", "yyyy", "zzzz"];

    // Get all Job Types
    public static function GetAllJobTypes() {
        return(MyHelper::$allJobTypes);
    }  

    // Record a staff's action
    public static function LogStaffAction($staff_id, $action, $severity) {
        $staff_act = new StaffAction;
        if ($staff_act) {
            $staff_act->staff_id = $staff_id;
            $staff_act->staff_action = $action;
            $staff_act->staff_action_severity = $severity;
            
            $saved = $staff_act->save();
            if(!$saved) {
                Log::Info("Failed to complete LogStaffAction() for staff ".$staff_id." with action: ".$action.".");
            }
        } else {
            Log::Info("Failed to create a StaffAction object for staff ".$staff_id.".");
        }
        
    }  

    // Record a staff's action result
    public static function LogStaffActionResult($staff_id, $result, $severity) {
        $staff_act = new StaffAction;
        if ($staff_act) {
            $staff_act->staff_id = $staff_id;
            $staff_act->staff_action_result = $result;
            $staff_act->staff_action_severity = $severity;
            
            $saved = $staff_act->save();
            if(!$saved) {
                Log::Info("Failed to complete LogStaffActionResult() for staff ".$staff_id." with result: ".$result.".");
            }
        } else {
            Log::Info("Failed to create a StaffAction object for staff ".$staff_id.".");
        }
        
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