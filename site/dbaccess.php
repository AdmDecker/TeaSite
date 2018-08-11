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
        $statement = $this->dbObject->prepare("insert into users values(NULL, :username, :password, :role, 0, 0, NULL)");
        $statement->bindParam(':username', $username);
        $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        $statement->bindParam(':role', $role);
        $statement->execute();
        return $this->dbObject->lastInsertId();
    }

    public function getAllUsersByRole($role)
    {
        $statement = $this->dbObject->prepare('SELECT * FROM users WHERE role=:role');
        $statement->bindParam(':role', $role);
        $statement->execute();
        return $statement->fetchAll();
    }
    
    public function getPassword($username)
    {
        $statement = $this->dbObject->prepare("select password from users 
            where userName = :username");
		$username = trim($username);
		$statement->bindParam(':username', $username);;
		$statement->execute();
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$passwd_inDB = $statement->fetch();
        if (!empty($passwd_inDB))
            return $passwd_inDB["password"];
        else
            return NULL;
    }

    public function setPassword($userID, $password)
    {
        $statement = $this->dbObject->prepare("UPDATE users SET password=:password WHERE userID=:userID");
        $statement->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        $statement->bindParam(':userID', $userID);
        $statement->execute();
    }
    
    public function getUserID($username)
    {
        //Get userID
        $statement = $this->dbObject->prepare("SELECT userID FROM users where username=:username");
        $statement->bindParam(':username', $username);
        $statement->execute();
        $userID = $statement->fetch();
        if (!empty($userID))
            return $userID['userID'];
        else
            return NULL;
    }
    
    public function getUserType($userID)
    {
        $statement = $this->dbObject->prepare("SELECT role FROM users WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetch()['role'];
    }

    public function getUserTeas($userID)
    {
        $statement = $this->dbObject->prepare("SELECT teas FROM users WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetch()['teas'];
    }

	public function setUserTeas($userID, $amount)
    {
        $statement = $this->dbObject->prepare("UPDATE users SET teas=:amount WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
		$statement->bindParam(':amount', $amount);
        $statement->execute();
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
	    $statement = $this->dbObject->prepare("SELECT userName FROM users WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetch()['userName']; 
    }

    public function setUsername($userID, $newUsername)
    {
        $statement = $this->dbObject->prepare("UPDATE users set userName=:newUsername WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->bindParam(':newUsername', $newUsername);
        $statement->execute();
    }

    public function getTimeOfNextOrder($userID)
    {	
        $statement = $this->dbObject->prepare("SELECT timeOfNextOrder FROM users WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetch()['timeOfNextOrder'];
    }

    public function setTimeOfNextOrder($userID, $timeOfNextOrder)
    {
        $statement = $this->dbObject->prepare("UPDATE users set timeOfNextOrder=:timeOfNextOrder WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->bindParam(':timeOfNextOrder', $timeOfNextOrder);
        $statement->execute();
    }
	
}
?>
