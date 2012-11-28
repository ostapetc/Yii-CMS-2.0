<?php

class m120904_162306_auth_items_insert_roles extends DbMigration
{
	public function up()
	{
        $this->execute("
            INSERT INTO `auth_items`
                (`name`, `type`, `description`, `bizrule`, `data`, `allow_for_all`) VALUES
                ('admin', 2, 'Администратор', NULL, NULL, 0),
                ('guest', 2, 'Гость', NULL, NULL, 0),
                ('moderator', 2, 'Модератор', NULL, NULL, 0),
                ('user', 2, 'Пользователь', NULL, NULL, 0);
        ");
	}


	public function down()
	{
		echo "m120904_121454_auth_items_insert_roles does not support migration down.\n";
		return false;
	}
}