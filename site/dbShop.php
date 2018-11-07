<?php
require_once('dbAccess.php');

class dbShop extends dbAccess {
    public function __construct() {
        parent::__construct('shops', 'shopID');
    }

    public function getShopsByMember($userID) {
        
    }
}
?>