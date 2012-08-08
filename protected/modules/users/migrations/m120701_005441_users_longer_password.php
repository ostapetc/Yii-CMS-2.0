<?
class m120701_005441_users_longer_password extends DbMigration
{
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `users`
	          CHANGE COLUMN `password` `password` VARCHAR(60) NOT NULL COMMENT 'Пароль' AFTER `email`;
        ");
    }


    public function safeDown()
    {
        return false;
    }
}