<?
    require_once('dbaccess.php');
    require_once('Session.php');

    class TranHistoryLogger {
        public static function logTransaction($userID, $message) {
            $actingUserID = PupSession::getUserID();

            $db = new dbAccess();
            $db->addTransaction($userID, $actingUserID, $message);
        }
    }
?>