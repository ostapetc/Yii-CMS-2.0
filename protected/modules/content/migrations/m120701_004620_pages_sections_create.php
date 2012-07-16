<?
class m120701_004620_pages_sections_create extends EDbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `pages_sections`");

        $this->execute("
            CREATE TABLE `pages_sections` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Родитель',
                `name` varchar(50) NOT NULL COMMENT 'Название',
                `order` int(11) NOT NULL COMMENT 'Порядок',
                `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создан',
                PRIMARY KEY (`id`),
                UNIQUE KEY `name` (`name`),
                KEY `parent_id` (`parent_id`),
                CONSTRAINT `pages_sections_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `pages_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
              ) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}