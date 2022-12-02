-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.19 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Export de la structure de la base pour plumers
CREATE DATABASE IF NOT EXISTS `plumers` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `plumers`;

-- Export de la structure de la table plumers. add_to_cart
CREATE TABLE IF NOT EXISTS `add_to_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=139 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.add_to_cart : 5 rows
/*!40000 ALTER TABLE `add_to_cart` DISABLE KEYS */;
INSERT INTO `add_to_cart` (`id`, `user_id`, `product_id`, `date`) VALUES
	(134, 28, 6, '2020-05-04 15:54:36'),
	(133, 24, 5, '2020-04-29 14:12:03'),
	(127, 25, 4, '2020-04-29 05:45:54'),
	(138, 49, 6, '2020-05-05 15:28:41'),
	(132, 24, 6, '2020-04-29 10:36:41');
/*!40000 ALTER TABLE `add_to_cart` ENABLE KEYS */;

-- Export de la structure de la table plumers. admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `profileimage` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uodated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.admin : ~1 rows (environ)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `username`, `email`, `password`, `profileimage`, `status`, `created_on`, `uodated_on`) VALUES
	(1, 'admin', 'admin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '', '', '2020-01-12 15:14:29', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Export de la structure de la table plumers. admin_project_payment_status
CREATE TABLE IF NOT EXISTS `admin_project_payment_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rowid` bigint(20) NOT NULL,
  `affiliate_id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `affiliate_comment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_comment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` bigint(20) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.admin_project_payment_status : ~5 rows (environ)
/*!40000 ALTER TABLE `admin_project_payment_status` DISABLE KEYS */;
INSERT INTO `admin_project_payment_status` (`id`, `rowid`, `affiliate_id`, `customer_id`, `project_id`, `affiliate_comment`, `customer_comment`, `status`, `date`) VALUES
	(3, 5, 35, 36, 5, 'i need To pay ', '', 2, '2020-04-21'),
	(4, 11, 25, 24, 10, 'I have done. this project...', '', 2, '2020-04-28'),
	(5, 12, 25, 24, 11, 'I have done this project please refund my money...', '', 2, '2020-04-29'),
	(6, 19, 35, 34, 15, 'Need payement ', '', 2, '2020-05-05'),
	(7, 11, 35, 35, 5, 'i need To pay ', 'BB', 2, '2020-04-21');
/*!40000 ALTER TABLE `admin_project_payment_status` ENABLE KEYS */;

-- Export de la structure de la table plumers. affiliate_customer_projects
CREATE TABLE IF NOT EXISTS `affiliate_customer_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `customer_project_id` bigint(20) NOT NULL,
  `status` varchar(255) CHARACTER SET latin1 NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.affiliate_customer_projects : 0 rows
/*!40000 ALTER TABLE `affiliate_customer_projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `affiliate_customer_projects` ENABLE KEYS */;

-- Export de la structure de la table plumers. affiliate_off_days
CREATE TABLE IF NOT EXISTS `affiliate_off_days` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.affiliate_off_days : ~5 rows (environ)
/*!40000 ALTER TABLE `affiliate_off_days` DISABLE KEYS */;
INSERT INTO `affiliate_off_days` (`id`, `affiliate_id`, `date`) VALUES
	(16, 27, '2020-04-30'),
	(17, 35, '2020-04-30'),
	(18, 35, '2020-05-16'),
	(19, 35, '2020-05-17'),
	(20, 35, '2020-05-18');
/*!40000 ALTER TABLE `affiliate_off_days` ENABLE KEYS */;

-- Export de la structure de la table plumers. affiliate_portfolio_profile
CREATE TABLE IF NOT EXISTS `affiliate_portfolio_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint(20) NOT NULL,
  `category` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `linkedin_link` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fb_link` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.affiliate_portfolio_profile : 8 rows
/*!40000 ALTER TABLE `affiliate_portfolio_profile` DISABLE KEYS */;
INSERT INTO `affiliate_portfolio_profile` (`id`, `affiliate_id`, `category`, `linkedin_link`, `fb_link`, `description`, `date`) VALUES
	(21, 35, 'Designer', '', '', 'Je suis designer depuis plus de 20 ans. Je suis passionné par le design intérieur ça me fait vibrer. J aime les gens autour de moi ?❤️❤️???????????????❤️❤️???????????', '2020-04-19 10:00:51'),
	(19, 25, 'Designer', '', '', 'hello Everyone', '2020-04-16 07:10:08'),
	(20, 27, 'Designer', '', '', 'Je suis un passionné de Design avec 30 d experience. J aime les gens et le design intérieur ???????????????✌️✌️???', '2020-04-18 03:10:06'),
	(18, 22, 'Designer', '', '', 'I have a lot of experience in Designer... ', '2020-04-15 10:26:26'),
	(22, 36, 'Designer', '', '', 'I have a lot of experience in Designer... ', '2020-04-15 10:26:26'),
	(23, 32, 'Designer', '', '', 'passionnée de déco', '2020-04-21 19:43:33'),
	(24, 38, 'Plumber', '', '', 'Idi u yait f udit thushti fff', '2020-04-22 15:46:19'),
	(25, 39, 'Designer', '', '', 'Hello I am Kamal', '2020-04-23 11:57:43');
/*!40000 ALTER TABLE `affiliate_portfolio_profile` ENABLE KEYS */;

-- Export de la structure de la table plumers. affiliate_portfolio_project
CREATE TABLE IF NOT EXISTS `affiliate_portfolio_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint(20) NOT NULL,
  `project_name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `project_image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `project_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.affiliate_portfolio_project : 12 rows
/*!40000 ALTER TABLE `affiliate_portfolio_project` DISABLE KEYS */;
INSERT INTO `affiliate_portfolio_project` (`id`, `affiliate_id`, `project_name`, `project_image`, `project_description`, `date`) VALUES
	(11, 35, 'maison patrimoine ', 'http://plumers.test/public/uploads/1587304941_photo_IMG_20190517_140415.jpg,http://plumers.test/public/uploads/1587304941_photo_20181019_020248.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190206_111351.jpg,http://plumers.test/public/uploads/1587304941_photo_20181019_021146.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190206_111353.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190206_111445.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190220_133716.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190220_133733.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190220_133725.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190220_133721.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190220_133737.jpg,http://plumers.test/public/uploads/1587304941_photo_20181024_234748.jpg,http://plumers.test/public/uploads/1587304941_photo_20180822_144352.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190517_140418.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190220_133744.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190517_140434.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190528_112048.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190528_112056.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190825_161447.jpg,http://plumers.test/public/uploads/1587304941_photo_IMG_20190825_161449.jpg', 'Maison St Jean ???????☺️☺️☺️☺️', '2020-04-19 10:02:21'),
	(10, 27, 'maison t?moin ', 'http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161447.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161449.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161534.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161524.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161523.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161536.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161535.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161543.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161609.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161555.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161548.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161612.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161615.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161616.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161624.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161626.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161638.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161655.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161652.jpg,http://plumers.test/public/uploads/1587194212_photo_IMG_20190825_161640.jpg', 'La maison témoin fut un plaisir pour nous ????????☺️???????????????????????????????', '2020-04-18 03:16:52'),
	(8, 25, 'Anand Kitchen', 'http://plumers.test/public/uploads/1587035391_photo_1587035377939.jpg', 'I have a good knowledge of Anand kitchen.', '2020-04-16 07:09:51'),
	(9, 27, 'maison Legault ', 'http://plumers.test/public/uploads/1587193999_photo_IMG_20200312_142342.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20190604_135747.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20200402_213714.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20200402_211554.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20191204_150456.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20200311_151615.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20200402_211755.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20200313_115534.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20200312_142356.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20190606_141155.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20190606_141152.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20190606_141148.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20190606_141130.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20190606_141132.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20190606_141136.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20190604_135742.jpg,http://plumers.test/public/uploads/1587193999_photo_IMG_20190604_135744.jpg', 'Cuisine maison Legault ????????????????????', '2020-04-18 03:13:20'),
	(7, 22, 'Anand Kitch', 'http://plumers.test/public/uploads/1586960837_photo_IMG-20200121-WA0001.jpg,http://plumers.test/public/uploads/1586960837_photo_IMG-20200121-WA0003.jpg,http://plumers.test/public/uploads/1586960837_photo_IMG-20200121-WA0002.jpg', 'I want to renovate a kitchen. I want good worker.. ', '2020-04-15 10:27:17'),
	(12, 35, 'maison fort de france ', 'http://plumers.test/public/uploads/1587305310_photo_IMG_20190604_135742.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190604_135744.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190606_141130.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190606_141136.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190606_141132.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190606_141148.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20191204_150456.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200311_151615.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200312_142342.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200313_115534.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200312_142356.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200402_211554.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190604_135747.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190606_141152.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190830_170149.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200313_115535.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200311_213951.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200311_213947.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190830_170135.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190903_131711.jpg', 'Maison du 18 siècle rénover ????☀️☀️☀️☀️☀️????????', '2020-04-19 10:08:30'),
	(13, 36, 'maison fort de france ', 'http://plumers.test/public/uploads/1587305310_photo_IMG_20190604_135742.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190604_135744.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190606_141130.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190606_141136.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190606_141132.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190606_141148.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20191204_150456.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200311_151615.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200312_142342.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200313_115534.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200312_142356.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200402_211554.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190604_135747.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190606_141152.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190830_170149.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200313_115535.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200311_213951.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20200311_213947.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190830_170135.jpg,http://plumers.test/public/uploads/1587305310_photo_IMG_20190903_131711.jpg', 'Maison du 18 siècle rénover ????☀️☀️☀️☀️☀️????????', '2020-04-19 10:08:30'),
	(14, 35, 'Design Perso ', 'http://plumers.test/public/uploads/1587458188_photo_mmexport1587452371785.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1587452369030.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1587452361821.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1587452354277.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1587447275292.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1587447243324.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1587447240748.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1587368079502.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1587362947666.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1587362940215.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1587362936608.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1587348728992.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1587362933426.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1586276815620.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1585625473437.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1585625461218.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1585625453101.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1585625429356.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1585583601809.jpg,http://plumers.test/public/uploads/1587458188_photo_mmexport1584614797501.jpg', 'Nouvelle cuisines extérieur ???????????????????????????', '2020-04-21 04:36:28'),
	(15, 32, 'maison', 'http://plumers.test/public/uploads/1587512580_photo_Snapchat-390611642.jpg', 'construction d\'une maison en briques ', '2020-04-21 19:43:00'),
	(16, 38, 'Hello kitchen', 'http://plumers.test/public/uploads/1587584750_photo_IMG-20200422-WA0030.jpg,http://plumers.test/public/uploads/1587584750_photo_IMG-20200422-WA0029.jpg,http://plumers.test/public/uploads/1587584750_photo_IMG-20200422-WA0028.jpg,http://plumers.test/public/uploads/1587584750_photo_IMG-20200404-WA0025.jpg,http://plumers.test/public/uploads/1587584750_photo_IMG-20200422-WA0023.jpg', 'Uday hthudu u uday t', '2020-04-22 15:45:50'),
	(17, 39, 'kamal', 'http://plumers.test/public/uploads/1587657391_photo_IMG-20200422-WA0007.jpg', 'Hello I am kamal', '2020-04-23 11:56:31'),
	(18, 39, 'kamal', 'http://plumers.test/public/uploads/1587657393_photo_IMG-20200422-WA0007.jpg', 'Hello I am kamal', '2020-04-23 11:56:33');
/*!40000 ALTER TABLE `affiliate_portfolio_project` ENABLE KEYS */;

-- Export de la structure de la table plumers. affiliate_portfolio_videos
CREATE TABLE IF NOT EXISTS `affiliate_portfolio_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint(20) NOT NULL,
  `link` longtext CHARACTER SET latin1 NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.affiliate_portfolio_videos : 0 rows
/*!40000 ALTER TABLE `affiliate_portfolio_videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `affiliate_portfolio_videos` ENABLE KEYS */;

-- Export de la structure de la table plumers. affiliate_portfolio_vr
CREATE TABLE IF NOT EXISTS `affiliate_portfolio_vr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint(20) NOT NULL,
  `vr` longtext CHARACTER SET latin1 NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.affiliate_portfolio_vr : 0 rows
/*!40000 ALTER TABLE `affiliate_portfolio_vr` DISABLE KEYS */;
/*!40000 ALTER TABLE `affiliate_portfolio_vr` ENABLE KEYS */;

-- Export de la structure de la table plumers. affiliate_project
CREATE TABLE IF NOT EXISTS `affiliate_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint(20) NOT NULL,
  `project_name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `service` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.affiliate_project : 4 rows
/*!40000 ALTER TABLE `affiliate_project` DISABLE KEYS */;
INSERT INTO `affiliate_project` (`id`, `affiliate_id`, `project_name`, `service`, `description`, `images`, `status`, `date`) VALUES
	(18, 25, 'kidjjdj', 'Need 3D plan', 'zuzhhxhs', 'http://plumers.test/public/uploads/1588006445_photo_IMG-20200419-WA0002.jpg,http://plumers.test/public/uploads/1588006445_photo_IMG-20200324-WA0001.jpg,http://plumers.test/public/uploads/1588006445_photo_IMG-20200419-WA0000.jpg', 1, '2020-04-27 12:54:05'),
	(19, 25, 'Gaurav project', 'Need 3D plan', 'I want to renovate my kitchen', 'http://plumers.test/public/uploads/1588154136_photo_IMG-20200325-WA0000.jpg,http://plumers.test/public/uploads/1588154136_photo_IMG-20200324-WA0001.jpg,http://plumers.test/public/uploads/1588154136_photo_IMG-20200324-WA0003.jpg', 1, '2020-04-29 05:55:36'),
	(17, 25, 'kitchen Henri', 'Need VR plan', 'I want to redesign of my kitchen...', 'http://plumers.test/public/uploads/1588006260_photo_IMG-20200419-WA0002.jpg,http://plumers.test/public/uploads/1588006260_photo_IMG-20200324-WA0001.jpg,http://plumers.test/public/uploads/1588006260_photo_IMG-20200419-WA0000.jpg', 1, '2020-04-27 12:51:00'),
	(16, 35, 'refaire cuisine ', 'Need 3D plan', 'je désire avoir les 3D de mon projet ', 'http://plumers.test/public/uploads/1587484170_photo_SmartSelect_20181019-090009_Drive.jpg', 1, '2020-04-21 11:49:30');
/*!40000 ALTER TABLE `affiliate_project` ENABLE KEYS */;

-- Export de la structure de la table plumers. affiliate_project_files
CREATE TABLE IF NOT EXISTS `affiliate_project_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint(20) NOT NULL,
  `affiliate_project_id` bigint(20) NOT NULL,
  `service_type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pdf` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.affiliate_project_files : ~3 rows (environ)
/*!40000 ALTER TABLE `affiliate_project_files` DISABLE KEYS */;
INSERT INTO `affiliate_project_files` (`id`, `affiliate_id`, `affiliate_project_id`, `service_type`, `thumbnail`, `link`, `image`, `pdf`, `doc`, `date`) VALUES
	(5, 25, 18, 'Need 3D plan', '', '', 'http://plumers.test/public/uploads/drlogo1.png,http://plumers.test/public/uploads/dr-archana-sharma-logo.png', '', '', '2020-04-28'),
	(6, 25, 18, 'Need 3D plan', '', '', 'http://plumers.test/public/uploads/IMG_2772.jpg,http://plumers.test/public/uploads/practo2.png', '', '', '2020-04-28'),
	(7, 25, 19, 'Need 3D plan', '', '', 'http://plumers.test/public/uploads/030320200044123.jpg,http://plumers.test/public/uploads/030320200045043.jpg,http://plumers.test/public/uploads/170120201542172.jpg', '', '', '2020-04-29');
/*!40000 ALTER TABLE `affiliate_project_files` ENABLE KEYS */;

-- Export de la structure de la table plumers. affiliate_user
CREATE TABLE IF NOT EXISTS `affiliate_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `name` longtext CHARACTER SET latin1 NOT NULL,
  `accountnumber` longtext CHARACTER SET latin1 NOT NULL,
  `routingNumber` longtext CHARACTER SET latin1 NOT NULL,
  `earnings` float(10,2) NOT NULL,
  `status` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.affiliate_user : 8 rows
/*!40000 ALTER TABLE `affiliate_user` DISABLE KEYS */;
INSERT INTO `affiliate_user` (`id`, `user_id`, `name`, `accountnumber`, `routingNumber`, `earnings`, `status`, `date`) VALUES
	(20, 27, '', '', '', 0.00, 1, '2020-04-18 03:16:58'),
	(19, 25, '', '', '', 0.00, 1, '2020-04-16 07:10:10'),
	(18, 22, '', '', '', 0.00, 1, '2020-04-15 10:27:21'),
	(21, 35, '', '', '', 0.00, 1, '2020-04-19 10:08:36'),
	(22, 36, '', '', '', 0.00, 1, '2020-04-20 10:08:36'),
	(23, 32, '', '', '', 0.00, 1, '2020-04-21 19:43:42'),
	(24, 38, '', '', '', 0.00, 1, '2020-04-22 15:46:23'),
	(25, 39, '', '', '', 0.00, 1, '2020-04-23 11:57:58');
/*!40000 ALTER TABLE `affiliate_user` ENABLE KEYS */;

-- Export de la structure de la table plumers. affiliate_vr_by_admin
CREATE TABLE IF NOT EXISTS `affiliate_vr_by_admin` (
  `id` int(11) NOT NULL,
  `affiliate_id` bigint(20) NOT NULL,
  `vr` longtext CHARACTER SET latin1 NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.affiliate_vr_by_admin : 0 rows
/*!40000 ALTER TABLE `affiliate_vr_by_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `affiliate_vr_by_admin` ENABLE KEYS */;

-- Export de la structure de la table plumers. annee_scolaire
CREATE TABLE IF NOT EXISTS `annee_scolaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `debut_annee` date DEFAULT NULL,
  `fin_annee` date DEFAULT NULL,
  `annee` varchar(12) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.annee_scolaire : ~1 rows (environ)
/*!40000 ALTER TABLE `annee_scolaire` DISABLE KEYS */;
INSERT INTO `annee_scolaire` (`id`, `debut_annee`, `fin_annee`, `annee`, `created_at`, `update_at`) VALUES
	(2, '2020-07-06', '2021-04-05', '2020-2021', '2020-07-06 00:05:30', NULL);
/*!40000 ALTER TABLE `annee_scolaire` ENABLE KEYS */;

-- Export de la structure de la table plumers. apprenant
CREATE TABLE IF NOT EXISTS `apprenant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `photo` varchar(100) DEFAULT 'sss',
  `sexe` varchar(10) DEFAULT NULL,
  `telephone` varchar(10) DEFAULT NULL,
  `idclasse` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.apprenant : ~2 rows (environ)
/*!40000 ALTER TABLE `apprenant` DISABLE KEYS */;
INSERT INTO `apprenant` (`id`, `nom`, `prenom`, `date_naissance`, `photo`, `sexe`, `telephone`, `idclasse`, `created_at`, `updated_at`) VALUES
	(2, 'dikla', 'lucien', '2020-07-07', 'http://itnote.log/public/identity/6c2e3a2ff83dca3d4567e14adce42538.png', 'Masculin', '696888617', 5, '2020-07-02 23:27:18', '2020-07-03 09:56:50'),
	(3, 'Yousouf', 'hamadou', '2020-07-10', 'http://itnote.log/public/identity/7ef34e4f48463680130e5082de4b1012.png', 'Masculin', '696888617', 6, '2020-07-02 23:35:43', '2020-07-03 10:22:50');
/*!40000 ALTER TABLE `apprenant` ENABLE KEYS */;

-- Export de la structure de la table plumers. banners
CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `vr` longtext CHARACTER SET latin1 NOT NULL,
  `banner` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.banners : ~7 rows (environ)
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` (`id`, `title`, `vr`, `banner`, `created_on`) VALUES
	(8, 'salon', '', 'http://plumers.test/public/uploads/03032020004229.jpg', '2020-03-03 09:42:29'),
	(9, 'salon', '', 'http://plumers.test/public/uploads/03032020004319.jpg', '2020-03-03 09:43:19'),
	(10, 'exterieur', '', 'http://plumers.test/public/uploads/03032020004412.jpg', '2020-03-03 09:44:12'),
	(11, 'salon', '', 'http://plumers.test/public/uploads/03032020004504.jpg', '2020-03-03 09:45:04'),
	(12, 'salon', '', 'http://plumers.test/public/uploads/03032020004552.jpg', '2020-03-03 09:45:52'),
	(14, '', '', 'http://plumers.test/public/uploads/14032020105010.jpg', '2020-03-14 18:50:10'),
	(15, 'VR Image', 'https://inviz.pro/wp-content/uploads/tour/fireplace/index.htm', '', '2020-03-26 03:00:13');
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;

-- Export de la structure de la table plumers. boutique
CREATE TABLE IF NOT EXISTS `boutique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `sexe` varchar(20) NOT NULL,
  `naissance` date NOT NULL,
  `cni` varchar(20) NOT NULL,
  `imageCni` text,
  `numero` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `matricule` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ville` varchar(100) DEFAULT NULL,
  `quartier` varchar(150) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'assets/images/user.png',
  `last_login` datetime DEFAULT NULL,
  `etat` tinyint(4) DEFAULT '1',
  `privilege` text,
  `idProfile` int(11) DEFAULT NULL,
  `libProfile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.boutique : ~2 rows (environ)
