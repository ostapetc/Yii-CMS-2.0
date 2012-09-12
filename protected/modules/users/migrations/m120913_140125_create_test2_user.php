<?php

class m120913_140125_create_test2_user extends DbMigration
{
	public function up()
	{
        $user = new User();
        $user->id       = 2;
        $user->name     = 'Test2 user';
        $user->email    = 'test2@mail.ru';
        $user->password = UserIdentity::crypt('test2');
        $user->status   = User::STATUS_ACTIVE;
        $user->save(false);
	}


	public function down()
	{
		echo "m120913_140125_create_test2_user does not support migration down.\n";
		return false;
	}
}