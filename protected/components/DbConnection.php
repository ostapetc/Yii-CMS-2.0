<?php
class DbConnection extends CDbConnection
{
    public function getDbHost()
    {
        preg_match("/host=([^;]*)/", $this->connectionString, $matches);
        return $matches[1];
    }

    public function getDbName()
    {
        preg_match("/dbname=([^;]*)/", $this->connectionString, $matches);
        return $matches[1];
    }
}