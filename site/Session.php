<?php
require_once('dbaccess.php');
require_once('PupError.php');

class PupSession {
    
    public static function Create($timeout, $username, $userID, $userType, $teas)
    {
        //Start the session
        PupSession::LoadSession();
        $_SESSION['timeout'] = time() + $timeout;
        $_SESSION['username'] = $username;
        $_SESSION['userID'] = $userID;
        $_SESSION['userType'] = $userType;
        $_SESSION['teas'] = $teas;
        echo "success";
    }
    
    public static function Destroy()
    {
        PupSession::LoadSession();
        session_unset();
        session_destroy();
    }
    
    public static function LoadSession()
    {
        if (!isset($_SESSION))
            session_start();
    }
    
    //Check for valid userID TODO: return false if logged in from somewhere else
    public static function Validate()
    {
        PupSession::LoadSession();
        //Check for session timeout
        if(!isset($_SESSION['timeout']) || $_SESSION['timeout'] < time())
        { 
            PupSession::ReturnToDefault();
        }
        
        //Check for valid userID
        if (!isset($_SESSION['userID']))
        {
            PupSession::ReturnToDefault();
        }

        return;
    }
    
    public static function ReturnToDefault()
    {
        header('Location: /login.html');
            
        $e = new PupError('');
        exit($e->Redirect('/index.php'));
    }

    // Returns user type, or U if no type found.
    //User types: C for Customer,
    //            M for Manager,
    //            U for Undefined
    public static function getUserType() 
    {
            PupSession::LoadSession();
            $type = 'U';

            if (isset($_SESSION['userType']))
            {
                $type = $_SESSION['userType'];
            }

            return $type;
    }

    public static function getUserID()
    {
        PupSession::LoadSession();
        if (isset($_SESSION['userID']))
        {
            return $_SESSION['userID'];
        }

        return NULL;
    }
    
    public static function getUsername()
    {
        PupSession::LoadSession();
        if (isset($_SESSION['username']))
        {
            return $_SESSION['username'];
        }
        else
        {
            $username = PupSession::getUserID();
            $db = new dbAccess();
            $_SESSION['username'] = $db->getUsername($userID);
            return $_SESSION['username'];
        }
    }

    public static function setUsername($newUsername)
    {
        PupSession::LoadSession();
        $userID = PupSession::getUserID();
        $db = new dbAccess();
        try {
            $db->setUsername($userID, $newUsername);
        }
        catch(Exception $e) { 
            echo 'notification error: '.$e->getMessage();
            exit();
        }
        
        $_SESSION['username'] = $newUsername;
    }

    public static function getTeas()
    {
        PupSession::LoadSession();
        $userID = PupSession::getUserID();
        $db = new dbAccess();
        return $db->getUserTeas($userID);
    }

    public static function canOrder()
    {
        PupSession::LoadSession();
        $userID = PupSession::getUserID();
        if (PupSession::getTeas() < 1)
            return FALSE;
        $db = new dbAccess();
        $timeOfNextOrder = $db->getTimeOfNextOrder($userID);
        return time() > $timeOfNextOrder;
    }

    public static function orderTea()
    {
        PupSession::LoadSession();
        $userID = PupSession::getUserID();
        $db = new dbAccess();
        $db->setTimeOfNextOrder($userID, time() + 60 * 15);
        $db->decrementUserTeas($userID);
    }
    
    public static function getEmail()
    {
        PupSession::LoadSession();
        $userID = PupSession::getUserID();
        $db = new dbAccess();
        return $db->getEmail($userID);
    }
    
    public static function getEmailEnabled()
    {
        PupSession::LoadSession();
        $userID = PupSession::getUserID();
        $db = new dbAccess();
        return $db->getEmailEnabled($userID);
    }
}
