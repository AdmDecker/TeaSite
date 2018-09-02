<?php
require_once('dbaccess.php');

class Notification 
{
    public static function sendNotification($userID, $subject, $message)
    {
        $db = new dbAccess();

        $email = $db->getEmail($userID);
        //Find out if user has notification settings enabled
        if (!$db->getEmailEnabled($userID) || $email == NULL)
        {
            //Don't send anything
            return;
        }

        $itemOrdered = 'Tea';
        
        $requestMessage = filter_var(trim($message, FILTER_SANITIZE_STRING));
        
        $message = "<html>$requestMessage</html>";
        $headers = "From: orders@t.pupperino.net\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
        mail($email, $subject, $message, $headers);
    }
}
?>