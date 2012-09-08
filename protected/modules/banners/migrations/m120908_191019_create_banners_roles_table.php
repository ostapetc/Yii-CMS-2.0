<?php

class m120908_191019_create_banners_roles_table extends DbMigration
{
	public function up()
	{
        $this->execute("
            CREATE TABLE IF NOT EXISTS `banners_roles` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `banner_id` int(11) unsigned NOT NULL,
              `role` varchar(64) NOT NULL COMMENT 'Роль',
              PRIMARY KEY (`id`),
              KEY `banner_id` (`banner_id`),
              KEY `role` (`role`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;
        ");
	}


	public function down()
	{
        $this->execute("DROP TABLE `banners_roles`");
	}
}