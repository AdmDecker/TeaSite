<?php
    require_once('dbaccess.php');
	require_once('PupError.php');
	require_once('Session.php');

	$POST = json_decode(file_get_contents('php://input'), true);
    $password = $POST['password'];
    $username = trim($POST['username']);
	$registerCode = htmlspecialchars(trim($POST['registerCode']));
	$e = new PupError($POST['form']);

    //Check Registercode
    
    $realCode = 'puppertea';
    if ($registerCode != $realCode)
    {
		exit( $e->Error( 'Incorrect registration code' ) );
    }

	try {
		//Create our database object
		$db = new dbAccess();

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

		PupSession::Login($userID);
		exit( $e->Redirect('/index.php') );
	}
	catch(PDOException $ex)
	{
		exit( $e->Error("Database error: " . $ex->getMessage()) );
	}

?>
