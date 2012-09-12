<?
class m120701_005251_meta_tags_create extends DbMigration
{
    public function safeUp()
    {
        $this->execute("DROP TABLE IF EXISTS `meta_tags`");

        $this->execute("
            CREATE TABLE `meta_tags` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `object_id` int(11) unsigned DEFAULT NULL COMMENT 'ID объекта',
                `model_id` varchar(50) NOT NULL COMMENT 'Модель',
                `title` varchar(300) DEFAULT NULL COMMENT 'Заголовок',
                `keywords` varchar(300) DEFAULT NULL COMMENT 'Ключевые слова',
                `description` varchar(300) DEFAULT NULL COMMENT 'Описание',
                `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создано',
                `date_update` datetime DEFAULT NULL COMMENT 'Отредактирован',
                PRIMARY KEY (`id`),
                UNIQUE KEY `object_id` (`object_id`,`model_id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function safeDown()
    {
        return false;
    }
}