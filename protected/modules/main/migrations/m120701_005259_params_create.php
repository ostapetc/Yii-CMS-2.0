<?
class m120701_005259_params_create extends EDbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `params`");

        $this->execute("
            CREATE TABLE `params` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `module_id` varchar(50) NOT NULL COMMENT 'Модуль',
                `code` varchar(50) NOT NULL COMMENT 'Код',
                `name` varchar(100) NOT NULL COMMENT 'Заголовок',
                `value` text NOT NULL COMMENT 'Значение',
                `element` enum('text','textarea','editor','checkbox','file','select') NOT NULL COMMENT 'Элемент',
                `options` text COMMENT 'Список значений',
                PRIMARY KEY (`id`),
                UNIQUE KEY `const` (`code`),
                UNIQUE KEY `title` (`name`)
              ) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}