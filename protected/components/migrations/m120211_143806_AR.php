<?php
class m120211_143806_AR extends CDbMigration
{
	public function up()
	{
    $a = <<<HEAD
    UPDATE `yii_base`.`documentation` SET `content` = '#ActiveRecord

##Labels для атрибутов

`Labels` для атрибутов берутся из комментариев к полям в БД


##Scopes

По умолчанию доступны следующие `scopes`:

~~~
[php]
public function limit(\$num)
public function offset(\$num)
public function in(\$row, \$values, \$operator = \'AND\')
public function notIn(\$row, \$values, \$operator = \'AND\')
public function notEqual(\$param, \$value)
public function last()
public function published()
public function ordered()
~~~

##Подключаемые поведения

По умолчанию всегда подключены следующие поведения:

- `NullValueBehavior` - записывает `null` в пустые поля для которых есть `allowNull`
- `UserForeignKeyBehavior` - `если имеется не заданный атрибу `user_id`, то он устанавливается в Yii::app()->user->id
- `UploadFileBehavior` - автоматически загружает файлы
- `DateFormatBehavior` - автоматически форматирует даты нужным образом
- `TimestampBehavior` - автоматически выставляет значения `date_create` и `date_update`
- `MaxMinBehavior` - содержит функции поиска максимума/минимума по заданному атрибуту


##Дополнительные функции добавляемые поведениями

**MaxMinBehavior**

- `public function min(\$attr)` - находит минимум в БД для заданного атрибута модели
- `public function max(\$attr)` - находит максимум в БД для заданного атрибута модели

**UploadFileBehavior**

Позволяет использовать следующий синтаксис в моделях для автоматической загрузки файлов

~~~
[php]
public function uploadFiles()
{
    return array(
        \'photo\' => array(\'dir\' => self::PHOTOS_DIR)
    );
}
~~~


##Возможность использования "негорбатого" стиля

Добавлена поддержка "негорбатого" написания полей класса,
т.е. для геттера вида `getUserInfo` вы можете писать `\$model->user_info`,
и геттер отработает.
Для сеттеров ситуация аналогичная.
';
HEAD;
		$this->execute($a);
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
		$this->clearAssets();
	}
	
	private function clearAssets()
	{
		$path = Yii::app()->getComponent('assetManager')->getBasePath();
		$this->clearDir($path);
		echo "Assets clear\n";
	}

	private function clearDir($folder, $main=true)
	{
		if(is_dir($folder))
		{
			$handle = opendir($folder);
			while($subfile = readdir($handle))
			{
				if($subfile == '.' || $subfile == '..')
					continue;
				if(is_file($subfile))
					unlink("{$folder}/{$subfile}");
				else
					$this->clearDir("{$folder}/{$subfile}", false);
			}
			closedir($handle);
			if(!$main)
				rmdir($folder);
		}
		else
			unlink($folder);
	}

	public function down()
	{
		echo "m120211_143806_AR does not support migration down.\n";
		return false;
		
		$this->execute("");
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
