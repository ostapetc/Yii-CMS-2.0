<?

class m120920_174205_messages_create extends DbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `messages` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `from_user_id` int(11) unsigned DEFAULT NULL COMMENT 'От кого',
                `to_user_id` int(11) unsigned DEFAULT NULL COMMENT 'Кому',
                `text` text COMMENT 'Текст',
                `is_read` tinyint(1) DEFAULT '0' COMMENT 'Прочитано',
                `date_create` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата',
                PRIMARY KEY (`id`),
                KEY `from_user_id` (`from_user_id`),
                KEY `to_user_id` (`to_user_id`),
                CONSTRAINT `to_user_id` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `from_user_id` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        $this->dropTable('messages');
    }
}