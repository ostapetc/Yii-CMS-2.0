<?
class m120701_005231_languages_translations_create extends EDbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `languages_translations`");

        $this->execute("
            CREATE TABLE `languages_translations` (
                `id` int(11) NOT NULL,
                `language` char(2) NOT NULL DEFAULT '' COMMENT 'Язык',
                `translation` text COMMENT 'Перевод',
                PRIMARY KEY (`id`,`language`),
                KEY `language` (`language`),
                CONSTRAINT `languages_translations_ibfk_1` FOREIGN KEY (`language`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id`) REFERENCES `languages_messages` (`id`) ON DELETE CASCADE
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}