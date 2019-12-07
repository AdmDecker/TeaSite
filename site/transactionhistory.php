<?php
    require_once('dbaccess.php');
    require_once('Session.php');
    require_once('PupError.php');
    require_once('Notification.php');
    PupSession::Validate();

    trigger_error("reached transactionhistory.php");

    $POST = json_decode(file_get_contents('php://input'), true);
    $e = new PupError('transactionhistory');
    $db = new dbAccess();

    $userID = PupSession::getUserID();

    trigger_error("transactionhistory UserId: $userId");

    try {
        $tableData = $db->getTransactionsByUser($userID);
    }
    catch(PDOException $ex) {
        exit( $e->Error('Database error: '.$ex->getMessage()) );
    }

    trigger_error('transactionhistory tableData' + strval($tableData));

    echo json_encode($tableData);
?>