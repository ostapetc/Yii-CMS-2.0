<?php

class Step1Test extends CTestCase
{
    public $data = array(
        'db_host'            => 'localhost',
        'db_name'            => 'test_database_tmp',
        'db_login'           => 'root',
        'db_pass'            => '',
    );


    public function testCreateDb()
    {
        $step1 = new Step1();
        $step1->setAttributes($this->data,false);
        $this->assertTrue($step1->createDb());

        $conn_string = 'mysql:host=' . $step1->db_host . ';dbname=' . $step1->db_name;
        $con = new CDbConnection($conn_string, $step1->db_login, $step1->db_pass);
        try
        {
            $con->init();
        }
        catch (Exception $e)
        {
            $this->assert('Db was not created');
        }

        $con->createCommand('DROP DATABASE IF EXISTS '.$con->quoteTableName($this->data['db_name']))->execute();
    }
}