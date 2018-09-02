<?php
    require_once('dbaccess.php');
    require_once('PupError.php');
    require_once('Session.php');

	$e = new PupError('login');

	$POST = json_decode(file_get_contents('php://input'), true);
    $password = $POST['password'];
    $username = $POST['username'];

	try 
    {   
        $db = new dbaccess();
        
        //Verify username exists
        $userID = $db->getUserID($username);
        if (is_null($userID)) {
            exit( $e->Error('Login Failed: User does not exist') );
        }
		
        //Fetch password for user from DB
        $passwd_inDB = $db->getPassword($userID);

		if (!is_null($passwd_inDB) && password_verify($password, $passwd_inDB))
        {
            PupSession::Login($userID, TRUE);
        }	
		else
			echo $e->Error( 'Login Failed: Username and password do not match' );				
	}
	catch(PDOException $e)
	{
		echo $e->Error( 'Database error: ' . $e->getMessage() );
	}
    exit();
?>

