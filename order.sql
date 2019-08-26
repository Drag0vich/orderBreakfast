-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Авг 26 2019 г., 20:23
-- Версия сервера: 5.7.27-0ubuntu0.19.04.1
-- Версия PHP: 7.2.19-0ubuntu0.19.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `order`
--

-- --------------------------------------------------------

--
-- Структура таблицы `user_authorize`
--

CREATE TABLE `user_authorize` (
  `ID` int(11) NOT NULL,
  `LOGIN` varchar(255) NOT NULL,
  `PASS` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_authorize`
--

INSERT INTO `user_authorize` (`ID`, `LOGIN`, `PASS`) VALUES
(1, 'admin', '202CB962AC59075B964B07152D234B70');


-- --------------------------------------------------------

--
-- Структура таблицы `user_auth_log`
--

CREATE TABLE `user_auth_log` (
  `AUTH_ID` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `SESSION_ID` varchar(255) NOT NULL,
  `USER_AGENT` varchar(255) NOT NULL,
  `IP_ADDRESS` varchar(255) NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_auth_log`
--

INSERT INTO `user_auth_log` (`AUTH_ID`, `ID`, `SESSION_ID`, `USER_AGENT`, `IP_ADDRESS`, `TIMESTAMP`) VALUES
(1, 1, 's8ur1hfge9p9i274k9ls1hgftd', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '::1', '2019-08-26 20:00:32'),
(2, 1, 's8ur1hfge9p9i274k9ls1hgftd', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '::1', '2019-08-26 20:01:34');

-- --------------------------------------------------------

--
-- Структура таблицы `user_info`
--

CREATE TABLE `user_info` (
  `ID` int(11) NOT NULL,
  `GIVEN_NAME` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Женя',
  `FAMILY_NAME` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Спицин',
  `EMAIL` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `LOGIN` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `DATE_REGISTER` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PASS` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_info`
--

INSERT INTO `user_info` (`ID`, `GIVEN_NAME`, `FAMILY_NAME`, `EMAIL`, `LOGIN`, `DATE_REGISTER`, `PASS`) VALUES
(1, 'Женя', 'Спицин', 'nike_nrj@mail.ru', 'Dragovich', '2019-08-19 00:24:19', '202CB962AC59075B964B07152D234B70');

-- --------------------------------------------------------

--
-- Структура таблицы `user_permissions`
--

CREATE TABLE `user_permissions` (
  `ID` int(11) NOT NULL,
  `ADMIN` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_permissions`
--

INSERT INTO `user_permissions` (`ID`, `ADMIN`) VALUES
(1, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `user_authorize`
--
ALTER TABLE `user_authorize`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `user_auth_log`
--
ALTER TABLE `user_auth_log`
  ADD PRIMARY KEY (`AUTH_ID`),
  ADD UNIQUE KEY `AUTH_ID` (`AUTH_ID`);

--
-- Индексы таблицы `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `LOGIN` (`LOGIN`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- Индексы таблицы `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `user_auth_log`
--
ALTER TABLE `user_auth_log`
  MODIFY `AUTH_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `user_info`
--
ALTER TABLE `user_info`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `user_authorize`
--
ALTER TABLE `user_authorize`
  ADD CONSTRAINT `user_authorize_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `user_info` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `user_permissions_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `user_info` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
