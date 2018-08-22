<?php
    require_once('dbaccess.php');
	require_once('PupError.php');

	$e = new PupError('register');

	$POST = json_decode(file_get_contents('php://input'), true);
    $password = $POST['password'];
    $username = trim($POST['username']);
	$registerCode = htmlspecialchars(trim($POST['registerCode']));

    //Check Registercode
    
    $realCode = 'puppertea';
    if ($registerCode != $realCode)
    {
		exit( $e->Error( 'Incorrect registration code' ) );
    }

	try {
		//Create our database object
		$db = new dbaccess();

		//Check if the user already exists.
		$user_inDB = $db->getUserID($username);
			if (!is_null($user_inDB))
		{
			exit( $e->Error('User already exists') );
		}

		//Insert user to database
		$db->addUser($username, $password, "C");

		//Get userID
		$userID = $db->getUserID($username);

		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['timeout'] = time() + 60*60*12;
		$_SESSION['userID'] = $userID;
		$_SESSION['userType'] = $db->getUserType($userID);
		exit( $e->Redirect('/index.php') );
	}
	catch(PDOException $ex)
	{
		exit( $e->Error("Database error: " . $ex->getMessage()) );
	}

?>
