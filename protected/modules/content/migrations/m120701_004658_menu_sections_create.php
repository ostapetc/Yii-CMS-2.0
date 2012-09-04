<?
class m120701_004658_menu_sections_create extends EDbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `menu_sections` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
                `page_id` int(11) unsigned DEFAULT NULL COMMENT 'Привязка к странице',
                `menu_id` int(11) unsigned NOT NULL COMMENT 'Меню',
                `root` int(11) unsigned DEFAULT NULL,
                `left` int(11) unsigned NOT NULL,
                `right` int(11) unsigned NOT NULL,
                `level` smallint(5) unsigned NOT NULL,
                `title` varchar(200) NOT NULL COMMENT 'Заголовок',
                `url` varchar(200) NOT NULL COMMENT 'Адрес',
                `module_url` varchar(300) DEFAULT NULL COMMENT 'Раздел модуля',
                `module_id` varchar(64) DEFAULT NULL,
                `is_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Отображать',
                PRIMARY KEY (`id`),
                KEY `page_id` (`page_id`),
                KEY `menu_id` (`menu_id`),
                KEY `lang` (`lang`),
                CONSTRAINT `menu_sections_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `menu_sections_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
              ) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        $this->execute("DROP TABLE `menu_sections`");
    }
}