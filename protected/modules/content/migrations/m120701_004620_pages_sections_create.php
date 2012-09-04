<?
class m120701_004620_pages_sections_create extends DbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `pages_sections` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Родитель',
                `name` varchar(50) NOT NULL COMMENT 'Название',
                `order` int(11) NOT NULL COMMENT 'Порядок',
                `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создан',
                PRIMARY KEY (`id`),
                UNIQUE KEY `name` (`name`),
                KEY `parent_id` (`parent_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
        ");
    }


    public function down()
    {
        $this->execute("DROP TABLE `pages_sections`");
    }
}