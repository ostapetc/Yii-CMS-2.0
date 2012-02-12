<?php
class m120210_223441_banners extends CDbMigration
{
	public function up()
	{
		$this->execute("-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 11 2012 г., 01:34
-- Версия сервера: 5.1.40
-- Версия PHP: 5.3.3

SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";

--
-- БД: `yii_base`
--

-- --------------------------------------------------------

--
-- Структура таблицы `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned DEFAULT NULL COMMENT 'Раздел сайта',
  `name` varchar(50) NOT NULL COMMENT 'Название',
  `content` text,
  `image` varchar(37) NOT NULL COMMENT 'Изображение',
  `url` varchar(500) DEFAULT NULL COMMENT 'URL-адрес',
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Активен',
  `order` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Сортировка',
  `date_start` date DEFAULT NULL COMMENT 'Дата начала показа',
  `date_end` date DEFAULT NULL COMMENT 'Дата окончания показа',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `banners`
--

INSERT INTO `banners` (`id`, `page_id`, `name`, `content`, `image`, `url`, `is_published`, `order`, `date_start`, `date_end`) VALUES
(1, NULL, 'Yii-CMS на GitHub', 'Разработка ведется на GitHub.com', 'GitHub.png', 'https://github.com/ostapetc/Yii-CMS-2.0', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `banners_roles`
--

CREATE TABLE IF NOT EXISTS `banners_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) unsigned NOT NULL,
  `role` varchar(64) NOT NULL COMMENT 'Роль',
  PRIMARY KEY (`id`),
  KEY `banner_id` (`banner_id`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `banners_roles`
--

INSERT INTO `banners_roles` (`id`, `banner_id`, `role`) VALUES
(1, 1, 'guest'),
(2, 1, 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `menu_links`
--

CREATE TABLE IF NOT EXISTS `menu_links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Родитель',
  `page_id` int(11) unsigned DEFAULT NULL COMMENT 'Привязка к странице',
  `menu_id` int(11) unsigned NOT NULL COMMENT 'Меню',
  `title` varchar(50) NOT NULL COMMENT 'Заголовок',
  `url` varchar(200) NOT NULL COMMENT 'Адрес',
  `user_role` varchar(64) DEFAULT NULL COMMENT 'Только для',
  `not_user_role` varchar(64) DEFAULT NULL COMMENT 'Для всех кроме',
  `order` int(11) NOT NULL COMMENT 'Порядок',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Отображать',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `menu_id` (`menu_id`),
  KEY `parent_id` (`parent_id`),
  KEY `user_role` (`user_role`),
  KEY `not_user_role` (`not_user_role`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `menu_links`
--

INSERT INTO `menu_links` (`id`, `lang`, `parent_id`, `page_id`, `menu_id`, `title`, `url`, `user_role`, `not_user_role`, `order`, `is_visible`) VALUES
(1, 'ru', NULL, 1, 6, 'Главная', '/', NULL, NULL, 1, 1),
(2, 'ru', NULL, 2, 6, 'О нас', 'about_usss', NULL, NULL, 2, 1),
(3, 'ru', NULL, NULL, 6, 'Обратная связь', 'feedback', NULL, NULL, 3, 1),
(7, 'en', NULL, 3, 6, 'Main page', '', NULL, NULL, 1, 1),
(8, 'en', NULL, 4, 6, 'About us', '', NULL, NULL, 2, 1),
(9, 'en', NULL, NULL, 6, 'Feedback', 'feedback', NULL, NULL, 3, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `banners_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `banners_roles`
--
ALTER TABLE `banners_roles`
  ADD CONSTRAINT `banners_roles_ibfk_1` FOREIGN KEY (`banner_id`) REFERENCES `banners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `banners_roles_ibfk_2` FOREIGN KEY (`role`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_links`
--
ALTER TABLE `menu_links`
  ADD CONSTRAINT `menu_links_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `menu_links` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_3` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_4` FOREIGN KEY (`user_role`) REFERENCES `auth_items` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_5` FOREIGN KEY (`not_user_role`) REFERENCES `auth_items` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_6` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
");
		
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
		echo "m120210_223441_banners does not support migration down.\n";
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
