<?
class m120701_005013_mailer_outbox_create extends DbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `mailer_outbox` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `user_id` int(11) unsigned NOT NULL COMMENT 'Получатель',
                `template_id` int(11) unsigned NOT NULL COMMENT 'Шаблон',
                `email` varchar(750) DEFAULT NULL COMMENT 'Email',
                `subject` varchar(750) DEFAULT NULL COMMENT 'Тема письма',
                `body` longtext COMMENT 'Тело письма',
                `log` text COMMENT 'Лог',
                `status` enum('sent','queue','process','error') DEFAULT 'queue' COMMENT 'Статус',
                `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата создания',
                `date_send` timestamp NULL DEFAULT NULL COMMENT 'Дата отправки',
                PRIMARY KEY (`id`),
                KEY `template_id` (`template_id`),
                KEY `user_id` (`user_id`),
                CONSTRAINT `mailer_outbox_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `mailer_templates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `mailer_outbox_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
              ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        $this->execute("DROP TABLE `mailer_outbox`");
    }
}