/*!40000 ALTER TABLE `boutique` DISABLE KEYS */;
INSERT INTO `boutique` (`id`, `type`, `nom`, `prenom`, `sexe`, `naissance`, `cni`, `imageCni`, `numero`, `email`, `matricule`, `password`, `created_at`, `ville`, `quartier`, `adresse`, `photo`, `last_login`, `etat`, `privilege`, `idProfile`, `libProfile`) VALUES
	(1, 2, 'Founda Wafo', 'Alain Chris', 'Masculin', '1987-11-26', '10000956676798', NULL, '671747474', 'alain@yahoo.fr', '15A11261', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', '2017-11-09 10:47:15', 'Douala', 'New Bell', 'CBC Nguangue', 'assets/images/user.png', '2019-08-08 19:32:37', 1, 'MAKE_TRANSACTIONS,ADD_PAYMENT,ADD_PAYMENT_2,VIEW_TRANSACTIONS,VIEW_TYPE_TRANSACTIONS,ADD_TYPE_TRANSACTIONS,EDIT_TYPE_TRANSACTIONS,DELETE_TYPE_TRANSACTIONS,PRINT_RECU,VIEW_SCOLARITE,ADD_SCOLARITE,EDIT_SCOLARITE,VIEW_SCOLARITE_PAYMENTS,VIEW_CHARGE,ADD_CHARGE,EDIT_CHARGE,DELETE_CHARGE,VIEW_CHARGE_PAYMENTS,DELETE_PAYMENTS,TABLEAU_BORD,PRINT_BULLETIN,PRINT_OTHERS,PLANIFICATION,PROFIL_GESTION,PRINT_GESTION,PROFILE_GESTION,VIEW_CLASSES,VIEW_CLASSES_STATS,ADD_CLASSES,EDIT_CLASSES,DELETE_CLASSES,VIEW_CLASSES_ELEVES,VIEW_CLASSES_ELEVES_GENERATE,VIEW_CLASSES_ELEVES_SANCTIONNER,VIEW_CLASSES_COURS,VIEW_CLASSES_COURS_ADD,VIEW_CLASSES_COURS_EDIT,VIEW_CLASSES_COURS_DELETE,VIEW_CLASSES_COURS_CHANGER_ENSEIGNANT,VIEW_CLASSES_COURS_NOTES,NOTE_ADD,NOTE_EDIT,NOTE_CALCUL,VIEW_CLASSES_JOURNAL,JOURNAL_ADD,JOURNAL_EDIT,VIEW_ELEVES,ADD_ELEVE,EDIT_ELEVE,RESET_ELEVE,ELEVE_DETAIL,ELEVE_ADD_CLASSE,ELEVE_REMOVE_CLASSE,VIEW_ENSEIGNANTS,ADD_ENSEIGNANT,EDIT_ENSEIGNANT,RESET_ENSEIGNANT,ENSEIGNANT_DETAIL,ENSEIGNANT_ADD_CLASSE,VIEW_PERSONNELS,ADD_PERSONNEL,EDIT_PERSONNEL,RESET_PERSONNEL,PERSONNEL_DETAIL,VIEW_SESSIONS,ADD_SESSION,EDIT_SESSION,DELETE_SESSION,CONFIGURE_SESSION,VIEW_CATEGORIES,ADD_CATEGORIE,EDIT_CATEGORIE,DELETE_CATEGORIE,VIEW_SPECIALITES,ADD_SPECIALITE,EDIT_SPECIALITE,DELETE_SPECIALITE,VIEW_MATIERES,GROUP_MATIERE,ADD_MATIERE,EDIT_MATIERE,DELETE_MATIERE,VIEW_PACKS,ADD_PACK,EDIT_PACK,DELETE_PACK,VIEW_SANCTIONS,ADD_SANCTION,EDIT_SANCTION,DELETE_SANCTION,ARCHIVE_ELEVES,ARCHIVE_ENSEIGNANTS,ARCHIVE_CLASSE,ARCHIVE_SCOLARITE', 1, 'Administrateur principal'),
	(2, 1, 'Ntah Teki', 'Manuella Caprice', 'Feminin', '1993-06-15', '1256767980090871', NULL, '655555555', 'ntah@yahoo.fr', '17E09117', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', '2017-11-09 10:54:01', 'Douala', 'Cité Sic', 'Belle Hollandaise', 'assets/images/user.png', '2017-12-04 21:23:42', 1, NULL, NULL, NULL);
/*!40000 ALTER TABLE `boutique` ENABLE KEYS */;

-- Export de la structure de la table plumers. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `category_image` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'http://adminjwell.log/public/assets/img/logo.png',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.category : ~1 rows (environ)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `category_name`, `category_image`, `created_on`) VALUES
	(1, 'electronique', 'http://adminjwell.log/public/assets/img/logo.png', '2020-07-20 23:03:15');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Export de la structure de la table plumers. checkout_orders
CREATE TABLE IF NOT EXISTS `checkout_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) NOT NULL,
  `qty` bigint(20) NOT NULL,
  `total_paid_price` float(10,2) NOT NULL,
  `product_total_price` float(10,2) NOT NULL,
  `fName` varchar(200) CHARACTER SET latin1 NOT NULL,
  `lName` varchar(200) CHARACTER SET latin1 NOT NULL,
  `addressLine1` longtext CHARACTER SET latin1 NOT NULL,
  `addressLine2` longtext CHARACTER SET latin1 NOT NULL,
  `phoneNumber` varchar(200) CHARACTER SET latin1 NOT NULL,
  `provice` varchar(200) CHARACTER SET latin1 NOT NULL,
  `city` varchar(200) CHARACTER SET latin1 NOT NULL,
  `postalCode` varchar(200) CHARACTER SET latin1 NOT NULL,
  `country` varchar(200) CHARACTER SET latin1 NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `checkout_id` longtext CHARACTER SET latin1 NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `status` varchar(200) CHARACTER SET latin1 NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.checkout_orders : 54 rows
/*!40000 ALTER TABLE `checkout_orders` DISABLE KEYS */;
INSERT INTO `checkout_orders` (`id`, `product_id`, `qty`, `total_paid_price`, `product_total_price`, `fName`, `lName`, `addressLine1`, `addressLine2`, `phoneNumber`, `provice`, `city`, `postalCode`, `country`, `user_id`, `checkout_id`, `order_id`, `status`, `date`) VALUES
	(4, 5, 4, 2759.00, 2400.00, 'henri', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, 'fb89b8813155bf4fbd2c7c2ebcd0a911', 1587193472, 'succeeded', '2020-04-18 03:04:32'),
	(3, 5, 4, 2759.00, 2400.00, 'henri', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '545ec1ac46fa8d4bc32321ab48e5e540', 1587193407, 'Pending', '2020-04-18 03:03:27'),
	(5, 4, 1, 602.00, 523.61, 'mboah', 'laurence', '4627 Avenue coolbrook\\n\\n', '', '699115044', 'Québec', 'Montréal', 'H3X 2K7', 'Canada', 34, '0806c89c3625b5d0cc42731020b2d22c', 1587249136, 'Pending', '2020-04-18 18:32:16'),
	(6, 4, 1, 602.00, 523.61, 'mboah', 'laurence', '4627 Avenue coolbrook\\n\\n', '', '699115044', 'Québec', 'Montréal', 'H3X 2K7', 'Canada', 34, '3556b2dcbc2fe22db5653fdd8ff48cf5', 1587249264, 'succeeded', '2020-04-18 18:34:24'),
	(7, 4, 2, 1204.04, 1047.22, 'Anand', 'Rastogi', 'Unnamed Road, Block D, New Ashok Nagar, New Delhi, Uttar Pradesh 110096, India', '', '9635855', 'Québec', 'New Delhi', '110096', 'India', 24, 'edf8cb57bae1008bb8493de9a85b6d2c', 1587289491, 'succeeded', '2020-04-19 05:44:51'),
	(8, 6, 1, 623.70, 644.00, 'Priyanshu', 'Bisht', 'Unnamed Road, Block D, New Ashok Nagar, New Delhi, Uttar Pradesh 110096, India', '', '96325874123', 'Yukon', 'New Delhi', '110096', 'India', 24, '93cd8c683c295bde521984432672adc8', 1587293977, 'succeeded', '2020-04-19 06:59:37'),
	(9, 5, 1, 610.20, 600.00, 'Ram', 'shaym', 'E-256/A new ashoke nagar, Block ED, New Ashok Nagar, Delhi, Uttar Pradesh 110096, India', '', '8523697412', 'Ontario', 'Delhi', '110096', 'India', 24, '8615c801739c1fff42931d2f95528642', 1587294692, 'succeeded', '2020-04-19 07:11:32'),
	(10, 4, 3, 180606.00, 1570.83, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 35, 'bf4e16c67f78e115f2cf070f59737000', 1587305794, 'succeeded', '2020-04-19 10:16:34'),
	(11, 5, 1, 1893.00, 600.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, 'ac5578f4702a226dcecbb55c39a0a0d1', 1587307105, 'succeeded', '2020-04-19 10:38:25'),
	(12, 4, 2, 1893.00, 1047.22, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, 'ac5578f4702a226dcecbb55c39a0a0d1', 1587307105, 'succeeded', '2020-04-19 10:38:25'),
	(13, 4, 3, 1806.00, 1570.83, 'vinisha', 'rao', 'Unnamed Road, Block D, New Ashok Nagar, New Delhi, Uttar Pradesh 110096, Inde', '', '935853', 'Québec', 'New Delhi', '110096', 'Inde', 24, '692c85ff64b4128df51405db59640fc5', 1587309667, 'succeeded', '2020-04-19 11:21:07'),
	(14, 5, 1, 6710.00, 600.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '48e3b1b33289849d3f692d0415b6b723', 1587309716, 'succeeded', '2020-04-19 11:21:56'),
	(15, 4, 10, 6710.00, 5236.10, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '48e3b1b33289849d3f692d0415b6b723', 1587309716, 'succeeded', '2020-04-19 11:21:56'),
	(16, 5, 1, 3097.00, 600.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '2bb2eff523230ff2a2cf8fcf6a5fbdb8', 1587311555, 'succeeded', '2020-04-19 11:52:35'),
	(17, 4, 4, 3097.00, 2094.44, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '2bb2eff523230ff2a2cf8fcf6a5fbdb8', 1587311555, 'succeeded', '2020-04-19 11:52:35'),
	(18, 6, 7, 12081.00, 4508.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '4b7d6d889d5f111159a371156b681878', 1587313124, 'succeeded', '2020-04-19 12:18:44'),
	(19, 5, 10, 12081.00, 6000.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '4b7d6d889d5f111159a371156b681878', 1587313124, 'succeeded', '2020-04-19 12:18:44'),
	(20, 5, 2, 1379.00, 1200.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '4bcec55097fa85373fbacbe052050231', 1587315293, 'succeeded', '2020-04-19 12:54:53'),
	(21, 6, 1, 2120.00, 644.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '6d1f20d6e8a65b5526d6af0fc256b420', 1587320289, 'succeeded', '2020-04-19 14:18:09'),
	(22, 5, 2, 2120.00, 1200.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '6d1f20d6e8a65b5526d6af0fc256b420', 1587320289, 'succeeded', '2020-04-19 14:18:09'),
	(23, 6, 4, 3651.00, 2576.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '2d783051c4caf304fe9ca4102b07f205', 1587321096, 'succeeded', '2020-04-19 14:31:36'),
	(24, 5, 1, 3651.00, 600.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '2d783051c4caf304fe9ca4102b07f205', 1587321096, 'succeeded', '2020-04-19 14:31:36'),
	(25, 6, 3, 3704.49, 1932.00, 'test', 'redd', 'ffff', 'fff', '6898955', 'Nouveau Brunswick ', 'frrfgff', '293893', 'cskdkkff', 36, '5c67e1e2ad2c9a98fc08934eda4fb4e8', 1587463368, 'Pending', '2020-04-21 06:02:48'),
	(26, 5, 1, 3704.49, 600.00, 'test', 'redd', 'ffff', 'fff', '6898955', 'Nouveau Brunswick ', 'frrfgff', '293893', 'cskdkkff', 36, '5c67e1e2ad2c9a98fc08934eda4fb4e8', 1587463368, 'Pending', '2020-04-21 06:02:48'),
	(27, 4, 2, 3704.49, 1047.22, 'test', 'redd', 'ffff', 'fff', '6898955', 'Nouveau Brunswick ', 'frrfgff', '293893', 'cskdkkff', 36, '5c67e1e2ad2c9a98fc08934eda4fb4e8', 1587463368, 'Pending', '2020-04-21 06:02:48'),
	(28, 6, 3, 3704.49, 1932.00, 'test', 'redd', 'ffff', 'fff', '6898955', 'Nouveau Brunswick ', 'frrfgff', '293893', 'cskdkkff', 36, '4cdda760b7b17ca5efea68de733d38db', 1587463376, 'succeeded', '2020-04-21 06:02:56'),
	(29, 5, 1, 3704.49, 600.00, 'test', 'redd', 'ffff', 'fff', '6898955', 'Nouveau Brunswick ', 'frrfgff', '293893', 'cskdkkff', 36, '4cdda760b7b17ca5efea68de733d38db', 1587463376, 'succeeded', '2020-04-21 06:02:56'),
	(30, 4, 2, 3704.49, 1047.22, 'test', 'redd', 'ffff', 'fff', '6898955', 'Nouveau Brunswick ', 'frrfgff', '293893', 'cskdkkff', 36, '4cdda760b7b17ca5efea68de733d38db', 1587463376, 'succeeded', '2020-04-21 06:02:56'),
	(31, 5, 1, 551.00, 600.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 35, 'be8805bd0616a2c807f3fad92e7a11ee', 1587463403, 'succeeded', '2020-04-21 06:03:23'),
	(32, 6, 1, 1144.00, 644.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '8efa310ee8961b433b9f3baa2af1cdb5', 1587464273, 'succeeded', '2020-04-21 06:17:53'),
	(33, 5, 1, 1144.00, 600.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '8efa310ee8961b433b9f3baa2af1cdb5', 1587464273, 'succeeded', '2020-04-21 06:17:53'),
	(34, 5, 1, 4903.00, 600.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '9a63ddab3c36ef13e7f6ab32c36ecbe9', 1587464419, 'succeeded', '2020-04-21 06:20:19'),
	(35, 4, 7, 4903.00, 3665.27, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, '9a63ddab3c36ef13e7f6ab32c36ecbe9', 1587464419, 'succeeded', '2020-04-21 06:20:19'),
	(36, 5, 1, 689.00, 600.00, 'Laurence', 'Ilana', '4627 avenue coolbrook', '', '699115044', 'Québec', 'Montréal', 'H3X2K7', 'canada', 32, '91f05619d942baef39efc0d31155f9ff', 1587474621, 'succeeded', '2020-04-21 09:10:21'),
	(37, 5, 1, 689.00, 600.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, 'e2948486617203a27d944c88791ead64', 1588081219, 'succeeded', '2020-04-28 09:40:19'),
	(38, 4, 1, 602.00, 523.61, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 26, 'ea00b36d28867c91b3837b4969a5f41d', 1588081484, 'succeeded', '2020-04-28 09:44:44'),
	(39, 5, 1, 689.85, 600.00, 'anand', 'rastogi', 'Unnamed Road, Block D, New Ashok Nagar, New Delhi, Uttar Pradesh 110096, India', '', '+1917879357664', 'Québec', 'New Delhi', '110096', 'India', 24, 'dddd63765056689469443610231848e0', 1588082051, 'succeeded', '2020-04-28 09:54:11'),
	(40, 4, 1, 602.15, 523.61, 'Priyansh', 'bisht', 'Janak puri', '', '9911769966', 'Nouvelle-Écosse', 'shj', 'zusus', '11000', 16, '85c5f3688f31866ef29295fe549141e4', 1588095404, 'succeeded', '2020-04-28 13:36:44'),
	(41, 5, 1, 689.85, 600.00, 'Anand', 'Rastogi', 'Unnamed Road, Block D, New Ashok Nagar, New Delhi, Uttar Pradesh 110096, India', '', '+1917879357664', 'Québec', 'New Delhi', '110096', 'India', 24, '6b9a022a12bf5ea9d4724f0adaf49083', 1588111581, 'succeeded', '2020-04-28 18:06:21'),
	(42, 6, 1, 1335.56, 644.00, 'vinisha', 'rao', 'Unnamed Road, Block D, New Ashok Nagar, New Delhi, Uttar Pradesh 110096, India', '', '+1917879357664', 'Québec', 'New Delhi', '110096', 'India', 24, '4c5fec070eaafd4eb8deea8b259123c0', 1588111892, 'succeeded', '2020-04-28 18:11:32'),
	(43, 4, 1, 1335.56, 523.61, 'vinisha', 'rao', 'Unnamed Road, Block D, New Ashok Nagar, New Delhi, Uttar Pradesh 110096, India', '', '+1917879357664', 'Québec', 'New Delhi', '110096', 'India', 24, '4c5fec070eaafd4eb8deea8b259123c0', 1588111892, 'succeeded', '2020-04-28 18:11:32'),
	(44, 5, 1, 676.42, 600.00, 'vinisha', 'rao', 'Unnamed Road, Block D, New Ashok Nagar, New Delhi, Uttar Pradesh 110096, India', '', '+1917879357664', 'Québec', 'New Delhi', '110096', 'India', 24, '3ffb5ad033e39a3d104030e71f56405d', 1588153635, 'succeeded', '2020-04-29 05:47:15'),
	(45, 6, 1, 1855.99, 644.00, 'test', 'test', 'testv', 'tedrf', '69332154', 'Nunavut', 'trohgg', '177', 'canada', 36, 'a55144cb248a66d460236d4ee366d324', 1588155537, 'Pending', '2020-04-29 06:18:57'),
	(46, 5, 1, 1855.99, 600.00, 'test', 'test', 'testv', 'tedrf', '69332154', 'Nunavut', 'trohgg', '177', 'canada', 36, 'a55144cb248a66d460236d4ee366d324', 1588155537, 'Pending', '2020-04-29 06:18:57'),
	(47, 4, 1, 1855.99, 523.61, 'test', 'test', 'testv', 'tedrf', '69332154', 'Nunavut', 'trohgg', '177', 'canada', 36, 'a55144cb248a66d460236d4ee366d324', 1588155537, 'Pending', '2020-04-29 06:18:57'),
	(48, 6, 1, 1855.99, 644.00, 'test', 'test', 'testv', 'tedrf', '69332154', 'Nunavut', 'trohgg', '177', 'canada', 36, 'bb3f28303f172b5d6bc3b7eaca14b9e9', 1588155539, 'succeeded', '2020-04-29 06:18:59'),
	(49, 5, 1, 1855.99, 600.00, 'test', 'test', 'testv', 'tedrf', '69332154', 'Nunavut', 'trohgg', '177', 'canada', 36, 'bb3f28303f172b5d6bc3b7eaca14b9e9', 1588155539, 'succeeded', '2020-04-29 06:18:59'),
	(50, 4, 1, 1855.99, 523.61, 'test', 'test', 'testv', 'tedrf', '69332154', 'Nunavut', 'trohgg', '177', 'canada', 36, 'bb3f28303f172b5d6bc3b7eaca14b9e9', 1588155539, 'succeeded', '2020-04-29 06:18:59'),
	(51, 6, 1, 740.00, 644.00, 'Laurence', 'Ilana', '123', '', '699115044', 'Québec', 'Montréal', '12345', 'canada', 34, '82da575ea6b813613b27abde8925cb0b', 1588693407, 'succeeded', '2020-05-05 11:43:27'),
	(52, 6, 1, 2120.00, 644.00, 'Elodie', 'Achard', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 1N2, Canada', '', '5146600670', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 1N2', 'Canada', 49, '03b59658a3755a6bc429dbefa19df964', 1588706870, 'succeeded', '2020-05-05 15:27:50'),
	(53, 5, 2, 2120.00, 1200.00, 'Elodie', 'Achard', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 1N2, Canada', '', '5146600670', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 1N2', 'Canada', 49, '03b59658a3755a6bc429dbefa19df964', 1588706870, 'succeeded', '2020-05-05 15:27:50'),
	(54, 6, 20, 14808.00, 12880.00, 'Gloria ', 'Dooh Collins ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 35, '29436855b7c7325931a2774025883336', 1588755016, 'succeeded', '2020-05-06 04:50:16'),
	(55, 6, 20, 14660.00, 12880.00, 'Gloria ', 'Dooh Collins ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 35, '8010a8f180adf970c2bcfcd08eb21f32', 1588755302, 'succeeded', '2020-05-06 04:55:02'),
	(56, 6, 1, 592.00, 644.00, 'Henri ', 'Jong ', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada', '', '5142290159', 'Québec', 'Saint-Jean-sur-Richelieu', 'J2W 0G6', 'Canada', 35, 'b5eee29c5bc60c1ad36b9b35b9d7fa9b', 1588822851, 'succeeded', '2020-05-06 23:40:51');
/*!40000 ALTER TABLE `checkout_orders` ENABLE KEYS */;

-- Export de la structure de la table plumers. classe
CREATE TABLE IF NOT EXISTS `classe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT '0',
  `cycle` varchar(50) DEFAULT '0',
  `idserie` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.classe : ~4 rows (environ)
/*!40000 ALTER TABLE `classe` DISABLE KEYS */;
INSERT INTO `classe` (`id`, `nom`, `cycle`, `idserie`, `created_at`, `updated_at`) VALUES
	(3, 'Tle', '2', 6, '2020-07-01 15:44:38', '2020-07-01 22:40:17'),
	(4, 'Tle', '2', 8, '2020-07-01 15:45:10', NULL),
	(5, '1ére', '2', 7, '2020-07-01 15:45:35', NULL),
	(6, 'Tle', '2', 7, '2020-07-01 15:46:02', '2020-07-01 22:38:41');
/*!40000 ALTER TABLE `classe` ENABLE KEYS */;

-- Export de la structure de la table plumers. comment
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `council_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `userid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `comments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.comment : ~8 rows (environ)
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` (`id`, `council_id`, `userid`, `comments`, `created_on`) VALUES
	(68, '27', '26', 'merci bien ?????', '2020-04-18 18:24:31'),
	(69, '27', '34', 'very nice', '2020-04-19 10:09:44'),
	(70, '27', '26', 'Good news ????????', '2020-04-20 05:32:59'),
	(71, '29', '35', 'hello', '2020-04-21 19:31:10'),
	(72, '29', '35', 'good', '2020-04-21 19:31:01'),
	(73, '29', '32', 'assez joli. je veux la même chez moi ???', '2020-04-22 00:14:58'),
	(74, '29', '32', 'je ne sais pas si mon like a été pris en compte', '2020-04-22 00:15:38'),
	(75, '28', '32', 'bienvenu au soleil', '2020-04-22 00:16:29');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;

-- Export de la structure de la table plumers. contact
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `sujet` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `message` text CHARACTER SET latin1 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `numero` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.contact : ~0 rows (environ)
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;

-- Export de la structure de la table plumers. content
CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `about_us` longtext CHARACTER SET latin1 NOT NULL,
  `privacy_policy` longtext CHARACTER SET latin1 NOT NULL,
  `terms_and_conditions` longtext CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.content : 1 rows
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` (`id`, `about_us`, `privacy_policy`, `terms_and_conditions`) VALUES
	(1, '<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">Bonjour Cher(e)s Client(e)s,</span></span></span></span></p>\r\n\r\n\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">Tout d’abord, nous tenons à vous remercie d’avoir pris le temps de télécharger notre application mobile </span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">« Conçue spécialement pour vous ! ». </span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:9.0pt"><span style="color:black">La Team PLUMERS !</span></span></strong></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">Qui sommes-nous &amp; quelle est notre engagement vis-à-vis de vous en Quelques Mots : </span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">Originaire de la Rive-Sud de Montréal, plus particulièrement de la ville de St-Jean-Sur-Richelieu, le concept de <strong>PLUMERS</strong> est née d’une interrogation simple.&nbsp; </span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">Comment pouvons-nous faire aujourd’hui, en utilisant les moyens technologiques mise à notre disposition pour faciliter en un seul clic l’accès aux passionné(e)s de Déco &amp; Réno comme vous, à tous les professionnels du milieu de la construction et de la rénovation ainsi qu’aux fabricants de matériaux Canadien &amp; internationaux sur une seule plateforme ?</span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">Il faut d’abord savoir, que tout comme vous, nous sommes d’abord et avant tout, des passionner de nouvelle technologie (T.I), d’architecture, de décoration intérieure, de Home Staging et de toutes les nouvelles tendances en termes de matériaux…</span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">Dans notre processus créatif, nous avons eu la chance de rencontrer des personnes inspirantes avec qui nous entretenons de très bonnes relations professionnelles. Il y a parmi elles, des leaders dans l’industrie de la construction/rénovation en Amérique du nord et à travers le monde, tels que Cosentino, Grohe Canada, Matteo, et Les poignées Rocheleau, pour ne citer que ceux-là.</span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">Nous avons eu la chance de découvrir non seulement leur travail, vivre avec eux leurs passions qui se résume généralement à : « Proposer des produits de qualités supérieur et avant-gardistes pour tous les budgets !». </span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">Fort de cette expérience, et dans ce contexte bien particulier, il est alors devenu évident pour nos partenaires d’affaires et nous même, de nous pencher un peu plus sur le sujet. Le concept d’application mobile <strong>PLUMERS</strong> venais ainsi de voir le jour.</span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">Nous l’avons voulu simple et facile d’utilisation, nous avons voulu que celle-ci puisse vous permettre de mieux organiser votre temps afin que vous puissiez tirer les meilleurs avantages et bénéfices qu’offre notre application mobile <strong>PLUMERS</strong>. </span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">Nous avons voulu que <strong>PLUMERS</strong> soit simple et épuré pour ensuite y ajouter « un petit plus ». </span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">En effet, nous souhaitons permettre à notre nouvelle communauté de « <strong>PLUMERS</strong> » de bénéficier gratuitement de produits déco tendance grâce à nos systèmes de récompense bien mérité : nos fameux <strong>« PLUMERS $».</strong></span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">&nbsp;Aussi, nous avons voulu que certains experts avec qui nous entretenons des rapports privilégiés donnent des conseils pratiques aux utilisateurs de l’application afin de les guider dans l’élaboration de leur projet. Enfin, nous avons négocié des ententes avec différents partenaires commerciaux afin de rendre tout cela possible pour vous et pour l’ensemble de vos familles à travers le Canada. </span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">Lorsque nous pensons à cette application au sein de <strong>La Team PLUMERS</strong>, la phrase qui nous vient à l’esprit c’est :</span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:9.0pt"><span style="color:black">« Vous l’avez imaginé, nous l’avons conçu ! ».</span></span></strong></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt"><span style="color:black">Nous espérons enfin, que vous aurez chez nous des conseils utiles et une expérience d’achat inoubliable, bonne visite.</span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:9.0pt"><span style="color:black">La Team PLUMERS.</span></span></strong></span></span></p>\r\n', '<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:16.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:#333333">1 -</span></span></span> <strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:red">Politique de confidentialité</span></span></span></strong></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Renseignement collecté&nbsp;</span></span></span></strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">: cette Application Mobile collecte et utilise des renseignements sur ses utilisateurs. Ces renseignements sont de diverses catégories. Cette Application Mobile collecte automatiquement certains renseignements sur l\'utilisateur, lesquels sont habituellement consignés par les serveurs Internet, tel que l\'adresse du protocole Internet (IP) par laquelle il a eu accès à l’application mobile, la date et l\'heure où il a accédé à cette Application Mobile et l\'adresse IP duquel l\'utilisateur s\'est directement relié à la présente (« renseignements sur le IP de l\'utilisateur »).</span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Cette Application Mobile peut utiliser des dispositifs de collecte de données qui permet à l\'utilisateur de communiquer plus facilement et d\'interagir avec l’Application Mobile. L’Application Mobile peut collecter des renseignements qui ne permettent pas de vous identifier, comme vos préférences d\'achat, votre âge; ces renseignements sont également connus comme données démographiques ou données de profil (« renseignements anonymes sur l\'utilisateur »). Les renseignements anonymes sur l\'utilisateur sont généralement fournis à <strong>PLUMERS </strong>par les utilisateurs. L’Application Mobile peut collecter des renseignements sur l\'utilisateur susceptible de vous identifier personnellement, tel votre nom, adresse, numéro de téléphone et adresse de courriel (« renseignements personnels »). La collecte de renseignements personnels peut se faire par le biais de divers moyens, telles des soumissions, concours et communications avec l’Application Mobile, commandes que vous avez placées pour des produits ou services disponibles au moyen de cette Application Mobile, et affichages sur babillards ou clavardages en ligne, s\'il y a lieu. Nous pouvons rassembler ou anonymiser les renseignements personnels (en retirant les renseignements susceptibles d\'identifier un utilisateur individuel) dans le but de créer des renseignements anonymes sur l\'utilisateur.</span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Avant de soumettre des informations au Service, veuillez lire attentivement cette Politique de confidentialité. En utilisant le Service ou en y accédant, vous acceptez les pratiques décrites dans cette Politique de confidentialité. Si vous préférez que nous ne recueillions pas ni ne traitions les renseignements vous concernant, veuillez ne pas accéder au Service. Nous ne collectons pas sciemment de Renseignements personnels auprès&nbsp;d’enfants de moins de 13&nbsp;ans. Lorsque ces renseignements sont recueillis par inadvertance, nous les supprimerons dès que possible. Si vous croyez qu’un enfant de moins de 13&nbsp;ans nous a fourni des Renseignements personnels, veuillez nous contacter à&nbsp;</span></span></span><a href="mailto:support@renoplus-soft.com%20."><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif">support@renoplus-soft.com .</span></span></a></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Renseignements fournis par vous-même</span></span></span></strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">&nbsp;Vous nous fournissez des renseignements personnels lorsque vous ouvrez un compte, passez une commande, envoyez des commentaires, participez à un concours, répondez à un questionnaire ou contactez notre Service à la clientèle. Par exemple, vous nous fournissez des renseignements personnel lorsque vous passez une commande; lorsque vous entrez des renseignements dans Votre Compte (il se peut même que vous ayez créé plus d\'un compte, si vous avez utilisé plus d\'une adresse électronique en magasinant sur l’Application Mobile); lorsque vous nous contactez par téléphone, par courriel ou par un autre moyen; lorsque vous remplissez un questionnaire ou un formulaire de participation à un concours; lorsque vous dressez une liste d\'envies cadeaux ou autre liste cadeaux; lorsque vous nous transmettez des évaluations ou les évaluez. Ce faisant, vous pouvez nous avoir fourni des renseignements comme vos nom, adresse et numéro de téléphone; les renseignements relatifs à votre carte de crédit; les noms, adresse et numéro de téléphone de personnes à qui vos achats ont été expédiés; les noms, adresse et numéro de téléphone des personnes figurant dans vos coordonnées; le contenu des évaluations et des courriels que vous nous avez fait parvenir ainsi que certains renseignements financiers.</span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Renseignements recueillis automatiquement</span></span></span></strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">&nbsp;Parmi les renseignements que nous recueillons et analysons, citons l\'adresse IP utilisée pour connecter votre appareil au réseau Internet, votre nom d\'utilisateur, votre adresse électronique, votre mot de passe, les renseignements relatifs à votre système et à vos connexions, tels que le type et la version de votre navigateur, le réglage de l\'heure en fonction de votre fuseau horaire, les types et versions des logiciels additionnels à votre navigateur, votre système d\'exploitation et la plateforme. Nous analysons également votre historique d\'achats (que nous mettons parfois en corrélation avec l\'historique d\'achats d\'autres consommateurs pour établir nos listes de Meilleures ventes, par exemple), le parcours URL complet vers, via et depuis notre application mobile, y compris la date et l\'heure de connexion, les produits que vous avez consultés ou recherchés, votre numéro de témoin (cookie) ainsi que le numéro de téléphone à partir duquel vous avez appelé notre service à la clientèle. Nous utilisons également des renseignements de navigation comme les cookies, les cookies Flash (également appelés Flash Local Shared Objects) ou d\'autres renseignements du même type sur certaines parties de notre <strong>Application Mobile</strong> <strong>à des fins de prévention de la fraude ou autres</strong>. Durant certaines de vos visite sur notre Application Mobiles, il se peut que nous utilisions des outils logiciels comme JavaScript pour mesurer et recueillir les renseignements liés à votre session, y compris les temps de réponse des pages Mobile, les erreurs de téléchargement, le temps passé à la consultation de certaines pages, les renseignements liés à l\'interaction avec la page (comme le défilement, les clics effectués et l\'effet de survol) ainsi que les méthodes employées pour sortir de la page. Nous pouvons également recueillir des renseignements techniques pour nous aider à <strong>identifier votre appareil à des fins de prévention de la fraude et de diagnostic</strong>. Partage des renseignements personnels <strong>PLUMERS </strong>peut divulguer les renseignements personnels à des partenaires d\'affaires et autres tiers lesquels, nous croyons, pourraient vous faire des offres susceptibles de vous intéresser. L\'utilisation de vos renseignements personnels par de telles entités doit être soumise aux politiques de confidentialité de telles entités. Les renseignements personnels collectés cette Application Mobile appartiennent à <strong>PLUMERS </strong>et peuvent&nbsp;&nbsp; être transférés à un acheteur des actifs ou affaires de <strong>PLUMERS</strong>, en tout ou en partie.</span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Afin de rendre cette Application Mobile plus attrayant pour les visites.</span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">&nbsp;<strong>PLUMERS </strong>vise constamment à apprendre comment les visites et les utilisations, se déroule sur cette Application Mobile. &nbsp;Par Conséquemment, les renseignements personnels peuvent être transférés à un tiers ou plus, tels un préposé au traitement de données, une agence de couponnage, ou une agence de publicité, pour traitement relié à ces fins.</span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Nous maintenons une ou plusieurs bases de données pour stocker vos Renseignements personnels et pouvons la/les conserver aussi longtemps que raisonnablement nécessaire pour vous servir et exploiter le Service. Les Renseignements personnels que nous recueillons dépendent de la façon dont vous utilisez le Service, y compris créer un compte en ligne avec nous, faire un achat ou une réclamation, nous contacter via toute méthode de service à la clientèle, vous inscrire à un programme de fidélisation, vous inscrire pour recevoir des courriels promotionnels ou autres communications, participer à des études client, des sondages, des concours ou des promotions, ou autrement nous communiquer des renseignements. <strong>La décision de nous fournir des Renseignements personnels vous revient</strong>. Si vous choisissez de ne pas nous fournir certains Renseignements personnels, il est possible que vous ne soyez pas en mesure de tirer parti de certaines fonctionnalités du Service;</span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Le téléphone cellulaire et la tablette numérique géolocalise la plupart des appareils. Les cellulaires et tablette numérique offrent à leurs utilisateurs la possibilité de désactiver les services de géolocalisation. Ces contrôles se trouvent fort probablement dans le menu des réglages de l\'appareil. Pour plus de renseignements concernant des appareils spécifiques. Si vous avez des questions sur la façon de désactiver les services de localisation de votre appareil, nous vous recommandons de communiquer avec votre fournisseur de service de téléphonie cellulaire ou avec le fabricant de votre appareil.</span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Autorisation et accès</span></span></span></strong></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Sous réserve que vous vous conformiez à ces Conditions d\'utilisation et payez tous les frais applicables, <strong>PLUMERS </strong>ou ses fournisseurs de contenu vous accordent une autorisation limitée, non exclusive, non transférable, et sans droit d\'accorder de sous-licence, d\'accéder aux Services de <strong>« PLUMERS »</strong> et d\'en faire une utilisation personnelle et non commerciale. Cette autorisation exclut : la revente ou l\'utilisation commerciale de tout Service <strong>« PLUMERS »</strong> ou de son contenu; l\'utilisation de toute liste de produits, de descriptions ou de prix; toute utilisation dérivée de tout Service <strong>« PLUMERS »</strong> ou de son contenu; tout téléchargement ou copie d\'information concernant les comptes au bénéfice d\'un autre commerçant; toute utilisation d\'outils d\'exploration, de collecte et d\'extraction de données. <strong>« PLUMERS »</strong> et ses concédants de licence, fournisseurs, éditeurs, titulaires de droits ou autres fournisseurs de contenu conservent et se réservent tous les droits qui ne vous sont pas expressément accordés par les présentes Conditions d\'utilisation ou les Conditions de Service. Aucun Service <strong>« PLUMERS »</strong> ou portion de celui-ci ne peut être reproduit, en totalité ou en partie, copié, vendu, revendu, visité, ou exploité à toute fin commerciale sans la permission écrite expresse <strong>PLUMERS</strong>. Vous n\'êtes pas autorisé à encadrer toute marque de commerce, logo ou autre information exclusive (y compris les éléments graphiques et textuels, la mise en page et les formulaires) <strong>PLUMERS </strong>sans une permission écrite expresse. Vous n\'êtes pas autorisé à utiliser les métabalises (meta tags) ou tout autre « texte caché » utilisant le nom ou les marques de commerce <strong>PLUMERS </strong>sans la permission écrite expresse <strong>PLUMERS</strong>. Vous ne devez pas faire d\'utilisation inappropriée des Services <strong>PLUMERS </strong>Vous ne pouvez utiliser les Services&nbsp;&nbsp;&nbsp; <strong>PLUMERS </strong>que conformément à la loi. Les licences accordées par <strong>PLUMERS </strong>seront résiliées si vous ne vous conformez pas aux présentes Conditions d\'utilisation ou à toute Condition de Service. </span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Votre compte « PLUMERS » </span></span></span></strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Afin d’accéder à certaines fonctionnalités du Service, vous devrez créer un compte. Vous ne pouvez jamais utiliser le compte d’un autre sans autorisation. Lors de la création du votre compte, vous devez fournir des informations exactes et complètes.<strong> </strong>Si vous utilisez tout Service <strong>« PLUMERS », </strong>vous êtes responsable d\'assurer la confidentialité de votre compte et de votre mot de passe, et de limiter l\'accès à votre tablette numérique ou téléphone intelligent, et vous vous engagez à assumer la responsabilité de toutes les transactions effectuées dans votre compte à l\'aide de votre mot de passe. </span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">« PLUMERS »</span></span></span></strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333"> propose des produits qui s\'adressent aux enfants, mais ces produits sont offerts en vente aux adultes qui peuvent utiliser une carte de crédit ou autre méthode de paiement permise. Si vous n\'avez pas atteint l\'âge de la majorité dans votre province de résidence, vous ne pouvez utiliser les Services <strong>« PLUMERS »</strong> qu\'avec la participation d\'un parent ou d\'un tuteur. </span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">« PLUMERS »</span></span></span></strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333"> se réserve le droit de refuser de servir un client, de fermer un compte, de supprimer ou de modifier le contenu du Site et ou cette Application Mobile, ou d\'annuler une commande, à son entière discrétion. </span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Refus </span></span></span></strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Vous avez toujours la possibilité de refuser de consentir à la collecte, l\'utilisation ou la divulgation de vos renseignements personnels. Pour ce faire, vous devez communiquer avec <strong>PLUMERS </strong>par l\'un des moyens mis à votre disposition et indiqués ci-dessous. Dans certaines circonstances (tels des concours, promotions ou achats de produits ou services), le fait de vous inscrire sur une liste d\'exclusion pourrait nous empêcher de transiger avec vous. </span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Accès aux renseignements personnels</span></span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Sur demande, <strong>PLUMERS </strong>fournira à un individu les détails de tout renseignement personnel le concernant et qui sont en possession <strong>PLUMERS </strong>ou sous son contrôle.</span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Pour sécuriser vos renseignements personnels</span></span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333"><strong>PLUMERS </strong>prend des mesures commerciales raisonnables dans le cadre de ses procédures et de sa technologie internes afin de préserver la sécurité de vos renseignements personnels et prévenir leur accès non autorisé, leur suppression ou leur altération; cependant, comme dans toute communication de renseignements personnels, il y a toujours un risque que des tiers puissent intercepter illégalement ou accéder à des transmissions ou à des communications privées<strong> PLUMERS </strong>n\'aura aucune&nbsp; responsabilité à votre endroit si vos renseignements personnels sont interceptés ou autrement pénétrés par des tiers. Vous devez prendre des précautions pour veiller à ce que personne d\'autre n\'ait accès à vos renseignements personnels; de telles précautions incluent l\'utilisation des mots de passe et le cryptage et la fermeture de votre appareil mobile lorsque vous avez terminé de l\'utiliser.</span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Pourquoi et comment l\'application mobile collecte et utilise les renseignements</span></span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">La raison qui justifie la collecte de renseignements sur cette Application Mobile et l\'utilisation de ces renseignements collectés dépend de la nature des renseignements.<br>\r\n• Les renseignements sur le IP de l\'utilisateur sont utilisés afin de mesurer le nombre de visite et des différentes sections de cette Application Mobile, et de nous aider à rendre cette Application Mobile plus utile aux utilisateurs. Par exemple, nous collectons votre adresse IP afin de faciliter le diagnostic des problèmes avec notre serveur, et pour administrer notre Application Mobile. Une adresse IP est un numéro qui est assigné à votre ordinateur lorsque vous utilisez l\'Internet par exemple. Votre adresse IP ne contient pas de renseignements personnels sur vous. Votre adresse IP est aussi utilisée pour vous identifier durant une session particulière et pour rassembler des données démographiques générales.<br>\r\n• Cette Application Mobile utilise les mouchards pour personnaliser votre expérience sur l’Application Mobile. Nous utilisons les mouchards également pour consigner le nombre de fois qu\'un utilisateur visite cette Application Mobile et quelles sont les pages auxquelles l\'utilisateur a accédé. Vous pouvez, cependant, refuser de recevoir des mouchards à n\'importe quel moment, par le biais de votre navigateur Web. Nous n\'avons pas l\'intention d\'utiliser les mouchards pour récupérer des renseignements qui sont sans rapport avec notre Application Mobile ou votre interaction avec notre Application Mobile. </span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">• Nous pouvons utiliser les renseignements sur le IP de l\'utilisateur, les renseignements fournis par les mouchards ou les renseignements anonymes de l\'utilisateur qui sont collectés par le biais de ce cette Application Mobile afin d\'améliorer notre Application Mobile, de personnaliser votre expérience sur cette Application Mobile et de vous faire parvenir des renseignements susceptibles de vous intéresser. Nous pouvons partager ces renseignements avec d\'autres, tels des annonceurs désireux de placer des annonces sur le Site et ou cette Application Mobile. Ces renseignements peuvent également être utilisés à des fins statistiques ou pour évaluer quelles sont les sections de cette Application Mobile les plus populaires, déterminé d\'où viennent les visites sur cette Application Mobiles et où ils vont, et combien de temps les visiteurs passent sur cette Application Mobile demeurent sur une page particulière. </span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">• <strong>PLUMERS </strong>et ses affiliés utiliseront les renseignements personnels collectés sur et par le biais de cette Application Mobile uniquement aux fins décrites dans cette politique de confidentialité ou à des fins additionnelles lesquelles sont divulguées au moment où les renseignements personnels sont collectés. Par exemple, les renseignements personnels collectés sur et par le biais de cette Application Mobile peuvent être utilisés pour vous faire parvenir de l\'information à propos des mises à jour sur notre Application Mobile, ou à propos des produits et services offerts de temps à autre par <strong>PLUMERS </strong>et ses affiliés. </span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Dans certaines circonstances limitées, nous pouvons être requis ou permis par la loi de divulguer vos renseignements personnels, par exemple à la police, au cours d\'une enquête criminelle.</span></span></span></strong></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Critiques, commentaires, communications et autres contenus</span></span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Vous pouvez publier des critiques, des commentaires, des photos et d\'autre contenu; envoyer des cartes électroniques et d\'autres communications; et soumettre des suggestions, des idées, des commentaires, des questions et d\'autres informations, pourvu que leur teneur ne soit pas illégale, obscène, menaçante, diffamatoire, ne porte pas atteinte à la vie privée, n\'enfreigne pas les droits de propriété intellectuelle et ne porte pas préjudice à des tiers ou ne soit répréhensible, et ne consiste pas à introduire de virus informatique, ni ne contienne de discours politique, de sollicitation commerciale, de chaîne de lettres, de publipostage ou toute forme de pourriels ou messages électroniques commerciaux non sollicités. Vous ne pouvez utiliser de fausse adresse électronique, usurper l\'identité d\'un individu ou d\'une entité, ou encore induire en erreur quant à l\'origine d\'une carte ou d\'autre contenu. <strong>« PLUMERS »</strong> se réserve le droit (mais non l\'obligation) de supprimer ou de modifier un tel contenu, mais ne passe pas régulièrement en revue le contenu affiché.</span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">Votre acceptation de notre politique de confidentialité</span></span></span></strong><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">&nbsp;: </span></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;Arial Narrow&quot;,sans-serif"><span style="color:#333333">.</span></span></span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>&nbsp;</h2>\r\n', '<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:16.0pt"><span style="color:#333333">1 - </span></span><span style="font-size:12.0pt"><span style="color:#333333">Politiques de confidentialité :</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Bienvenue sur « <strong>« PLUMERS »</strong> » l\'application mobile de <strong>PLUMERS </strong>et&nbsp;ou les sociétés de son groupe vous proposent des services&nbsp;: </span></span></span></span></span></p>\r\n\r\n<ul>\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">D’utilisation de service de&nbsp;:</span></span></span></span></span>\r\n\r\n	<ul style="list-style-type:circle">\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">&nbsp;Réalité Augmenté;</span></span></span></span></span></li>\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Visioconférence;</span></span></span></span></span></li>\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Tchat Direct via Sms;</span></span></span></span></span></li>\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Suivi de commande;</span></span></span></span></span></li>\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Partage de fichier entre affilié et client;</span></span></span></span></span></li>\r\n	</ul>\r\n	</li>\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">De recherche de professionnels dans le domaine de&nbsp;:</span></span></span></span></span>\r\n	<ul style="list-style-type:circle">\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">&nbsp;la construction (designer, architecte, contracteur général…)</span></span></span></span></span></li>\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">la rénovation;</span></span></span></span></span></li>\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">&nbsp;la décoration intérieur et extérieur; </span></span></span></span></span></li>\r\n	</ul>\r\n	</li>\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">De conception de plan&nbsp;:</span></span></span></span></span>\r\n	<ul style="list-style-type:circle">\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Plan de Production;</span></span></span></span></span></li>\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Plan 3D;</span></span></span></span></span></li>\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Plan en Réalité Virtuelle;</span></span></span></span></span></li>\r\n	</ul>\r\n	</li>\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">D’achats de produits de&nbsp;: </span></span></span></span></span>\r\n	<ul style="list-style-type:circle">\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Construction;</span></span></span></span></span></li>\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Mobilier intérieur/ extérieur;</span></span></span></span></span></li>\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Décoration intérieur/ extérieur; </span></span></span></span></span></li>\r\n		<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Rénovation;</span></span></span></span></span></li>\r\n	</ul>\r\n	</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">De conseils gratuits….</span></span></span></span></span></li>\r\n</ul>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Ce document établit les conditions d\'utilisation et la politique de confidentialité du site et ou de &nbsp;l\'application mobile <strong>« PLUMERS »</strong>», lequel inclut, sans limitation, l’Application Mobile et ou le Site internet au&nbsp;</span></span><a href="http://www.renoplus-soft.com/" target="_blank"><span style="font-size:12.0pt"><span style="color:#0186ba">www.renoplus-soft.com</span></span></a><span style="font-size:12.0pt"><span style="color:#333333">&nbsp;, </span></span><a href="http://www.renoplus-soft.ca"><span style="font-size:12.0pt">www.renoplus-soft.ca</span></a><span style="font-size:12.0pt"><span style="color:#333333">, </span></span><a href="http://www.monprojetvr.com"><span style="font-size:12.0pt">www.monprojetvr.com</span></a><span style="font-size:12.0pt"><span style="color:#333333">&nbsp; et ou </span></span><a href="http://www.monprojetvr.ca"><span style="font-size:12.0pt">www.monprojetvr.ca</span></a><span style="font-size:12.0pt"><span style="color:#333333"> , la page introductive, et toutes les autres pages sous le nom de domaine de premier niveau, et tout contenu s\'y trouvant (l\'«application mobile ») conformément aux conditions stipulées par <strong>PLUMERS </strong>(<strong>« PLUMERS »</strong>). En explorant et en utilisant cette application, vous acceptez d\'être lié par les conditions d\'utilisation et la politique de confidentialité ci-après nommées (les « Conditions d\'utilisation »). </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">PLUMERS </span></span></strong><span style="font-size:12.0pt"><span style="color:#333333">se réserve le droit, à sa seule discrétion, de changer, modifier, ajouter ou supprimer, des parties de ces Conditions en tout temps, et il est de votre responsabilité de revoir les Conditions à chaque fois que vous accédez à l’application <strong>« PLUMERS »</strong>.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">L\'utilisation continue des services offerts par <strong>« PLUMERS »</strong> postérieure à l\'affichage de telles modifications aux Conditions vaudra acceptation des conditions. Veuillez quitter immédiatement l’application «<strong> PLUMERS »</strong> si vous n\'acceptez pas les Conditions, ou si vous vous trouvez dans une juridiction qui interdit l\'utilisation. Rien dans les présentes Conditions d’utilisation ne sera considéré comme conférant des droits ou des avantages à des tiers. </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Ces conditions d’utilisation s’appliquent à toutes les utilisatrices et tous les utilisateurs du service, y compris aux utilisateurs qui contribuent également au contenu du service. Le terme « contenu » comprend le texte, les logiciels, les scripts, les graphiques, les photos, les sons, la musique, les vidéos, les combinaisons audiovisuelles, les fonctions interactives et d’autres documents que vous pouvez consulter, accéder ou contribuer au Service. Le Service comprend tous les aspects &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;de <strong>« PLUMERS », </strong>y compris, mais sans s’y limiter, tous les produits, logiciels et services offerts sur l’Application Mobile de <strong>« PLUMERS »</strong>, tels que les pages <strong>« PLUMERS », </strong>l’application mobile <strong>« PLUMERS », </strong>et d’autres applications. </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Utilisation du matériel de l\'application mobile: Vous pouvez imprimer ou faire imprimer par un tiers tout matériel téléchargeable contenu sur cette application mobile sous réserve des trois conditions suivantes : (i) vous le faites à des fins personnelles et non commerciales; (ii) aucun avis de droit d\'auteur ou d\'autre propriété n\'est retiré du matériel; et (iii) le matériel n\'est modifié d\'aucune manière.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Conditions d\'utilisation d\'Apple ou de Google</span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="color:#333333">Si vous avez téléchargé l\'Application <strong>« PLUMERS » </strong>à partir de l\'Apple App Store, le présent Accord incorpore les conditions d\'utilisation d\'Apple, Inc., y compris le Contrat de licence utilisateur final relatif à l\'application sous licence qui s\'y trouve (disponible à l\'adresse&nbsp;</span></span><a href="http://www.apple.com/legal/internet-services/itunes/ca/terms.html" target="_blank"><span style="font-size:12.0pt"><span style="color:#0186ba">http://www.apple.com/legal/internet-services/itunes/ca/terms.html</span></span></a><span style="font-size:12.0pt"><span style="color:#333333">). </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Si vous avez téléchargé l\'Application <strong>« PLUMERS »</strong> à partir de Google Play Store, le présent Accord incorpore les conditions d\'utilisation de Google Play (disponibles à l\'adresse&nbsp;</span></span><a href="https://play.google.com/about/play-terms.html" target="_blank"><span style="font-size:12.0pt"><span style="color:#0186ba">https://play.google.com/about/play-terms.html</span></span></a><span style="font-size:12.0pt"><span style="color:#333333">). </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">En cas de différend entre les modalités des conditions d\'utilisation d\'Apple, Inc. ou de Google Play et les modalités du présent Accord, le présent Accord prévaudra.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Droits d\'auteur, marques de commerce et autres droits de propriété</span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="color:#333333">Le contenu de cette application, incluant mais ne s\'y limitant pas les marques de commerce, concepts, logos, textes, images, est la propriété de <strong>PLUMERS </strong>à moins que spécifié autrement. Le contenu de l\'application est protégé en vertu des lois du Canada et de d\'autres pays à travers le monde ainsi que par les traités internationaux. Aucun avis de droit d\'auteur ou d\'autre propriété ne peut être retiré du Matériel exclusif à <strong>PLUMERS </strong>Toute utilisation, y compris la reproduction, la modification, la distribution, la transmission, l\'affichage ou l\'exécution du contenu de cette application mobile ou son utilisation à des fins publiques ou commerciales sans le consentement écrit, préalable et express de <strong>PLUMERS </strong>est strictement interdite.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Liens vers d\'autres Site et ou cette Application Mobiles</span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="color:#333333">Cette application mobile contient des liens vers des Sites, du contenu et ou cette Application Mobiles Web de tiers. Ces liens sont offerts uniquement dans le but de faciliter votre consultation. <strong>PLUMERS </strong>et ses affiliés n\'endossent pas le contenu de tels Site et ou d’autres Application Mobiles de tiers, ne passent pas en revue le matériel lié à de tels types de tiers et ne sont pas responsables de leur contenu. L\'accès et la visualisation de tels Site et ou d’autres Application Mobiles de tiers est à vos propres risques. </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Des parties autres que <strong>« PLUMERS »</strong> peuvent exploiter des boutiques, fournir des services ou proposer des gammes de produits par le biais des Services <strong>« PLUMERS ».</strong> </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">En outre, nous offrons des liens vers les Site et ou d’autres Application Mobiles de sociétés liées et de certaines autres entreprises. Nous ne sommes aucunement responsables d\'examiner, d\'évaluer ou de garantir les offres de vente faites par ces entreprises ou individus, pas plus que le contenu de leurs Site et ou de leurs Application Mobiles Web.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">&nbsp;<strong>« PLUMERS »</strong> n\'engage aucune responsabilité pour les actes, produits et contenus de ces parties ou de tout autre tiers. Nous vous conseillons de lire attentivement leurs déclarations de confidentialité et autres conditions d\'utilisation.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Généralités</span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="color:#333333"><strong>PLUMERS </strong>ne fait aucune affirmation quant aux propos du contenu de son Application Mobile ou de son téléchargement à l\'extérieur du Canada. Lorsque vous accédez à ce Site Internet et ou cette Application Mobile depuis un emplacement de l\'extérieur du Canada, vous convenez de le faire à vos propres risques et d\'être responsable de l\'observation des lois du pays ou du territoire où vous vous trouvez. </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Les références à tout produit ou service particulier ne signifient pas que <strong>PLUMERS </strong>et ses affiliés ont l\'intention de rendre de tels produits ou services disponibles dans tous les pays. Advenant que toute disposition des Conditions soit jugée invalide par tout tribunal compétent, les autres dispositions demeurent pleinement en vigueur sans être invalidées de quelque manière que ce soit. La renonciation à quelque disposition que ce soit des présentes Conditions ne constitue pas une renonciation continue à cette disposition ou à quelque autre disposition des Conditions.&nbsp;</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">« PLUMERS », SES SOCIÉTÉS AFFILIÉES ET SES AGENTS N\'ACCEPTENT AUCUNE RESPONSABILITÉ POUR LES CONSÉQUENCES POUVANT DÉCOULER DIRECTEMENT OU INDIRECTEMENT D\'UNE ACTION OU INACTION DE VOTRE PART FONDÉE SUR LES INFORMATIONS SE TROUVANT DANS RENOPLUS+ TECH CANADA INC.</span></span></strong></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Stipulation d\'exonération de garanties</span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="color:#333333">LORSQUE VOUS UTILISEZ LE SERVICE <strong>« PLUMERS »,</strong> VOUS CONVENEZ DE LE FAIRE À VOS PROPRES RISQUES. LE SERVICE <strong>« PLUMERS »</strong> ET SON CONTENU SONT FOURNIS \'\'TEL QUEL\'\' ET SANS GARANTIE D\'AUCUNE SORTE, QU\'ELLE SOIT EXPRESSE OU IMPLICITE, INCLUANT MAIS NE S\'Y LIMINANT PAS TOUTES GARANTIES DE QUALITÉ MARCHANDE, LA NON CONTREFAÇON DES DROITS D\'UN TIERS, L\'ADAPTATION À UN USAGE PARTICULIER, OU TOUTES GARANTIES À L\'EFFET QUE L\'ACCÈS AU PRÉSENT SITE ET OU CETTE APPLICATION MOBILE SERA ININTERROMPU OU SANS ERREURS, QUE CE SERVICE SERA SÉCURISÉ OU LIBRE DE VIRUS OU AUTRE MATÉRIEL DOMMAGEABLE, OU QUE LES RENSEIGNEMENTS TROUVÉS SUR CE SITE ET OU CETTE APPLICATION MOBILE SERONT COMPLETS ET EXACTS OU OPPORTUNS.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">PLUMERS </span></span></strong><span style="font-size:12.0pt"><span style="color:#333333">SE RÉSERVE LE DROIT DE RESTREINDRE OU DE METTRE FIN À VOTRE ACCÈS À CE SERVICE OU À TOUTE OPTION OU PARTIE DE CETTE APPLICATION MOBILE EN TOUT TEMPS, AVEC OU SANS AVIS PRÉALABLE.<strong> &nbsp;« PLUMERS »</strong>, N’APPUIE, NE GARANTIT PAS ET N’ASSUME AUCUNE RESPONSABILITÉ POUR TOUT &nbsp;PRODUIT OU SERVICE PUBLIÉ OU OFFERT PAR UN TIERS PAR L’INTERMÉDIAIRE DES SERVICES OU DE TOUT SERVICE HYPERLIÉ OU PRÉSENTÉ DANS TOUTE BANNIÈRE OU AUTRE PUBLICITÉ, ET NE SERA PAS UNE PARTIE OU À DE QUELQUE FAÇON QUE CE SOIT, IL SERA RESPONSABLE DE SURVEILLER TOUTE TRANSACTION ENTRE VOUS ET LES FOURNISSEURS TIERS DE PRODUITS OU DE SERVICES, COMME AVEC L’ACHAT D’UN PRODUIT OU D’UN SERVICE PAR L’INTERMÉDIAIRE DE TOUT SUPPORT OU DANS TOUT ENVIRONNMENT. </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Limitation de responsabilité</span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="color:#333333">DANS LA PLEINE MESURE PERMISE PAR LA LÉGISLATION APPLICABLE, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>PLUMERS </strong>OU SES AFFILIÉS, INCLUANT SANS S\'Y LIMITER TOUS LES DIRIGEANTS, ADMINISTRATEURS, DIRECTEURS, EMPLOYÉS, ET AGENTS, NE PEUT EN AUCUN CAS ÊTRE TENU RESPONSABLE DE QUELQUE DOMMAGE, TORT OU PRÉJUDICE QUE CE SOIT (INCLUANT SANS LIMITATION LES DOMMAGES DIRECTS, INDIRECTS, CONSÉCUTIFS, SPÉCIAUX, CORRÉLATIFS ET PUNITIFS, PERTES DE PROFIT, ET DOMMAGES RÉSULTANT DE PERTES DE DONNÉES OU INTERRUPTION D\'AFFAIRES) DÉCOULANT DE OU AYANT TRAIT À L\'UTILISATION OU À L\'INCAPACITÉ D\'UTILISER CE SERVICE ET SON CONTENU, FONDÉ OU NON SUR UNE GARANTIE, UN CONTRAT, UN DÉLIT OU TOUTE AUTRE THÉORIE LÉGALE, PEU IMPORTE SI &nbsp;<strong>PLUMERS </strong>OU TOUT AUTRE DE SES AFFILIÉS AURAIT FAIT PREUVE OU NON DE NÉGLIGENCE OU AURAIT OU NON ÉTÉ AVISÉ DE LA POSSIBILITÉ DE TELS DOMMAGES.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">VOUS RECONNAISSEZ SPÉCIFIQUEMENT QUE <strong>« PLUMERS »</strong> NE SERA PAS RESPONSABLE DU CONTENU OU DE LA CONDUITE DIFFAMATOIRE, OFFENSIVE OU ILLÉGALE DE TOUT TIERS ET QUE LE RISQUE DE PRÉJUDICE OU DE DOMMAGE DÉCOULANT DE CE QUI PRÉCÈDE RESTE ENTIÈREMENT AVEC VOUS. </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Indemnisation</span></span></strong><span style="font-size:12.0pt"><span style="color:#333333">&nbsp;Vous convenez de tenir <strong>PLUMERS </strong>et ses dirigeants, administrateurs, directeurs, employés, agents et affiliés indemnes et à couvert et de prendre fait &nbsp;et cause pour eux quant à toute réclamation ou demande faite par un tiers, quant à tous les frais, responsabilités associées ou coûts ou dépenses de quelque nature que ce soit (y compris notamment mais ne s\'y limitant pas les honoraires juridiques raisonnables), découlant ou ayant trait à votre visite sur cette Application Mobile ou à l\'utilisation de la présente application mobile, du contenu que vous transmettez au présent à cette Application Mobile ou de la violation par vous de l\'une des présentes Conditions.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">2 - </span></span><strong><span style="font-size:12.0pt"><span style="color:red">ACHATS ET LIVRAISON</span></span></strong></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Modalités de paiement</span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="color:#333333">Nous acceptons les cartes de crédit, MasterCard, Visa émises par des banques canadiennes ainsi que les paiements fait avec vos Crédits «&nbsp;<strong>PLUMER$&nbsp;»</strong> de <strong>« PLUMERS »</strong> </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">(certaines conditions s\'appliquent voir section Politique des Crédits <strong>PLUMER$).</strong> </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">En effectuant votre achat, vous; </span></span></span></span></span></p>\r\n\r\n<ol>\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">acceptez les termes et conditions et ceux-ci ont préséance sur tous autres termes et conditions; </span></span></span></span></span></li>\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">acceptez que les produits se trouvant sur la/les facture(s) sont bien les produits désirés;</span></span></span></span></span></li>\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">affirmez que toutes informations de facturation fournie doivent être véridiques et exactes.</span></span></span></span></span></li>\r\n</ol>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Fournir des renseignements faux ou inexacts constitue une violation du présent Accord et peut entraîner l\'annulation d\'une commande. <strong>« PLUMERS »</strong> se réserve le droit de limiter la quantité d\'articles achetés par personne, par foyer ou par commande, pour toute raison. Ces restrictions peuvent s\'appliquer aux commandes effectuées par le même compte, à l\'aide de la même carte de crédit ou utilisant la même adresse de facturation ou de livraison. Nous aviserons le client si une telle limite est appliquée. <strong>« PLUMERS »</strong> se réserve également le droit, à sa seule discrétion, d\'interdire la vente à des marchands ou revendeurs. Aux fins de cet Accord, la revente est définie comme l\'achat ou l\'intention d\'acheter des produits sur la plateforme de <strong>« PLUMERS »</strong> dans le but de pratiquer la vente commerciale de ces mêmes produits auprès d\'une tierce partie. Vos informations de paiement sont transmises via «&nbsp;<strong>Stripe</strong>&nbsp;» pour autorisation. Les normes PCI seront respectées. Lors de votre achat sur l’Application Mobile <strong>« PLUMERS »</strong> le paiement complet de votre achat est prélevé sur votre carte de crédit, et ce, au moment où vous passez votre commande. Les taxes fédérales et provinciales sont calculées selon le taux en vigueur au moment de l\'achat. <strong>Tous les montants sont en dollars Canadiens</strong>. La propriété de tous les biens vendus est retenue par <strong>« PLUMERS » </strong>jusqu\'à réception du paiement intégral. Aucune marchandise ne sera expédiée avant la réception du paiement complet.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Sécurité des transactions</span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="color:#333333"><strong>« PLUMERS »</strong> utilise le service de paiement «&nbsp;<strong>Stripe</strong>&nbsp;» Lors de votre achat via <strong>« PLUMERS »,</strong> la page de paiement est immédiatement envoyée au service de vérification de </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">«&nbsp;<strong>Stripe »,</strong> de sorte que <strong>« PLUMERS »</strong> ne détiendra aucune de vos informations bancaires. </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Tous les renseignements sont traités par un système de cryptage sécuritaire. Bien que nous utilisions des moyens conformes aux normes de l\'industrie pour protéger notre Application Mobile et vos renseignements personnels. Nous ne pouvons pas promettre que votre utilisation de notre Application Mobile sera entièrement sécuritaire. Nous vous invitons à faire preuve de prudence et ce en tout temps.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Prix</span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="color:#333333">Les prix cités sur cette Application Mobile sont les prix de vente d\'un produit tel que déterminé par nos fournisseurs et nos fabricants. Nous révisons de façon régulière la liste des prix en le comparant à la liste des prix des articles offerts par d\'autres revendeurs. La plupart des produits sont affichés avec un prix « rayé en noir, prix généralement vendu sur le marché », suivie d\'une valeur, soit le prix vendant « <strong>PLUMERS</strong> ». Quant aux articles vendus par « <strong>PLUMERS</strong> », nous ne pouvons confirmer le prix d\'un article jusqu\'à ce que vous en passiez la commande, en raison des fluctuations imprévisibles du marché, « <strong>PLUMERS</strong> » se réserve le droit de modifier les prix des articles annoncés sur son Application Mobile en tout temps et ce sans préavis. Malgré nos meilleurs efforts, un petit nombre d\'articles pourraient afficher un prix erroné. Si le prix exact de l\'article est plus élevé que le prix affiché, nous pourrons, à notre seule discrétion, vous contacter pour obtenir des instructions avant l\'expédition ou annuler votre commande et vous en aviser. D\'autres commerçants peuvent avoir des pratiques différentes relativement aux articles affichant un prix erroné.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Descriptions des produits</span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="color:#333333">« <strong>PLUMERS</strong> » tente de s\'assurer de la plus grande exactitude possible des informations fournies sur l’Application Mobile. Toutefois, « <strong>PLUMERS</strong> » ne garantit pas que la description des produits ou tout autre contenu de tout Service « <strong>PLUMERS</strong> » sont exacts, complets, fiables, à jour ou exempts d\'erreur. « <strong>PLUMERS</strong> » s\'efforce de s\'assurer que le contenu de son Application Mobile est complet et à jour. Cependant, nous ne garantissons pas qu\'il soit exempt d\'erreurs, d\'inexactitudes ou d\'omissions liés au prix, description du produit ou la disponibilité de celui-ci. En outre, « <strong>PLUMERS</strong> » se réserve le droit de refuser ou d\'annuler les commandes contenant une erreur, inexactitude ou omission, indépendamment du fait que la commande a été soumise et / ou confirmée. Les prix, les quantités et les tons de couleur peuvent changer sans préavis initial. <strong>Remarque:</strong> En raison de la nature faite à la main et sur mesure de la plupart des produits uniques vendus par « <strong>PLUMERS</strong> », il est normal que les dimensions, la couleur et la finition varient d\'un élément à un autre. </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">En outre, les couleurs des produits consultés sur l\'application varient d\'un écran de cellulaire, de tablette et/ou d\'ordinateur à l\'autre en raison de la façon dont les différents moniteurs et de navigateurs Web rende les couleurs. De ce fait, « <strong>PLUMERS</strong> » <strong>SE DÉGAGE DE TOUTE RESPONSABILITÉ QUANT À TOUT DOMMAGE POUVANT ÊTRE CAUSÉ EN RAISON D\'UNE RUPTURE DE STOCK, D\'UN DÉLAIS DE LIVRAISON, DES TEINTES ET COULEURS D\'UN PRODUIT.&nbsp;</strong></span></span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Livraison</span></span></strong><br>\r\n<span style="font-size:12.0pt"><span style="color:#333333">Vos achats vous seront normalement livrés dans un délai de 5 à 10 jour ouvrable, ceci prévaut pour toutes les commandes qui ne font pas partie de commande spécial ou de produit fait sur mesure, à l\'adresse inscrite sur votre fiche descriptive « <strong>PLUMERS</strong> » (au Canada seulement) par le transporteur que vous allez choisir dans la liste qui s’offre à vous. Assurez-vous de nous transmettre une adresse valide et exacte par conséquent des frais de restockage de 30% + les frais de livraison vous seront chargés. Un numéro de référence vous peut vous être transmis sur demande expresse de votre part, afin, de vous permettre de faire le suivi de votre commande à l\'adresse du transporteur que vous allez choisir. Nous nous efforçons de vous faire parvenir vos achats rapidement. Cependant, des raisons imprévisibles, comme la météo, créent parfois des retards d\'expédition. « <strong>PLUMERS</strong> » ne peut garantir les délais de livraison.&nbsp;</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Décharge quant aux garanties et limitation de responsabilité</span></span></strong></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">LES LOIS DE CERTAINES JURIDICTIONS, NOTAMMENT LA LOI SUR LA PROTECTION DU CONSOMMATEUR DU QUÉBEC, NE PERMETTENT PAS L\'EXCLUSION DES GARANTIES OU CONDITIONS IMPLICITES OU L\'EXONÉRATION OU LA LIMITATION DE RESPONSABILITÉ POUR CERTAINS DOMMAGES. SI CES LOIS S\'APPLIQUENT DANS VOTRE CAS, CERTAINES DES EXONÉRATIONS, EXCLUSIONS OU LIMITATIONS ÉNONCÉES CI-DESSOUS, OU L\'ENSEMBLE DE CELLES-CI, PEUVENT NE PAS S\'APPLIQUER À VOUS ET VOUS POURRIEZ DISPOSER DE DROITS ADDITIONNELS. LES SERVICES « <strong>PLUMERS</strong> » ET TOUS LES RENSEIGNEMENTS, LE CONTENU, LES ÉLÉMENTS, LES PRODUITS (INCLUANT LES LOGICIELS) ET LES AUTRES SERVICES QUI Y SONT INCLUS OU QUI VOUS SONT AUTREMENT RENDUS DISPONIBLES PAR LE BIAIS DES SERVICES « <strong>PLUMERS</strong> » SONT FOURNIS PAR « <strong>PLUMERS</strong> » « TELS QUELS » ET « EN FONCTION DES DISPONIBILITÉS », À MOINS D\'UNE INDICATION ÉCRITE SPÉCIFIQUE À L\'EFFET CONTRAIRE. « <strong>PLUMERS</strong> » NE FAIT AUCUNE DÉCLARATION ET NE DONNE AUCUNE GARANTIE QUELLE QU\'ELLE SOIT, EXPLICITE OU IMPLICITE, QUANT AU FONCTIONNEMENT DES SERVICES « <strong>PLUMERS</strong> » OU AUX RENSEIGNEMENTS, AU CONTENU, AUX ÉLÉMENTS, AUX PRODUITS (INCLUANT LES LOGICIELS) OU AUX SERVICES INCLUS DANS LES SERVICES « <strong>PLUMERS</strong> » OU QUI VOUS SONT AUTREMENT RENDUS DISPONIBLES PAR LE BIAIS DE CEUX-CI, À MOINS QUE CELA NE SOIT SPÉCIFIÉ PAR ÉCRIT. VOUS CONVENEZ EXPRESSÉMENT QUE VOTRE UTILISATION DES SERVICES « <strong>PLUMERS</strong> » EST À VOS SEULS RISQUES. DANS LA PLEINE MESURE PERMISE PAR LA LOI APPLICABLE, « <strong>PLUMERS</strong> » EXCLUT TOUTE GARANTIE OU CONDITION, EXPRESSE OU TACITE (NOTAMMENT LES GARANTIES TACITES DE TITRE, QUALITÉ MARCHANDE ET D\'APTITUDE À UN USAGE PARTICULIER). « <strong>PLUMERS</strong> » NE GARANTIT PAS L\'ABSENCE DE VIRUS OU D\'AUTRES COMPOSANTS NOCIFS DANS LES SERVICES « <strong>PLUMERS</strong> », DANS LES RENSEIGNEMENTS, LE CONTENU, LES ÉLÉMENTS, LES PRODUITS (INCLUANT LES LOGICIELS) OU LES AUTRES SERVICES INCLUS DANS LES SERVICES « <strong>PLUMERS</strong> » OU QUI VOUS SONT RENDUS DISPONIBLES PAR LE BIAIS DE CEUX-CI, SUR SES SERVEURS, COMMUNICATIONS ÉLECTRONIQUES OU DANS LES COURRIELS PROVENANT DES SERVICES « <strong>PLUMERS</strong> ». « <strong>PLUMERS</strong> » NE SERA RESPONSABLE D\'AUCUN DOMMAGE PROVENANT DE L\'UTILISATION DES SERVICES « <strong>PLUMERS</strong> » OU DES RENSEIGNEMENTS, DU CONTENU, DES ÉLÉMENTS, DES PRODUITS (INCLUANT LES LOGICIELS) OU DES SERVICES INCLUS DANS TOUT SERVICE <strong>« PLUMERS »</strong> OU QUI VOUS SONT AUTREMENT RENDUS DISPONIBLES PAR LE BIAIS DE TOUT SERVICE <strong>« PLUMERS »,</strong> Y COMPRIS NOTAMMENT TOUT DOMMAGE DIRECT, INDIRECT, ACCESSOIRE OU PUNITIF, À MOINS D\'UNE MENTION ÉCRITE SPÉCIFIQUE À L\'EFFET CONTRAIRE.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">&nbsp;3 - </span></span><strong><span style="font-size:12.0pt"><span style="color:red">POLITIQUE DES CRÉDITS \'\'PLUMER$\'\'&nbsp;:</span></span></strong></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Programme des Crédits de <strong>\'\'PLUMER$\'\'</strong> de « <strong>PLUMERS</strong> » permet à ses clients d\'accumuler des Crédits sous forme de <strong>«&nbsp;PLUMER$&nbsp;»</strong> en achetant les produits offerts sur l\'application « <strong>PLUMERS</strong> ». </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">De ce fait, automatiquement en achetant un produit sur l\'application « <strong>PLUMERS</strong> » vous commencez à accumuler des Crédits <strong>«&nbsp;PLUMER$&nbsp;»</strong>. Chaque montant de Crédit de <strong>«&nbsp;PLUMER$&nbsp;»</strong> de « <strong>PLUMERS</strong> » est variable selon les différents produits offerts et « <strong>PLUMERS</strong> » se réserve le droit de modifier à tout moment et à sa discrétion les Crédits proposé sur chaque produit. Vous obtenez le droit d\'échanger des Crédits <strong>«&nbsp;PLUMER$&nbsp;»</strong> et de les utiliser lors de vos prochains achats. </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Veuillez noter que votre solde de Crédits «&nbsp;PLUMER$&nbsp;» ne peut être échanger contre de l’argent ou un chèque ou tout autres moyens de paiement conventionnel.</span></span></strong> </span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:red">4 - <strong>Risque de perte</strong></span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Le risque de perte et le droit de propriété liés à la marchandise achetée auprès <strong>« PLUMERS»</strong> vous sont transférés au moment où nous remettons la marchandise au transporteur.</span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:red">Retours, remboursements et titre&nbsp;</span></span></strong></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">AUCUN REMBOURSEMENT NE PEUT ÊTRE ÉMIS, un échange à notre seul gré peut être consenti. Certaines conditions et exceptions s\'appliquent. Nous voulons que vous soyez 100% satisfait de votre achat. De ce fait, les produits peuvent être retournés seulement avec le consentement de « <strong>PLUMERS</strong> ». Seuls les items inutilisés, dans leurs états et leurs emballages originaux, peuvent être retournés <strong>dans les 14 jours</strong> de la livraison du produit accompagné de leur preuve d\'achat original. Un frais de restockage de 30% sera automatiquement déduit pour les marchandises standards retournées. Les clients sont responsables à 100% de tous les frais d\'expédition réels (c.-à-d. livraison et retour), indépendamment de ce que le client d\'abord payé ou n\'a pas payer (c.-à-d. <strong>PLUMER$</strong>) d\'avoir l\'item(s) livré(s). Les retours non autorisés ou ceux envoyé port à payer, seront refusés et retournés au client à ses frais. Les frais de restockage sont basés sur le prix d\'origine (non compris les offres de rabais, coupons ou <strong>PLUMER$).</strong> S\'il-vous-plaît nous contacter pour avoir un numéro d\'autorisation retour et les instructions avant de retourner toute marchandise. Tout article retourné sans un numéro de pré-autorisation ne sera pas crédité pour un échange. Indiquez votre numéro d\'autorisation de retour sur le bordereau d\'expédition et inclure votre bordereau d\'expédition avec votre retour. Inscrivez votre numéro d\'autorisation de retour à l\'extérieur de l\'emballage pour être retourné. Il n\'y a pas de retours autorisés sur les items (tel quel) vente finale. </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Les items considéré comme vente finales sont les suivants&nbsp;: </span></span></span></span></span></p>\r\n\r\n<ul style="list-style-type:square">\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Les articles achetés en utilisant vos <strong>PLUMER$;</strong></span></span></span></span></span></li>\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Les articles achetés avec un code <strong>Rabais PLUMERS;</strong></span></span></span></span></span></li>\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Les articles dont le <strong>prix original est barré</strong>;</span></span></span></span></span></li>\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Les articles dont <strong>le prix de vente est écrit en or</strong>;</span></span></span></span></span></li>\r\n</ul>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Pour vous aider dans le processus de retour, voici quelques lignes directrices: </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Tous les produits doivent être retournés en état « comme neuf »&nbsp;:</span></span></span></span></span></p>\r\n\r\n<ul style="list-style-type:square">\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">la façon dont il a été reçu, dans son emballage d\'origine et en état de revente 100% sans</span></span></span></span></span></li>\r\n</ul>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">aucune modification. </span></span></span></span></span></p>\r\n\r\n<ul style="list-style-type:square">\r\n	<li><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Si l\'item a été installé, il sera refusé automatiquement. Les retours sont inspectés à</span></span></span></span></span></li>\r\n</ul>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">l\'entrepôt à la réception; si l\'élément est déterminé à avoir été installé ou utilisé (sauf en cas de défaut), le produit peut être retourné à vos frais. </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">PORT PAYÉ ET ASSURÉ PAR LE CLIENT. Il est fortement recommandé d\'utiliser un support fiable (</span></span>UPS, FEDEX, DHL, PUROLATOR<span style="font-size:12.0pt"><span style="color:#333333">…) qui offre le suivi. Nous exigeons également que vous assurez le paquet, vous serez responsable de s\'assurer que tous les éléments arrivent à nous dans leur état d\'origine. </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">EXCEPTIONS : AUCUN RETOUR SUR LES COMPTOIRS, LES PRODUITS EN COMMANDES SPÉCIALES (CABINET DE CUISINE, ROBINETS SPÉCIAL, PLANCHER DE BOIS FRANC) AINSI QUE CERTAINS PRODUITS POUR DES RAISONS D\'HYGIÈNE (EXEMPLE (NON LIMITÉ À) : SIÈGES DE TOILETTE, CASQUES DE RÉALITÉ VIRTUELLE, ETC.).</span></span></strong></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Pour retourner un article écrivez-nous au </span></span><a href="mailto:support@renoplus-soft.com"><span style="font-size:12.0pt">support@renoplus-soft.com</span></a><span style="font-size:12.0pt"><span style="color:#333333">&nbsp; afin de recevoir les informations de retour par e-mail et ou par notification sur notre application mobile. </span></span></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Articles endommagés et ou défectueux&nbsp;: </span></span></strong></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:12pt"><span style="background-color:white">Dans le cas improbable où un article que vous avez commandé arrive endommagé ou défectueux, <span style="color:#333333">prenez note, que la Garantie Légale ou du fournisseur/fabricant s\'appliquent. S\'il vous plaît ne pas jeter la boîte ou tout matériau d\'emballage. Prendre des photos en preuves. N\'oubliez pas de nous en informer dans les 48 heures suivant la livraison pour signaler les dommages / défauts. Dans le cas contraire, « PLUMERS » se réserve le droit d\'investiguer afin de trouver la cause véritable du dommage. En ce qui concerne les dommages, vous devez nous en informer immédiatement dans les 48 heures suivant la réception. TOUS les produits sont inspectés SANS EXCEPTIONS par nos fournisseurs et/ou fabricants avant la livraison au client afin d\'éviter de mauvaises surprises. Les photos numériques sont d\'une grande aide et nécessaire afin d\'accélérer le processus. « PLUMERS » se dégage de toute responsabilité des frais associés/encourus par le client directement ou indirectement à la défectuosité/bris de produit(s) (exemple (non-limité à): rappel d\'un électricien pour changer la fixture). </span></span></span></p>\r\n\r\n<p><span style="font-size:12pt"><span style="background-color:white">Pour signaler un article endommagé et ou défectueux écrivez-nous au <a href="mailto:support@renoplus-soft.com">support@renoplus-soft.com</a><span style="color:#333333">&nbsp; afin de recevoir les informations de retour par e-mail et ou par notification sur notre application mobile.</span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">Articles manquants&nbsp;:</span></span></strong></span></span></p>\r\n\r\n<p><span style="font-size:12pt"><span style="background-color:white">S\'il manque des éléments ou des pièces à votre commande, veuillez-nous en informer le plus tôt possible et au plus tard 5 jours après la livraison.&nbsp;</span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">Procédure d\'annulation <strong>NOUS N\'ACCEPTONS AUCUNE ANNULATION DE COMMANDE</strong>. Votre acceptation de nos politiques En utilisant cette Application Mobile, vous acceptez nos politiques. Si vous n\'êtes pas d\'accord avec cette politique, veuillez ne pas utiliser ce Site et ou cette Application Mobile © 2020 </span></span><strong><span style="font-size:10.0pt"><span style="color:#333333">PLUMERS.</span></span></strong><span style="font-size:12.0pt"><span style="color:#333333"> Tous droits réservés.</span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="color:#333333">6 - Joindre <strong>PLUMERS</strong></span></span><strong><span style="font-size:10.0pt"><span style="color:#333333">:</span></span></strong></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="color:#333333">PLUMERS </span></span></strong><span style="font-size:12.0pt"><span style="color:#333333">peut être contacté par courrier:<br>\r\nResponsable de la protection de la vie privée&nbsp;<br>\r\n<strong>PLUMERS </strong><br>\r\n<strong>353 Rue St-Jacques<br>\r\nSt Jean Sur Richelieu, QC J3B 2L5&nbsp;<br>\r\nOu par téléphone : 514-229-0159</strong><br>\r\nOu par courriel à cette adresse :&nbsp;</span></span><a href="mailto:info@renoplus-soft.com"><span style="font-size:12.0pt">info@renoplus-soft.com</span></a></span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="mailto:support@renoplus-soft.com"><span style="font-size:12.0pt">support@renoplus-soft.com</span></a> </span></span></span></p>\r\n\r\n<p><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Calibri,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="mailto:h.jong@renoplus-soft.com"><span style="font-size:12.0pt">h.jong@renoplus-soft.com</span></a></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>&nbsp;</h2>\r\n');
/*!40000 ALTER TABLE `content` ENABLE KEYS */;

-- Export de la structure de la table plumers. council
CREATE TABLE IF NOT EXISTS `council` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `media_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` int(10) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.council : ~3 rows (environ)
/*!40000 ALTER TABLE `council` DISABLE KEYS */;
INSERT INTO `council` (`id`, `userid`, `title`, `image`, `media_type`, `status`, `created_on`) VALUES
	(28, '35', 'Bienvenue a la fin de l hiver 🏹🎉🎉🎉👍🏿👍🏿👍🏿👍🏿🥂🥂🥂🥂😀', 'http://plumers.test/public/uploads/j7KXO541a671216268389de57725a9c8bc79e35.jpg', 'Image', 0, '2020-04-21 19:30:14'),
	(29, '35', 'Nouvelle salle à manger visiter notre site 💪💪💪🎉🎉🎉😊😉😉🥂🥂🥂🥂', 'http://plumers.test/public/uploads/ZXnOKfa8b2fda75f665148ffdb46390854d1e35.jpg', 'Image', 0, '2020-04-21 19:31:10'),
	(32, '35', 'Chambre d enfant moderne 🤔🤔😍😍', 'http://plumers.test/public/uploads/HPARM44a763334ac90fcd1bdabfca7f421b2735.jpg', 'Image', 0, '2020-05-06 07:53:38');
/*!40000 ALTER TABLE `council` ENABLE KEYS */;

-- Export de la structure de la table plumers. coupons
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_code` varchar(255) CHARACTER SET latin1 NOT NULL,
  `description` longtext CHARACTER SET latin1 NOT NULL,
  `discount` bigint(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.coupons : 5 rows
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` (`id`, `coupon_code`, `description`, `discount`, `start_date`, `end_date`, `date`) VALUES
	(2, 'CLOUD30', 'Just grab the deal. Flat 20% off on all order from 04 feb 2020 to 29 feb 2020', 20, '2020-02-04', '2020-05-14', '2020-02-26 10:49:28'),
	(3, 'ANAND10', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 10, '2020-02-26', '2020-05-15', '2020-02-26 17:45:56'),
	(8, 'boro 60', 'salu mr je suis en route<br>', 200, '2020-05-03', '2020-05-20', '2020-05-19 08:51:43'),
	(9, 'RENO56', 'nbnb', 200, '2020-05-07', '2020-05-30', '2020-05-21 05:47:54'),
	(13, 'RENO900', 'sss', 50, '2020-05-03', '2020-05-05', '2020-05-24 01:42:10');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;

-- Export de la structure de la table plumers. coupon_users
CREATE TABLE IF NOT EXISTS `coupon_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `coupon_id` bigint(20) NOT NULL,
  `coupon_code` varchar(200) CHARACTER SET latin1 NOT NULL,
  `description` longtext CHARACTER SET latin1 NOT NULL,
  `discount` bigint(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.coupon_users : 11 rows
/*!40000 ALTER TABLE `coupon_users` DISABLE KEYS */;
INSERT INTO `coupon_users` (`id`, `user_id`, `coupon_id`, `coupon_code`, `description`, `discount`, `start_date`, `end_date`, `status`, `date`) VALUES
	(31, 35, 6, 'RENO20', 'RELANCE20', 20, '2020-04-21', '2020-04-22', 1, '2020-04-21'),
	(30, 26, 6, 'RENO20', 'RELANCE20', 20, '2020-04-21', '2020-04-22', 1, '2020-04-21'),
	(29, 36, 3, 'ANAND10', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 10, '2020-02-26', '2020-05-15', 1, '2020-04-19'),
	(28, 35, 3, 'ANAND10', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 10, '2020-02-26', '2020-05-15', 0, '2020-04-19'),
	(27, 34, 3, 'ANAND10', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 10, '2020-02-26', '2020-05-15', 0, '2020-04-19'),
	(26, 33, 3, 'ANAND10', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 10, '2020-02-26', '2020-05-15', 0, '2020-04-19'),
	(25, 32, 3, 'ANAND10', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 10, '2020-02-26', '2020-05-15', 0, '2020-04-19'),
	(24, 28, 3, 'ANAND10', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 10, '2020-02-26', '2020-05-15', 0, '2020-04-19'),
	(23, 26, 3, 'ANAND10', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 10, '2020-02-26', '2020-05-15', 0, '2020-04-19'),
	(22, 25, 3, 'ANAND10', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 10, '2020-02-26', '2020-05-15', 0, '2020-04-19'),
	(21, 24, 3, 'ANAND10', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 10, '2020-02-26', '2020-05-15', 1, '2020-04-19');
/*!40000 ALTER TABLE `coupon_users` ENABLE KEYS */;

-- Export de la structure de la table plumers. cours
CREATE TABLE IF NOT EXISTS `cours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idclasse` int(11) NOT NULL,
  `idserie` int(11) NOT NULL,
  `idenseignant` int(11) NOT NULL,
  `idmatiere` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `coef` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.cours : ~6 rows (environ)
/*!40000 ALTER TABLE `cours` DISABLE KEYS */;
INSERT INTO `cours` (`id`, `idclasse`, `idserie`, `idenseignant`, `idmatiere`, `code`, `coef`, `created_at`) VALUES
	(1, 3, 6, 6, 6, '050306060', 5, '2020-07-09 17:24:00'),
	(2, 6, 7, 1, 2, '050602010', 5, '2020-07-09 17:29:50'),
	(3, 3, 6, 1, 3, '050306010', 5, '2020-07-09 17:31:00'),
	(4, 6, 7, 6, 3, '020603060', 2, '2020-07-09 17:31:35'),
	(5, 3, 6, 2, 4, '070304020', 7, '2020-07-09 18:14:04'),
	(6, 5, 7, 3, 2, '070502030', 7, '2020-07-10 14:09:02');
/*!40000 ALTER TABLE `cours` ENABLE KEYS */;

-- Export de la structure de la table plumers. customer_project
CREATE TABLE IF NOT EXISTS `customer_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) NOT NULL,
  `project_name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `affiliate_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.customer_project : 16 rows
/*!40000 ALTER TABLE `customer_project` DISABLE KEYS */;
INSERT INTO `customer_project` (`id`, `customer_id`, `project_name`, `category`, `description`, `images`, `affiliate_ids`, `status`, `date`) VALUES
	(1, 26, 'refaire ma cuisine ', 'Designer', 'je cherche un design pour ma nouvelle cuisines ???????????', 'http://plumers.test/public/uploads/1587194802_photo_SmartSelect_20181019-090009_Drive.jpg', '27', 1, '2020-04-18 03:26:42'),
	(2, 34, 'cuisine', 'Designer', 'mettre plus de lumière dans ma cuisine', 'http://plumers.test/public/uploads/1587250481_photo_0415201333.jpg', '27', 1, '2020-04-18 18:54:41'),
	(3, 36, 'test', 'Designer', 'test', 'http://plumers.test/public/uploads/1587282916_photo_IMG-20200419-WA0025.jpg,http://plumers.test/public/uploads/1587282916_photo_IMG-20200419-WA0024.jpg', '25', 1, '2020-04-19 03:55:16'),
	(4, 26, 'Cuisine ', 'Designer', 'Refaire ma cuisine ??❤️❤️❤️???', 'http://plumers.test/public/uploads/1587316032_photo_20181019_021146.jpg,http://plumers.test/public/uploads/1587316032_photo_IMG_20190517_140415.jpg,http://plumers.test/public/uploads/1587316032_photo_20181019_020248.jpg,http://plumers.test/public/uploads/1587316032_photo_IMG_20190603_173028.jpg,http://plumers.test/public/uploads/1587316032_photo_20181020_034607.jpg,http://plumers.test/public/uploads/1587316032_photo_IMG_20190220_133716.jpg,http://plumers.test/public/uploads/1587316032_photo_IMG_20190206_111445.jpg,http://plumers.test/public/uploads/1587316032_photo_IMG_20190206_111353.jpg,http://plumers.test/public/uploads/1587316032_photo_IMG_20190220_133725.jpg,http://plumers.test/public/uploads/1587316032_photo_IMG_20190220_133721.jpg,http://plumers.test/public/uploads/1587316032_photo_IMG_20190220_133733.jpg,http://plumers.test/public/uploads/1587316032_photo_20180822_144352.jpg,http://plumers.test/public/uploads/1587316032_photo_IMG_20190220_133737.jpg,http://plumers.test/public/uploads/1587316032_photo_20181024_234748.jpg,http://plumers.test/public/uploads/1587316032_photo_IMG_20190206_111351.jpg', '35', 1, '2020-04-19 13:07:12'),
	(5, 36, 'test ', 'Designer', 'test', 'http://plumers.test/public/uploads/1587463529_photo_IMG-20200421-WA0011.jpg,http://plumers.test/public/uploads/1587463529_photo_IMG-20200421-WA0016.jpg,http://plumers.test/public/uploads/1587463529_photo_IMG-20200421-WA0014.jpg', '35,36', 1, '2020-04-21 06:05:29'),
	(6, 32, 'chambre', 'Designer', 'agrandir la chambre', 'http://plumers.test/public/uploads/1587474830_photo_IMG_20200419_204858_9.jpg', '35', 1, '2020-04-21 09:13:50'),
	(7, 26, 'refaire cuisine ', 'Designer', 'refaire cuisine ', 'http://plumers.test/public/uploads/1587512870_photo_20190326_022505.jpg,http://plumers.test/public/uploads/1587512870_photo_20190326_022510.jpg,http://plumers.test/public/uploads/1587512870_photo_20190326_022459.jpg,http://plumers.test/public/uploads/1587512870_photo_20190326_022604.jpg,http://plumers.test/public/uploads/1587512870_photo_20190326_022546.jpg', '32', 1, '2020-04-21 19:47:50'),
	(8, 24, 'Henry Kitchen', 'Designer', 'I habsusjsbsisisj☺?☺?☺?☺?', 'http://plumers.test/public/uploads/1588007192_photo_IMG-20200426-WA0005.jpg,http://plumers.test/public/uploads/1588007192_photo_IMG-20200426-WA0006.jpg,http://plumers.test/public/uploads/1588007192_photo_IMG-20200426-WA0004.jpg', '25', 1, '2020-04-27 13:06:32'),
	(9, 26, 'Refaire salle de bain ', 'Designer', 'Refaire ma salle à manger de salon ??????☺️☺️♥️♥️???', 'http://plumers.test/public/uploads/1588055145_photo_mmexport1577949860936.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1577106967715.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1577112323504.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1577949791013.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1577949787632.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1577949809530.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1577949812948.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1577949831395.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1577949838826.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1577949835407.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1577949857973.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1578703461606.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1578703455217.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1578703438811.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1578703560667.jpg,http://plumers.test/public/uploads/1588055145_photo_mmexport1579042864665.jpg,http://plumers.test/public/uploads/1588055145_photo_1588055119825.jpg', '35', 1, '2020-04-28 02:25:45'),
	(10, 24, 'Priyanshu kitchen', 'Designer', 'hdbjiuu????????????', 'http://plumers.test/public/uploads/1588112077_photo_IMG-20200428-WA0006.jpg,http://plumers.test/public/uploads/1588112077_photo_IMG-20200428-WA0005.jpg', '25', 1, '2020-04-28 18:14:37'),
	(11, 24, 'Gaurav kitchen', 'Designer', 'icy ji jkvfj jobhi', 'http://plumers.test/public/uploads/1588153145_photo_IMG-20200429-WA0000.jpeg,http://plumers.test/public/uploads/1588153145_photo_IMG-20200428-WA0005.jpg', '25,35,36', 1, '2020-04-29 05:39:05'),
	(12, 34, 'chambre ', 'Designer', 'une nouvelle chambre spacieuse', 'http://plumers.test/public/uploads/1588190721_photo_1588190693106.jpg', '35', 1, '2020-04-29 16:05:21'),
	(13, 46, 'test', 'Designer', 'ceci est un test', 'http://plumers.test/public/uploads/1588260758_photo_1588260640452.jpg', '35', 1, '2020-04-30 11:32:38'),
	(14, 48, 'refaire cuisine', 'Designer', 'refaire ma cuisine ', 'http://plumers.test/public/uploads/1588386478_photo_1588386446444.jpg', '35,36', 1, '2020-05-01 22:27:58'),
	(15, 34, 'salon', 'Designer', 'beau salon', 'http://plumers.test/public/uploads/1588692250_photo_1588692220943.jpg', '35', 1, '2020-05-05 11:24:10'),
	(16, 49, 'cuisine ', 'Designer', 'refaire carrelage et installer 3 luminaire ', 'http://plumers.test/public/uploads/1588714767_photo_1588717884219.jpg,http://plumers.test/public/uploads/1588714767_photo_1588717970234.jpg,http://plumers.test/public/uploads/1588714767_photo_20180502_101609.jpg', '35', 1, '2020-05-05 17:39:27');
/*!40000 ALTER TABLE `customer_project` ENABLE KEYS */;

-- Export de la structure de la table plumers. cycle
CREATE TABLE IF NOT EXISTS `cycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.cycle : ~0 rows (environ)
/*!40000 ALTER TABLE `cycle` DISABLE KEYS */;
/*!40000 ALTER TABLE `cycle` ENABLE KEYS */;

-- Export de la structure de la table plumers. dealoftheday
CREATE TABLE IF NOT EXISTS `dealoftheday` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` longtext CHARACTER SET utf8mb4 NOT NULL,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `price` float(10,2) NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 NOT NULL,
  `banner` longtext CHARACTER SET utf8mb4 NOT NULL,
  `status` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.dealoftheday : 2 rows
/*!40000 ALTER TABLE `dealoftheday` DISABLE KEYS */;
INSERT INTO `dealoftheday` (`id`, `title`, `starttime`, `endtime`, `product_id`, `price`, `description`, `banner`, `status`, `date`) VALUES
	(33, 'Mothers Day\'s', '2020-05-05 10:40:33', '2020-05-06 10:40:33', 5, 32.00, 'Happy mother days for all.', 'http://plumers.test/public/uploads/05052020103633.jpg', 1, '2020-05-05'),
	(32, 'X-Mass Festival', '2020-04-28 15:15:54', '2020-05-02 15:15:54', 4, 589.00, 'For 4 days of this deal', 'http://plumers.test/public/uploads/29042020055125.jpg', 1, '2020-04-29');
/*!40000 ALTER TABLE `dealoftheday` ENABLE KEYS */;

-- Export de la structure de la table plumers. email
CREATE TABLE IF NOT EXISTS `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.email : ~0 rows (environ)
/*!40000 ALTER TABLE `email` DISABLE KEYS */;
/*!40000 ALTER TABLE `email` ENABLE KEYS */;

-- Export de la structure de la table plumers. evalution
CREATE TABLE IF NOT EXISTS `evalution` (
  `id` int(11) DEFAULT NULL,
  `idsequence` int(11) DEFAULT NULL,
  `idcours` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.evalution : ~0 rows (environ)
/*!40000 ALTER TABLE `evalution` DISABLE KEYS */;
/*!40000 ALTER TABLE `evalution` ENABLE KEYS */;

-- Export de la structure de la table plumers. hospitalisation
CREATE TABLE IF NOT EXISTS `hospitalisation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idsalle` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL,
  `date_in` date NOT NULL,
  `date_out` date DEFAULT NULL,
  `montant` float DEFAULT NULL,
  `rest` float DEFAULT NULL,
  `etat` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.hospitalisation : ~0 rows (environ)
/*!40000 ALTER TABLE `hospitalisation` DISABLE KEYS */;
/*!40000 ALTER TABLE `hospitalisation` ENABLE KEYS */;

-- Export de la structure de la table plumers. likes
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `council_id` varchar(100) CHARACTER SET latin1 NOT NULL,
  `userid` varchar(100) CHARACTER SET latin1 NOT NULL,
  `like_status` int(10) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.likes : ~22 rows (environ)
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` (`id`, `council_id`, `userid`, `like_status`, `created_on`) VALUES
	(17, '27', '26', 1, '2020-04-18 18:24:17'),
	(18, '27', '30', 1, '2020-04-19 04:11:44'),
	(19, '27', '34', 1, '2020-04-19 10:09:22'),
	(20, '27', '26', 1, '2020-04-20 05:33:07'),
	(21, '27', '26', 1, '2020-04-20 05:33:08'),
	(22, '27', '26', 1, '2020-04-20 05:33:08'),
	(23, '27', '26', 1, '2020-04-20 05:33:12'),
	(24, '27', '26', 1, '2020-04-20 05:33:13'),
	(25, '29', '32', 1, '2020-04-22 00:14:31'),
	(26, '29', '32', 1, '2020-04-22 00:15:06'),
	(27, '29', '32', 1, '2020-04-22 00:15:06'),
	(28, '29', '32', 1, '2020-04-22 00:15:07'),
	(29, '29', '32', 1, '2020-04-22 00:15:09'),
	(30, '29', '32', 1, '2020-04-22 00:15:17'),
	(31, '29', '32', 1, '2020-04-22 00:15:18'),
	(32, '29', '32', 1, '2020-04-22 00:15:18'),
	(33, '29', '32', 1, '2020-04-22 00:15:21'),
	(34, '28', '32', 1, '2020-04-22 00:16:14'),
	(35, '29', '16', 1, '2020-04-24 04:41:10'),
	(36, '28', '16', 1, '2020-04-24 04:41:11'),
	(37, '27', '16', 1, '2020-04-24 04:41:13'),
	(38, '30', '35', 1, '2020-05-06 08:08:31');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;

-- Export de la structure de la table plumers. matiere
CREATE TABLE IF NOT EXISTS `matiere` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.matiere : ~4 rows (environ)
/*!40000 ALTER TABLE `matiere` DISABLE KEYS */;
INSERT INTO `matiere` (`id`, `nom`, `code`, `created_at`, `updated_at`) VALUES
	(2, 'Mathematiques', 'Mat', '2020-07-09 07:58:41', '2020-07-09 08:06:38'),
	(3, 'Philosophie', 'Phi', '2020-07-09 08:07:31', NULL),
	(4, 'Anglais', 'Ang', '2020-07-09 08:07:48', NULL),
	(6, 'Geographie', 'Geo', '2020-07-09 08:13:37', NULL);
/*!40000 ALTER TABLE `matiere` ENABLE KEYS */;

-- Export de la structure de la table plumers. mention
CREATE TABLE IF NOT EXISTS `mention` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idsous_system` int(11) DEFAULT NULL,
  `note_min` int(11) DEFAULT NULL,
  `note_max` int(11) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `appreciation` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.mention : ~2 rows (environ)
/*!40000 ALTER TABLE `mention` DISABLE KEYS */;
INSERT INTO `mention` (`id`, `idsous_system`, `note_min`, `note_max`, `code`, `appreciation`, `created_at`, `updated_at`) VALUES
	(5, 2, 0, 2, 'Null', 'Null', '2020-06-29 03:07:47', '2020-06-29 03:13:42'),
	(6, 2, 10, 12, 'Passable', 'Passable', '2020-06-29 03:14:40', NULL);
/*!40000 ALTER TABLE `mention` ENABLE KEYS */;

-- Export de la structure de la table plumers. news
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET latin1 NOT NULL,
  `contenu` text CHARACTER SET latin1 NOT NULL,
  `image` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vues` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.news : ~1 rows (environ)
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` (`id`, `titre`, `contenu`, `image`, `created_at`, `vues`) VALUES
	(1, 'ddddddddddddddddddddd', 'dddddd', 'dddd', '2020-05-21 16:22:55', 0);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;

-- Export de la structure de la table plumers. notes
CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idmention` int(11) DEFAULT NULL,
  `idapprenant` int(11) DEFAULT NULL,
  `idevaluation` int(11) DEFAULT NULL,
  `idmatiere` int(11) DEFAULT NULL,
  `idclasse` int(11) DEFAULT NULL,
  `note` float DEFAULT NULL,
  `notecoef` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.notes : ~0 rows (environ)
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;

-- Export de la structure de la table plumers. notification
CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` bigint(20) NOT NULL,
  `to_id` bigint(20) NOT NULL,
  `action` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=255 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.notification : ~254 rows (environ)
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` (`id`, `from_id`, `to_id`, `action`, `notification`, `status`, `date`, `time`) VALUES
	(1, 0, 22, 'meeting-Affiliate-22', 'Raj Anand sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-15', '10:42:41'),
	(2, 0, 23, 'meeting-Customer-23', 'Hello, Anand Facebook accepted your meeting.', 'Unread', '2020-04-15', '11:38:22'),
	(3, 0, 25, 'meeting-Affiliate-25', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-16', '07:11:44'),
	(4, 0, 24, 'meeting-Customer-24', 'Hello, Shubham Saurabh accepted your meeting.', 'Unread', '2020-04-16', '07:14:16'),
	(5, 0, 25, 'meeting-Affiliate-25', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-16', '09:06:10'),
	(6, 0, 25, 'meeting-Affiliate-25', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-16', '09:07:23'),
	(7, 0, 24, 'meeting-Customer-24', 'Hello, Shubham Saurabh accepted your meeting.', 'Unread', '2020-04-16', '09:21:41'),
	(8, 0, 25, 'meeting-Affiliate-25', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-16', '11:30:23'),
	(9, 0, 24, 'meeting-Customer-24', 'Hello, Shubham Saurabh accepted your meeting.', 'Unread', '2020-04-16', '11:31:15'),
	(10, 0, 24, 'meeting-Customer-24', 'Hello, Shubham Saurabh accepted your meeting.', 'Unread', '2020-04-16', '11:39:34'),
	(11, 0, 27, 'myProject-Affiliate-27', 'Henri Jong sent you a project. Click here to open it', 'Read', '2020-04-18', '03:26:43'),
	(12, 0, 26, 'myProject-Customer-26', 'Henri  jong sent you a price for your project. Click here to open it', 'Read', '2020-04-18', '03:28:17'),
	(13, 0, 27, 'meeting-Affiliate-27', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Read', '2020-04-18', '03:31:07'),
	(14, 0, 26, 'meeting-Customer-26', 'Hello, Henri  jong accepted your meeting.', 'Read', '2020-04-18', '03:31:29'),
	(15, 0, 26, 'meeting-Customer-26', 'Hello, Henri  jong accepted your meeting.', 'Read', '2020-04-18', '03:31:39'),
	(16, 0, 26, 'meeting-Customer-26', 'Hello, Henri  jong accepted your meeting.', 'Read', '2020-04-18', '03:33:44'),
	(17, 0, 27, 'meeting-Affiliate-27', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Read', '2020-04-18', '03:34:50'),
	(18, 0, 26, 'meeting-Customer-26', 'Hello, Henri  jong accepted your meeting.', 'Read', '2020-04-18', '03:36:19'),
	(19, 0, 27, 'meeting-Affiliate-27', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Read', '2020-04-18', '14:46:58'),
	(20, 0, 24, 'meeting-Customer-24', 'Hello, Henri  jong accepted your meeting.', 'Read', '2020-04-18', '14:48:18'),
	(21, 0, 24, 'meeting-Customer-24', 'Hello, Henri  jong accepted your meeting.', 'Unread', '2020-04-18', '14:48:30'),
	(22, 0, 27, 'myProject-Affiliate-27', 'Laurence Vanessa Mboah sent you a project. Click here to open it', 'Read', '2020-04-18', '18:54:41'),
	(23, 0, 34, 'myProject-Customer-34', 'Henri  jong sent you a price for your project. Click here to open it', 'Read', '2020-04-18', '18:56:56'),
	(24, 0, 27, 'meeting-Affiliate-27', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Read', '2020-04-18', '19:22:13'),
	(25, 0, 26, 'meeting-Customer-26', 'Hello, Henri  jong accepted your meeting.', 'Read', '2020-04-18', '19:22:37'),
	(26, 0, 27, 'meeting-Affiliate-27', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-18', '19:27:43'),
	(27, 0, 34, 'meeting-Customer-34', 'Hello, Henri  jong accepted your meeting.', 'Unread', '2020-04-18', '19:28:08'),
	(28, 0, 25, 'myProject-Affiliate-25', 'Steve Ndjeunou sent you a project. Click here to open it', 'Read', '2020-04-19', '03:55:16'),
	(29, 0, 24, 'app-Customer-', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 'Read', '2020-04-19', '07:07:33'),
	(30, 0, 25, 'app-Affiliate-', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 'Read', '2020-04-19', '07:07:33'),
	(31, 0, 26, 'app-Customer-', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 'Read', '2020-04-19', '07:07:33'),
	(32, 0, 32, 'app-Customer-', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 'Unread', '2020-04-19', '07:07:33'),
	(33, 0, 33, 'app-Customer-', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 'Unread', '2020-04-19', '07:07:33'),
	(34, 0, 34, 'app-Customer-', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 'Unread', '2020-04-19', '07:07:33'),
	(35, 0, 35, 'app-Customer-', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 'Read', '2020-04-19', '07:07:33'),
	(36, 0, 36, 'app-Customer-', 'Just grab the deal. Flat 10% off on all order from 26 feb 2020 to 29 feb 2020', 'Read', '2020-04-19', '07:07:33'),
	(37, 0, 35, 'myProject-Affiliate-35', 'Henri Jong sent you a project. Click here to open it', 'Read', '2020-04-19', '13:07:13'),
	(38, 0, 26, 'myorders-Customer-26', 'Your Order has been placed. Please click here to check order status', 'Read', '2020-04-19', '14:31:38'),
	(39, 0, 35, 'meeting-Affiliate-35', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Read', '2020-04-19', '14:33:53'),
	(40, 0, 26, 'myProject-Customer-26', 'Henri  Jong  sent you a price for your project. Click here to open it', 'Read', '2020-04-19', '14:35:59'),
	(41, 0, 26, 'meeting-Customer-26', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-19', '14:36:09'),
	(42, 0, 26, 'myorders-Customer-26', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-04-19', '14:39:36'),
	(43, 0, 24, 'myorders-Customer-24', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-04-19', '14:41:37'),
	(44, 0, 35, 'meeting-Affiliate-35', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Read', '2020-04-19', '14:45:31'),
	(45, 0, 24, 'myorders-Customer-24', 'Your Order status has been updated. Please click here to check.', 'Unread', '2020-04-19', '14:45:46'),
	(46, 0, 26, 'meeting-Customer-26', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-19', '14:45:56'),
	(47, 0, 26, 'myorders-Customer-26', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-04-19', '14:47:12'),
	(48, 0, 35, 'meeting-Affiliate-35', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Read', '2020-04-19', '15:19:38'),
	(49, 0, 24, 'meeting-Customer-24', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-19', '15:20:21'),
	(50, 0, 25, 'meeting-Affiliate-25', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-19', '15:34:15'),
	(51, 0, 26, 'meeting-Customer-26', 'Hello, Shubham Saurabh accepted your meeting.', 'Read', '2020-04-19', '15:34:33'),
	(52, 0, 26, 'meeting-Customer-26', 'Hello, Shubham Saurabh accepted your meeting.', 'Read', '2020-04-19', '15:34:34'),
	(53, 0, 35, 'meeting-Affiliate-35', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Read', '2020-04-19', '17:30:17'),
	(54, 0, 24, 'meeting-Customer-24', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-19', '17:30:42'),
	(55, 0, 25, 'meeting-Affiliate-25', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Read', '2020-04-19', '17:36:49'),
	(56, 0, 26, 'meeting-Customer-26', 'Hello, Shubham Saurabh accepted your meeting.', 'Read', '2020-04-19', '17:37:07'),
	(57, 0, 26, 'meeting-Customer-26', 'Hello, Shubham Saurabh accepted your meeting.', 'Read', '2020-04-19', '17:37:08'),
	(58, 0, 25, 'meeting-Affiliate-25', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-19', '18:41:27'),
	(59, 0, 26, 'meeting-Customer-26', 'Hello, Shubham Saurabh accepted your meeting.', 'Read', '2020-04-19', '18:42:01'),
	(60, 0, 26, 'meeting-Customer-26', 'Hello, Shubham Saurabh accepted your meeting.', 'Read', '2020-04-19', '18:42:12'),
	(61, 0, 26, 'meeting-Customer-26', 'Hello, Shubham Saurabh accepted your meeting.', 'Read', '2020-04-19', '18:42:13'),
	(62, 0, 26, 'myorders-Customer-26', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-04-19', '18:58:49'),
	(63, 0, 26, 'myorders-Customer-26', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-04-19', '18:59:37'),
	(64, 0, 35, 'meeting-Affiliate-35', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Read', '2020-04-20', '07:48:25'),
	(65, 0, 26, 'meeting-Customer-26', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-20', '07:48:48'),
	(66, 0, 26, 'meeting-Customer-26', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-20', '07:49:03'),
	(67, 0, 26, 'app-Customer-26', 'RELANCE20', 'Read', '2020-04-21', '05:58:21'),
	(68, 0, 35, 'app-Affiliate-35', 'RELANCE20', 'Read', '2020-04-21', '05:58:21'),
	(69, 0, 36, 'myorders-Customer-36', 'Your Order has been placed. Please click here to check order status', 'Unread', '2020-04-21', '06:02:59'),
	(70, 0, 35, 'myorders-Affiliate-35', 'Your Order has been placed. Please click here to check order status', 'Read', '2020-04-21', '06:03:25'),
	(71, 0, 35, 'myProject-Affiliate-35', 'Steve Ndjeunou sent you a project. Click here to open it', 'Read', '2020-04-21', '06:05:30'),
	(72, 0, 36, 'myProject-Affiliate-36', 'Steve Ndjeunou sent you a project. Click here to open it', 'Unread', '2020-04-21', '06:05:30'),
	(73, 0, 36, 'myProject-Customer-36', 'Henri  Jong  sent you a price for your project. Click here to open it', 'Unread', '2020-04-21', '06:06:21'),
	(74, 0, 35, 'meeting-Affiliate-35', 'Steve Ndjeunou sent you a a request for meeting. Click here to open it', 'Read', '2020-04-21', '06:09:50'),
	(75, 0, 36, 'myorders-Customer-36', 'Your Order status has been updated. Please click here to check.', 'Unread', '2020-04-21', '06:09:57'),
	(76, 0, 36, 'myorders-Customer-36', 'Your Order status has been updated. Please click here to check.', 'Unread', '2020-04-21', '06:10:13'),
	(77, 0, 36, 'myorders-Customer-36', 'Your Order status has been updated. Please click here to check.', 'Unread', '2020-04-21', '06:10:22'),
	(78, 0, 36, 'myorders-Customer-36', 'Your Order status has been updated. Please click here to check.', 'Unread', '2020-04-21', '06:10:38'),
	(79, 0, 36, 'myorders-Customer-36', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-04-21', '06:11:14'),
	(80, 0, 26, 'myorders-Customer-26', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-04-21', '06:11:51'),
	(81, 0, 36, 'myorders-Customer-36', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-04-21', '06:12:14'),
	(82, 0, 35, 'myorders-Affiliate-35', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-04-21', '06:12:41'),
	(83, 0, 36, 'meeting-Customer-36', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-21', '06:13:18'),
	(84, 0, 36, 'meeting-Affiliate-36', 'Steve Ndjeunou sent you a a request for meeting. Click here to open it', 'Read', '2020-04-21', '06:16:38'),
	(85, 0, 35, 'meeting-Affiliate-35', 'Steve Ndjeunou sent you a a request for meeting. Click here to open it', 'Read', '2020-04-21', '06:17:09'),
	(86, 0, 26, 'myorders-Customer-26', 'Your Order has been placed. Please click here to check order status', 'Read', '2020-04-21', '06:17:55'),
	(87, 0, 36, 'meeting-Customer-36', 'Hello, Steve Ndjeunou accepted your meeting.', 'Unread', '2020-04-21', '06:18:19'),
	(88, 0, 26, 'myorders-Customer-26', 'Your Order has been placed. Please click here to check order status', 'Read', '2020-04-21', '06:20:20'),
	(89, 0, 36, 'meeting-Customer-36', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-21', '06:21:23'),
	(90, 0, 36, 'myorders-Customer-36', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-04-21', '06:26:15'),
	(91, 0, 32, 'myorders-Customer-32', 'Your Order has been placed. Please click here to check order status', 'Unread', '2020-04-21', '09:10:25'),
	(92, 0, 35, 'myProject-Affiliate-35', 'Laurence Ilana sent you a project. Click here to open it', 'Read', '2020-04-21', '09:13:51'),
	(93, 0, 35, 'meeting-Affiliate-35', 'Laurence Ilana sent you a a request for meeting. Click here to open it', 'Read', '2020-04-21', '09:22:01'),
	(94, 0, 35, 'meeting-Affiliate-35', 'Laurence Ilana sent you a a request for meeting. Click here to open it', 'Read', '2020-04-21', '09:22:35'),
	(95, 0, 32, 'myorders-Customer-32', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-04-21', '09:24:31'),
	(96, 0, 32, 'myorders-Customer-32', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-04-21', '09:27:24'),
	(97, 0, 32, 'myProject-Customer-32', 'Henri  Jong  sent you a price for your project. Click here to open it', 'Read', '2020-04-21', '09:32:26'),
	(98, 0, 32, 'meeting-Customer-32', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-21', '09:33:23'),
	(99, 0, 32, 'meeting-Customer-32', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-21', '09:34:04'),
	(100, 0, 25, 'meeting-Affiliate-25', 'vinisha rao sent you a a request for meeting. Click here to open it', 'Read', '2020-04-21', '11:51:53'),
	(101, 0, 38, 'meeting-Customer-38', 'Hello, Shubham Saurabh accepted your meeting.', 'Read', '2020-04-21', '11:52:12'),
	(102, 0, 25, 'meeting-Affiliate-25', 'vinisha rao sent you a a request for meeting. Click here to open it', 'Read', '2020-04-21', '12:11:00'),
	(103, 0, 38, 'meeting-Customer-38', 'Hello, Shubham Saurabh accepted your meeting.', 'Unread', '2020-04-21', '12:11:04'),
	(104, 0, 32, 'myProject-Affiliate-32', 'Henri Jong sent you a project. Click here to open it', 'Read', '2020-04-21', '19:47:51'),
	(105, 0, 26, 'myProject-Customer-26', 'Laurence Ilana sent you a price for your project. Click here to open it', 'Read', '2020-04-21', '19:49:19'),
	(106, 0, 25, 'meeting-Affiliate-25', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-22', '15:10:07'),
	(107, 0, 24, 'meeting-Customer-24', 'Hello, Shubham Saurabh accepted your meeting.', 'Unread', '2020-04-22', '15:10:41'),
	(108, 0, 38, 'meeting-Affiliate-38', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-22', '15:49:06'),
	(109, 0, 24, 'meeting-Customer-24', 'Hello, vivek accepted your meeting.', 'Unread', '2020-04-22', '15:49:24'),
	(110, 0, 38, 'meeting-Affiliate-38', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-22', '19:37:41'),
	(111, 0, 24, 'meeting-Customer-24', 'Hello, vivek accepted your meeting.', 'Unread', '2020-04-22', '19:37:44'),
	(112, 0, 32, 'meeting-Affiliate-32', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Read', '2020-04-23', '10:40:13'),
	(113, 0, 26, 'meeting-Customer-26', 'Hello, Laurence Ilana accepted your meeting.', 'Read', '2020-04-23', '10:48:47'),
	(114, 0, 26, 'meeting-Customer-26', 'Hello, Laurence Ilana accepted your meeting.', 'Read', '2020-04-23', '10:49:47'),
	(115, 0, 25, 'meeting-Affiliate-25', 'Aki Kumar sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-23', '10:52:23'),
	(116, 0, 40, 'meeting-Customer-40', 'Hello, Shubham Saurabh accepted your meeting.', 'Read', '2020-04-23', '10:52:48'),
	(117, 0, 35, 'meeting-Affiliate-35', 'Lionel Ekabouma sent you a a request for meeting. Click here to open it', 'Read', '2020-04-23', '11:39:15'),
	(118, 0, 41, 'meeting-Customer-41', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-23', '11:39:27'),
	(119, 0, 39, 'meeting-Affiliate-39', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-23', '12:16:24'),
	(120, 0, 39, 'meeting-Affiliate-39', 'Lionel Ekabouma sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-23', '12:24:37'),
	(121, 0, 41, 'meeting-Customer-41', 'Hello, Kamal Kishor accepted your meeting.', 'Read', '2020-04-23', '12:25:54'),
	(122, 0, 26, 'meeting-Customer-26', 'Hello, Kamal Kishor accepted your meeting.', 'Read', '2020-04-23', '12:26:05'),
	(123, 0, 26, 'meeting-Customer-26', 'Hello, Kamal Kishor accepted your meeting.', 'Read', '2020-04-23', '12:26:06'),
	(124, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-23', '14:13:11'),
	(125, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-23', '14:17:35'),
	(126, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-23', '14:29:16'),
	(127, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-23', '14:29:21'),
	(128, 0, 39, 'meeting-Affiliate-39', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-23', '14:34:11'),
	(129, 0, 26, 'meeting-Customer-26', 'Hello, Kamal Kishor accepted your meeting.', 'Read', '2020-04-23', '14:34:55'),
	(130, 0, 26, 'meeting-Customer-26', 'Hello, Kamal Kishor accepted your meeting.', 'Read', '2020-04-23', '14:35:17'),
	(131, 0, 26, 'meeting-Customer-26', 'Hello, Kamal Kishor accepted your meeting.', 'Read', '2020-04-23', '14:35:18'),
	(132, 0, 26, 'meeting-Customer-26', 'Hello, Kamal Kishor accepted your meeting.', 'Read', '2020-04-23', '14:35:19'),
	(133, 0, 39, 'meeting-Affiliate-39', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-23', '14:37:34'),
	(134, 0, 24, 'meeting-Customer-24', 'Hello, Kamal Kishor accepted your meeting.', 'Unread', '2020-04-23', '14:37:42'),
	(135, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-23', '14:46:09'),
	(136, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-23', '14:46:20'),
	(137, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-23', '14:46:34'),
	(138, 0, 39, 'meeting-Affiliate-39', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-23', '14:46:40'),
	(139, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-23', '14:46:42'),
	(140, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-23', '14:46:46'),
	(141, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-23', '14:46:49'),
	(142, 0, 24, 'meeting-Customer-24', 'Hello, Kamal Kishor accepted your meeting.', 'Unread', '2020-04-23', '14:46:49'),
	(143, 0, 24, 'meeting-Customer-24', 'Hello, Kamal Kishor accepted your meeting.', 'Unread', '2020-04-23', '14:46:50'),
	(144, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-23', '15:03:13'),
	(145, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-23', '15:03:24'),
	(146, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-23', '15:03:34'),
	(147, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-23', '15:03:45'),
	(148, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-23', '15:03:48'),
	(149, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-23', '15:03:50'),
	(150, 0, 25, 'meeting-Affiliate-25', 'chetan  verma sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-23', '15:04:12'),
	(151, 0, 42, 'meeting-Customer-42', 'Hello, Shubham Saurabh accepted your meeting.', 'Unread', '2020-04-23', '15:04:37'),
	(152, 0, 25, 'meeting-Affiliate-25', 'chetan  verma sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-23', '15:07:06'),
	(153, 0, 42, 'meeting-Customer-42', 'Hello, Shubham Saurabh accepted your meeting.', 'Unread', '2020-04-23', '15:07:29'),
	(154, 0, 42, 'meeting-Customer-42', 'Hello, Shubham Saurabh accepted your meeting.', 'Unread', '2020-04-23', '15:07:31'),
	(155, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-23', '15:17:21'),
	(156, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-23', '15:17:43'),
	(157, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-23', '15:18:07'),
	(158, 0, 25, 'meeting-Affiliate-25', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-23', '17:12:28'),
	(159, 0, 24, 'meeting-Customer-24', 'Hello, Shubham Saurabh accepted your meeting.', 'Unread', '2020-04-23', '17:12:50'),
	(160, 0, 38, 'meeting-Affiliate-38', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-23', '17:13:10'),
	(161, 0, 24, 'meeting-Customer-24', 'Hello, vivek accepted your meeting.', 'Unread', '2020-04-23', '17:13:36'),
	(162, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-23', '18:31:54'),
	(163, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-23', '18:31:58'),
	(164, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-23', '18:32:01'),
	(165, 0, 35, 'meeting-Affiliate-35', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Read', '2020-04-24', '08:24:41'),
	(166, 0, 26, 'meeting-Customer-26', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-24', '08:24:59'),
	(167, 0, 35, 'meeting-Affiliate-35', 'Lionel Ekabouma sent you a a request for meeting. Click here to open it', 'Read', '2020-04-24', '08:40:22'),
	(168, 0, 41, 'meeting-Customer-41', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-24', '08:40:40'),
	(169, 0, 35, 'meeting-Affiliate-35', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Read', '2020-04-24', '08:43:19'),
	(170, 0, 24, 'meeting-Customer-24', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-24', '08:46:52'),
	(171, 0, 36, 'meeting-Affiliate-36', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Read', '2020-04-24', '10:27:38'),
	(172, 0, 26, 'meeting-Customer-26', 'Hello, Steve Ndjeunou accepted your meeting.', 'Read', '2020-04-24', '10:30:02'),
	(173, 0, 26, 'meeting-Customer-26', 'Hello, Steve Ndjeunou accepted your meeting.', 'Read', '2020-04-24', '10:30:03'),
	(174, 0, 32, 'meeting-Affiliate-32', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Read', '2020-04-24', '11:06:08'),
	(175, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-24', '11:12:05'),
	(176, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-24', '11:12:17'),
	(177, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-24', '11:12:23'),
	(178, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-24', '11:12:26'),
	(179, 0, 36, 'meeting-Affiliate-36', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Read', '2020-04-26', '15:25:26'),
	(180, 0, 25, 'meeting-Affiliate-25', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-26', '15:26:31'),
	(181, 0, 24, 'meeting-Customer-24', 'Hello, Shubham Saurabh accepted your meeting.', 'Unread', '2020-04-26', '15:26:46'),
	(182, 0, 25, 'meeting-Affiliate-25', 'Anand Rastogi sent you a a request for meeting. Click here to open it', 'Unread', '2020-04-26', '15:27:07'),
	(183, 0, 24, 'meeting-Customer-24', 'Hello, Steve Ndjeunou accepted your meeting.', 'Unread', '2020-04-26', '15:30:26'),
	(184, 0, 24, 'meeting-Customer-24', 'Hello, Steve Ndjeunou accepted your meeting.', 'Unread', '2020-04-26', '15:30:34'),
	(185, 0, 25, 'myProject-Affiliate-25', 'Anand Rastogi sent you a project. Click here to open it', 'Unread', '2020-04-27', '13:06:32'),
	(186, 0, 24, 'myProject-Customer-24', 'Shubham Saurabh sent you a price for your project. Click here to open it', 'Unread', '2020-04-27', '13:07:21'),
	(187, 0, 35, 'myProject-Affiliate-35', 'Henri Jong sent you a project. Click here to open it', 'Read', '2020-04-28', '02:25:46'),
	(188, 0, 26, 'myProject-Customer-26', 'Henri  Jong  sent you a price for your project. Click here to open it', 'Read', '2020-04-28', '02:26:58'),
	(189, 0, 26, 'myorders-Customer-26', 'Your Order has been placed. Please click here to check order status', 'Read', '2020-04-28', '09:40:21'),
	(190, 0, 26, 'myorders-Customer-26', 'Your Order has been placed. Please click here to check order status', 'Read', '2020-04-28', '09:44:46'),
	(191, 0, 24, 'myorders-Customer-24', 'Your Order has been placed. Please click here to check order status', 'Unread', '2020-04-28', '09:54:13'),
	(192, 0, 16, '', '', 'Unread', '2020-04-28', '13:36:47'),
	(193, 0, 24, 'myorders-Customer-24', 'Your Order has been placed. Please click here to check order status', 'Unread', '2020-04-28', '18:06:24'),
	(194, 0, 24, 'myorders-Customer-24', 'Your Order has been placed. Please click here to check order status', 'Unread', '2020-04-28', '18:11:34'),
	(195, 0, 25, 'myProject-Affiliate-25', 'Anand Rastogi sent you a project. Click here to open it', 'Unread', '2020-04-28', '18:14:38'),
	(196, 0, 24, 'myProject-Customer-24', 'Shubham Saurabh sent you a price for your project. Click here to open it', 'Unread', '2020-04-28', '18:16:25'),
	(197, 0, 25, 'myProject-Affiliate-25', 'Anand Rastogi sent you a project. Click here to open it', 'Unread', '2020-04-29', '05:39:05'),
	(198, 0, 35, 'myProject-Affiliate-35', 'Anand Rastogi sent you a project. Click here to open it', 'Read', '2020-04-29', '05:39:05'),
	(199, 0, 36, 'myProject-Affiliate-36', 'Anand Rastogi sent you a project. Click here to open it', 'Read', '2020-04-29', '05:39:06'),
	(200, 0, 24, 'myProject-Customer-24', 'Shubham Saurabh sent you a price for your project. Click here to open it', 'Unread', '2020-04-29', '05:39:54'),
	(201, 0, 24, 'myorders-Customer-24', 'Your Order has been placed. Please click here to check order status', 'Unread', '2020-04-29', '05:47:17'),
	(202, 0, 36, 'myorders-Customer-36', 'Your Order has been placed. Please click here to check order status', 'Unread', '2020-04-29', '06:19:01'),
	(203, 0, 36, 'myorders-Customer-36', 'Your Order has been placed. Please click here to check order status', 'Unread', '2020-04-29', '06:19:03'),
	(204, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-29', '15:54:14'),
	(205, 0, 35, 'myProject-Affiliate-35', 'Laurence Vanessa Mboah sent you a project. Click here to open it', 'Read', '2020-04-29', '16:05:22'),
	(206, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-29', '16:07:05'),
	(207, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-04-29', '16:10:17'),
	(208, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-04-29', '16:25:58'),
	(209, 0, 35, 'myProject-Affiliate-35', 'jeremie miyouna sent you a project. Click here to open it', 'Read', '2020-04-30', '11:32:38'),
	(210, 0, 35, 'meeting-Affiliate-35', 'jeremie miyouna sent you a a request for meeting. Click here to open it', 'Read', '2020-04-30', '11:37:30'),
	(211, 0, 46, 'myProject-Customer-46', 'Henri  Jong  sent you a price for your project. Click here to open it', 'Read', '2020-04-30', '11:45:11'),
	(212, 0, 46, 'meeting-Customer-46', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-30', '11:45:29'),
	(213, 0, 46, 'meeting-Customer-46', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-30', '11:45:30'),
	(214, 0, 35, 'meeting-Affiliate-35', 'jeremie miyouna sent you a a request for meeting. Click here to open it', 'Read', '2020-04-30', '12:01:25'),
	(215, 0, 35, 'meeting-Affiliate-35', 'jeremie miyouna sent you a a request for meeting. Click here to open it', 'Read', '2020-04-30', '12:02:08'),
	(216, 0, 46, 'meeting-Customer-46', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-30', '12:02:42'),
	(217, 0, 46, 'meeting-Customer-46', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-04-30', '12:02:46'),
	(218, 0, 35, 'meeting-Affiliate-35', 'Annie Ngono sent you a a request for meeting. Click here to open it', 'Read', '2020-05-01', '22:23:30'),
	(219, 0, 48, 'meeting-Customer-48', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-05-01', '22:24:16'),
	(220, 0, 35, 'myProject-Affiliate-35', 'Annie Ngono sent you a project. Click here to open it', 'Read', '2020-05-01', '22:27:58'),
	(221, 0, 36, 'myProject-Affiliate-36', 'Annie Ngono sent you a project. Click here to open it', 'Unread', '2020-05-01', '22:27:58'),
	(222, 0, 48, 'myProject-Customer-48', 'Henri  Jong  sent you a price for your project. Click here to open it', 'Read', '2020-05-01', '22:28:53'),
	(223, 0, 35, 'myProject-Affiliate-35', 'Laurence Vanessa Mboah sent you a project. Click here to open it', 'Read', '2020-05-05', '11:24:11'),
	(224, 0, 34, 'myProject-Customer-34', 'Henri  Jong  sent you a price for your project. Click here to open it', 'Read', '2020-05-05', '11:26:54'),
	(225, 0, 34, 'myorders-Customer-34', 'Your Order has been placed. Please click here to check order status', 'Unread', '2020-05-05', '11:43:30'),
	(226, 0, 34, 'myorders-Customer-34', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-05-05', '11:48:20'),
	(227, 0, 34, 'myorders-Customer-34', 'Your Order status has been updated. Please click here to check.', 'Unread', '2020-05-05', '12:00:45'),
	(228, 0, 35, 'meeting-Affiliate-35', 'Laurence Vanessa Mboah sent you a a request for meeting. Click here to open it', 'Read', '2020-05-05', '12:12:46'),
	(229, 0, 34, 'meeting-Customer-34', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-05-05', '12:17:37'),
	(230, 0, 49, 'myorders-Customer-49', 'Your Order has been placed. Please click here to check order status', 'Read', '2020-05-05', '15:27:53'),
	(231, 0, 49, 'myorders-Customer-49', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-05-05', '15:31:35'),
	(232, 0, 49, 'myorders-Customer-49', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-05-05', '15:37:24'),
	(233, 0, 49, 'myorders-Customer-49', 'Your Order status has been updated. Please click here to check.', 'Read', '2020-05-05', '15:37:41'),
	(234, 0, 35, 'meeting-Affiliate-35', 'Elodie Ach sent you a a request for meeting. Click here to open it', 'Read', '2020-05-05', '15:45:57'),
	(235, 0, 49, 'meeting-Customer-49', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-05-05', '15:47:15'),
	(236, 0, 35, 'myProject-Affiliate-35', 'Elodie Ach sent you a project. Click here to open it', 'Read', '2020-05-05', '17:39:27'),
	(237, 0, 49, 'myProject-Customer-49', 'Henri  Jong  sent you a price for your project. Click here to open it', 'Read', '2020-05-05', '17:43:42'),
	(238, 0, 35, 'myorders-Affiliate-35', 'Your Order has been placed. Please click here to check order status', 'Read', '2020-05-06', '04:50:18'),
	(239, 0, 35, 'myorders-Affiliate-35', 'Your Order has been placed. Please click here to check order status', 'Read', '2020-05-06', '04:55:04'),
	(240, 0, 35, 'meeting-Affiliate-35', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Read', '2020-05-06', '04:58:27'),
	(241, 0, 26, 'meeting-Customer-26', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-05-06', '04:58:57'),
	(242, 0, 35, 'myorders-Affiliate-35', 'Your Order has been placed. Please click here to check order status', 'Read', '2020-05-06', '23:40:53'),
	(243, 0, 35, 'meeting-Affiliate-35', 'chetan  verma sent you a a request for meeting. Click here to open it', 'Read', '2020-05-07', '10:46:30'),
	(244, 0, 32, 'meeting-Affiliate-32', 'chetan  verma sent you a a request for meeting. Click here to open it', 'Unread', '2020-05-07', '10:48:50'),
	(245, 0, 42, 'meeting-Customer-42', 'Hello, Henri  Jong  accepted your meeting.', 'Unread', '2020-05-07', '10:53:38'),
	(246, 0, 39, 'meeting-Affiliate-39', 'Lionel Ekabouma sent you a a request for meeting. Click here to open it', 'Unread', '2020-05-07', '11:18:52'),
	(247, 0, 41, 'meeting-Customer-41', 'Hello, Kamal Kishor accepted your meeting.', 'Unread', '2020-05-07', '11:19:05'),
	(248, 0, 39, 'meeting-Affiliate-39', 'Lionel Ekabouma sent you a a request for meeting. Click here to open it', 'Unread', '2020-05-07', '11:34:33'),
	(249, 0, 41, 'meeting-Customer-41', 'Hello, Kamal Kishor accepted your meeting.', 'Unread', '2020-05-07', '11:34:59'),
	(250, 0, 39, 'meeting-Affiliate-39', 'Henri Jong sent you a a request for meeting. Click here to open it', 'Unread', '2020-05-07', '11:39:08'),
	(251, 0, 35, 'meeting-Affiliate-35', 'Annie Ngono sent you a a request for meeting. Click here to open it', 'Read', '2020-05-08', '10:00:12'),
	(252, 0, 48, 'meeting-Customer-48', 'Hello, Henri  Jong  accepted your meeting.', 'Read', '2020-05-08', '10:00:36'),
	(253, 0, 36, 'meeting-Affiliate-36', 'Steve Ndjeunou sent you a a request for meeting. Click here to open it', 'Read', '2020-05-13', '13:25:32'),
	(254, 0, 36, 'meeting-Customer-36', 'Hello, Steve Ndjeunou accepted your meeting.', 'Unread', '2020-05-13', '13:26:20');
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;

-- Export de la structure de la table plumers. orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) NOT NULL,
  `checkout_order_id` longtext COLLATE utf8_unicode_ci NOT NULL,
  `checkout_id` longtext COLLATE utf8_unicode_ci NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `qty` bigint(20) NOT NULL,
  `product_price` float(10,2) NOT NULL,
  `product_price_currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'usd',
  `paid_amount` float(10,2) NOT NULL,
  `paid_amount_currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `wallet_amount_used` float(10,2) NOT NULL,
  `coupon_id` bigint(20) NOT NULL,
  `coupon_discount` bigint(20) NOT NULL,
  `txn_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `transit_status` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `date_delivery` date DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.orders : ~49 rows (environ)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `product_id`, `checkout_order_id`, `checkout_id`, `order_id`, `user_id`, `qty`, `product_price`, `product_price_currency`, `paid_amount`, `paid_amount_currency`, `wallet_amount_used`, `coupon_id`, `coupon_discount`, `txn_id`, `payment_status`, `transit_status`, `created_date`, `date_delivery`, `delivery_date`) VALUES
	(3, 5, '4', 'fb89b8813155bf4fbd2c7c2ebcd0a911', 1587193472, 26, 4, 2400.00, 'cad', 2759.00, 'cad', 0.00, 0, 0, 'pi_1GZAi3HB8hPb9oPMrNM2nygj', 'succeeded', 'Order Placed', '2020-04-18 03:04:34', NULL, NULL),
	(4, 4, '6', '3556b2dcbc2fe22db5653fdd8ff48cf5', 1587249264, 34, 1, 523.61, 'cad', 602.00, 'cad', 0.00, 0, 0, 'pi_1GZPCwHB8hPb9oPMVwrGWftg', 'succeeded', 'Order Placed', '2020-04-18 18:34:28', NULL, NULL),
	(5, 4, '7', 'edf8cb57bae1008bb8493de9a85b6d2c', 1587289491, 24, 2, 1047.22, 'cad', 1204.04, 'cad', 0.00, 0, 0, 'pi_1GZZhVHB8hPb9oPMrendrA3m', 'succeeded', 'Order in Delivery', '2020-04-19 05:44:53', NULL, NULL),
	(6, 6, '8', '93cd8c683c295bde521984432672adc8', 1587293977, 24, 1, 644.00, 'cad', 623.70, 'cad', 50.00, 0, 0, 'pi_1GZarfHB8hPb9oPMxb7RwZ6P', 'succeeded', 'Order in Delivery', '2020-04-19 06:59:38', NULL, NULL),
	(7, 5, '9', '8615c801739c1fff42931d2f95528642', 1587294692, 24, 1, 600.00, 'cad', 610.20, 'cad', 0.00, 3, 10, 'pi_1GZb3GHB8hPb9oPMy4L4fv7L', 'succeeded', 'Order is Delivered', '2020-04-19 07:11:33', NULL, NULL),
	(8, 4, '10', 'bf4e16c67f78e115f2cf070f59737000', 1587305794, 35, 3, 1570.83, 'cad', 180606.00, 'cad', 0.00, 0, 0, 'pi_1GZdwKHB8hPb9oPMYPFpGwn1', 'succeeded', 'Order is in Production', '2020-04-19 10:16:35', NULL, NULL),
	(9, 5, '11', 'ac5578f4702a226dcecbb55c39a0a0d1', 1587307105, 26, 1, 600.00, 'cad', 1893.00, 'cad', 0.00, 0, 0, 'pi_1GZeHMHB8hPb9oPM2Zosv2sE', 'succeeded', 'Order Placed', '2020-04-19 10:38:27', NULL, NULL),
	(10, 4, '12', 'ac5578f4702a226dcecbb55c39a0a0d1', 1587307105, 26, 2, 1047.22, 'cad', 1893.00, 'cad', 0.00, 0, 0, 'pi_1GZeHMHB8hPb9oPM2Zosv2sE', 'succeeded', 'Order is in Production', '2020-04-19 10:38:27', NULL, NULL),
	(11, 4, '13', '692c85ff64b4128df51405db59640fc5', 1587309667, 24, 3, 1570.83, 'cad', 1806.00, 'cad', 0.00, 0, 0, 'pi_1GZewuHB8hPb9oPM4Wt8E6d2', 'succeeded', 'Order in Delivery', '2020-04-19 11:21:09', NULL, NULL),
	(12, 5, '14', '48e3b1b33289849d3f692d0415b6b723', 1587309716, 26, 1, 600.00, 'cad', 6710.00, 'cad', 0.00, 0, 0, 'pi_1GZexZHB8hPb9oPM9cTvJKty', 'succeeded', 'Order in Delivery', '2020-04-19 11:22:00', NULL, NULL),
	(13, 4, '15', '48e3b1b33289849d3f692d0415b6b723', 1587309716, 26, 10, 5236.10, 'cad', 6710.00, 'cad', 0.00, 0, 0, 'pi_1GZexZHB8hPb9oPM9cTvJKty', 'succeeded', 'Order Placed', '2020-04-19 11:22:00', NULL, NULL),
	(14, 5, '16', '2bb2eff523230ff2a2cf8fcf6a5fbdb8', 1587311555, 26, 1, 600.00, 'cad', 3097.00, 'cad', 0.00, 0, 0, 'pi_1GZfRAHB8hPb9oPM1rpZtouF', 'succeeded', 'Order Placed', '2020-04-19 11:52:36', NULL, NULL),
	(15, 4, '17', '2bb2eff523230ff2a2cf8fcf6a5fbdb8', 1587311555, 26, 4, 2094.44, 'cad', 3097.00, 'cad', 0.00, 0, 0, 'pi_1GZfRAHB8hPb9oPM1rpZtouF', 'succeeded', 'Order Placed', '2020-04-19 11:52:36', NULL, NULL),
	(16, 6, '18', '4b7d6d889d5f111159a371156b681878', 1587313124, 26, 7, 4508.00, 'cad', 12081.00, 'cad', 0.00, 0, 0, 'pi_1GZfqWHB8hPb9oPMp7AVb1wt', 'succeeded', 'Order Placed', '2020-04-19 12:18:46', NULL, NULL),
	(17, 5, '19', '4b7d6d889d5f111159a371156b681878', 1587313124, 26, 10, 6000.00, 'cad', 12081.00, 'cad', 0.00, 0, 0, 'pi_1GZfqWHB8hPb9oPMp7AVb1wt', 'succeeded', 'Order in Delivery', '2020-04-19 12:18:46', NULL, NULL),
	(18, 5, '20', '4bcec55097fa85373fbacbe052050231', 1587315293, 26, 2, 1200.00, 'cad', 1379.00, 'cad', 0.00, 0, 0, 'pi_1GZgPCHB8hPb9oPMRkyaTjVY', 'succeeded', 'Order is in Production', '2020-04-19 12:54:55', NULL, NULL),
	(19, 6, '21', '6d1f20d6e8a65b5526d6af0fc256b420', 1587320289, 26, 1, 644.00, 'cad', 2120.00, 'cad', 0.00, 0, 0, 'pi_1GZhhvHB8hPb9oPM3TjlyqtM', 'succeeded', 'Order is in Production', '2020-04-19 14:18:11', NULL, NULL),
	(20, 5, '22', '6d1f20d6e8a65b5526d6af0fc256b420', 1587320289, 26, 2, 1200.00, 'cad', 2120.00, 'cad', 0.00, 0, 0, 'pi_1GZhhvHB8hPb9oPM3TjlyqtM', 'succeeded', 'Order is in Production', '2020-04-19 14:18:11', NULL, NULL),
	(21, 6, '23', '2d783051c4caf304fe9ca4102b07f205', 1587321096, 26, 4, 2576.00, 'cad', 3651.00, 'cad', 0.00, 0, 0, 'pi_1GZhuvHB8hPb9oPMLohkWMJi', 'succeeded', 'Order Placed', '2020-04-19 14:31:37', NULL, NULL),
	(22, 5, '24', '2d783051c4caf304fe9ca4102b07f205', 1587321096, 26, 1, 600.00, 'cad', 3651.00, 'cad', 0.00, 0, 0, 'pi_1GZhuvHB8hPb9oPMLohkWMJi', 'succeeded', 'Order is in Production', '2020-04-19 14:31:37', NULL, NULL),
	(23, 6, '28', '4cdda760b7b17ca5efea68de733d38db', 1587463376, 36, 3, 1932.00, 'cad', 3704.49, 'cad', 0.00, 3, 10, 'pi_1GaIwHHB8hPb9oPMbnJvnjmS', 'succeeded', 'Order in Delivery', '2020-04-21 06:02:59', NULL, NULL),
	(24, 5, '29', '4cdda760b7b17ca5efea68de733d38db', 1587463376, 36, 1, 600.00, 'cad', 3704.49, 'cad', 0.00, 3, 10, 'pi_1GaIwHHB8hPb9oPMbnJvnjmS', 'succeeded', 'Order in Delivery', '2020-04-21 06:02:59', NULL, NULL),
	(25, 4, '30', '4cdda760b7b17ca5efea68de733d38db', 1587463376, 36, 2, 1047.22, 'cad', 3704.49, 'cad', 0.00, 3, 10, 'pi_1GaIwHHB8hPb9oPMbnJvnjmS', 'succeeded', 'Order is Delivered', '2020-04-21 06:02:59', NULL, '2020-06-11 11:14:20'),
	(26, 5, '31', 'be8805bd0616a2c807f3fad92e7a11ee', 1587463403, 35, 1, 600.00, 'cad', 551.00, 'cad', 0.00, 6, 20, 'pi_1GaIwNHB8hPb9oPMwv8M4HJN', 'succeeded', 'Order is Delivered', '2020-04-21 06:03:25', '2020-06-18', '2020-06-11 13:22:25'),
	(27, 6, '32', '8efa310ee8961b433b9f3baa2af1cdb5', 1587464273, 26, 1, 644.00, 'cad', 1144.00, 'cad', 0.00, 6, 20, 'pi_1GaJALHB8hPb9oPMN5lgGp6i', 'succeeded', 'Order Placed', '2020-04-21 06:17:55', NULL, NULL),
	(28, 5, '33', '8efa310ee8961b433b9f3baa2af1cdb5', 1587464273, 26, 1, 600.00, 'cad', 1144.00, 'cad', 0.00, 6, 20, 'pi_1GaJALHB8hPb9oPMN5lgGp6i', 'succeeded', 'Order Placed', '2020-04-21 06:17:55', NULL, NULL),
	(29, 5, '34', '9a63ddab3c36ef13e7f6ab32c36ecbe9', 1587464419, 26, 1, 600.00, 'cad', 4903.00, 'cad', 0.00, 0, 0, 'pi_1GaJChHB8hPb9oPMZSTfDLrF', 'succeeded', 'Order Placed', '2020-04-21 06:20:20', NULL, NULL),
	(30, 4, '35', '9a63ddab3c36ef13e7f6ab32c36ecbe9', 1587464419, 26, 7, 3665.27, 'cad', 4903.00, 'cad', 0.00, 0, 0, 'pi_1GaJChHB8hPb9oPMZSTfDLrF', 'succeeded', 'Order in Delivery', '2020-04-21 06:20:20', NULL, NULL),
	(31, 5, '36', '91f05619d942baef39efc0d31155f9ff', 1587474621, 32, 1, 600.00, 'cad', 689.00, 'cad', 0.00, 0, 0, 'pi_1GaLq1HB8hPb9oPMnfsZWK4U', 'succeeded', 'Order in Delivery', '2020-04-21 09:10:25', NULL, NULL),
	(32, 5, '37', 'e2948486617203a27d944c88791ead64', 1588081219, 26, 1, 600.00, 'cad', 689.00, 'cad', 0.00, 0, 0, 'pi_1GctdjHB8hPb9oPMfGFCgGuO', 'succeeded', 'Order Placed', '2020-04-28 09:40:21', NULL, NULL),
	(33, 4, '38', 'ea00b36d28867c91b3837b4969a5f41d', 1588081484, 26, 1, 523.61, 'cad', 602.00, 'cad', 0.00, 0, 0, 'pi_1GctjTHB8hPb9oPMSXfI6mCX', 'succeeded', 'Order Placed', '2020-04-28 09:44:46', NULL, NULL),
	(34, 5, '39', 'dddd63765056689469443610231848e0', 1588082051, 24, 1, 600.00, 'cad', 689.85, 'cad', 0.00, 0, 0, 'pi_1GctsjHB8hPb9oPMImI8ptUT', 'succeeded', 'Order Placed', '2020-04-28 09:54:13', NULL, NULL),
	(35, 4, '40', '85c5f3688f31866ef29295fe549141e4', 1588095404, 16, 1, 523.61, 'cad', 602.15, 'cad', 0.00, 0, 0, 'pi_1GcxLVHB8hPb9oPMGL2a67FJ', 'succeeded', 'Order Placed', '2020-04-28 13:36:47', NULL, NULL),
	(36, 5, '41', '6b9a022a12bf5ea9d4724f0adaf49083', 1588111581, 24, 1, 600.00, 'cad', 689.85, 'cad', 0.00, 0, 0, 'pi_1Gd1YrHB8hPb9oPMjFcDgR0i', 'succeeded', 'Order in Delivery', '2020-04-28 18:06:23', NULL, NULL),
	(37, 6, '42', '4c5fec070eaafd4eb8deea8b259123c0', 1588111892, 24, 1, 644.00, 'cad', 1335.56, 'cad', 6.00, 0, 0, 'pi_1Gd1e4HB8hPb9oPMnVlUcfZr', 'succeeded', 'Order Placed', '2020-04-28 18:11:34', NULL, NULL),
	(38, 4, '43', '4c5fec070eaafd4eb8deea8b259123c0', 1588111892, 24, 1, 523.61, 'cad', 1335.56, 'cad', 6.00, 0, 0, 'pi_1Gd1e4HB8hPb9oPMnVlUcfZr', 'succeeded', 'Order Placed', '2020-04-28 18:11:34', NULL, NULL),
	(39, 5, '44', '3ffb5ad033e39a3d104030e71f56405d', 1588153635, 24, 1, 600.00, 'cad', 676.42, 'cad', 11.68, 0, 0, 'pi_1GdCV2HB8hPb9oPMk3YVZvcY', 'succeeded', 'Order Placed', '2020-04-29 05:47:17', NULL, NULL),
	(40, 6, '48', 'bb3f28303f172b5d6bc3b7eaca14b9e9', 1588155539, 36, 1, 644.00, 'cad', 1855.99, 'cad', 0.00, 0, 0, 'pi_1GdCzsHB8hPb9oPMQkHYgoyT', 'succeeded', 'Order in Delivery', '2020-04-29 06:19:01', '2020-06-22', NULL),
	(41, 5, '49', 'bb3f28303f172b5d6bc3b7eaca14b9e9', 1588155539, 36, 1, 600.00, 'cad', 1855.99, 'cad', 0.00, 0, 0, 'pi_1GdCzsHB8hPb9oPMQkHYgoyT', 'succeeded', 'Order Placed', '2020-04-29 06:19:01', NULL, NULL),
	(42, 4, '50', 'bb3f28303f172b5d6bc3b7eaca14b9e9', 1588155539, 36, 1, 523.61, 'cad', 1855.99, 'cad', 0.00, 0, 0, 'pi_1GdCzsHB8hPb9oPMQkHYgoyT', 'succeeded', 'Order in Delivery', '2020-04-29 06:19:01', NULL, NULL),
	(43, 6, '48', 'bb3f28303f172b5d6bc3b7eaca14b9e9', 1588155539, 36, 1, 644.00, 'cad', 1855.99, 'cad', 0.00, 0, 0, 'pi_1GdD0IHB8hPb9oPMQ1MkJpsy', 'succeeded', 'Order is in Production', '2020-04-29 06:19:03', '2020-06-24', NULL),
	(44, 5, '49', 'bb3f28303f172b5d6bc3b7eaca14b9e9', 1588155539, 36, 1, 600.00, 'cad', 1855.99, 'cad', 0.00, 0, 0, 'pi_1GdD0IHB8hPb9oPMQ1MkJpsy', 'succeeded', 'Order Placed', '2020-04-29 06:19:03', '2020-06-11', NULL),
	(45, 4, '50', 'bb3f28303f172b5d6bc3b7eaca14b9e9', 1588155539, 36, 1, 523.61, 'cad', 1855.99, 'cad', 0.00, 0, 0, 'pi_1GdD0IHB8hPb9oPMQ1MkJpsy', 'succeeded', 'Order is in Production', '2020-04-29 06:19:03', '2020-06-28', NULL),
	(46, 6, '51', '82da575ea6b813613b27abde8925cb0b', 1588693407, 34, 1, 644.00, 'cad', 740.00, 'cad', 0.00, 0, 0, 'pi_1GfSupHB8hPb9oPMpHH6DAea', 'succeeded', 'Order in Delivery', '2020-05-05 11:43:30', '2020-06-24', NULL),
	(47, 6, '52', '03b59658a3755a6bc429dbefa19df964', 1588706870, 49, 1, 644.00, 'cad', 2120.00, 'cad', 0.00, 0, 0, 'pi_1GfWHzHB8hPb9oPMYHuLTG5i', 'succeeded', 'Order is Delivered', '2020-05-05 15:27:52', NULL, NULL),
	(48, 5, '53', '03b59658a3755a6bc429dbefa19df964', 1588706870, 49, 2, 1200.00, 'cad', 2120.00, 'cad', 0.00, 0, 0, 'pi_1GfWHzHB8hPb9oPMYHuLTG5i', 'succeeded', 'Order is Delivered', '2020-05-05 15:27:52', NULL, '2020-06-11 13:47:03'),
	(49, 6, '54', '29436855b7c7325931a2774025883336', 1588755016, 35, 20, 12880.00, 'cad', 14808.00, 'cad', 0.00, 0, 0, 'pi_1GfiwcHB8hPb9oPMBudlKK0E', 'succeeded', 'Order is Delivered', '2020-05-06 04:50:18', NULL, NULL),
	(50, 6, '55', '8010a8f180adf970c2bcfcd08eb21f32', 1588755302, 35, 20, 12880.00, 'cad', 14660.00, 'cad', 128.80, 0, 0, 'pi_1Gfj1KHB8hPb9oPMwLcWMJ1h', 'succeeded', 'Order is Delivered', '2020-05-06 04:55:04', NULL, NULL),
	(51, 6, '56', 'b5eee29c5bc60c1ad36b9b35b9d7fa9b', 1588822851, 35, 1, 644.00, 'cad', 592.00, 'cad', 128.80, 0, 0, 'pi_1Gg0auHB8hPb9oPMMBE2KfAz', 'succeeded', 'Order is Delivered', '2020-05-06 23:40:53', '2020-06-30', NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Export de la structure de la table plumers. order_delivery_date
CREATE TABLE IF NOT EXISTS `order_delivery_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) NOT NULL,
  `delivery_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.order_delivery_date : ~9 rows (environ)
/*!40000 ALTER TABLE `order_delivery_date` DISABLE KEYS */;
INSERT INTO `order_delivery_date` (`id`, `order_id`, `delivery_date`) VALUES
	(2, 1587315293, '2020-04-30'),
	(3, 1587293977, '2020-04-15'),
	(4, 1587321096, '2020-04-23'),
	(5, 1587320289, '2020-04-24'),
	(6, 1587463376, '2020-04-30'),
	(7, 1587463403, '2020-05-30'),
	(8, 1587474621, '2020-04-30'),
	(9, 1588693407, '2020-05-31'),
	(10, 1588706870, '2020-06-02');
/*!40000 ALTER TABLE `order_delivery_date` ENABLE KEYS */;

-- Export de la structure de la table plumers. patient
CREATE TABLE IF NOT EXISTS `patient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `sexe` varchar(50) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `date_nais` date NOT NULL,
  `groupe` varchar(50) NOT NULL,
  `poids` float NOT NULL,
  `taille` float NOT NULL,
  `etat` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.patient : ~1 rows (environ)
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` (`id`, `nom`, `prenom`, `sexe`, `numero`, `date_nais`, `groupe`, `poids`, `taille`, `etat`, `created_at`, `updated_at`) VALUES
	(2, 'Toko', 'paloma', 'FEMININ', '677777777', '1999-09-02', 'A-', 50, 1.9, 1, '2020-09-07 23:50:37', '2020-09-08 00:29:06');
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;

-- Export de la structure de la table plumers. privacypolicy
CREATE TABLE IF NOT EXISTS `privacypolicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `contenu` longtext CHARACTER SET latin1,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.privacypolicy : ~1 rows (environ)
/*!40000 ALTER TABLE `privacypolicy` DISABLE KEYS */;
INSERT INTO `privacypolicy` (`id`, `titre`, `contenu`, `date`) VALUES
	(6, 'premier', '<!--[if gte mso 9]><xml> <o:OfficeDocumentSettings>  <o:AllowPNG></o:AllowPNG> </o:OfficeDocumentSettings></xml><![endif]--><!--[if gte mso 9]><xml> <w:WordDocument>  <w:View>Normal</w:View>  <w:Zoom>0</w:Zoom>  <w:TrackMoves></w:TrackMoves>  <w:TrackFormatting></w:TrackFormatting>  <w:HyphenationZone>21</w:HyphenationZone>  <w:PunctuationKerning></w:PunctuationKerning>  <w:ValidateAgainstSchemas></w:ValidateAgainstSchemas>  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>  <w:DoNotPromoteQF></w:DoNotPromoteQF>  <w:LidThemeOther>FR</w:LidThemeOther>  <w:LidThemeAsian>X-NONE</w:LidThemeAsian>  <w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript>  <w:Compatibility>   <w:BreakWrappedTables></w:BreakWrappedTables>   <w:SnapToGridInCell></w:SnapToGridInCell>   <w:WrapTextWithPunct></w:WrapTextWithPunct>   <w:UseAsianBreakRules></w:UseAsianBreakRules>   <w:DontGrowAutofit></w:DontGrowAutofit>   <w:SplitPgBreakAndParaMark></w:SplitPgBreakAndParaMark>   <w:EnableOpenTypeKerning></w:EnableOpenTypeKerning>   <w:DontFlipMirrorIndents></w:DontFlipMirrorIndents>   <w:OverrideTableStyleHps></w:OverrideTableStyleHps>  </w:Compatibility>  <m:mathPr>   <m:mathFont m:val="Cambria Math"></m:mathFont>   <m:brkBin m:val="before"></m:brkBin>   <m:brkBinSub m:val="', '2020-05-20 16:16:03');
/*!40000 ALTER TABLE `privacypolicy` ENABLE KEYS */;

-- Export de la structure de la table plumers. products
CREATE TABLE IF NOT EXISTS `products` (
  `productid` int(11) NOT NULL AUTO_INCREMENT,
  `productname` varchar(255) CHARACTER SET latin1 NOT NULL,
  `category_id` varchar(100) CHARACTER SET latin1 NOT NULL,
  `slug` varchar(255) CHARACTER SET latin1 NOT NULL,
  `description` longtext CHARACTER SET latin1 NOT NULL,
  `image` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'http://adminjwell.log/public/assets/img/logo.png',
  `price` varchar(200) CHARACTER SET latin1 NOT NULL,
  `offer_price` varchar(255) CHARACTER SET latin1 NOT NULL,
  `discount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sub_category` varchar(255) CHARACTER SET latin1 NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `length` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `width` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `height` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `weight` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `deal` int(11) NOT NULL DEFAULT '1',
  `best_sellers` int(11) NOT NULL DEFAULT '1',
  `new_arrival` int(11) NOT NULL DEFAULT '1',
  `special_offer` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`productid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.products : ~3 rows (environ)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`productid`, `productname`, `category_id`, `slug`, `description`, `image`, `price`, `offer_price`, `discount`, `sub_category`, `qty`, `length`, `width`, `height`, `weight`, `deal`, `best_sellers`, `new_arrival`, `special_offer`, `status`, `created_on`, `updated_on`) VALUES
	(1, 'Iphone 11 pro', '1', 'iphone_11_pro', 'best iphone best pro<br>', 'http://adminjwell.log/public/articles/iphone_11_pro_be6103e1494d02fdbb6f6a51cf66c448.jpg', '2000', '1999', '0.05', '1', 100, '', '', '', '', 2, 1, 2, 2, 1, '2020-07-20 23:09:52', '2020-07-20 23:55:30'),
	(2, 'Photo pro', '1', 'photo_pro', 'photo pro 11<br>', 'http://adminjwell.log/public/articles/_bd4c28641477b1da74a2d714415e2da8.jpg', '500', '250', '50.00', '2', 90, '', '', '', '', 1, 1, 1, 2, 1, '2020-07-20 23:52:02', '2020-07-20 23:57:09'),
	(3, 'Photos folo', '1', 'photos_folo', 'cameros', 'http://adminjwell.log/public/articles/photos_folo_317867e28d8660eaa10669d03ca7cc4f.jpg', '900', '500', '44.44', '2', 0, '', '', '', '', 2, 2, 2, 2, 1, '2020-07-21 00:32:02', '2020-07-21 00:37:59');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Export de la structure de la table plumers. productsimage
CREATE TABLE IF NOT EXISTS `productsimage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` varchar(255) CHARACTER SET latin1 NOT NULL,
  `image` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.productsimage : ~1 rows (environ)
/*!40000 ALTER TABLE `productsimage` DISABLE KEYS */;
INSERT INTO `productsimage` (`id`, `productid`, `image`, `created_on`) VALUES
	(1, '2', 'http://adminjwell.log/public/articles/_b2fef05c4825d88c0b1b0dfb66cc71d0.png', '2020-07-20 22:58:16');
/*!40000 ALTER TABLE `productsimage` ENABLE KEYS */;

-- Export de la structure de la table plumers. product_review
CREATE TABLE IF NOT EXISTS `product_review` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `rating` bigint(20) NOT NULL,
  `review` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.product_review : 0 rows
/*!40000 ALTER TABLE `product_review` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_review` ENABLE KEYS */;

-- Export de la structure de la table plumers. profil
CREATE TABLE IF NOT EXISTS `profil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `privilege` text CHARACTER SET latin1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.profil : ~2 rows (environ)
/*!40000 ALTER TABLE `profil` DISABLE KEYS */;
INSERT INTO `profil` (`id`, `nom`, `privilege`, `created_at`) VALUES
	(2, 'SuperAdmin', 'DASHBOARD_VIEW,DASHBOARD_AFFAIRE,RETRAIT_VIEW,RETRAIT_ETAT,RETRAIT_VALID,RETRAIT_CANCEL,MEETING_VIEW,MEETING_ETAT,CMD_VIEW,CMD_ETAT,CMD_VALID,PRODUCT_VIEW,PRODUCT_ETAT,PRODUCT_EDIT,PRODUCT_ACTIVE,PRODUCT_DESACTIVE,PRODUCT_ADD,PRODUCT_DEAL,PRODUCT_STOCKADD,PRODUCT_STOCKMOVE,PRODUCT_IMGCHANGE,PRODUCT_IMGADD,PRODUCT_IMGDELETE,PRODUCT_NOTE,PRODUCT_SALE,PRODUCT_SALEETAT,PRODUCT_DEALVIEW,PRODUCT_DEALACTIVE,PRODUCT_DEALDESACTIVE,PRODUCT_CATVIEW,PRODUCT_CATADD,PRODUCT_CATEDIT,PRODUCT_CATIMG,PRODUCT_CATDELETE,PRODUCT_SUBCATVIEW,PRODUCT_SUBCATADD,PRODUCT_SUBCATEDIT,PRODUCT_SUBCATIMG,PRODUCT_SUBCATDELETE,PROJECT_CLIENTVIEW,PROJECT_AFFILIEVIEW,USER_CLIENTVIEW,USER_CLIENTADD,USER_CLIENTRESET,USER_CLIENTACTIVE,USER_CLIENTDESACTIVE,USER_CLIENTCMDVIEW,USER_CLIENTPROJECTETAT,USER_CLIENTPROJECTVIEW,USER_AFFILIEVIEW,USER_AFFILIEADD,USER_AFFILIERESET,USER_AFFILIEACTIVE,USER_AFFILIEDESACTIVE,USER_AFFILIECMDVIEW,USER_AFFILIEPROJECTVIEW,USER_AFFILIEDMDRETRAITVIEW,USER_AFFILIEPROFOLIOVIEW,USER_AFFILIEPROJECTANS,USER_AFFILIEPROJ0CTETAT,USER_AFFILIEIMG,USER_AFFILIEIMGDEL,CONFIG_COUPONVIEW,CONFIG_COUPONADD,CONFIG_COUPONEDIT,CONFIG_COUPONDELETE,CONFIG_APPTEXTVIEW,CONFIG_APPTEXTEDIT,CONFIG_TAXEVIEW,CONFIG_TAXEADD,CONFIG_TAXEEDIT,CONFIG_TAXEDELETE,COUNCILS_VIEW,COUNCILS_CMDVIEW,COUNCILS_ACTIVE,COUNCILS_DESACTIVE,COUNCILS_DELETE,ADMIN_VIEW,ADMIN_ADD,ADMIN_EDIT,ADMIN_RESET,ADMIN_ACTIVE,ADMIN_DESACTIVE,ADMIN_EDITIMG,PROFIL_GESTION,OTHER_NEWVIEW,OTHER_NEWADD,OTHER_NEWEDIT,OTHER_NEWDELETE,OTHER_NEWCHANGEIMG,OTHER_VISITVIEW,OTHER_SUGESTIONVIEW', '2020-06-07 07:28:02'),
	(3, 'SuperAdmin', 'DASHBOARD_VIEW,DASHBOARD_AFFAIRE,RETRAIT_VIEW,RETRAIT_ETAT,RETRAIT_VALID,RETRAIT_CANCEL,MEETING_VIEW,MEETING_ETAT,CMD_VIEW,CMD_ETAT,CMD_VALID,PRODUCT_VIEW,PRODUCT_ETAT,PRODUCT_EDIT,PRODUCT_ACTIVE,PRODUCT_DESACTIVE,PRODUCT_ADD,PRODUCT_DEAL,PRODUCT_STOCKADD,PRODUCT_STOCKMOVE,PRODUCT_IMGCHANGE,PRODUCT_IMGADD,PRODUCT_IMGDELETE,PRODUCT_NOTE,PRODUCT_SALE,PRODUCT_SALEETAT,PRODUCT_DEALVIEW,PRODUCT_DEALACTIVE,PRODUCT_DEALDESACTIVE,PRODUCT_CATVIEW,PRODUCT_CATADD,PRODUCT_CATEDIT,PRODUCT_CATIMG,PRODUCT_CATDELETE,PRODUCT_SUBCATVIEW,PRODUCT_SUBCATADD,PRODUCT_SUBCATEDIT,PRODUCT_SUBCATIMG,PRODUCT_SUBCATDELETE,PROJECT_CLIENTVIEW,PROJECT_AFFILIEVIEW,USER_CLIENTVIEW,USER_CLIENTADD,USER_CLIENTRESET,USER_CLIENTACTIVE,USER_CLIENTDESACTIVE,USER_CLIENTCMDVIEW,USER_CLIENTPROJECTETAT,USER_CLIENTPROJECTVIEW,USER_AFFILIEVIEW,USER_AFFILIEADD,USER_AFFILIERESET,USER_AFFILIEACTIVE,USER_AFFILIEDESACTIVE,USER_AFFILIECMDVIEW,USER_AFFILIEPROJECTVIEW,USER_AFFILIEDMDRETRAITVIEW,USER_AFFILIEPROFOLIOVIEW,USER_AFFILIEPROJECTANS,USER_AFFILIEPROJ0CTETAT,USER_AFFILIEIMG,USER_AFFILIEIMGDEL,CONFIG_COUPONVIEW,CONFIG_COUPONADD,CONFIG_COUPONEDIT,CONFIG_COUPONDELETE,CONFIG_APPTEXTVIEW,CONFIG_APPTEXTEDIT,CONFIG_TAXEVIEW,CONFIG_TAXEADD,CONFIG_TAXEEDIT,CONFIG_TAXEDELETE,COUNCILS_VIEW,COUNCILS_CMDVIEW,COUNCILS_ACTIVE,COUNCILS_DESACTIVE,COUNCILS_DELETE,ADMIN_VIEW,ADMIN_ADD,ADMIN_EDIT,ADMIN_RESET,ADMIN_ACTIVE,ADMIN_DESACTIVE,ADMIN_EDITIMG,PROFIL_GESTION,OTHER_NEWVIEW,OTHER_NEWADD,OTHER_NEWEDIT,OTHER_NEWDELETE,OTHER_NEWCHANGEIMG,OTHER_VISITVIEW,OTHER_SUGESTIONVIEW', '2020-06-07 07:28:02');
/*!40000 ALTER TABLE `profil` ENABLE KEYS */;

-- Export de la structure de la table plumers. project_payment
CREATE TABLE IF NOT EXISTS `project_payment` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `project_request_for_affiliate_row_id` bigint(20) NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `project_price` float(10,2) NOT NULL,
  `project_price_currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'usd',
  `txn_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.project_payment : ~10 rows (environ)
/*!40000 ALTER TABLE `project_payment` DISABLE KEYS */;
INSERT INTO `project_payment` (`id`, `project_request_for_affiliate_row_id`, `project_id`, `project_price`, `project_price_currency`, `txn_id`, `payment_status`, `created_date`) VALUES
	(12, 1, 1, 450.00, 'cad', 'pi_1GZB6WHB8hPb9oPMYK73yYOq', 'succeeded', '2020-04-18 03:29:19'),
	(13, 4, 4, 450.00, 'cad', 'pi_1GZi0tHB8hPb9oPMBXDg8a28', 'succeeded', '2020-04-19 14:37:37'),
	(14, 5, 5, 560.00, 'cad', 'pi_1GaJ0QHB8hPb9oPMyWKRsuho', 'succeeded', '2020-04-21 06:07:38'),
	(15, 8, 7, 1000.00, 'cad', 'pi_1GaVqsHB8hPb9oPMyEayaz5g', 'succeeded', '2020-04-21 19:50:35'),
	(16, 9, 8, 500.00, 'cad', 'pi_1GcaR6HB8hPb9oPM8P5KnNOX', 'succeeded', '2020-04-27 13:08:41'),
	(17, 10, 9, 1500.00, 'cad', 'pi_1GcmvMHB8hPb9oPMEU4tChjB', 'succeeded', '2020-04-28 02:28:35'),
	(18, 11, 10, 100.00, 'cad', 'pi_1Gd1jLHB8hPb9oPM3elxviU7', 'succeeded', '2020-04-28 18:17:05'),
	(19, 12, 11, 100.00, 'cad', 'pi_1GdCOqHB8hPb9oPMudxU3Ra2', 'succeeded', '2020-04-29 05:40:36'),
	(20, 17, 14, 1000.00, 'cad', 'pi_1GeB6MHB8hPb9oPMcRnkdb8C', 'succeeded', '2020-05-01 22:29:48'),
	(21, 19, 15, 450.00, 'cad', 'pi_1GfSjBHB8hPb9oPM1y7Czei0', 'succeeded', '2020-05-05 11:35:36');
/*!40000 ALTER TABLE `project_payment` ENABLE KEYS */;

-- Export de la structure de la table plumers. project_request_for_affiliate
CREATE TABLE IF NOT EXISTS `project_request_for_affiliate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `customer_project_reguest_status` varchar(100) CHARACTER SET latin1 NOT NULL,
  `payment_bid_reguest_status` varchar(100) CHARACTER SET latin1 NOT NULL,
  `date` datetime NOT NULL,
  `customer_payment_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.project_request_for_affiliate : 20 rows
/*!40000 ALTER TABLE `project_request_for_affiliate` DISABLE KEYS */;
INSERT INTO `project_request_for_affiliate` (`id`, `affiliate_id`, `customer_id`, `project_id`, `customer_project_reguest_status`, `payment_bid_reguest_status`, `date`, `customer_payment_date`) VALUES
	(1, 27, 26, 1, 'Approved', 'Approved', '2020-04-18 03:26:42', '2020-04-18'),
	(2, 27, 34, 2, 'Approved', 'Pending', '2020-04-18 18:54:41', NULL),
	(3, 25, 36, 3, 'Pending', 'Pending', '2020-04-19 03:55:16', NULL),
	(4, 35, 26, 4, 'Approved', 'Approved', '2020-04-19 13:07:12', '2020-04-19'),
	(5, 35, 36, 5, 'Approved', 'Approved', '2020-04-21 06:05:29', '2020-04-21'),
	(6, 36, 36, 5, 'Pending', 'Pending', '2020-04-21 06:05:29', NULL),
	(7, 35, 32, 6, 'Approved', 'Pending', '2020-04-21 09:13:50', NULL),
	(8, 32, 26, 7, 'Approved', 'Approved', '2020-04-21 19:47:50', '2020-04-21'),
	(9, 25, 24, 8, 'Approved', 'Approved', '2020-04-27 13:06:32', '2020-04-27'),
	(10, 35, 26, 9, 'Approved', 'Approved', '2020-04-28 02:25:45', '2020-04-28'),
	(11, 25, 24, 10, 'Approved', 'Approved', '2020-04-28 18:14:37', '2020-04-28'),
	(12, 25, 24, 11, 'Approved', 'Approved', '2020-04-29 05:39:05', '2020-04-29'),
	(13, 35, 24, 11, 'Rejected', 'Pending', '2020-04-29 05:39:05', NULL),
	(14, 36, 24, 11, 'Pending', 'Pending', '2020-04-29 05:39:05', NULL),
	(15, 35, 34, 12, 'Rejected', 'Pending', '2020-04-29 16:05:21', NULL),
	(16, 35, 46, 13, 'Approved', 'Pending', '2020-04-30 11:32:38', NULL),
	(17, 35, 48, 14, 'Approved', 'Approved', '2020-05-01 22:27:58', '2020-05-01'),
	(18, 36, 48, 14, 'Pending', 'Pending', '2020-05-01 22:27:58', NULL),
	(19, 35, 34, 15, 'Approved', 'Approved', '2020-05-05 11:24:10', '2020-05-05'),
	(20, 35, 49, 16, 'Approved', 'Pending', '2020-05-05 17:39:27', NULL);
/*!40000 ALTER TABLE `project_request_for_affiliate` ENABLE KEYS */;

-- Export de la structure de la table plumers. project_request_for_affiliate_respone
CREATE TABLE IF NOT EXISTS `project_request_for_affiliate_respone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_request_for_affiliate_id` bigint(20) NOT NULL,
  `affiliate_id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `fund_raised` float(10,2) NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.project_request_for_affiliate_respone : 17 rows
/*!40000 ALTER TABLE `project_request_for_affiliate_respone` DISABLE KEYS */;
INSERT INTO `project_request_for_affiliate_respone` (`id`, `project_request_for_affiliate_id`, `affiliate_id`, `customer_id`, `project_id`, `fund_raised`, `comment`, `status`, `date`) VALUES
	(24, 11, 25, 24, 10, 100.00, 'ivdhjvg hkufg', 'Approved', '2020-04-28 18:16:24'),
	(23, 10, 35, 26, 9, 1500.00, 'merci se votre prix ????????????????', 'Approved', '2020-04-28 02:26:57'),
	(22, 9, 25, 24, 8, 500.00, 'I have dkduduei', 'Approved', '2020-04-27 13:07:21'),
	(21, 8, 32, 26, 7, 1000.00, 'Nice ', 'Approved', '2020-04-21 19:49:19'),
	(20, 7, 35, 32, 6, 528.00, 'good il faut essayer le paiement stp ', 'Approved', '2020-04-21 09:32:25'),
	(19, 5, 35, 36, 5, 560.00, 'Projet en cours ??????', 'Approved', '2020-04-21 06:06:21'),
	(18, 4, 35, 26, 4, 450.00, 'yes no problem ???????', 'Approved', '2020-04-19 14:35:58'),
	(17, 2, 27, 34, 2, 450.00, 'Merci ma belle je vais bien te piner quand je vais te voir même si il faut nourrir dans tes fesses je vais died seulement ❤️❤️❤️?????????????', 'Approved', '2020-04-18 18:56:55'),
	(16, 1, 27, 26, 1, 450.00, 'Merci beaucoup ?????????', 'Approved', '2020-04-18 03:28:16'),
	(25, 12, 25, 24, 11, 100.00, 'tjxsytdd', 'Approved', '2020-04-29 05:39:53'),
	(26, 16, 35, 46, 13, 300.00, 'Test payement ', 'Approved', '2020-04-30 11:45:10'),
	(27, 17, 35, 48, 14, 1000.00, 'Henene ???', 'Approved', '2020-05-01 22:28:52'),
	(28, 19, 35, 34, 15, 450.00, 'Prix non discutable ??', 'Approved', '2020-05-05 11:26:54'),
	(29, 15, 35, 34, 12, 0.00, '', 'Rejected', '2020-05-05 17:09:23'),
	(30, 13, 35, 24, 11, 0.00, '', 'Rejected', '2020-05-05 17:09:26'),
	(31, 13, 35, 24, 11, 0.00, '', 'Rejected', '2020-05-05 17:09:28'),
	(32, 20, 35, 49, 16, 400.00, 'Prix d amie ', 'Approved', '2020-05-05 17:43:41');
/*!40000 ALTER TABLE `project_request_for_affiliate_respone` ENABLE KEYS */;

-- Export de la structure de la table plumers. recent_viewed_product
CREATE TABLE IF NOT EXISTS `recent_viewed_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.recent_viewed_product : 39 rows
/*!40000 ALTER TABLE `recent_viewed_product` DISABLE KEYS */;
INSERT INTO `recent_viewed_product` (`id`, `user_id`, `product_id`, `date`) VALUES
	(1, 26, 5, '2020-05-05 11:09:07'),
	(2, 34, 4, '2020-04-18 18:46:39'),
	(3, 24, 4, '2020-04-29 14:11:56'),
	(4, 24, 6, '2020-04-29 10:36:39'),
	(5, 24, 5, '2020-04-29 14:12:07'),
	(6, 35, 4, '2020-04-19 10:13:32'),
	(7, 35, 5, '2020-04-21 06:03:45'),
	(8, 26, 4, '2020-04-28 09:43:47'),
	(9, 26, 6, '2020-04-21 06:16:16'),
	(10, 32, 5, '2020-04-21 19:48:11'),
	(11, 16, 5, '2020-04-23 13:39:22'),
	(12, 34, 5, '2020-05-05 11:37:51'),
	(13, 25, 5, '2020-04-29 05:45:49'),
	(14, 41, 5, '2020-04-24 08:41:19'),
	(15, 16, 4, '2020-04-28 13:35:05'),
	(16, 25, 4, '2020-04-29 06:22:02'),
	(17, 36, 6, '2020-04-29 06:13:03'),
	(18, 36, 4, '2020-04-29 06:15:40'),
	(19, 36, 5, '2020-04-29 06:15:56'),
	(20, 38, 4, '2020-04-29 16:15:58'),
	(21, 46, 4, '2020-04-30 11:55:20'),
	(22, 28, 6, '2020-05-04 15:54:34'),
	(23, 34, 6, '2020-05-05 11:57:05'),
	(24, 49, 5, '2020-05-05 15:07:28'),
	(25, 49, 6, '2020-05-05 15:28:22'),
	(26, 49, 4, '2020-05-05 15:09:30'),
	(27, 35, 6, '2020-05-06 23:41:22'),
	(28, 26, 9, '2020-05-13 05:38:02'),
	(29, 26, 7, '2020-05-13 05:38:07'),
	(30, 26, 15, '2020-05-13 05:38:31'),
	(31, 26, 34, '2020-05-13 08:25:44'),
	(32, 26, 31, '2020-05-13 08:26:11'),
	(33, 36, 93, '2020-05-13 12:53:25'),
	(34, 36, 94, '2020-05-13 12:53:13'),
	(35, 36, 7, '2020-05-13 12:53:31'),
	(36, 24, 95, '2020-05-13 13:15:30'),
	(37, 24, 96, '2020-05-13 13:16:04'),
	(38, 24, 88, '2020-05-13 13:16:52'),
	(39, 24, 86, '2020-05-13 13:17:06');
/*!40000 ALTER TABLE `recent_viewed_product` ENABLE KEYS */;

-- Export de la structure de la table plumers. reset
CREATE TABLE IF NOT EXISTS `reset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `token` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.reset : ~0 rows (environ)
/*!40000 ALTER TABLE `reset` DISABLE KEYS */;
/*!40000 ALTER TABLE `reset` ENABLE KEYS */;

-- Export de la structure de la table plumers. role_change_status
CREATE TABLE IF NOT EXISTS `role_change_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `role` varchar(250) CHARACTER SET latin1 NOT NULL,
  `status` varchar(250) CHARACTER SET latin1 NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.role_change_status : 0 rows
/*!40000 ALTER TABLE `role_change_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_change_status` ENABLE KEYS */;

-- Export de la structure de la table plumers. salle
CREATE TABLE IF NOT EXISTS `salle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prix` float DEFAULT NULL,
  `etat` tinyint(4) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.salle : ~3 rows (environ)
/*!40000 ALTER TABLE `salle` DISABLE KEYS */;
INSERT INTO `salle` (`id`, `nom`, `prix`, `etat`, `created_at`, `updated_at`) VALUES
	(3, 'A2', 20000, 1, '2020-09-03 21:00:07', NULL),
	(4, 'A3', 5000, 1, '2020-09-03 21:00:27', NULL),
	(6, 'A4', 15000, 1, '2020-09-04 10:53:24', NULL);
/*!40000 ALTER TABLE `salle` ENABLE KEYS */;

-- Export de la structure de la table plumers. schedule_meeting
CREATE TABLE IF NOT EXISTS `schedule_meeting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `mode_of_meeting` varchar(200) CHARACTER SET latin1 NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` varchar(200) CHARACTER SET latin1 NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.schedule_meeting : 77 rows
/*!40000 ALTER TABLE `schedule_meeting` DISABLE KEYS */;
INSERT INTO `schedule_meeting` (`id`, `affiliate_id`, `customer_id`, `mode_of_meeting`, `date`, `time`, `status`, `created_date`) VALUES
	(1, 22, 23, 'Chat', '2020-04-15', '21:12:00', 'Approved', '2020-04-15 10:42:41'),
	(2, 25, 24, 'Chat', '2020-04-16', '17:41:00', 'Approved', '2020-04-16 07:11:44'),
	(3, 25, 24, 'Audio', '2020-04-16', '19:36:00', 'Approved', '2020-04-16 09:06:09'),
	(4, 25, 24, 'Video', '2020-04-16', '20:37:00', 'Approved', '2020-04-16 09:07:23'),
	(5, 25, 24, 'Video', '2020-04-16', '23:00:00', 'Approved', '2020-04-16 11:30:23'),
	(6, 27, 26, 'Video', '2020-04-18', '04:33:00', 'Approved', '2020-04-18 03:31:06'),
	(7, 27, 26, 'Chat', '2020-04-18', '04:38:00', 'Approved', '2020-04-18 03:34:49'),
	(8, 27, 24, 'Audio', '2020-04-19', '01:16:00', 'Approved', '2020-04-18 14:46:58'),
	(9, 27, 26, 'Video', '2020-04-18', '20:23:00', 'Approved', '2020-04-18 19:22:13'),
	(10, 27, 34, 'Video', '2020-04-19', '19:19:00', 'Approved', '2020-04-18 19:27:43'),
	(11, 35, 26, 'Chat', '2020-04-19', '14:35:00', 'Approved', '2020-04-19 14:33:53'),
	(12, 35, 26, 'Video', '2020-04-19', '14:50:00', 'Approved', '2020-04-19 14:45:31'),
	(13, 35, 24, 'Audio', '2020-04-20', '01:49:00', 'Approved', '2020-04-19 15:19:38'),
	(14, 25, 26, 'Video', '2020-04-19', '15:38:00', 'Approved', '2020-04-19 15:34:15'),
	(15, 35, 24, 'Audio', '2020-04-20', '04:00:00', 'Approved', '2020-04-19 17:30:17'),
	(16, 25, 26, 'Audio', '2020-04-19', '17:40:00', 'Approved', '2020-04-19 17:36:48'),
	(17, 25, 26, 'Video', '2020-04-19', '18:45:00', 'Approved', '2020-04-19 18:41:27'),
	(18, 35, 26, 'Audio', '2020-04-20', '08:52:00', 'Approved', '2020-04-20 07:48:24'),
	(19, 35, 36, 'Audio', '2020-04-21', '11:13:00', 'Approved', '2020-04-21 06:09:50'),
	(20, 36, 36, 'Video', '2020-04-21', '13:16:00', 'Approved', '2020-04-21 06:16:38'),
	(21, 35, 36, 'Chat', '2020-04-21', '15:16:00', 'Approved', '2020-04-21 06:17:09'),
	(22, 35, 32, 'Chat', '2020-05-22', '17:17:00', 'Approved', '2020-04-21 09:22:01'),
	(23, 35, 32, 'Video', '2020-04-21', '14:50:00', 'Approved', '2020-04-21 09:22:35'),
	(24, 25, 38, 'Audio', '2020-04-21', '21:22:00', 'Approved', '2020-04-21 11:51:53'),
	(25, 25, 38, 'Chat', '2020-04-21', '22:40:00', 'Approved', '2020-04-21 12:10:59'),
	(26, 25, 24, 'Audio', '2020-04-22', '01:39:00', 'Approved', '2020-04-22 15:10:07'),
	(27, 38, 24, 'Audio', '2020-04-23', '01:22:00', 'Approved', '2020-04-22 15:49:06'),
	(28, 38, 24, 'Chat', '2020-04-23', '06:07:00', 'Approved', '2020-04-22 19:37:41'),
	(29, 32, 26, 'Video', '2020-04-23', '10:43:00', 'Approved', '2020-04-23 10:40:13'),
	(30, 25, 40, 'Audio', '2020-04-23', '20:23:00', 'Approved', '2020-04-23 10:52:23'),
	(31, 35, 41, 'Video', '2020-04-23', '16:45:00', 'Approved', '2020-04-23 11:39:15'),
	(32, 39, 26, 'Video', '2020-04-23', '12:18:00', 'Approved', '2020-04-23 12:16:24'),
	(33, 39, 41, 'Video', '2020-04-23', '17:35:00', 'Approved', '2020-04-23 12:24:37'),
	(34, 35, 34, 'Video', '2020-04-23', '19:15:00', 'Approved', '2020-04-23 14:13:11'),
	(35, 35, 34, 'Audio', '2020-04-23', '19:19:00', 'Approved', '2020-04-23 14:17:34'),
	(36, 39, 26, 'Audio', '2020-04-23', '14:36:00', 'Approved', '2020-04-23 14:34:11'),
	(37, 39, 24, 'Audio', '2020-04-24', '01:07:00', 'Approved', '2020-04-23 14:37:34'),
	(38, 35, 34, 'Video', '2020-04-23', '19:48:00', 'Approved', '2020-04-23 14:46:09'),
	(39, 35, 34, 'Audio', '2020-04-23', '19:50:00', 'Approved', '2020-04-23 14:46:20'),
	(40, 35, 34, 'Chat', '2020-04-23', '19:51:00', 'Approved', '2020-04-23 14:46:33'),
	(41, 39, 24, 'Video', '2020-04-24', '01:16:00', 'Approved', '2020-04-23 14:46:40'),
	(42, 35, 34, 'Audio', '2020-04-23', '20:05:00', 'Approved', '2020-04-23 15:03:13'),
	(43, 35, 34, 'Video', '2020-04-23', '20:06:00', 'Approved', '2020-04-23 15:03:24'),
	(44, 35, 34, 'Chat', '2020-04-23', '20:08:00', 'Approved', '2020-04-23 15:03:34'),
	(45, 25, 42, 'Video', '2020-04-24', '01:35:00', 'Approved', '2020-04-23 15:04:12'),
	(46, 25, 42, 'Audio', '2020-04-24', '01:36:00', 'Approved', '2020-04-23 15:07:05'),
	(47, 35, 34, 'Audio', '2020-04-23', '20:20:00', 'Approved', '2020-04-23 15:17:21'),
	(48, 35, 34, 'Video', '2020-04-23', '20:22:00', 'Approved', '2020-04-23 15:17:43'),
	(49, 35, 34, 'Chat', '2020-04-23', '20:25:00', 'Approved', '2020-04-23 15:18:06'),
	(50, 25, 24, 'Video', '2020-04-24', '02:43:00', 'Approved', '2020-04-23 17:12:28'),
	(51, 38, 24, 'Video', '2020-04-24', '02:44:00', 'Approved', '2020-04-23 17:13:10'),
	(52, 35, 26, 'Video', '2020-04-24', '08:28:00', 'Approved', '2020-04-24 08:24:40'),
	(53, 35, 41, 'Audio', '2020-04-24', '13:45:00', 'Approved', '2020-04-24 08:40:22'),
	(54, 35, 24, 'Audio', '2020-04-24', '19:13:00', 'Approved', '2020-04-24 08:43:19'),
	(55, 36, 26, 'Audio', '2020-04-24', '11:31:00', 'Approved', '2020-04-24 10:27:38'),
	(56, 32, 26, 'Video', '2020-04-24', '11:11:00', 'Pending', '2020-04-24 11:06:08'),
	(57, 35, 34, 'Video', '2020-04-24', '16:14:00', 'Approved', '2020-04-24 11:12:04'),
	(58, 35, 34, 'Audio', '2020-04-24', '16:13:00', 'Approved', '2020-04-24 11:12:17'),
	(59, 36, 24, 'Chat', '2020-04-27', '01:55:00', 'Approved', '2020-04-26 15:25:26'),
	(60, 25, 24, 'Chat', '2020-04-27', '01:56:00', 'Approved', '2020-04-26 15:26:31'),
	(61, 25, 24, 'Chat', '2020-04-27', '02:57:00', 'Pending', '2020-04-26 15:27:07'),
	(62, 35, 34, 'Video', '2020-04-29', '21:00:00', 'Approved', '2020-04-29 15:54:14'),
	(63, 35, 34, 'Chat', '2020-04-29', '21:12:00', 'Approved', '2020-04-29 16:10:17'),
	(64, 35, 46, 'Audio', '2020-05-01', '15:40:00', 'Approved', '2020-04-30 11:37:30'),
	(65, 35, 46, 'Chat', '2020-05-01', '17:01:00', 'Approved', '2020-04-30 12:01:24'),
	(66, 35, 46, 'Chat', '2020-05-01', '19:05:00', 'Approved', '2020-04-30 12:02:08'),
	(67, 35, 48, 'Audio', '2020-05-01', '22:26:00', 'Approved', '2020-05-01 22:23:29'),
	(68, 35, 34, 'Audio', '2020-05-05', '17:15:00', 'Approved', '2020-05-05 12:12:45'),
	(69, 35, 49, 'Video', '2020-05-05', '16:50:00', 'Approved', '2020-05-05 15:45:56'),
	(70, 35, 26, 'Chat', '2020-05-06', '06:02:00', 'Approved', '2020-05-06 04:58:27'),
	(71, 35, 42, 'Audio', '2020-05-07', '21:16:00', 'Approved', '2020-05-07 10:46:29'),
	(72, 32, 42, 'Audio', '2020-05-07', '21:18:00', 'Pending', '2020-05-07 10:48:49'),
	(73, 39, 41, 'Audio', '2020-05-07', '16:21:00', 'Approved', '2020-05-07 11:18:52'),
	(74, 39, 41, 'Video', '2020-05-07', '16:35:00', 'Approved', '2020-05-07 11:34:32'),
	(75, 39, 26, 'Video', '2020-05-07', '11:42:00', 'Pending', '2020-05-07 11:39:08'),
	(76, 35, 48, 'Video', '2020-05-08', '10:01:00', 'Approved', '2020-05-08 10:00:11'),
	(77, 36, 36, 'Chat', '2020-05-15', '20:25:00', 'Approved', '2020-05-13 13:25:32');
/*!40000 ALTER TABLE `schedule_meeting` ENABLE KEYS */;

-- Export de la structure de la table plumers. sequence
CREATE TABLE IF NOT EXISTS `sequence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idannee` varchar(12) DEFAULT NULL,
  `trims` int(11) DEFAULT NULL,
  `seq` int(11) DEFAULT NULL,
  `statu` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.sequence : ~6 rows (environ)
/*!40000 ALTER TABLE `sequence` DISABLE KEYS */;
INSERT INTO `sequence` (`id`, `idannee`, `trims`, `seq`, `statu`, `created_at`, `updated_at`) VALUES
	(1, '1', 1, 1, 1, '2020-06-28 15:23:28', '2020-06-28 16:28:20'),
	(2, '1', 1, 2, 0, '2020-06-28 16:12:36', NULL),
	(3, '1', 2, 3, 0, '2020-06-28 16:22:17', '2020-06-28 16:24:40'),
	(4, '1', 2, 4, 0, '2020-06-28 16:29:30', '2020-06-28 16:31:21'),
	(5, '1', 3, 5, 0, '2020-06-28 16:30:07', '2020-06-28 23:28:37'),
	(6, '1', 3, 6, 0, '2020-06-28 16:30:13', '2020-06-28 16:31:33');
/*!40000 ALTER TABLE `sequence` ENABLE KEYS */;

-- Export de la structure de la table plumers. serie
CREATE TABLE IF NOT EXISTS `serie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT 'Intremediare',
  `idsous_system` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.serie : ~4 rows (environ)
/*!40000 ALTER TABLE `serie` DISABLE KEYS */;
INSERT INTO `serie` (`id`, `nom`, `idsous_system`, `created_at`, `updated_at`) VALUES
	(1, 'A4 all', 2, '2020-06-28 18:16:00', '2020-06-28 18:18:59'),
	(6, 'A4 esp', 2, '2020-06-28 18:35:16', '2020-06-28 18:40:48'),
	(7, 'C', 2, '2020-06-28 18:41:08', NULL),
	(8, 'D', 2, '2020-06-28 23:27:08', NULL);
/*!40000 ALTER TABLE `serie` ENABLE KEYS */;

-- Export de la structure de la table plumers. sous_system
CREATE TABLE IF NOT EXISTS `sous_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Export de données de la table plumers.sous_system : ~2 rows (environ)
/*!40000 ALTER TABLE `sous_system` DISABLE KEYS */;
INSERT INTO `sous_system` (`id`, `nom`, `created_at`, `updated_at`) VALUES
	(1, 'Anglephone', '2020-06-28 12:47:56', '2020-06-28 12:48:40'),
	(2, 'Francophone', '2020-06-28 12:48:59', '2020-07-03 11:19:50');
/*!40000 ALTER TABLE `sous_system` ENABLE KEYS */;

-- Export de la structure de la table plumers. subcategory
CREATE TABLE IF NOT EXISTS `subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subcategory_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `category_id` varchar(255) CHARACTER SET latin1 NOT NULL,
  `subcategory_image` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'http://adminjwell.log/public/assets/img/logo.png',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.subcategory : ~2 rows (environ)
/*!40000 ALTER TABLE `subcategory` DISABLE KEYS */;
INSERT INTO `subcategory` (`id`, `subcategory_name`, `category_id`, `subcategory_image`, `created_on`) VALUES
	(1, 'téléphone', '1', 'http://adminjwell.log/public/assets/img/logo.png', '2020-07-20 23:07:06'),
	(2, 'appareil photo', '1', 'http://adminjwell.log/public/assets/img/logo.png', '2020-07-20 23:50:04');
/*!40000 ALTER TABLE `subcategory` ENABLE KEYS */;

-- Export de la structure de la table plumers. tax_list
CREATE TABLE IF NOT EXISTS `tax_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` longtext CHARACTER SET latin1 NOT NULL,
  `tps` float NOT NULL,
  `tvq` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.tax_list : 13 rows
/*!40000 ALTER TABLE `tax_list` DISABLE KEYS */;
INSERT INTO `tax_list` (`id`, `state_name`, `tps`, `tvq`) VALUES
	(15, 'cameroun', 1, 2),
	(3, 'Colombie Britannique ', 5, 0),
	(4, 'Ile du prince Édouard', 14, 0),
	(5, 'Manitoba', 5, 0),
	(6, 'Nouveau Brunswick ', 15, 0),
	(7, 'Nouvelle-Écosse', 15, 0),
	(9, 'Ontario', 13, 0),
	(10, 'Québec', 5, 9.975),
	(12, 'Terre-Neuve-et-Labrador', 15, 0),
	(13, 'Territoire du nord-Ouest', 5, 0),
	(14, 'Yukon', 5, 0),
	(1, 'Select Province', 0, 0),
	(16, 'camerou', 2, 0);
/*!40000 ALTER TABLE `tax_list` ENABLE KEYS */;

-- Export de la structure de la table plumers. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(200) CHARACTER SET latin1 NOT NULL,
  `prenom` varchar(200) CHARACTER SET latin1 NOT NULL,
  `sexe` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `numero` varchar(35) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `privilege` text CHARACTER SET latin1,
  `photo` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'http://plumers/public/assets/images/user.jpg',
  `idProfile` int(11) DEFAULT NULL,
  `libProfile` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.user : ~1 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `nom`, `prenom`, `sexe`, `email`, `numero`, `password`, `etat`, `last_login`, `created_at`, `privilege`, `photo`, `idProfile`, `libProfile`) VALUES
	(1, 'Dikla', 'Lucien', 'Masculin', 'lucien@plumers.net', '671747474', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', 1, '2020-09-10 21:17:54', '2020-05-16 00:53:40', 'DASHBOARD_VIEW,DASHBOARD_AFFAIRE,RETRAIT_VIEW,RETRAIT_ETAT,RETRAIT_VALID,RETRAIT_CANCEL,MEETING_VIEW,MEETING_ETAT,CMD_VIEW,CMD_ETAT,CMD_VALID,PRODUCT_VIEW,PRODUCT_ETAT,PRODUCT_EDIT,PRODUCT_ACTIVE,PRODUCT_DESACTIVE,PRODUCT_ADD,PRODUCT_DEAL,PRODUCT_STOCKADD,PRODUCT_STOCKMOVE,PRODUCT_IMGCHANGE,PRODUCT_IMGADD,PRODUCT_IMGDELETE,PRODUCT_NOTE,PRODUCT_SALE,PRODUCT_SALEETAT,PRODUCT_DEALVIEW,PRODUCT_DEALACTIVE,PRODUCT_DEALDESACTIVE,PRODUCT_CATVIEW,PRODUCT_CATADD,PRODUCT_CATEDIT,PRODUCT_CATIMG,PRODUCT_CATDELETE,PRODUCT_SUBCATVIEW,PRODUCT_SUBCATADD,PRODUCT_SUBCATEDIT,PRODUCT_SUBCATIMG,PRODUCT_SUBCATDELETE,PROJECT_CLIENTVIEW,PROJECT_AFFILIEVIEW,USER_CLIENTVIEW,USER_CLIENTADD,USER_CLIENTRESET,USER_CLIENTACTIVE,USER_CLIENTDESACTIVE,USER_CLIENTCMDVIEW,USER_CLIENTPROJECTETAT,USER_CLIENTPROJECTVIEW,USER_AFFILIEVIEW,USER_AFFILIEADD,USER_AFFILIERESET,USER_AFFILIEACTIVE,USER_AFFILIEDESACTIVE,USER_AFFILIECMDVIEW,USER_AFFILIEPROJECTVIEW,USER_AFFILIEDMDRETRAITVIEW,USER_AFFILIEPROFOLIOVIEW,USER_AFFILIEPROJECTANS,USER_AFFILIEPROJ0CTETAT,USER_AFFILIEIMG,USER_AFFILIEIMGDEL,CONFIG_COUPONVIEW,CONFIG_COUPONADD,CONFIG_COUPONEDIT,CONFIG_COUPONDELETE,CONFIG_APPTEXTVIEW,CONFIG_APPTEXTEDIT,CONFIG_TAXEVIEW,CONFIG_TAXEADD,CONFIG_TAXEEDIT,CONFIG_TAXEDELETE,COUNCILS_VIEW,COUNCILS_CMDVIEW,COUNCILS_ACTIVE,COUNCILS_DESACTIVE,COUNCILS_DELETE,ADMIN_VIEW,ADMIN_ADD,ADMIN_EDIT,ADMIN_RESET,ADMIN_ACTIVE,ADMIN_DESACTIVE,ADMIN_EDITIMG,PROFIL_GESTION,OTHER_NEWVIEW,OTHER_NEWADD,OTHER_NEWEDIT,OTHER_NEWDELETE,OTHER_NEWCHANGEIMG,OTHER_VISITVIEW,OTHER_SUGESTIONVIEW', 'http://adminjwell.log/public/identity/c86a2e95481d15868fc4ddf0c5400a6b.png', 2, 'SuperAdmin');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Export de la structure de la table plumers. users
CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) CHARACTER SET latin1 NOT NULL,
  `lname` varchar(255) CHARACTER SET latin1 NOT NULL,
  `username` varchar(255) CHARACTER SET latin1 NOT NULL,
  `mobile` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` longtext CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `gender` varchar(255) CHARACTER SET latin1 NOT NULL,
  `profileimg` varchar(255) CHARACTER SET latin1 NOT NULL,
  `secetkey` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '1',
  `address` longtext CHARACTER SET latin1,
  `latitude` longtext CHARACTER SET latin1 NOT NULL,
  `longitude` longtext CHARACTER SET latin1 NOT NULL,
  `city` varchar(255) CHARACTER SET latin1 NOT NULL,
  `state` varchar(255) CHARACTER SET latin1 NOT NULL,
  `country` varchar(255) CHARACTER SET latin1 NOT NULL,
  `zip` bigint(20) NOT NULL,
  `role` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT 'Customer',
  `chat_uid` varchar(250) CHARACTER SET latin1 NOT NULL,
  `chat_apiKey` longtext CHARACTER SET latin1 NOT NULL,
  `fcmToken` longtext CHARACTER SET latin1 NOT NULL,
  `appVersion` longtext CHARACTER SET latin1 NOT NULL,
  `deviceId` longtext CHARACTER SET latin1 NOT NULL,
  `deviceType` longtext CHARACTER SET latin1 NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.users : ~15 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`userid`, `fname`, `lname`, `username`, `mobile`, `email`, `password`, `gender`, `profileimg`, `secetkey`, `status`, `address`, `latitude`, `longitude`, `city`, `state`, `country`, `zip`, `role`, `chat_uid`, `chat_apiKey`, `fcmToken`, `appVersion`, `deviceId`, `deviceType`, `created_on`) VALUES
	(26, 'Henri', 'Jong', 'Henri Jong', '5142290159', 'duperclan01@gmail.com', '90d7313718e48341149561b0a03159c5', '', 'http://plumers.test/public/uploads/5gCpqc3bad8cc04868f03187900e012cc509026.jpg', '5e9aa55172bd51587193169', '1', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada\n', '45.3523139', '-73.2883265', 'Saint-Jean-sur-Richelieu', 'Qubec', 'Canada', 0, 'Customer', '', '', 'dB6rtIM5zHU:APA91bHOywolBkMGX_3kD7MyO1BO4SMWKTmlPtHg3Od5hpr7hz0TZTE_h5g_mqYiAgsRYobhrUgn27wyNjNtG6bmVrbVH8gcjt_ldG7z0C2od6H1ol16tC6Z0zyLjCxVpg7mXp483HHy', '1.2.3', '765ea6cf2fe58b98', 'Android', '2020-05-29 10:57:09'),
	(32, 'Laurence', 'Ilana', 'Laurence Ilana', '5142391223', 'ilanalaurence8@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '', 'http://plumers.test/public/uploads/lIXau2d8cd20c190300b5fa2850df1e49d24b32.jpg', '5e9b7acf2c6ff1587247823', '1', '120 Douala', '0.0', '0.0', '', '', '', 0, 'Affiliate', '', '', 'dBBafnp9cxo:APA91bGxH85WbGt5exXX6Wm9h0Gs8wbYX85Wiqur2M9lYcFfBxXFgdHyVuWkyLEcZ82Yx_v96S3hbkNo8w4oR7LtzqzLuxm_hSboOS0_QN7A57JMX23Dm2hgfpKwPcYYghyiTTvmz_rF', '1.2.3', 'c3b56f93a05ae55c', 'Android', '2020-04-30 03:51:18'),
	(33, 'Laurence', 'Mboah', 'Laurence Mboah', '', 'lraika2006@hotmail.com', 'b728819df45fec8ac5daff065ef9f2b9', '', 'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=10158333142648117&height=480&width=480&ext=1589839989&hash=AeQT9MVtUUAUH0qL', '5e9b7b7650c221587247990', '1', NULL, '', '', '', '', '', 0, 'Customer', '', '', 'fn9gVoyf66o:APA91bH2jYBg7uK_8QHu69iJ05qikdatYM8eUOXA13HNjf2h1SxWjAI0M2kZaLdfKJZUMrTQKbvfQSzcC6RjfwyCqFtFIoJEIROef_AjZJudelCBKv-VcTg6IEtfRnByO3gUqeCHV96j', '', 'c3b56f93a05ae55c', 'Android', '2020-04-19 06:13:10'),
	(34, 'Laurence Vanessa', 'Mboah ', 'Laurence Vanessa Mboah', '', 'laurence.mboah@ikramlogistics.com', 'e75ca73bfe69faf01da537f4704f05dd', '', 'null', '5e9b7bc58eeb41587248069', '1', NULL, '', '', '', '', '', 0, 'Customer', '', '', 'dBBafnp9cxo:APA91bGxH85WbGt5exXX6Wm9h0Gs8wbYX85Wiqur2M9lYcFfBxXFgdHyVuWkyLEcZ82Yx_v96S3hbkNo8w4oR7LtzqzLuxm_hSboOS0_QN7A57JMX23Dm2hgfpKwPcYYghyiTTvmz_rF', '1.2.3', 'c3b56f93a05ae55c', 'Android', '2020-04-30 03:52:46'),
	(35, 'Henri ', 'Jong ', 'Henri  Jong ', '5142290159', 'H.jong@renoplus-soft.com ', '81dc9bdb52d04dc20036dbd8313ed055', '', 'http://plumers.test/public/uploads/k8nBv96b43ef231340a06ac28995bd676cb1435.jpg', '5e9bedde8857d1587277278', '1', '175 Avenue du Parc, Saint-Jean-sur-Richelieu, QC J2W 0G6, Canada\n', '0.0', '0.0', 'Saint-Jean-sur-Richelieu', 'Qubec', 'Canada', 0, 'Affiliate', '', '', 'f1C2UHl276c:APA91bFCs-yW27e83S7IWfQhCCn6-ajQMrcPnKfA_b2EiGIsWae7xiUr15g9sEyEDgP2PeKayuazFo4g9Fr2nCyugwutD_ijhfKFJZ0nMeickfplRG0dg6BsBGhFaWPrQfndYVRER1mZ', '1.2.3', '1461608e7f1c9a83', 'Android', '2020-05-29 10:57:19'),
	(36, 'Steve', 'Ndjeunou', 'Steve Ndjeunou', '693381374', 'ndjeunousteve@yahoo.fr', '284e95bdf94bd5d2666c7cfc9cfe4ff5', '', 'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=2711491078965345&height=480&width=480&ext=1589874543&hash=AeSG7oCgrlmPWRT3', '5e9c0271382821587282545', '1', 'tes', '0.0', '0.0', '', '', '', 0, 'Customer', '', '', 'fWF9-FsDtMM:APA91bFnS4gQXHPFaC_yHtO9p1o6vkDB5vy7jRAK1ihIPrD3wViN9uPOwsneWuNtuqUgCFp0EX7hg2QAR05M8h4lA9hZ4WnHBJXWCP4yHwl6W3FcxQFEkfwEXDhyFq8aoaIKhbYJdjBE', '1.2.3', '20e665d27627416e', 'Android', '2020-04-30 19:58:02'),
	(37, 'Lionel', 'Ekabouma', 'Lionel Ekabouma', '', 'lionel.ekabouma@gmail.com', 'b268db1133ba450ebc6c2c830921635e', '', 'https://lh3.googleusercontent.com/a-/AOh14Gjfdbv3NTqMvMuOTo6JE0Xp4ObTzSzXlVwkmhAGZQ', '5e9da2fe35b4c1587389182', '1', NULL, '', '', '', '', '', 0, 'Customer', '', '', '', '1.1.8', '8a39a5b6ef745486', 'Android', '2020-04-20 21:26:22'),
	(41, 'Lionel', 'Ekabouma', 'Lionel Ekabouma', '', 'lionel.ekabouma@maleamms.com', 'ed1d65aba4394cf567a17a0b4954a80a', '', 'null', '5ea1b5740243d1587656052', '1', NULL, '', '', '', '', '', 0, 'Customer', '', '', 'csBm3JoDkZg:APA91bGQH1GDCqevkogAnspAg0fmS7IShblchVPp2EshVAkBpzxi7Scwx2slaYLZvAeCbE-pEWUENTjJafj3yC9gq6VZ8YHDp9wYUEg9Ce5IHEE3j6fryr852UhI69vqqGJleqm_O3MF', '1.2.3', 'c1841cb9ec719022', 'Android', '2020-05-11 22:52:49'),
	(43, 'Lamine Ben Mor', 'Diankha', 'Lamine Ben Mor Diankha', '', 'laminediankha@hotmail.fr', 'da03a5de6a6b407acd22b7ef6499fc48', '', 'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=2811891392212413&height=480&width=480&ext=1590797650&hash=AeQ2RfTWqg_pgGUv', '5eaa18554efc41588205653', '1', NULL, '', '', '', '', '', 0, 'Customer', '', '', '', '1.2.3', 'dfbd391e0255504b', 'Android', '2020-04-30 08:14:13'),
	(45, 'ben ', 'ben', 'ben  ben', '', 'grh2019@gmail.com', 'be81086080893d8fa32cc1226b9a4bfa', '', '', '5eaa1aecf27d11588206316', '1', NULL, '', '', '', '', '', 0, 'Customer', '', '', '', '', '', '', '2020-04-30 08:25:16'),
	(46, 'jeremie', 'miyouna', 'jeremie miyouna', '', 'mijefun@gmail.com', 'f2b158b1616f0a12b54a61e076fb7000', '', '', '5eaaecd2c9b3d1588260050', '1', NULL, '', '', '', '', '', 0, 'Customer', '', '', 'dytq5acWhO8:APA91bFmWDTa66DbgiFW1IyMT_gSTwyQQeCU36OV0P6eBaXDMEU2vrHQJIKSolRbvTw2ThG6u7px1OVrp-yXy9skKgR7lHfExjnBC7-y6m0X7H6L31yqkrKwgDJuat7iFMqtjIZcBiTX', '1.2.3', '0995ba9bd2d8d2cd', 'Android', '2020-04-30 23:29:44'),
	(47, 'Lamime Ben Mor', 'Diankha', 'Lamime Ben Mor Diankha', '', 'laminediankha1994@gmail.com', 'b8a12b4da65ab35f98189983fd66d743', '', 'null', '5eaaf3f4889621588261876', '1', NULL, '', '', '', '', '', 0, 'Customer', '', '', 'cXQyH7mUh5w:APA91bGkND0WVtCWB-lo3s2Aul7D40xUNELO1vLa86XTdUTtxkFm_uQdKH_KGQ3P9JlgxPfKZyqI-WS5n0G3xob44nPUmoz5aPzzjZw0mD07SyMj812QkVzYKvT7dKJLoQftyBfYn2FC', '1.2.3', 'c9bb880c3103eeee', 'Android', '2020-04-30 23:51:16'),
	(48, 'Annie', 'Ngono', 'Annie Ngono', '', 'anniengono9@gmail.com', 'b21d6561a0711cb2eff5804a84697af5', '', 'null', '5eacd925ec8d71588386085', '0', NULL, '', '', '', '', '', 0, 'Customer', '', '', 'cKWvev-Wygk:APA91bHXul1t43uPAUnt01hqLDMIVICaeJSZQEgcwmTHFXX5rXnc5l1pNHYX3RE0X91npu9Ru0QJrE8Z-OjMoTmIfQUV0sJeM9lPIMRIRQA99OrLDvLwvEEVSppjEt0TEeGvBWk_Lt2i', '1.2.3', '2619aea3dc63d930', 'Android', '2020-06-04 06:22:54'),
	(49, 'Elodie', 'Ach', 'Elodie Ach', '', 'elodie.achard@hec.ca', '81dc9bdb52d04dc20036dbd8313ed055', '', '', '5eb1b93ead6f61588705598', '1', NULL, '', '', '', '', '', 0, 'Customer', '', '', 'f1C2UHl276c:APA91bFCs-yW27e83S7IWfQhCCn6-ajQMrcPnKfA_b2EiGIsWae7xiUr15g9sEyEDgP2PeKayuazFo4g9Fr2nCyugwutD_ijhfKFJZ0nMeickfplRG0dg6BsBGhFaWPrQfndYVRER1mZ', '1.2.3', '1461608e7f1c9a83', 'Android', '2020-05-06 03:07:08'),
	(50, 'Rishabh', 'Shukla', 'rishabh1450@gmail.com', '', 'rishabh1450@gmail.com', '5ddb8c2f74e33e0c03e09b8190e89044', '', 'https://lh3.googleusercontent.com/a-/AOh14Ggw6jl0ugHQqO-ukRoPev17os5tpu0UNWz3iJmhDw=s200', '5ebac8300366a1589299248', '1', NULL, '', '', '', '', '', 0, 'Customer', '', '', '', '1.0', '', 'iOS', '2020-05-13 00:00:48');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Export de la structure de la table plumers. visite
CREATE TABLE IF NOT EXISTS `visite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(100) CHARACTER SET latin1 NOT NULL,
  `location` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `device` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `pays` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `region` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.visite : ~0 rows (environ)
/*!40000 ALTER TABLE `visite` DISABLE KEYS */;
/*!40000 ALTER TABLE `visite` ENABLE KEYS */;

-- Export de la structure de la table plumers. wallet
CREATE TABLE IF NOT EXISTS `wallet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) CHARACTER SET latin1 NOT NULL,
  `secetkey` varchar(100) CHARACTER SET latin1 NOT NULL,
  `amount` float(10,2) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.wallet : ~29 rows (environ)
/*!40000 ALTER TABLE `wallet` DISABLE KEYS */;
INSERT INTO `wallet` (`id`, `userid`, `secetkey`, `amount`, `created_on`, `updated_on`) VALUES
	(61, '22', '5e9718fd63cd71586960637', 0.00, '2020-04-15 22:23:57', NULL),
	(62, '23', '5e971d389fa4d1586961720', 0.00, '2020-04-15 22:42:00', NULL),
	(63, '24', '5e9838df41d861587034335', 6.00, '2020-04-29 17:47:17', NULL),
	(64, '25', '5e983bfb0a3b91587035131', 0.00, '2020-04-16 19:05:31', NULL),
	(65, '26', '5e9aa55172bd51587193169', 0.00, '2020-04-18 14:59:29', NULL),
	(66, '27', '5e9aa727b01981587193639', 0.00, '2020-04-18 15:07:19', NULL),
	(67, '28', '5e9b200d8e4621587224589', 0.00, '2020-04-18 23:43:09', NULL),
	(68, '29', '5e9b33fac80801587229690', 0.00, '2020-04-19 01:08:10', NULL),
	(69, '30', '5e9b3423e4b081587229731', 0.00, '2020-04-19 01:08:51', NULL),
	(70, '31', '5e9b6e9c91bf41587244700', 0.00, '2020-04-19 05:18:20', NULL),
	(71, '32', '5e9b7acf2c6ff1587247823', 0.00, '2020-04-19 06:10:23', NULL),
	(72, '33', '5e9b7b7650c221587247990', 0.00, '2020-04-19 06:13:10', NULL),
	(73, '34', '5e9b7bc58eeb41587248069', 6.44, '2020-05-05 23:43:30', NULL),
	(74, '35', '5e9bedde8857d1587277278', 6.44, '2020-05-07 11:40:53', NULL),
	(75, '36', '5e9c0271382821587282545', 35.36, '2020-04-29 18:19:03', NULL),
	(76, '37', '5e9da2fe35b4c1587389182', 0.00, '2020-04-20 21:26:22', NULL),
	(77, '38', '5e9f14c7b1c251587483847', 0.00, '2020-04-21 23:44:07', NULL),
	(78, '39', '5ea0c75a201101587595098', 0.00, '2020-04-23 06:38:18', NULL),
	(79, '40', '5ea19be5499091587649509', 0.00, '2020-04-23 21:45:09', NULL),
	(80, '41', '5ea1b5740243d1587656052', 0.00, '2020-04-23 23:34:12', NULL),
	(81, '42', '5ea1e60b7a6be1587668491', 0.00, '2020-04-24 03:01:31', NULL),
	(82, '43', '5eaa18554efc41588205653', 0.00, '2020-04-30 08:14:13', NULL),
	(83, '44', '5eaa19cbae8a21588206027', 0.00, '2020-04-30 08:20:27', NULL),
	(84, '45', '5eaa1aecf27d11588206316', 0.00, '2020-04-30 08:25:17', NULL),
	(85, '46', '5eaaecd2c9b3d1588260050', 0.00, '2020-04-30 23:20:50', NULL),
	(86, '47', '5eaaf3f4889621588261876', 0.00, '2020-04-30 23:51:16', NULL),
	(87, '48', '5eacd925ec8d71588386085', 0.00, '2020-05-02 10:21:25', NULL),
	(88, '49', '5eb1b93ead6f61588705598', 18.44, '2020-05-06 03:27:52', NULL),
	(89, '50', '5ebac8300366a1589299248', 0.00, '2020-05-13 00:00:48', NULL);
/*!40000 ALTER TABLE `wallet` ENABLE KEYS */;

-- Export de la structure de la table plumers. withdraw_request
CREATE TABLE IF NOT EXISTS `withdraw_request` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `status` int(10) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table plumers.withdraw_request : ~3 rows (environ)
/*!40000 ALTER TABLE `withdraw_request` DISABLE KEYS */;
INSERT INTO `withdraw_request` (`id`, `user_id`, `amount`, `status`, `date`) VALUES
	(4, 25, 100.00, 1, '2020-04-28'),
	(5, 25, 100.00, 1, '2020-04-29'),
	(6, 35, 450.00, 0, '2020-05-05');
/*!40000 ALTER TABLE `withdraw_request` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
