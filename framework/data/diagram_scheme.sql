DROP TABLE IF EXISTS `diagram_user`;

CREATE TABLE `diagram_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(50) not null,
  `first_name` varchar(20),
  `last_name` varchar(50) not null,
  `email` varchar(20) not null,
  `created_time int(11),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;