<?php

class m120926_122302_insert_forum_sections extends DbMigration
{
	public function up()
	{
        $this->execute("
            INSERT INTO `pages_sections` (`id`, `parent_id`, `name`, `order`, `date_create`) VALUES
            (6, 2, 'Игры MMA', 6, '2012-09-26 12:11:08'),
            (9, 2, 'Тренировки', 4, '2012-09-26 12:13:54'),
            (11, 2, 'Флудильня', 5, '2012-09-26 12:16:47'),
            (13, 2, 'MMA', 1, '2012-09-26 12:17:42'),
            (14, 2, 'Тайсткий бокс', 2, '2012-09-26 12:18:34'),
            (16, 2, 'Карате', 3, '2012-09-26 12:18:43');
        ");
    }


	public function down()
	{
		echo "m120926_122302_insert_forum_sections does not support migration down.\n";
		return false;
	}
}