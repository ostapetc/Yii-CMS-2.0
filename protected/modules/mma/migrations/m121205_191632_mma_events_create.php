<?

class m121205_191632_mma_events_create extends DbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `mma_events` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `sherdog_id` int(11) NOT NULL COMMENT 'Sherdog ID',
                `name` varchar(200) NOT NULL COMMENT 'Название события',
                `date` date DEFAULT NULL COMMENT 'Дата события',
                PRIMARY KEY (`id`),
                UNIQUE KEY `name` (`name`),
                UNIQUE KEY `sherdog_id` (`sherdog_id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        $this->dropTable('mma_events');
    }
}