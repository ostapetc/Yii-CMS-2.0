<?php

class m120903_111840_users_add_column_rating extends DbMigration
{
	public function up()
	{
        $this->execute(
            "ALTER TABLE `users`
                ADD `rating` INT( 11 ) NOT NULL COMMENT 'Рейтинг' AFTER `password_recover_date` "
        );
	}


	public function down()
	{
        $this->execute("ALTER TABLE `users` DROP `rating`");
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