# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.1.56-community
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-06-30 18:19:40
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping structure for table y_data_center.analysis
DROP TABLE IF EXISTS `analysis`;
CREATE TABLE IF NOT EXISTS `analysis` (
  `analysis_id` int(11) NOT NULL AUTO_INCREMENT,
  `url_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `result` text NOT NULL,
  PRIMARY KEY (`analysis_id`),
  KEY `fk_url_id` (`url_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分析表，分析本次采集信息和上次信息的变化';

# Dumping data for table y_data_center.analysis: 0 rows
/*!40000 ALTER TABLE `analysis` DISABLE KEYS */;
/*!40000 ALTER TABLE `analysis` ENABLE KEYS */;


# Dumping structure for table y_data_center.bidding
DROP TABLE IF EXISTS `bidding`;
CREATE TABLE IF NOT EXISTS `bidding` (
  `bidding_id` int(11) NOT NULL AUTO_INCREMENT,
  `web_id` tinyint(4) NOT NULL,
  `category` varchar(20) NOT NULL,
  `title` varchar(200) NOT NULL,
  `fromtime` int(10) NOT NULL,
  `totime` int(10) NOT NULL,
  `company` varchar(200) NOT NULL,
  `location` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `location_id` int(11) NOT NULL,
  `bidding_url` varchar(255) NOT NULL,
  `data_catch_url` varchar(255) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bidding_id`),
  UNIQUE KEY `bidding_url` (`bidding_url`),
  KEY `web_id` (`web_id`),
  KEY `category` (`category`)
) ENGINE=MyISAM AUTO_INCREMENT=3590 DEFAULT CHARSET=utf8;

# Dumping data for table y_data_center.bidding: 0 rows
/*!40000 ALTER TABLE `bidding` DISABLE KEYS */;
/*!40000 ALTER TABLE `bidding` ENABLE KEYS */;


# Dumping structure for table y_data_center.company
DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `web_id` tinyint(4) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `category_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `company_url` varchar(255) NOT NULL,
  `data_catch_url` text NOT NULL,
  `valid_info` tinyint(1) NOT NULL DEFAULT '0',
  `valid_contact` tinyint(1) NOT NULL DEFAULT '0',
  `locked_contact` tinyint(1) NOT NULL DEFAULT '0',
  `locked_info` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `company_url` (`company_url`),
  KEY `valid_info` (`valid_info`),
  KEY `valid_contact` (`valid_contact`),
  KEY `locked_contact` (`locked_contact`),
  KEY `locked_info` (`locked_info`),
  KEY `web_id` (`web_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1173365 DEFAULT CHARSET=utf8;

# Dumping data for table y_data_center.company: ~0 rows (approximately)
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
/*!40000 ALTER TABLE `company` ENABLE KEYS */;


# Dumping structure for table y_data_center.company_categories
DROP TABLE IF EXISTS `company_categories`;
CREATE TABLE IF NOT EXISTS `company_categories` (
  `categories_id` int(11) NOT NULL AUTO_INCREMENT,
  `categories_name` varchar(45) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`categories_id`)
) ENGINE=MyISAM AUTO_INCREMENT=418 DEFAULT CHARSET=utf8 COMMENT='公司分类';

# Dumping data for table y_data_center.company_categories: 0 rows
/*!40000 ALTER TABLE `company_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_categories` ENABLE KEYS */;


# Dumping structure for table y_data_center.company_contact
DROP TABLE IF EXISTS `company_contact`;
CREATE TABLE IF NOT EXISTS `company_contact` (
  `company_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `contact_user` varchar(30) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `position` varchar(100) NOT NULL,
  `telephone` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fax` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postcode` varchar(30) NOT NULL,
  `extend_company_url` text NOT NULL,
  `wangwang` varchar(20) DEFAULT NULL,
  `qq` varchar(20) DEFAULT NULL,
  `msn` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`company_id`),
  KEY `fk_info_company_id` (`company_id`),
  CONSTRAINT `fk_info_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dumping data for table y_data_center.company_contact: ~0 rows (approximately)
/*!40000 ALTER TABLE `company_contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_contact` ENABLE KEYS */;


# Dumping structure for table y_data_center.company_info
DROP TABLE IF EXISTS `company_info`;
CREATE TABLE IF NOT EXISTS `company_info` (
  `company_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `products` text NOT NULL,
  `industry` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `business_model` varchar(20) NOT NULL,
  `capital` varchar(100) DEFAULT NULL,
  `register_address` varchar(100) DEFAULT NULL,
  `employees` varchar(50) DEFAULT NULL,
  `register_date` varchar(20) DEFAULT NULL,
  `legal` varchar(20) DEFAULT NULL,
  `turnover` varchar(50) DEFAULT NULL,
  `business_area` text,
  `market` text,
  `band` varchar(100) DEFAULT NULL,
  `management` varchar(255) DEFAULT NULL,
  `oem` varchar(200) DEFAULT NULL,
  `quality` varchar(100) DEFAULT NULL,
  `developers` varchar(50) DEFAULT NULL,
  `plant_area` varchar(50) DEFAULT NULL,
  `registration` varchar(50) DEFAULT NULL,
  `in_exports` varchar(100) DEFAULT NULL,
  `on_imports` varchar(100) DEFAULT NULL,
  `customers` varchar(255) DEFAULT NULL,
  `month_produce` varchar(100) DEFAULT NULL,
  `technology` varchar(255) DEFAULT NULL,
  `service` varchar(255) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `account` varchar(40) DEFAULT NULL,
  `introductions` text NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`company_id`),
  KEY `fk_contact_company_id` (`company_id`),
  CONSTRAINT `fk_contact_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dumping data for table y_data_center.company_info: ~0 rows (approximately)
/*!40000 ALTER TABLE `company_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_info` ENABLE KEYS */;


# Dumping structure for table y_data_center.company_search_result
DROP TABLE IF EXISTS `company_search_result`;
CREATE TABLE IF NOT EXISTS `company_search_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `data_catch_url` varchar(255) NOT NULL,
  `page_num` int(11) NOT NULL DEFAULT '0',
  `company_num` int(11) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  `valid_page_num` int(11) NOT NULL DEFAULT '0',
  `valid_company_num` int(11) NOT NULL DEFAULT '0',
  `web_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category_id`),
  KEY `province` (`location_id`),
  KEY `locked` (`locked`),
  KEY `valid` (`valid`),
  KEY `web_id` (`web_id`)
) ENGINE=InnoDB AUTO_INCREMENT=395 DEFAULT CHARSET=utf8 COMMENT='搜索表\n';

