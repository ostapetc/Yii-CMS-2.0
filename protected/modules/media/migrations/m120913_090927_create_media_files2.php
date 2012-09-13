<?php

class m120913_090927_create_media_files2 extends DbMigration
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
            `name` VARCHAR(100) NOT NULL COMMENT 'Файл',
            `tag` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Тег',
            `title` TEXT NULL COMMENT 'Название',
            `descr` TEXT NULL COMMENT 'Описание',
            `order` INT(11) UNSIGNED NOT NULL COMMENT 'Порядок',
            `path` VARCHAR(250) NOT NULL COMMENT 'Путь к файлу',
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDb
        ");


	}

	public function down()
	{
		echo "m120913_090927_create_media_files2 does not support migration down.\n";
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