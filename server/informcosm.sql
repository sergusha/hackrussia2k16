-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 20 2016 г., 02:15
-- Версия сервера: 5.6.33-79.0-log
-- Версия PHP: 5.6.18-pl0-gentoo

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `informcosm`
--

-- --------------------------------------------------------

--
-- Структура таблицы `call_table`
--

CREATE TABLE `call_table` (
  `id` int(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `activity` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `coaсh_table`
--

CREATE TABLE `coaсh_table` (
  `id` int(11) NOT NULL,
  `coordX` float NOT NULL,
  `coordY` float NOT NULL,
  `employed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `coaсh_table`
--

INSERT INTO `coaсh_table` (`id`, `coordX`, `coordY`, `employed`) VALUES
(1, 59.9319, 30.3547, 0),
(2, 60.0091, 30.3708, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `department_detail_table`
--

CREATE TABLE `department_detail_table` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `scrubs_id` int(11) NOT NULL,
  `num_of_place` int(11) NOT NULL,
  `employed` int(11) NOT NULL,
  `buffer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `department_detail_table`
--

INSERT INTO `department_detail_table` (`id`, `department_id`, `scrubs_id`, `num_of_place`, `employed`, `buffer`) VALUES
(1, 1, 1, 12, 0, 0),
(2, 2, 1, 20, 0, 0),
(3, 3, 1, 14, 0, 0),
(4, 4, 1, 5, 0, 0),
(5, 5, 1, 10, 0, 0),
(6, 1, 2, 10, 0, 0),
(7, 2, 2, 30, 0, 0),
(8, 3, 2, 40, 0, 0),
(9, 4, 2, 4, 0, 0),
(10, 5, 2, 6, 0, 0),
(11, 1, 4, 11, 0, 0),
(12, 2, 4, 3, 0, 0),
(13, 3, 4, 21, 0, 0),
(14, 4, 4, 43, 0, 0),
(15, 5, 4, 9, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `department_table`
--

CREATE TABLE `department_table` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `department_table`
--

INSERT INTO `department_table` (`id`, `name`) VALUES
(1, 'Травма'),
(2, 'Хирургия'),
(3, 'Гастроэнтерология'),
(4, 'Наркологическое'),
(5, 'Кардиологическое');

-- --------------------------------------------------------

--
-- Структура таблицы `scrubs_detail_table`
--

CREATE TABLE `scrubs_detail_table` (
  `id` int(11) NOT NULL,
  `scrubs_id` int(11) NOT NULL,
  `coordX` double NOT NULL,
  `coordY` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `scrubs_detail_table`
--

INSERT INTO `scrubs_detail_table` (`id`, `scrubs_id`, `coordX`, `coordY`) VALUES
(1, 1, 59.935672, 30.34912),
(2, 2, 60.029373, 30.390147),
(3, 4, 59.877056, 29.916244);

-- --------------------------------------------------------

--
-- Структура таблицы `scrubs_table`
--

CREATE TABLE `scrubs_table` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `scrubs_table`
--

INSERT INTO `scrubs_table` (`id`, `name`) VALUES
(1, 'Мариинская больница'),
(2, 'Николаевская больница'),
(4, 'Елизаровская больница');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `call_table`
--
ALTER TABLE `call_table`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `coaсh_table`
--
ALTER TABLE `coaсh_table`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `department_detail_table`
--
ALTER TABLE `department_detail_table`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `department_table`
--
ALTER TABLE `department_table`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `scrubs_detail_table`
--
ALTER TABLE `scrubs_detail_table`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `scrubs_table`
--
ALTER TABLE `scrubs_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `call_table`
--
ALTER TABLE `call_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `coaсh_table`
--
ALTER TABLE `coaсh_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `department_detail_table`
--
ALTER TABLE `department_detail_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `department_table`
--
ALTER TABLE `department_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `scrubs_detail_table`
--
ALTER TABLE `scrubs_detail_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `scrubs_table`
--
ALTER TABLE `scrubs_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
