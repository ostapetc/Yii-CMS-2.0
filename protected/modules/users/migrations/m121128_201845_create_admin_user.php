<?php

class m121128_201845_create_admin_user extends DbMigration
{
	public function up()
	{
        $user = new User();
        $user->name      = 'admin';
        $user->email     = 'admin@admin.ru';
        $user->password  = UserIdentity::crypt('123456');
        $user->status    = 'active';
        $user->birthdate = '2011-01-01';
        $user->gender    = User::GENDER_MAN;
        $user->save();
	}


	public function down()
	{
		echo "m121128_201845_create_admin_user does not support migration down.\n";
		return false;
	}
}