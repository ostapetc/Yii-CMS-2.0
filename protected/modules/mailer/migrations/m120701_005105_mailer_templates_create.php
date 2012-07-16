<?
class m120701_005105_mailer_templates_create extends EDbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `mailer_templates`");

        $this->execute("
            CREATE TABLE `mailer_templates` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `code` varchar(70) NOT NULL COMMENT 'Код',
                `name` varchar(200) NOT NULL COMMENT 'Название',
                `subject` varchar(200) NOT NULL COMMENT 'Тема письма',
                `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создан',
                PRIMARY KEY (`id`),
                UNIQUE KEY `name` (`name`),
                UNIQUE KEY `code` (`code`)
              ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}