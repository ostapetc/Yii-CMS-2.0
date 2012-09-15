<?php

class m120915_202739_create_albums extends DbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `file_manager_album`");
        $this->execute("DROP TABLE IF EXISTS `media_albums`");

        $this->execute("CREATE TABLE IF NOT EXISTS `media_albums` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `model_id` varchar(50) DEFAULT NULL COMMENT 'ID модели',
                      `object_id` int(11) DEFAULT NULL COMMENT 'ID объекта',
                      `title` varchar(50) DEFAULT NULL COMMENT 'Название',
                      `descr` text COMMENT 'Описание',
                      `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создан',
                      `sort` int(11) DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDb DEFAULT CHARSET=utf8;
                ");
    }


    public function down()
    {
        echo "m120915_202739_create_albums does not support migration down.\n";
        return false;
    }

    /*
     // Use safeUp/safeDown to do migration with transaction
     public function safeUp()
     {
     }

     public function safeDown()
     {
     }
     */
}