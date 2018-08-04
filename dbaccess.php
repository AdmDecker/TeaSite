<?php

//Copyright Hog International Incorporated LLC.
//All rights reserved
class dbAccess
{
    private $dbObject = NULL;
    public function __construct()
    {
        $dbinfo = parse_ini_file('dbconf.ini');
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
        $statement = $this->dbObject->prepare("insert into users values(NULL, :username, :password, :role)");
        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        $statement->bindParam(':role', $role);
        $steatement->bindParam(':teas', 0);
        $statement->execute();
        return $this->dbObject->lastInsertId();
    }

    public function addCustomer($username, $password, $address, $phoneNumber, $email)
    {
        $customerID = addUser($username, $password, 'C');
        $statement = $this->dbObject->prepare('INSERT INTO customers values(:userID, :homeAddress, :phoneNumber, :email)');
        $statement->bindParam(':userID', $customerID);
        $statement->bindParam(':homeAddress', $address);
        $statement->bindParam(':phoneNumber', $phoneNumber);
        $statement->bindParam(':email', $email);
        return $customerID;
    }

    public function getCustomerByID($userID)
    {
        $statement = $this->dbObject->prepare('SELECT * FROM customers WHERE customerID=:userID');
        $statement->bindParam(':userID', $userID);
        $statement->execute();
        return $statement->fetch();
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
?>