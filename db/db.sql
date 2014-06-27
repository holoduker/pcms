-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 04 2013 г., 01:46
-- Версия сервера: 5.6.14
-- Версия PHP: 5.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `skc_www`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cms_admin`
--

CREATE TABLE IF NOT EXISTS `cms_admin` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(255) NOT NULL DEFAULT '',
  `admin_login` varchar(50) NOT NULL DEFAULT '',
  `admin_password` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;


-- --------------------------------------------------------

--
-- Структура таблицы `cms_admin_session`
--

CREATE TABLE IF NOT EXISTS `cms_admin_session` (
  `cas_admin_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cas_session` char(40) NOT NULL,
  `cas_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cas_ip` int(10) DEFAULT NULL
) ENGINE=MEMORY DEFAULT CHARSET=cp1251;


-- --------------------------------------------------------

--
-- Структура таблицы `cms_photo`
--

CREATE TABLE IF NOT EXISTS `cms_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `photo_gallery_id` smallint(10) unsigned NOT NULL DEFAULT '0',
  `photo_name` varchar(255) DEFAULT NULL,
  `photo_smallpic` varchar(100) NOT NULL DEFAULT '',
  `photo_bigpic` varchar(100) NOT NULL DEFAULT '',
  `photo_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`photo_id`),
  KEY `photo_gallery_id` (`photo_gallery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=221 ;


--
-- Структура таблицы `cms_photo_gallery`
--

CREATE TABLE IF NOT EXISTS `cms_photo_gallery` (
  `gal_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `gal_name` varchar(255) NOT NULL DEFAULT '',
  `gal_folder` varchar(100) NOT NULL,
  `gal_order` int(11) NOT NULL DEFAULT '0',
  `gal_showmain` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`gal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=22 ;


--
-- Структура таблицы `cms_pressrelease`
--

CREATE TABLE IF NOT EXISTS `cms_pressrelease` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `pr_title_ru` varchar(255) NOT NULL,
  `pr_title_en` varchar(255) NOT NULL,
  `pr_pic` varchar(100) DEFAULT NULL,
  `pr_text_ru` text NOT NULL,
  `pr_text_en` text NOT NULL,
  PRIMARY KEY (`pr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cms_project`
--

CREATE TABLE IF NOT EXISTS `cms_project` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `pr_title_ru` varchar(255) NOT NULL,
  `pr_title_en` varchar(255) NOT NULL DEFAULT '',
  `pr_pic` varchar(100) DEFAULT NULL,
  `pr_bigpic` varchar(100) DEFAULT NULL,
  `pr_shorttext` text,
  `pr_text` text NOT NULL,
  `pr_gallery` int(11) NOT NULL DEFAULT '0',
  `pr_date` date DEFAULT NULL,
  PRIMARY KEY (`pr_id`),
  KEY `pr_date` (`pr_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=24 ;

--
-- Дамп данных таблицы `cms_project`
--


--
-- Структура таблицы `cms_project_photo`
--

CREATE TABLE IF NOT EXISTS `cms_project_photo` (
  `pp_id` int(11) NOT NULL AUTO_INCREMENT,
  `pp_project_id` int(11) NOT NULL,
  `pp_photo_id` int(11) NOT NULL,
  `pp_title` varchar(255) NOT NULL,
  PRIMARY KEY (`pp_id`),
  KEY `pp_project_id` (`pp_photo_id`),
  KEY `pp_photo_id` (`pp_photo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
