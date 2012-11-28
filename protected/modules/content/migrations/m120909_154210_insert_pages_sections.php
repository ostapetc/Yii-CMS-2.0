<?php

class m120909_154210_insert_pages_sections extends DbMigration
{
	public function up()
	{
        $this->execute("DELETE FROM `pages_sections`");

	    $this->execute("
            INSERT INTO `pages_sections` (`id`, `parent_id`, `name`, `order`, `date_create`) VALUES
            (1, NULL, 'Новости', 0, '2012-09-08 20:20:23'),
            (2, NULL, 'Статьи', 0, '2012-09-08 20:20:32'),
            (3, NULL, 'Интервью', 0, '2012-09-09 15:41:11');
	    ");
    }


	public function down()
	{
		echo "m120909_154210_insert_pages_sections does not support migration down.\n";
		return false;
	}
}