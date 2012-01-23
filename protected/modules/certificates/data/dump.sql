CREATE TABLE IF NOT EXISTS `certificates_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Название',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлена',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;


INSERT INTO `certificates_groups` (`id`, `name`, `date_create`) VALUES
(5, 'Низкое напряжение', '2011-09-21 01:45:52'),
(6, 'Автоматизация зданий', '2011-09-21 01:45:52'),
(7, 'Электрооборудование для промышленных установок', '2011-09-21 01:45:52'),
(8, 'Электроустановочные изделия', '2011-09-21 01:45:52'),
(9, 'Кабеленесущие системы', '2011-09-21 01:45:52'),
(10, 'Приводная техника', '2011-09-21 01:45:52'),
(11, 'Сетевые фильтры и ИБП однофазные', '2011-09-21 01:45:52'),
(12, 'Промышленная автоматизация', '2011-09-21 01:45:52'),
(13, 'ИБП трехфазные и  инженерная инфраструктура', '2011-09-21 01:45:52');


CREATE TABLE IF NOT EXISTS `certificates_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Тип',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлен',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;


INSERT INTO `certificates_types` (`id`, `name`, `date_create`) VALUES
(1, 'ГОСТ', '2011-09-21 01:45:58'),
(2, 'ПожБ', '2011-09-21 01:45:58'),
(3, 'Метр', '2011-09-21 01:45:58'),
(4, 'РТН', '2011-09-21 01:45:58'),
(5, 'АЭС', '2011-09-21 01:45:58'),
(6, 'РМРС', '2011-09-21 01:45:58'),
(7, 'РРР', '2011-09-21 01:45:58'),
(8, 'СЭЗ', '2011-09-21 01:45:58'),
(9, 'Минсвязь', '2011-09-21 01:45:58');