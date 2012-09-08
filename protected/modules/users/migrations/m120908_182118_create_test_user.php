<?php

class m120908_182118_create_test_user extends DbMigration
{
	public function up()
	{
        $user = new User();
        $user->name     = 'Test user';
        $user->email    = 'test@mail.ru';
        $user->password = UserIdentity::crypt('test');
        $user->status   = User::STATUS_ACTIVE;
        $user->save(false);
	}


	public function down()
	{
		echo "m120908_182118_create_test_user does not support migration down.\n";
		return false;
	}
}