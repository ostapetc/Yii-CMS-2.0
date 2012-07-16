<?
class m120710_232834_friends_create extends EDbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `friends`");

        $this->execute("
            CREATE TABLE `friends` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `user_a_id` int(11) unsigned NOT NULL,
                `user_b_id` int(11) unsigned NOT NULL,
                `is_confirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
                `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `user_a_id_2` (`user_a_id`,`user_b_id`),
                KEY `user_a_id` (`user_a_id`),
                KEY `user_b_id` (`user_b_id`),
                CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_a_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`user_b_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}