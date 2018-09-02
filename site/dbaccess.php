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
    
    //Do not use this for Driver, use addDriver instead
    //Do not use this for Customer, use addCustomer instead
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

    public function getAllUsersByRole($role)
    {
        return $this->getUsersByField('role', $role);
    }

    public function getUserByCookie($cookie)
    {
        return $this->getUserByField('cookie', $cookie);
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
        $this->setUserField($userID, 'password', $password);
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
        $this->setUserTeas($userID, 'teas', $amount);
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

    private function getUsersByField($field, $fieldValue)
    {
        $statement = $this->dbObject->prepare("SELECT userID FROM users WHERE $field=:fieldValue");
        $statement->bindParam('fieldValue', $fieldValue);
        $statement->execute();
        $row = $statement->fetchAll();
        if (!empty($row))
            return $row;
        else
            return NULL;
    }

    private function getUserByField($field, $fieldValue)
    {
        return $this->getUsersByField($field, $fieldValue)[0]['userID'];
    }
}
?>
