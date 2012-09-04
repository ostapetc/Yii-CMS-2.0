<?

class m120904_161310_auth_items_childs_create extends DbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `auth_items_childs` (
                `parent` varchar(64) NOT NULL,
                `child` varchar(64) NOT NULL,
                PRIMARY KEY (`parent`,`child`),
                KEY `child` (`child`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        $this->execute("DROP TABLE `auth_items_childs`");
    }
}