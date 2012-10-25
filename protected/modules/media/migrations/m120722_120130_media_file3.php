<?php

class m120722_120130_media_file3 extends DbMigration
{
	public function up()
	{
        $this->execute("DROP TABLE IF EXISTS `file_manager`");
        $this->execute("DROP TABLE IF EXISTS `media_files`");

        $this->execute("
            CREATE TABLE `media_files` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `object_id` VARCHAR(100) NULL DEFAULT NULL COMMENT 'ID объекта',
                `model_id` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Модель',
                `remote_id` VARCHAR(100) NOT NULL COMMENT 'Файл',
                `tag` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Тег',
                `title` TEXT NULL COMMENT 'Название',
                `descr` TEXT NULL COMMENT 'Описание',
                `order` INT(11) UNSIGNED NOT NULL COMMENT 'Порядок',
                `type` ENUM('img','video','audio','doc') NULL DEFAULT NULL COMMENT 'Тип файла',
                `api_name` VARCHAR(50) NULL DEFAULT NULL COMMENT 'API',
                `target_api` VARCHAR(20) NULL DEFAULT NULL COMMENT 'API в которое нужно сконвертировать',
                `status` ENUM('on_moderate','active','deleted') NULL DEFAULT NULL COMMENT 'Статус',
                PRIMARY KEY (`id`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDb;
        ");
	}

	public function down()
	{
		echo "m121022_120130_media_file3 does not support migration down.\n";
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