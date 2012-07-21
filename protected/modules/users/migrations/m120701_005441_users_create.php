<?
class m120701_005441_users_create extends DbMigration
{
    public function safeUp()
    {
        $this->execute("DROP TABLE `users`");

        $this->execute("
            CREATE TABLE `users` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(40) NOT NULL COMMENT 'Имя',
                `email` varchar(200) NOT NULL COMMENT 'Email',
                `password` varchar(32) NOT NULL COMMENT 'Пароль',
                `birthdate` date DEFAULT NULL COMMENT 'Дата рождения',
                `gender` enum('man','woman') DEFAULT NULL COMMENT 'Пол',
                `status` enum('active','new','blocked') DEFAULT 'new' COMMENT 'Статус',
                `photo` varchar(50) DEFAULT NULL COMMENT 'Фото',
                `rating` int(11) NOT NULL DEFAULT '0' COMMENT 'Рейтинг',
                `activate_code` varchar(32) DEFAULT NULL COMMENT 'Код активации',
                `activate_date` timestamp NULL DEFAULT NULL COMMENT 'Дата активации',
                `password_recover_code` varchar(32) DEFAULT NULL,
                `password_recover_date` timestamp NULL DEFAULT NULL,
                `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Зарегистрирован',
                PRIMARY KEY (`id`),
                UNIQUE KEY `email` (`email`)
              ) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8
        ");
    }


    public function safeDown()
    {
        return false;
    }
}