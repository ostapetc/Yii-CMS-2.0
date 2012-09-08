<?php

class m120908_191031_alter_banners_roles_table extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `banners_roles`
              ADD CONSTRAINT `banners_roles_ibfk_2` FOREIGN KEY (`role`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `banners_roles_ibfk_1` FOREIGN KEY (`banner_id`) REFERENCES `banners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");
    }


	public function down()
	{
		echo "m120908_191031_alter_banners_roles_table does not support migration down.\n";
		return false;
	}
}