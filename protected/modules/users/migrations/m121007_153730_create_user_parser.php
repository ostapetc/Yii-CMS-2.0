<?php

class m121007_153730_create_user_parser extends DbMigration
{
	public function up()
	{
	    $user = new User();
        $user->id       = 555;
        $user->name     = 'Robot';
        $user->birthdate = '1900-01-01';
        $user->gender = User::GENDER_MAN;
        $user->email    = 'robot@factory.com';
        $user->status   = User::STATUS_BLOCKED;
        $user->password = 'Robot';
        $user->save();

        if ($user->errors_flat_array)
        {
            throw new CException("can't save user " . print_r($user->errors_flat_array, 1));
        }
    }


	public function down()
	{
		echo "m121007_153730_create_user_parser does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}