# Dumping data for table y_data_center.company_search_result: ~0 rows (approximately)
/*!40000 ALTER TABLE `company_search_result` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_search_result` ENABLE KEYS */;


# Dumping structure for table y_data_center.exhibit
DROP TABLE IF EXISTS `exhibit`;
CREATE TABLE IF NOT EXISTS `exhibit` (
  `exhibit_id` int(11) NOT NULL AUTO_INCREMENT,
  `web_id` tinyint(4) unsigned NOT NULL,
  `title` varchar(200) NOT NULL,
  `fromtime` int(10) NOT NULL,
  `totime` int(10) NOT NULL,
  `addtime` int(10) NOT NULL,
  `exhibit_url` varchar(255) NOT NULL,
  `location` varchar(45) NOT NULL,
  `type` varchar(45) NOT NULL,
  `data_catch_url` varchar(255) NOT NULL,
  `city` varchar(45) NOT NULL,
  `hall` varchar(100) NOT NULL,
  `organizers` varchar(200) NOT NULL,
  `sponsor` varchar(200) DEFAULT NULL,
  `coorganizer` varchar(200) DEFAULT NULL,
  `description` text NOT NULL,
  `contact` varchar(145) NOT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `contact_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `period` varchar(45) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`exhibit_id`),
  UNIQUE KEY `exhibit_url` (`exhibit_url`),
  KEY `web_id` (`web_id`),
  KEY `valid` (`valid`),
  KEY `locked` (`locked`)
) ENGINE=MyISAM AUTO_INCREMENT=5191 DEFAULT CHARSET=utf8;

# Dumping data for table y_data_center.exhibit: 0 rows
/*!40000 ALTER TABLE `exhibit` DISABLE KEYS */;
/*!40000 ALTER TABLE `exhibit` ENABLE KEYS */;


# Dumping structure for table y_data_center.failed_links
DROP TABLE IF EXISTS `failed_links`;
CREATE TABLE IF NOT EXISTS `failed_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL,
  `timeout` tinyint(1) NOT NULL DEFAULT '0',
  `solved` tinyint(1) NOT NULL DEFAULT '0',
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table y_data_center.failed_links: 0 rows
/*!40000 ALTER TABLE `failed_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_links` ENABLE KEYS */;


# Dumping structure for table y_data_center.job
DROP TABLE IF EXISTS `job`;
CREATE TABLE IF NOT EXISTS `job` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_name` varchar(100) NOT NULL,
  `startime` int(10) NOT NULL,
  `endtime` int(10) NOT NULL,
  `regular` varchar(10) NOT NULL COMMENT '时间格式为\nH:m:s\n表示为多少小时多少分\n多少秒执行一次任务',
  `description` text NOT NULL,
  `rule_id` int(11) NOT NULL,
  PRIMARY KEY (`job_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# Dumping data for table y_data_center.job: 0 rows
/*!40000 ALTER TABLE `job` DISABLE KEYS */;
/*!40000 ALTER TABLE `job` ENABLE KEYS */;


# Dumping structure for table y_data_center.location
DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(10) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`location_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# Dumping data for table y_data_center.location: 0 rows
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
/*!40000 ALTER TABLE `location` ENABLE KEYS */;


# Dumping structure for table y_data_center.news
DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `web_id` tinyint(2) NOT NULL,
  `news_categories` varchar(45) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `content` text,
  `addtime` int(10) DEFAULT NULL,
  `posttime` int(10) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `source` varchar(45) DEFAULT NULL,
  `author` varchar(50) NOT NULL DEFAULT '佚名',
  `news_url` varchar(255) NOT NULL,
  `introduction` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `data_catch_url` varchar(255) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`news_id`,`web_id`),
  KEY `valid` (`valid`),
  KEY `locked` (`locked`),
  KEY `news_url` (`news_url`),
  KEY `news_categories` (`news_categories`),
  KEY `web_id` (`web_id`)
) ENGINE=MyISAM AUTO_INCREMENT=203456 DEFAULT CHARSET=utf8;

# Dumping data for table y_data_center.news: 0 rows
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;


# Dumping structure for table y_data_center.rule
DROP TABLE IF EXISTS `rule`;
CREATE TABLE IF NOT EXISTS `rule` (
  `rule_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL COMMENT '1表示分析规则\n2表示执行规则\n3表示任务对应分析url的规则\n',
  `method` varchar(100) NOT NULL,
  `params` varchar(255) NOT NULL,
  `description` text,
  `uid` smallint(6) NOT NULL,
  PRIMARY KEY (`rule_id`),
  KEY `fk_rule_uid` (`uid`),
  CONSTRAINT `fk_rule_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dumping data for table y_data_center.rule: ~0 rows (approximately)
/*!40000 ALTER TABLE `rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `rule` ENABLE KEYS */;


# Dumping structure for table y_data_center.subject
DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(100) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL,
  `uid` smallint(6) NOT NULL,
  PRIMARY KEY (`subject_id`),
  KEY `parent_id` (`parent_id`),
  KEY `fk_subject_uid` (`uid`),
  CONSTRAINT `fk_subject_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dumping data for table y_data_center.subject: ~0 rows (approximately)
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;


# Dumping structure for table y_data_center.tmp_location
DROP TABLE IF EXISTS `tmp_location`;
CREATE TABLE IF NOT EXISTS `tmp_location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) NOT NULL,
  `area_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`location_id`),
  UNIQUE KEY `location` (`location`)
) ENGINE=MyISAM AUTO_INCREMENT=2638 DEFAULT CHARSET=utf8 COMMENT='中间表用来处理地区';

# Dumping data for table y_data_center.tmp_location: 0 rows
/*!40000 ALTER TABLE `tmp_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp_location` ENABLE KEYS */;


# Dumping structure for table y_data_center.url
DROP TABLE IF EXISTS `url`;
CREATE TABLE IF NOT EXISTS `url` (
  `url_id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `web_id` tinyint(4) NOT NULL,
  `analysis_rule_id` int(11) NOT NULL,
  `target_rule_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `addtime` int(11) NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `actived` tinyint(1) NOT NULL DEFAULT '0',
  `uid` smallint(6) NOT NULL,
  PRIMARY KEY (`url_id`),
  KEY `fk_target_rule` (`target_rule_id`),
  KEY `fk_analysis` (`analysis_rule_id`),
  KEY `fk_subject` (`subject_id`),
  KEY `fk_url_uid` (`uid`),
  CONSTRAINT `fk_target_rule` FOREIGN KEY (`target_rule_id`) REFERENCES `rule` (`rule_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_analysis` FOREIGN KEY (`analysis_rule_id`) REFERENCES `rule` (`rule_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_subject` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_url_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dumping data for table y_data_center.url: ~0 rows (approximately)
/*!40000 ALTER TABLE `url` DISABLE KEYS */;
/*!40000 ALTER TABLE `url` ENABLE KEYS */;


# Dumping structure for table y_data_center.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `uid` smallint(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `registertime` int(10) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

# Dumping data for table y_data_center.user: ~1 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`uid`, `username`, `password`, `salt`, `status`, `registertime`) VALUES
	(1, 'shearf', 'd42568610d4a09b9522c7e07938d0cb4', '42da3fe7c3cc5af4be49a35f80d92e44', 1, 1309427420);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;


# Dumping structure for table y_data_center.web
DROP TABLE IF EXISTS `web`;
CREATE TABLE IF NOT EXISTS `web` (
  `web_id` int(11) NOT NULL AUTO_INCREMENT,
  `web_name` varchar(45) NOT NULL,
  `web_url` varchar(45) NOT NULL,
  `description` text,
  PRIMARY KEY (`web_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

# Dumping data for table y_data_center.web: 0 rows
/*!40000 ALTER TABLE `web` DISABLE KEYS */;
/*!40000 ALTER TABLE `web` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
