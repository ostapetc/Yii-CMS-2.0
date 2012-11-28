<?

class m120904_161306_auth_assignments_create extends DbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `auth_assignments` (
                `itemname` varchar(64) NOT NULL,
                `userid` int(11) unsigned NOT NULL,
                `bizrule` text,
                `data` text,
                PRIMARY KEY (`itemname`,`userid`),
                KEY `userid` (`userid`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        $this->execute("DROP TABLE `auth_assignments`");
    }
}