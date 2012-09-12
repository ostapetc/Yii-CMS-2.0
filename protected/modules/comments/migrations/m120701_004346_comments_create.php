<?
class m120701_004346_comments_create extends EDbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `comments`");

        $this->execute("
            CREATE TABLE `comments` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Пользователь',
                `user_id` int(11) unsigned NOT NULL COMMENT 'Пользователь',
                `object_id` int(11) unsigned NOT NULL,
                `model_id` varchar(50) NOT NULL DEFAULT '0' COMMENT 'Пользователь',
                `root` int(11) unsigned NOT NULL,
                `left` int(11) unsigned NOT NULL,
                `right` int(11) unsigned NOT NULL,
                `level` smallint(5) unsigned NOT NULL,
                `text` text NOT NULL COMMENT 'Комментарий',
                `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата',
                PRIMARY KEY (`id`),
                KEY `root` (`root`),
                KEY `level` (`level`),
                KEY `left` (`left`),
                KEY `right` (`right`),
                KEY `user_id` (`user_id`),
                KEY `object_model` (`object_id`,`model_id`),
                CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}