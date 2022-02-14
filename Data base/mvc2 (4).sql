-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Фев 14 2022 г., 14:15
-- Версия сервера: 10.4.21-MariaDB
-- Версия PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mvc2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `academic_performances`
--

CREATE TABLE `academic_performances` (
  `id` int(11) NOT NULL,
  `discipline` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `academic_performances`
--

INSERT INTO `academic_performances` (`id`, `discipline`, `student`, `rate`) VALUES
(1, 1, 3, 7),
(2, 4, 3, 7),
(3, 2, 3, 6),
(5, 3, 3, 4),
(6, 1, 5, 4),
(7, 5, 9, 6),
(8, 6, 3, 1),
(9, 6, 9, 1),
(10, 6, 10, 2),
(11, 6, 7, 2),
(12, 1, 7, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `disciplines`
--

CREATE TABLE `disciplines` (
  `id` int(11) NOT NULL,
  `discipline_title` int(11) NOT NULL,
  `educational_plan` int(11) NOT NULL,
  `hours` int(4) NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `disciplines`
--

INSERT INTO `disciplines` (`id`, `discipline_title`, `educational_plan`, `hours`, `type`, `title`) VALUES
(1, 2, 21, 44, '0', 'Пирвп (Группа 492, семестр 1, курс 1)'),
(2, 1, 21, 42, '0', 'ГГ (Группа 492, семестр 1, курс 1)'),
(3, 2, 22, 50, 'Экзамен', 'Пирвп (Группа 492, семестр 2, курс 1, Экзамен)'),
(4, 1, 22, 50, 'Див зачёт', 'ГГ (Группа 492, семестр 2, курс 1, Див зачёт)'),
(5, 3, 23, 36, 'Экзамен', 'Оаип (Группа 494, семестр 1, курс 1, Экзамен)'),
(6, 4, 24, 72, 'Див зачёт', 'Практика на стороне сервера (Группа 492, семестр 2, курс 3, Див зачёт)'),
(7, 4, 22, 32, 'Див зачёт', 'Практика на стороне сервера (Группа 492, семестр 2, курс 1, Див зачёт)'),
(8, 5, 22, 13133, 'Див зачёт', 'АА (Группа 492, семестр 2, курс 1, Див зачёт)');

-- --------------------------------------------------------

--
-- Структура таблицы `discipline_titles`
--

CREATE TABLE `discipline_titles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `discipline_titles`
--

INSERT INTO `discipline_titles` (`id`, `title`) VALUES
(1, 'ГГ'),
(2, 'Пирвп'),
(3, 'Оаип'),
(4, 'Практика на стороне сервера'),
(5, 'АА');

-- --------------------------------------------------------

--
-- Структура таблицы `educational_plans`
--

CREATE TABLE `educational_plans` (
  `id` int(11) NOT NULL,
  `students_group` int(11) NOT NULL,
  `course` int(2) NOT NULL,
  `semester` int(2) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `educational_plans`
--

INSERT INTO `educational_plans` (`id`, `students_group`, `course`, `semester`, `title`) VALUES
(21, 6, 1, 1, 'Группа 492, семестр 1, курс 1'),
(22, 6, 1, 2, 'Группа 492, семестр 2, курс 1'),
(23, 8, 1, 1, 'Группа 494, семестр 1, курс 1'),
(24, 6, 3, 2, 'Группа 492, семестр 2, курс 3'),
(25, 9, 2, 2, 'Группа 444, семестр 2, курс 2');

-- --------------------------------------------------------

--
-- Структура таблицы `rates`
--

CREATE TABLE `rates` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `rates`
--

INSERT INTO `rates` (`id`, `title`) VALUES
(1, 'Зачёт'),
(2, 'Не зачёт'),
(3, '1'),
(4, '2'),
(5, '3'),
(6, '4'),
(7, '5');

-- --------------------------------------------------------

--
-- Структура таблицы `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `educational_plan` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `reports`
--

INSERT INTO `reports` (`id`, `educational_plan`, `image`) VALUES
(2, 22, 'C:\\xampp\\htdocs\\praktika\\app\\Model\\..\\..\\public\\upload\\'),
(3, 21, 'public\\upload\\'),
(4, 24, 'public\\upload\\fb__mini.png'),
(5, 21, 'public\\upload\\fb.png'),
(6, 24, 'public\\upload\\bg4.jpg'),
(7, 24, 'public/uploadbutmol.png'),
(8, 22, 'public/uploadbutmol.png'),
(9, 22, 'public/uploadкрол.png'),
(10, 22, 'public/upload/mz3.png'),
(11, 22, 'public/upload/'),
(12, 22, 'public/upload/bg5.jpg'),
(13, 22, 'public/upload/world.jpg'),
(14, 22, 'public/upload/facebook.png'),
(15, 24, 'public/upload/inst.png'),
(16, 24, 'public/upload/blue.png'),
(17, 21, 'public/upload/blue.png'),
(18, 21, 'public/upload/unins000.dat'),
(19, 21, 'public/upload/background.png'),
(20, 21, 'public/upload/envelope.png'),
(21, 22, 'public/upload/yes.png'),
(22, 24, 'public/upload/window.png'),
(23, 24, 'public/upload/fb.png'),
(24, 24, 'public/upload/button.png');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `title`, `code`) VALUES
(1, 'Администратор', 'admin'),
(2, 'Персонал', 'staff'),
(3, 'Куратор', 'curator');

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `patronymic` varchar(255) DEFAULT NULL,
  `sex` tinyint(1) NOT NULL,
  `date_birth` date NOT NULL,
  `address` text NOT NULL,
  `students_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `name`, `lastname`, `patronymic`, `sex`, `date_birth`, `address`, `students_group`) VALUES
(1, 'а', 'а', 'а', 1, '1111-01-01', '1', 6),
(3, 'Артём', 'Анисимов', 'Владимирович', 1, '2003-01-01', 'Пушкина дом 10', 6),
(5, 'Дмитрий', 'Дмитриев', '', 1, '4544-05-04', 'сфвыывс', 6),
(6, 'Валерия', 'Валерьевна', '', 0, '1212-12-12', 'ымс', 6),
(7, 'Илья', 'Кухарев', 'Павлович', 1, '3232-12-12', 'ролорло рлодб', 6),
(8, 'пп', 'пп', 'пп', 0, '5555-05-05', 'пп', 7),
(9, 'Виктор', 'Миллер', 'Романович', 1, '2003-11-17', 'г.Томск Каштак', 8),
(10, 'Илья', 'Муконин', 'Владимирович', 1, '2003-06-30', 'Томск Интер...', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `students_groups`
--

CREATE TABLE `students_groups` (
  `id` int(11) NOT NULL,
  `title` int(11) NOT NULL,
  `course` int(2) NOT NULL,
  `semester` int(2) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `students_groups`
--

INSERT INTO `students_groups` (`id`, `title`, `course`, `semester`, `user`) VALUES
(6, 492, 3, 2, 14),
(7, 493, 13131, 13131331, 3),
(8, 494, 1, 1, 17),
(9, 444, 3, 2, 18);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `patronymic` varchar(255) DEFAULT NULL,
  `date_birth` date DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `lastname`, `patronymic`, `date_birth`, `sex`, `address`, `role`, `token`) VALUES
(1, '1', 'c4ca4238a0b923820dcc509a6f75849b', 'Иван', 'Иванов', 'Иванович', '1996-02-21', 1, 'Ул.Пушкина, дом 12, кв 12', 1, NULL),
(2, '2', 'c81e728d9d4c2f636f067f89cc14862c', 'Петр', 'Петров', 'Петрович', '1999-04-22', 1, 'Ул. Герцена, дом 1, кв 1', 2, 'd0c3aff9d201c3037e0386866c98a79a'),
(3, '3', 'eccbc87e4b5ce2fe28308fd9f2a7baf3', 'Василий', 'Васильев', 'Васильевич', '2015-02-19', 1, 'вжыламщвмпощк оплкоылопрл', 3, 'c7403f0f64b6f629fd43661593d04316'),
(4, '12', 'c20ad4d76fe97759aa27a0c99bff6710', '12', '', NULL, NULL, NULL, NULL, 1, NULL),
(5, 'dd', '1aabac6d068eef6a7bad3fdf50a05cc8', 'Илья', '', NULL, NULL, NULL, NULL, 0, NULL),
(12, 'aa', '4124bc0a9335c27f086f24ba207a4912', 'aa', 'aa', 'aa', '1212-12-12', 1, 'aa', 2, NULL),
(13, '44', 'f7177163c833dff4b38fc8d2872f1ec6', '4', '', NULL, NULL, NULL, NULL, 0, NULL),
(14, '55', 'b53b3a3d6ab90ce0268229151c9bde11', 'КУРАТОР 14', '', NULL, NULL, NULL, NULL, 3, '3c2ab96fd335cf57dec76d32d4adb601'),
(15, '11', '6512bd43d9caa6e02c990b0a82652dca', '&lt;script&gt;alert()&lt;/script&gt;', '11', '11', '1122-11-11', 0, '11', 2, NULL),
(16, 'gg', '73c18c59a39b18382081ec00bb456d43', 'гг', 'гг', 'гг', '0000-00-00', 0, 'гг', 2, NULL),
(17, 'ist', 'e5a93371cfc7eab4a88221dd1f6c1a3c', 'Сергей', 'Истигечев', 'Сергеевич', '1999-12-12', 1, 'г. Томск тыры пыры', 3, NULL),
(18, 'you', '639bae9ac6b3e1a84cebb7b403297b79', 'Юрий', 'Грушевский', 'Викторович', '2000-05-03', 1, 'Пушкина дом 10', 3, NULL),
(20, 'c97ba3e8a04bff66acc0251586e25a3a', '21232f297a57a5a743894a0e4a801fc3', 'admin', '', NULL, NULL, NULL, NULL, 0, NULL),
(28, 'login is busy', '21232f297a57a5a743894a0e4a801fc3', 'admin', '', NULL, NULL, NULL, NULL, 0, NULL),
(29, '7c7defeca8b2967cc67c56bb97995a83', '21232f297a57a5a743894a0e4a801fc3', 'admin', '', NULL, NULL, NULL, NULL, 0, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `academic_performances`
--
ALTER TABLE `academic_performances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`discipline`,`student`,`rate`),
  ADD KEY `student` (`student`),
  ADD KEY `discipline` (`discipline`),
  ADD KEY `rate` (`rate`);

--
-- Индексы таблицы `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`discipline_title`,`educational_plan`),
  ADD KEY `discipline_title` (`discipline_title`),
  ADD KEY `curriculum` (`educational_plan`);

--
-- Индексы таблицы `discipline_titles`
--
ALTER TABLE `discipline_titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `educational_plans`
--
ALTER TABLE `educational_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`students_group`),
  ADD KEY `students_group` (`students_group`);

--
-- Индексы таблицы `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `educational_plan` (`educational_plan`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`students_group`),
  ADD KEY `students_group` (`students_group`);

--
-- Индексы таблицы `students_groups`
--
ALTER TABLE `students_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_2` (`user`),
  ADD KEY `id` (`id`,`user`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `id` (`id`,`role`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `academic_performances`
--
ALTER TABLE `academic_performances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `discipline_titles`
--
ALTER TABLE `discipline_titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `educational_plans`
--
ALTER TABLE `educational_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `rates`
--
ALTER TABLE `rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `students_groups`
--
ALTER TABLE `students_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `academic_performances`
--
ALTER TABLE `academic_performances`
  ADD CONSTRAINT `academic_performances_ibfk_1` FOREIGN KEY (`student`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `academic_performances_ibfk_2` FOREIGN KEY (`discipline`) REFERENCES `disciplines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `academic_performances_ibfk_3` FOREIGN KEY (`rate`) REFERENCES `rates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `disciplines`
--
ALTER TABLE `disciplines`
  ADD CONSTRAINT `disciplines_ibfk_1` FOREIGN KEY (`discipline_title`) REFERENCES `discipline_titles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `disciplines_ibfk_2` FOREIGN KEY (`educational_plan`) REFERENCES `educational_plans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `educational_plans`
--
ALTER TABLE `educational_plans`
  ADD CONSTRAINT `educational_plans_ibfk_1` FOREIGN KEY (`students_group`) REFERENCES `students_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`educational_plan`) REFERENCES `educational_plans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`students_group`) REFERENCES `students_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `students_groups`
--
ALTER TABLE `students_groups`
  ADD CONSTRAINT `students_groups_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
