<?php
class dbUser extends dbAccess
{
    public function __construct() {
        parent::__construct('users');
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
        $this->setField($userID, $fieldName, $newValue);
    }
    
    private function getUserField($userID, $fieldName)
    {
        $this->getField($userID, $fieldName);
    }

    private function getUsersByField($field, $fieldValue)
    {
        $this->getObjectsByField($field, $fieldValue);
    }

    private function getUserByField($field, $fieldValue)
    {
        return $this->getUsersByField($field, $fieldValue)[0]['userID'];
    }
}

?>