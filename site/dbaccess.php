<?php
abstract class dbAccess
{
    private $dbObject = NULL;
    public function __construct($tableName, $uidFieldName)
    {
        $dbinfo = parse_ini_file('../dbconf.ini');
        $hostname = $dbinfo['hostname'];
        $dbname = $dbinfo['db_name'];
        $dbuser = $dbinfo['db_user'];
        $dbpassword = $dbinfo['db_password'];
        $this->dbObject = new PDO("mysql:host=$hostname; dbname=$dbname", $dbuser, $dbpassword);
        $this->tableName = $tableName;
        $this->uidFieldName = $uidFieldName;
    }
    
    public function __destruct()
    {
        $dbObject = NULL;
    }

    protected function setField($UID, $fieldName, $newValue)
    {
        $statement = $this->dbObject->prepare("UPDATE $this->tableName set $fieldName=:newValue WHERE $this->uidFieldName=:UID");
        $statement->bindParam(':userID', $UID);
        $statement->bindParam(':newValue', $newValue);
        $statement->execute();
    }

    protected function getField($UID, $fieldName)
    {
        $statement = $this->dbObject->prepare("SELECT $fieldName FROM $this->tableName WHERE $this->uidFieldName=:UID");
        $statement->bindParam(':UID', $UID);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $row = $statement->fetch();
        if (!empty($row))
            return $row[$fieldName];
        else
            return NULL;
    }
    
    protected function getObjectsByField($field, $fieldValue)
    {
        $statement = $this->dbObject->prepare("SELECT * FROM $this->tableName WHERE $field=:fieldValue");
        $statement->bindParam('fieldValue', $fieldValue);
        $statement->execute();
        $rows = $statement->fetchAll();
        if (!empty($rows)) {
            trigger_error($rows);
            return $rows;
        }
        else {
            return NULL;
        }
    }

    protected function getAllObjects()
    {
        $statement = $this->dbObject->prepare("SELECT * FROM $this->tableName");
        $statement->execute();
        $rows = $statement->fetchAll();
        if (!empty($rows)) {
            trigger_error($rows);
            return $rows;
        }
        else {
            return NULL;
        }
    }
}
?>
