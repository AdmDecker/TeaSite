<?php
    require_once('dbaccess.php');
	require_once('PupError.php');

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
            //Start the session
            session_start();
            $_SESSION['timeout'] = time() + 60 * 60 * 15;
            $_SESSION['username'] = $username;
            $_SESSION['userID'] = $userID;
            $_SESSION['userType'] = $db->getUserType($userID);
            echo $e->Redirect('index.php');
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

