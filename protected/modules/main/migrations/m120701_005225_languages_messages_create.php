<?
class m120701_005225_languages_messages_create extends EDbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `languages_messages`");

        $this->execute("
            CREATE TABLE `languages_messages` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `category` varchar(32) NOT NULL COMMENT 'Категория',
                `message` text NOT NULL COMMENT 'Сообщение',
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}