<?
class m120701_004651_menu_create extends DbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `menu` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `language` char(2) DEFAULT 'ru' COMMENT 'Язык',
                `name` varchar(50) NOT NULL COMMENT 'Название',
                `code` varchar(50) NOT NULL COMMENT 'Код',
                `is_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Отображать',
                `lang` varchar(2) DEFAULT NULL COMMENT 'Язык',
                PRIMARY KEY (`id`),
                UNIQUE KEY `code` (`code`),
                KEY `language` (`language`),
                CONSTRAINT `language` FOREIGN KEY (`language`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
              ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        $this->execute("DROP TABLE `menu`");
    }
}