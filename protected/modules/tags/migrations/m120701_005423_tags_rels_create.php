<?
class m120701_005423_tags_rels_create extends DbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `tags_rels`");

        $this->execute("
            CREATE TABLE `tags_rels` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `tag_id` int(11) unsigned NOT NULL,
                `object_id` int(11) unsigned NOT NULL,
                `model_id` varchar(50) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `tag_id` (`tag_id`,`object_id`,`model_id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}