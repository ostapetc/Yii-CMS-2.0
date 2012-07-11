<?
class m120701_005307_site_actions_create extends EDbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `site_actions`");

        $this->execute("
            CREATE TABLE `site_actions` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `user_id` int(11) unsigned DEFAULT NULL COMMENT 'Пользователь',
                `title` varchar(200) NOT NULL COMMENT 'Заголовок',
                `module` varchar(50) NOT NULL COMMENT 'Модуль',
                `controller` varchar(50) NOT NULL COMMENT 'Контроллер',
                `action` varchar(50) NOT NULL COMMENT 'Действие',
                `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата',
                PRIMARY KEY (`id`),
                KEY `user_id` (`user_id`),
                CONSTRAINT `site_actions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
              ) ENGINE=InnoDB AUTO_INCREMENT=4791 DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}