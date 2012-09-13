<?
class m120701_005105_mailer_templates_create extends DbMigration
{
    public function up()
    {
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
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        $this->execute("DROP TABLE `mailer_templates`");
    }
}