-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 15 2018 г., 17:34
-- Версия сервера: 5.5.55-0+deb8u1
-- Версия PHP: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `cctldby`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auction_date`
--

CREATE TABLE IF NOT EXISTS `auction_date` (
`id` int(11) NOT NULL,
  `auction_start` varchar(24) NOT NULL,
  `auction_end` varchar(24) NOT NULL,
  `auction_state` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Структура таблицы `domains_list`
--

CREATE TABLE IF NOT EXISTS `domains_list` (
`id` int(11) NOT NULL,
  `cctld_id` int(11) NOT NULL,
  `link` text NOT NULL,
  `domain` text NOT NULL,
  `tic` int(11) NOT NULL,
  `alexa` int(11) NOT NULL,
  `dmoz` text NOT NULL,
  `yaca` text NOT NULL,
  `ags` text NOT NULL,
  `auction_date` varchar(24) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=23668 DEFAULT CHARSET=utf8;


--
-- Индексы таблицы `auction_date`
--
ALTER TABLE `auction_date`
 ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `domains_list`
--
ALTER TABLE `domains_list`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
