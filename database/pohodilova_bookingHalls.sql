-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Дек 17 2025 г., 20:28
-- Версия сервера: 11.4.7-MariaDB-ubu2404
-- Версия PHP: 8.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pohodilova_bookingHalls`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `id_booking` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_slot` varchar(20) NOT NULL,
  `status` enum('pending','approved','cancelled') NOT NULL DEFAULT 'pending',
  `created_booking` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id_booking`, `user_id`, `hall_id`, `date`, `time_slot`, `status`, `created_booking`) VALUES
(5, 5, 1, '2025-01-10', '15:00', 'approved', '2025-12-16 08:27:56'),
(6, 5, 1, '2025-01-12', '15:00', 'pending', '2025-12-16 08:27:59');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id_category`, `name`) VALUES
(1, 'Стандарт'),
(2, 'Премиум'),
(3, 'Тематический зал');

-- --------------------------------------------------------

--
-- Структура таблицы `halls`
--

CREATE TABLE `halls` (
  `id_hall` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Дамп данных таблицы `halls`
--

INSERT INTO `halls` (`id_hall`, `title`, `description`, `category_id`, `price`, `foto`) VALUES
(1, 'Обновленный зал1', 'Новое описание', 1, 1200, '/uploads/halls/obnovlennyy_zal1_1_1765875552.jpg'),
(2, 'Обновленный зал 2', 'Тёмный зал с подсветкой', 3, 1500, '/uploads/halls/black_box_2_1765828052.jpg'),
(3, 'Premium Loft', 'Большой зал с панорамными окнами', 2, 2500, '/uploads/halls/loft.jpg'),
(4, 'Dance Cube', 'Зал для интенсивных тренировок', 3, 1300, '/uploads/halls/cube.jpg'),
(5, 'Classic Room', 'Классический танцевальный зал', 1, 900, '/uploads/halls/classic.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `first_name`, `last_name`, `phone`, `login`, `password`, `avatar`, `role`, `created_at`) VALUES
(1, 'Виктория', 'Походилова', '+79045439911', 'vikap', '$2y$13$WZqQMVYxhnotF/H09FhkeO26E.lWhQSpi.3MQZPZ8IDr45gqd8bbi', '', 'admin', '2025-12-08 08:15:33'),
(2, 'Виктория', 'Админ', '+71235435500', 'admin', '123456', '', 'admin', '2025-12-16 08:33:10'),
(4, 'Иван', 'Петров', '89001234568', 'ivanp', '$2y$13$WZqQMVYxhnotF/H09FhkeO26E.lWhQSpi.3MQZPZ8IDr45gqd8bbi', '', 'user', '2025-12-15 19:17:09'),
(5, 'Иван', 'Петров', '89001564568', 'ivanpet', '$2y$13$gwCXWoOH1LTD0YHJ7Jz56emBbJC52LTTF1AoFFn96BUTxwActvWDW', '', 'user', '2025-12-15 20:14:09'),
(6, 'Антон', 'Дмитриев', '89001235764', 'anton', '$2y$13$jYOfRJz0NPpsQRt70fDYO.femw81gF4Ix2xcDL686ktqE.6wAZKgm', '/uploads/avatars/user6_1765875287.png', 'user', '2025-12-16 08:06:15'),
(7, 'Виктория', 'П', '89661234568', 'vikaph', '$2y$13$tli4KYQQ4HN0f0Arl1DV3eiQgwLiHVP17V2fd2csuzaf3ly5YMgSu', '', 'user', '2025-12-16 12:10:24'),
(8, 'Владимир', 'Петров', '8900120000', 'vlad', '$2y$13$xCw8VAstI1pTF5e0/4cYy.Fw3dHCp3nGm3Vfj4GEuz4YmfWUjYfle', '', 'user', '2025-12-17 18:26:49');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `booking_id_fk` (`user_id`),
  ADD KEY `idx_hall_date_time` (`hall_id`,`date`,`time_slot`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_date_hall` (`date`,`hall_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Индексы таблицы `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id_hall`),
  ADD KEY `category_fk` (`category_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `idx_phone_unique` (`phone`),
  ADD KEY `idx_login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `halls`
--
ALTER TABLE `halls`
  MODIFY `id_hall` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `booking_hall_fk` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id_hall`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `halls`
--
ALTER TABLE `halls`
  ADD CONSTRAINT `category_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
