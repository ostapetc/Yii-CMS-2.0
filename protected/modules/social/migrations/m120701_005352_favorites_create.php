<?
class m120701_005352_favorites_create extends DbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `favorites`");

        $this->execute("
            CREATE TABLE `favorites` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `user_id` int(11) unsigned NOT NULL,
                `object_id` int(11) unsigned NOT NULL,
                `model_id` varchar(50) NOT NULL,
                `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `user_id_object_id_model_id` (`user_id`,`object_id`,`model_id`),
                KEY `user_id` (`user_id`),
                KEY `object_id_model_id` (`object_id`,`model_id`),
                CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
              ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}