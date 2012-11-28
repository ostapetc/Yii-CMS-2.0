<?
class m120701_005357_ratings_create extends DbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `ratings`");

        $this->execute("
            CREATE TABLE `ratings` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `user_id` int(11) unsigned NOT NULL,
                `object_id` int(11) unsigned NOT NULL,
                `model_id` varchar(50) NOT NULL,
                `value` tinyint(1) NOT NULL,
                `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `user_object_model` (`user_id`,`object_id`,`model_id`),
                KEY `object_id_model_id` (`object_id`,`model_id`),
                KEY `user_id` (`user_id`),
                CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}