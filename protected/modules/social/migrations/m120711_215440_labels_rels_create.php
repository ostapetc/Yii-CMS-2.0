<?
class m120711_215440_labels_rels_create extends DbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `labels_rels`");

        $this->execute("
            CREATE TABLE `labels_rels` (
                `id` int(11) unsigned NOT NULL DEFAULT '0',
                `label_id` int(11) unsigned DEFAULT NULL,
                `object_id` int(11) unsigned DEFAULT NULL,
                `model_id` varchar(50) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `object_id_model_id` (`object_id`,`model_id`),
                KEY `label` (`label_id`),
                CONSTRAINT `label` FOREIGN KEY (`label_id`) REFERENCES `labels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}