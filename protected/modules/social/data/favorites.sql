CREATE TABLE IF NOT EXISTS `favorites` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `object_id` int(11) unsigned NOT NULL,
  `model_id` varchar(50) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_object_id_model_id` (`user_id`,`object_id`,`model_id`),
  KEY `user_id` (`user_id`),
  KEY `object_id_model_id` (`object_id`,`model_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;


ALTER TABLE `favorites`
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
