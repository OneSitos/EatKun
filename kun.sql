DROP TABLE IF EXISTS `kun_rank`;
CREATE TABLE `kun_rank` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `score` smallint(6) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL,
  `time` datetime NOT NULL,
  `system` varchar(320) NOT NULL,
  `area` varchar(320) NOT NULL,
  `message` varchar(1280) NOT NULL,
  `attempts` mediumint(9) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;