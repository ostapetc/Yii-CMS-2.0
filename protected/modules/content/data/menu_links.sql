#
# Структура для таблицы `menu_links`: 
#

CREATE TABLE `menu_links` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang` CHAR(2) COLLATE utf8_general_ci DEFAULT 'ru' COMMENT 'Язык',
  `parent_id` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Родитель',
  `page_id` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Привязка к странице',
  `menu_id` INTEGER(11) UNSIGNED NOT NULL COMMENT 'Меню',
  `title` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Заголовок',
  `url` VARCHAR(200) COLLATE utf8_general_ci NOT NULL COMMENT 'Адрес',
  `user_role` VARCHAR(64) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Только для',
  `not_user_role` VARCHAR(64) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Для всех кроме',
  `order` INTEGER(11) NOT NULL COMMENT 'Порядок',
  `is_visible` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Отображать',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `page_id` USING BTREE (`page_id`) COMMENT '',
   INDEX `menu_id` USING BTREE (`menu_id`) COMMENT '',
   INDEX `parent_id` USING BTREE (`parent_id`) COMMENT '',
   INDEX `user_role` USING BTREE (`user_role`) COMMENT '',
   INDEX `not_user_role` USING BTREE (`not_user_role`) COMMENT '',
   INDEX `lang` USING BTREE (`lang`) COMMENT '',
  CONSTRAINT `menu_links_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `menu_links` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `menu_links_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `menu_links_ibfk_3` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `menu_links_ibfk_4` FOREIGN KEY (`user_role`) REFERENCES `auth_items` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `menu_links_ibfk_5` FOREIGN KEY (`not_user_role`) REFERENCES `auth_items` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `menu_links_ibfk_6` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=14 AVG_ROW_LENGTH=1489 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
