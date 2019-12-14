<?php

//Copyright Hog International Incorporated LLC.
//All rights reserved
class dbAccess
{
    private $dbObject = NULL;
    public function __construct()
    {
        $dbinfo = parse_ini_file('../dbconf.ini');
        $hostname = $dbinfo['hostname'];
        $dbname = $dbinfo['db_name'];
        $dbuser = $dbinfo['db_user'];
        $dbpassword = $dbinfo['db_password'];
	    $this->dbObject = new PDO("mysql:host=$hostname; dbname=$dbname", $dbuser, $dbpassword);
    }
    
    public function __destruct()
    {
        $dbObject = NULL;
    }

    public function getAllUsersByRole($role)
    {
        return $this->getUsersByField('role', $role);
    }

    public function getUserByCookie($cookie)
    {
        return $this->getUserByField('loginCookie', $cookie);
    }

    public function setUserCookie($userID, $cookie)
    {
        $this->setUserField($userID, 'loginCookie', $cookie);
    }
    
    public function getPassword($userID)
    {
        return $this->getUserField($userID, 'password');
    }

    public function setPassword($userID, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->setUserField($userID, 'password', $hashedPassword);
    }
    
    public function getUserID($username)
    {
        return $this->getUserByField('username', $username);
    }
    
    public function getUserType($userID)
    {
        return $this->getUserField($userID, 'role');
    }

    public function getUserTeas($userID)
    {
        return $this->getUserField($userID, 'teas');
    }

	public function setUserTeas($userID, $amount)
    {
        $this->setUserField($userID, 'teas', $amount);
    }
	
    public function incrementUserTeas($userID)
    {
        $statement = $this->dbObject->prepare("UPDATE users set teas=teas+1 WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->execute();
    }

    public function decrementUserTeas($userID)
    {
        $statement = $this->dbObject->prepare("UPDATE users set teas=teas-1 WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->execute();
    }
	
    public function getUsername($userID)
    {
	    return $this->getUserField($userID, 'username');
    }

    public function setUsername($userID, $newUsername)
    {
        $this->setUserField($userID, 'username', $newUsername);
    }

    public function getTimeOfNextOrder($userID)
    {	
        return $this->getUserField($userID, 'timeOfNextOrder');
    }

    public function setTimeOfNextOrder($userID, $timeOfNextOrder)
    {
        $this->setUserField($userID, 'timeOfNextOrder', $timeOfNextOrder);
    }

    public function setEmail($userID, $email)
    {
        $this->setUserField($userID, 'email', $email);    
    }
    
    public function getEmail($userID)
    {
        return $this->getUserField($userID, 'email');
    }
	
    public function getEmailEnabled($userID)
    {
        return $this->getUserField($userID, 'emailEnabled');
    }
    
    public function setEmailEnabled($userID, $enabled)
    {
        $this->setUserField($userID, 'emailEnabled', $enabled);
    }
    
    private function setUserField($userID, $fieldName, $newValue)
    {
        $statement = $this->dbObject->prepare("UPDATE users set $fieldName=:newValue WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->bindParam(':newValue', $newValue);
        $statement->execute();
    }
    
    private function getUserField($userID, $fieldName)
    {
        $statement = $this->dbObject->prepare("SELECT $fieldName FROM users WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $row = $statement->fetch();
        if (!empty($row))
            return $row[$fieldName];
        else
            return NULL;
    }

    public function addTransaction($userID, $actingUserID, $message)
    {
        $dateTime = new DateTime();
        $statement = $this->dbObject->prepare("INSERT INTO transactions VALUES(NULL, $userID, $actingUserID, :message, :timeStamp)");
        $statement->bindParam(':message', $message);
        $statement->bindParam(':timeStamp', $dateTime->GetTimeStamp());
        $statement->execute();
    }

    public function getTransactionsByUser($userID) 
    {
        $statement = $this->dbObject->prepare("
            SELECT
            actor.username AS actorUsername,
            message
            FROM transactions t
            INNER JOIN users actor ON t.actingUserID = actor.userID
            WHERE t.userID = $userID
        ");

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getUsersByField($field, $fieldValue)
    {
        $statement = $this->dbObject->prepare("SELECT * FROM users WHERE $field=:fieldValue");
        $statement->bindParam('fieldValue', $fieldValue);
        $statement->execute();
        $rows = $statement->fetchAll();
        if (!empty($rows)) {
            trigger_error($rows);
            return $rows;
        }
        else {
            return NULL;
        }
    }

    //Returns userID of the added user
    public function addUser($username, $password, $role)
    {
        //Insert user to database
        $username = trim($username);
        $statement = $this->dbObject->prepare("insert into users values(NULL, :username, :password, :role, 0, 0, NULL, 0, 0)");
        $statement->bindParam(':username', $username);
        $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        $statement->bindParam(':role', $role);
        $statement->execute();
        return $this->dbObject->lastInsertId();
    }

    private function getUserByField($field, $fieldValue)
    {
        return $this->getUsersByField($field, $fieldValue)[0]['userID'];
    }
}
?>
