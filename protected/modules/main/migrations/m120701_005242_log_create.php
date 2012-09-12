<?
class m120701_005242_log_create extends DbMigration
{
    public function safeUp()
    {
        $this->execute("DROP TABLE IF EXISTS `log`");

        $this->execute("
            CREATE TABLE `log` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `level` varchar(128) DEFAULT NULL COMMENT 'Тип',
                `category` varchar(128) DEFAULT NULL COMMENT 'Категория',
                `logtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время',
                `message` text COMMENT 'Сообщение',
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function safeDown()
    {
        return false;
    }
}