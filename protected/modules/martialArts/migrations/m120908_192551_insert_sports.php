<?php

class m120908_192551_insert_sports extends DbMigration
{
	public function up()
	{
        $this->execute("
            INSERT INTO `sports` (`id`, `name`, `caption`) VALUES
            (1, 'MMA', 'mma'),
            (3, 'Тайский бокс', 'muai-tai'),
            (4, 'Бокс', 'box'),
            (5, 'Карате', 'karate');
        ");
	}
}