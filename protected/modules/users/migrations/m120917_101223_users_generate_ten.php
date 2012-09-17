<?php

class m120917_101223_users_generate_ten extends DbMigration
{
	public function up()
	{
        for ($id = 10; $id <= 20; $id++)
        {
            $user = new User();
            $user->id       = $id;
            $user->name     = 'Test user ' . $id;
            $user->email    = "tes{$id}t@mail.ru";
            $user->password = UserIdentity::crypt('test' . $id);
            $user->status   = User::STATUS_ACTIVE;
            $user->save(false);
        }
	}


    public function down()
	{
		echo "m120917_101223_users_generate_ten does not support migration down.\n";
		return false;
	}
}