<?
class m120701_005414_tags_create extends DbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `tags`");

        $this->execute("
            CREATE TABLE `tags` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(50) DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `tag` (`name`)
              ) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}