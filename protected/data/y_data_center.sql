-- MySQL dump 10.13  Distrib 5.5.14, for Linux (i686)
--
-- Host: localhost    Database: y_data_center
-- ------------------------------------------------------
-- Server version	5.5.14-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `51jiahe_company`
--

DROP TABLE IF EXISTS `51jiahe_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `51jiahe_company` (
  `company_id` int(10) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(64) NOT NULL,
  `company_url` varchar(128) NOT NULL,
  `address` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `data_catch_url` varchar(128) NOT NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `company_url` (`company_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `77883_company`
--

DROP TABLE IF EXISTS `77883_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `77883_company` (
  `company_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(64) NOT NULL,
  `company_url` varchar(128) NOT NULL,
  `location` varchar(32) NOT NULL,
  `category` varchar(32) NOT NULL,
  `address` varchar(128) NOT NULL,
  `postcode` varchar(32) NOT NULL DEFAULT '',
  `contact_user` varchar(32) NOT NULL,
  `telephone` varchar(32) NOT NULL DEFAULT '',
  `fax` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL,
  `introduce` text,
  `url` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `company_url` (`company_url`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2728 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `77883_company_search`
--

DROP TABLE IF EXISTS `77883_company_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `77883_company_search` (
  `search_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(32) NOT NULL,
  `location` varchar(32) NOT NULL,
  `url` varchar(128) NOT NULL,
  `data_catch_url` varchar(255) NOT NULL,
  PRIMARY KEY (`search_id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=2729 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `analysis`
--

DROP TABLE IF EXISTS `analysis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `analysis` (
  `analysis_id` int(11) NOT NULL AUTO_INCREMENT,
  `url_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `result` text NOT NULL,
  PRIMARY KEY (`analysis_id`),
  KEY `fk_url_id` (`url_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分析表，分析本次采集信息和上次信息的变化';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bidding`
--

DROP TABLE IF EXISTS `bidding`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bidding` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `company_categories`
--

DROP TABLE IF EXISTS `company_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_categories` (
  `categories_id` int(11) NOT NULL AUTO_INCREMENT,
  `categories_name` varchar(45) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`categories_id`)
) ENGINE=MyISAM AUTO_INCREMENT=418 DEFAULT CHARSET=utf8 COMMENT='公司分类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `company_contact`
--

DROP TABLE IF EXISTS `company_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_contact` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `company_info`
--

DROP TABLE IF EXISTS `company_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_info` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `company_search_result`
--

DROP TABLE IF EXISTS `company_search_result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_search_result` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='搜索表\n';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `edeng_category`
--

DROP TABLE IF EXISTS `edeng_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `edeng_category` (
  `category_id` smallint(4) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(45) NOT NULL,
  `data_catch_url` varchar(128) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='易登装饰分类信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `edeng_company`
--

DROP TABLE IF EXISTS `edeng_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `edeng_company` (
  `company_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(128) NOT NULL DEFAULT '',
  `category_id` smallint(4) NOT NULL,
  `location_id` smallint(4) NOT NULL,
  `location` varchar(128) NOT NULL,
  `contact_user` varchar(32) NOT NULL DEFAULT '',
  `mobile` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  `introduce` text,
  `data_catch_url` varchar(128) NOT NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `mobile` (`mobile`),
  UNIQUE KEY `data_catch_url` (`data_catch_url`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11440 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `edeng_company_contact`
--

DROP TABLE IF EXISTS `edeng_company_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `edeng_company_contact` (
  `company_id` bigint(20) unsigned NOT NULL,
  `contact_user` varchar(50) NOT NULL,
  `telephone` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `location` varchar(128) NOT NULL,
  `address` varchar(128) NOT NULL DEFAULT '',
  `data_catch_url` varchar(128) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `email` (`email`),
  KEY `data_catch_url` (`data_catch_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `edeng_location`
--

DROP TABLE IF EXISTS `edeng_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `edeng_location` (
  `location_id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `location` varchar(45) NOT NULL,
  `parent_id` smallint(4) NOT NULL DEFAULT '0',
  `has_child` tinyint(1) NOT NULL DEFAULT '0',
  `search_url` varchar(128) NOT NULL,
  `data_catch_url` varchar(128) NOT NULL,
  PRIMARY KEY (`location_id`),
  KEY `parent_id` (`parent_id`),
  KEY `has_child` (`has_child`),
  KEY `search_url` (`search_url`)
) ENGINE=MyISAM AUTO_INCREMENT=831 DEFAULT CHARSET=utf8 COMMENT='易登的地区';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `edeng_search_url`
--

DROP TABLE IF EXISTS `edeng_search_url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `edeng_search_url` (
  `url_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(128) NOT NULL,
  `category_id` smallint(4) NOT NULL,
  `location_id` smallint(4) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `data_catch_url` varchar(128) NOT NULL,
  PRIMARY KEY (`url_id`),
  UNIQUE KEY `url` (`url`),
  KEY `category_id` (`category_id`),
  KEY `location_id` (`location_id`),
  KEY `valid` (`valid`),
  KEY `locked` (`locked`),
  KEY `data_catch_url` (`data_catch_url`)
) ENGINE=InnoDB AUTO_INCREMENT=13654 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `exhibit`
--

DROP TABLE IF EXISTS `exhibit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exhibit` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `failed_links`
--

DROP TABLE IF EXISTS `failed_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL,
  `timeout` tinyint(1) NOT NULL DEFAULT '0',
  `solved` tinyint(1) NOT NULL DEFAULT '0',
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jc001_category_search_url`
--

DROP TABLE IF EXISTS `jc001_category_search_url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jc001_category_search_url` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `search_url` varchar(128) NOT NULL,
  `category_id` smallint(4) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id` (`category_id`),
  UNIQUE KEY `search_url` (`search_url`),
  KEY `locked` (`locked`),
  KEY `valid` (`valid`)
) ENGINE=InnoDB AUTO_INCREMENT=1579 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jc001_company`
--

DROP TABLE IF EXISTS `jc001_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jc001_company` (
  `company_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(128) NOT NULL,
  `logo` varchar(128) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL,
  `category_id` mediumint(8) NOT NULL,
  `location_id` smallint(4) NOT NULL,
  `company_url` varchar(128) NOT NULL,
  `vip` tinyint(2) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  `data_catch_url` varchar(128) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `company_url` (`company_url`),
  KEY `locked` (`locked`),
  KEY `valid` (`valid`),
  KEY `data_catch_url` (`data_catch_url`),
  KEY `type` (`type`),
  KEY `category_id` (`category_id`),
  KEY `location_id` (`location_id`),
  KEY `create_time` (`create_time`),
  KEY `update_time` (`update_time`)
) ENGINE=InnoDB AUTO_INCREMENT=36865 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jc001_company_category`
--

DROP TABLE IF EXISTS `jc001_company_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jc001_company_category` (
  `category_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(32) NOT NULL,
  `parent_id` mediumint(8) NOT NULL DEFAULT '0',
  `has_child` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`),
  KEY `parent_id` (`parent_id`),
  KEY `has_child` (`has_child`)
) ENGINE=InnoDB AUTO_INCREMENT=2654 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jc001_company_contact`
--

DROP TABLE IF EXISTS `jc001_company_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jc001_company_contact` (
  `company_id` bigint(20) unsigned NOT NULL,
  `contact_url` varchar(128) NOT NULL,
  `contact_user` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `telephone` varchar(64) NOT NULL DEFAULT '',
  `fax` varchar(64) NOT NULL DEFAULT '',
  `mobile` varchar(64) NOT NULL DEFAULT '',
  `postcode` varchar(32) NOT NULL DEFAULT '',
  `address` varchar(128) NOT NULL DEFAULT '',
  `qq` varchar(32) NOT NULL DEFAULT '',
  `extend_url` varchar(128) NOT NULL DEFAULT '',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `contact_url` (`contact_url`),
  KEY `create_time` (`create_time`),
  KEY `update_time` (`update_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='九正公司联系信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jc001_company_info`
--

DROP TABLE IF EXISTS `jc001_company_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jc001_company_info` (
  `company_id` bigint(20) unsigned NOT NULL,
  `introduce` text NOT NULL,
  `products` varchar(255) NOT NULL DEFAULT '',
  `capital` varchar(50) NOT NULL DEFAULT '0',
  `register_date` varchar(50) NOT NULL DEFAULT '',
  `register_location` varchar(128) NOT NULL DEFAULT '',
  `legal` varchar(32) NOT NULL DEFAULT '',
  `bank` varchar(128) NOT NULL DEFAULT '',
  `account` varchar(128) NOT NULL DEFAULT '',
  `acreage` varchar(128) NOT NULL DEFAULT '',
  `brand` varchar(64) NOT NULL DEFAULT '',
  `employee` varchar(64) NOT NULL DEFAULT '',
  `developer` varchar(64) NOT NULL DEFAULT '',
  `turnover` varchar(64) NOT NULL DEFAULT '',
  `certify` varchar(128) NOT NULL DEFAULT '',
  `quality` varchar(128) NOT NULL DEFAULT '',
  `market` varchar(128) NOT NULL DEFAULT '',
  `costomer` varchar(128) NOT NULL DEFAULT '',
  `data_catch_url` varchar(128) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `data_catch_url` (`data_catch_url`),
  KEY `create_time` (`create_time`),
  KEY `update_time` (`update_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='九正公司详情';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jc001_company_search`
--

DROP TABLE IF EXISTS `jc001_company_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jc001_company_search` (
  `search_id` int(10) NOT NULL AUTO_INCREMENT,
  `search_url` varchar(255) NOT NULL,
  `location_id` int(10) NOT NULL,
  `category_id` smallint(4) NOT NULL,
  `items` int(11) NOT NULL DEFAULT '0',
  `pages` int(11) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`search_id`),
  UNIQUE KEY `search_url` (`search_url`),
  KEY `category_id` (`category_id`),
  KEY `location_id` (`location_id`),
  KEY `locked` (`locked`,`valid`)
) ENGINE=InnoDB AUTO_INCREMENT=14280 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jc001_location`
--

DROP TABLE IF EXISTS `jc001_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jc001_location` (
  `location_id` smallint(4) unsigned NOT NULL,
  `location` varchar(32) NOT NULL,
  `parent_id` smallint(4) NOT NULL DEFAULT '0',
  `data_catch_url` varchar(50) NOT NULL,
  PRIMARY KEY (`location_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=418 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jc001_process`
--

DROP TABLE IF EXISTS `jc001_process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jc001_process` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `type` tinyint(2) NOT NULL DEFAULT '0',
  `locked` tinyint(1) DEFAULT '0',
  `valid` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`,`type`),
  KEY `locked` (`locked`),
  KEY `valid` (`valid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `job`
--

DROP TABLE IF EXISTS `job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_name` varchar(100) NOT NULL,
  `startime` int(10) NOT NULL,
  `endtime` int(10) NOT NULL,
  `regular` varchar(10) NOT NULL COMMENT '时间格式为\nH:m:s\n表示为多少小时多少分\n多少秒执行一次任务',
  `description` text NOT NULL,
  `rule_id` int(11) NOT NULL,
  PRIMARY KEY (`job_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(10) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`location_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rule`
--

DROP TABLE IF EXISTS `rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rule` (
  `rule_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL COMMENT '1表示分析规则\n2表示执行规则\n3表示任务对应分析url的规则\n',
  `method` varchar(100) NOT NULL,
  `params` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(100) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`subject_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tmp_company_category`
--

DROP TABLE IF EXISTS `tmp_company_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmp_company_category` (
  `category_id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(32) NOT NULL,
  `parent_id` smallint(4) NOT NULL DEFAULT '0',
  `has_child` tinyint(1) NOT NULL DEFAULT '0',
  `display_order` smallint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='临时企业分类表\r\n从传统父子关系的分类转化成左右值法的分类表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tmp_location`
--

DROP TABLE IF EXISTS `tmp_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmp_location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) NOT NULL,
  `area_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`location_id`),
  UNIQUE KEY `location` (`location`)
) ENGINE=MyISAM AUTO_INCREMENT=2638 DEFAULT CHARSET=utf8 COMMENT='中间表用来处理地区';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `url`
--

DROP TABLE IF EXISTS `url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `url` (
  `url_id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `web_id` tinyint(4) NOT NULL,
  `analysis_rule_id` int(11) NOT NULL,
  `target_rule_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  PRIMARY KEY (`url_id`),
  KEY `fk_target_rule` (`target_rule_id`),
  KEY `fk_analysis` (`analysis_rule_id`),
  KEY `fk_subject` (`subject_id`),
  CONSTRAINT `fk_analysis` FOREIGN KEY (`analysis_rule_id`) REFERENCES `rule` (`rule_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_subject` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_target_rule` FOREIGN KEY (`target_rule_id`) REFERENCES `rule` (`rule_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `uid` smallint(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `registertime` int(10) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `web`
--

DROP TABLE IF EXISTS `web`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `web` (
  `web_id` int(11) NOT NULL AUTO_INCREMENT,
  `web_name` varchar(45) NOT NULL,
  `web_url` varchar(45) NOT NULL,
  `description` text,
  PRIMARY KEY (`web_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `zsezt_company`
--

DROP TABLE IF EXISTS `zsezt_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zsezt_company` (
  `company_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(50) NOT NULL,
  `company_url` varchar(128) NOT NULL,
  `location_id` smallint(4) NOT NULL,
  `location` varchar(128) NOT NULL,
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `contact_user` varchar(32) NOT NULL DEFAULT '',
  `telephone` varchar(32) NOT NULL DEFAULT '',
  `fax` varchar(32) NOT NULL DEFAULT '',
  `mobile` varchar(32) NOT NULL DEFAULT '',
  `postcode` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL DEFAULT '',
  `address` varchar(128) NOT NULL DEFAULT '',
  `data_catch_url` varchar(128) NOT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8 COMMENT='装饰一站通公司';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-10-25 16:28:50
