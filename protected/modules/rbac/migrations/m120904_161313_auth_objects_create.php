<?

class m120904_162306_auth_items_insert_roles extends DbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `auth_objects` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `object_id` int(11) unsigned NOT NULL COMMENT 'Объект',
                `model_id` varchar(50) NOT NULL COMMENT 'Модель',
                `role` varchar(64) NOT NULL COMMENT 'Роль',
                PRIMARY KEY (`id`),
                KEY `role` (`role`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        $this->execute("DROP TABLE `auth_objects`");
    }
}