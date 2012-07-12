<?
class m120711_215433_labels_create extends EDbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `labels`");

        $this->execute("
            CREATE TABLE `labels` (
                `id` int(11) unsigned NOT NULL DEFAULT '0',
                `desc` varchar(100) DEFAULT NULL COMMENT 'Описание',
                `icon` varchar(36) DEFAULT NULL COMMENT 'Иконка',
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}