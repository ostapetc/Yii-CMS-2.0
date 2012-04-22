<?php
class InstallMigration extends CDbMigration
{
    /**
     * @var Step1
     */
    private $model;

    public function __construct(Step1 $model)
    {

    }

    public function safeUp()
    {
        return true;
    }

    public function safeDown()
    {

    }
}