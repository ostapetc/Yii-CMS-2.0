<?php

class m120908_191009_create_banners_table extends DbMigration
{
	public function up()
	{
        $this->execute("
            CREATE TABLE IF NOT EXISTS `banners` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(50) NOT NULL COMMENT 'Название',
              `image` varchar(37) NOT NULL COMMENT 'Изображение',
              `url` varchar(500) DEFAULT NULL COMMENT 'URL',
              `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Активен',
              `date_start` date DEFAULT NULL COMMENT 'Дата начала показа',
              `date_end` date DEFAULT NULL COMMENT 'Дата окончания показа',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ");
	}


	public function down()
	{
        $this->execute("DROP TABLE `banners`");
	}
}