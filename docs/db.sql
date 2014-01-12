--
-- Current Database: `activatoradmin`
--

CREATE DATABASE IF NOT EXISTS `activatoradmin`;

USE `activatoradmin`;

--
-- Table structure for table `items`
--
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(4) DEFAULT '0',
  `name` varchar(255) DEFAULT '',
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
