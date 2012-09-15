<?php

class m120912_174550_insert_tags extends DbMigration
{
	public function up()
	{
	    $this->execute("
            INSERT INTO `tags` (`id`, `name`) VALUES
            (5, 'Bellator '),
            (18, 'Glory '),
            (17, 'Glory 3 Rome'),
            (11, 'Strikeforce'),
            (6, 'UFC on FX 6'),
            (13, 'Ultimate Fighter'),
            (10, 'Александр Шлеменко'),
            (16, 'Артем Левин'),
            (7, 'Гектор Ломбард'),
            (12, 'Данэль Кормье'),
            (19, 'Джабар Аскеров'),
            (9, 'Джордж Соторопулос'),
            (20, 'Йошихиро Сато'),
            (4, 'Майкель Фалькао'),
            (8, 'Росимар Палхарес'),
            (15, 'Стефан Фокс'),
            (1, 'тег1'),
            (2, 'тег2'),
            (3, 'тег3'),
            (14, 'Чемпионат мира'),
            (21, 'Шемси Бекири');
	    ");
    }


	public function down()
	{
		echo "m120912_174550_insert_tags does not support migration down.\n";
		return false;
	}
}