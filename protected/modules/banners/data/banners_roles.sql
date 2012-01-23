#
# Структура для таблицы `banners_roles`: 
#

CREATE TABLE `banners_roles` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `banner_id` INTEGER(11) UNSIGNED NOT NULL,
  `role` VARCHAR(64) COLLATE utf8_general_ci NOT NULL COMMENT 'Роль',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `banner_id` USING BTREE (`banner_id`) COMMENT '',
   INDEX `role` USING BTREE (`role`) COMMENT '',
  CONSTRAINT `banners_roles_ibfk_2` FOREIGN KEY (`role`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `banners_roles_ibfk_1` FOREIGN KEY (`banner_id`) REFERENCES `banners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=121 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

