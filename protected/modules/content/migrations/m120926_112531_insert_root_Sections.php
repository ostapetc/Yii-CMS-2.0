<?php

class m120926_112531_insert_root_Sections extends DbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO `pages_sections` (`id`, `name`, `order`) VALUES (1, 'Страницы', 0)");
        $this->execute("INSERT INTO `pages_sections` (`id`, `name`, `order`) VALUES (2, 'Форум', 0)");
	}


	public function down()
	{
		echo "m120926_112531_insert_root_Sections does not support migration down.\n";
		return false;
	}
}