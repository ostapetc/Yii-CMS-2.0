<?

class m120904_161308_auth_items_create extends DbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `auth_items` (
                `name` varchar(64) NOT NULL COMMENT 'Название',
                `type` int(11) NOT NULL COMMENT 'Тип',
                `description` varchar(50) DEFAULT NULL COMMENT 'Описание',
                `bizrule` text COMMENT 'Бизнес-правило',
                `data` text COMMENT 'Данные',
                `allow_for_all` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Доступно всем',
                PRIMARY KEY (`name`),
                UNIQUE KEY `description` (`description`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        $this->execute("DROP TABLE `auth_items`");
    }
}