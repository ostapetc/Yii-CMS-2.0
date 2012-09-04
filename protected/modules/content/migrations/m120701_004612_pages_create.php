<?
class m120701_004612_pages_create extends DbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `pages` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `user_id` int(11) unsigned NOT NULL COMMENT 'Автор',
                `language` char(2) DEFAULT 'ru' COMMENT 'Язык',
                `title` varchar(200) NOT NULL COMMENT 'Заголовок',
                `url` varchar(250) DEFAULT NULL COMMENT 'Адрес',
                `text` text NOT NULL COMMENT 'Текст',
                `status` enum('published','draft','unpublished') NOT NULL DEFAULT 'draft' COMMENT 'Статус',
                `comments_denied` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Комментарии запрещены',
                `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создана',
                `order` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `pages_language_fk` (`language`),
                KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
        ");
    }


    public function down()
    {
        $this->execute("DROP TABLE `pages`");
    }
}