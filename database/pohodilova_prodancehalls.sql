-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Май 29 2026 г., 13:22
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
-- База данных: `pohodilova_prodancehalls`
--

-- --------------------------------------------------------

--
-- Структура таблицы `booking_first_class`
--

CREATE TABLE `booking_first_class` (
  `id_booking_first_class` int(11) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` set('Новая','Обработана','Отклонена') NOT NULL DEFAULT 'Новая'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Дамп данных таблицы `booking_first_class`
--

INSERT INTO `booking_first_class` (`id_booking_first_class`, `phone`, `name`, `status`) VALUES
(1, '+76542228844', 'Виктория', 'Новая'),
(2, '+79044705478', 'Виктория', 'Обработана'),
(5, '+7 (433) 343-43-45', 'ffbfbfbfdvsdfv', 'Новая'),
(6, '+7 (383) 838-38-83', 'Аоаоао', 'Новая'),
(7, '+7 (921) 453-43-41', 'Софья', 'Новая'),
(8, '+7 (905) 346-22-11', 'Полина', 'Обработана');

-- --------------------------------------------------------

--
-- Структура таблицы `booking_hall`
--

CREATE TABLE `booking_hall` (
  `id_booking` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_slot` varchar(20) NOT NULL,
  `created_booking` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Дамп данных таблицы `booking_hall`
--

INSERT INTO `booking_hall` (`id_booking`, `user_id`, `hall_id`, `date`, `time_slot`, `created_booking`) VALUES
(9, 9, 4, '2026-05-27', '16:00', '2026-05-26 15:16:02'),
(10, 9, 4, '2026-05-27', '17:00', '2026-05-26 15:16:02'),
(11, 9, 1, '2026-05-27', '17:00', '2026-05-27 13:47:32'),
(12, 9, 2, '2026-05-28', '10:00', '2026-05-27 13:53:04');

-- --------------------------------------------------------

--
-- Структура таблицы `booking_lesson`
--

CREATE TABLE `booking_lesson` (
  `id_booking_lesson` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `coach`
--

CREATE TABLE `coach` (
  `id_coach` int(11) NOT NULL,
  `fio` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `dance_direction_id` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Дамп данных таблицы `coach`
--

INSERT INTO `coach` (`id_coach`, `fio`, `description`, `dance_direction_id`, `foto`) VALUES
(1, 'Волкова Алина', 'Танцует с 2014 года (12 лет)\r\nПреподает с 2021 года (5 лет)\r\n\r\nДостижения:\r\n— Участница команды «Volga Dance Crew»\r\n— Победительница в номинации Dancehall Solo на ивенте Uptown Weekend (2025, Санкт-Петербург)\r\n— Призёр командных соревнований Street Dance Session (2023, Ставрополь)\r\n— Участница международного танцевального лагеря Dancehall Summer Camp (2023, Москва)\r\n\r\nЧто значит для тебя танцевальное комьюнити?\r\n\"Для меня танцевальное комьюнити — это люди, рядом с которыми можно быть настоящей. Это поддержка, энергия и место, где тебя понимают без слов\".\r\n\r\nКем ты вдохновляешься в танцевальной культуре?\r\n\"Меня вдохновляют танцоры с индивидуальностью. Те, кто не пытаются быть похожими на других и несут через танец свой характер\".\r\n\r\nЧто посоветуешь начинающим танцовщикам?\r\n\"Не бойтесь ошибаться. В танцах невозможно расти идеально. Главное — не останавливаться и получать удовольствие от процесса\".\r\n\r\nКак танец влияет на твою повседневную жизнь?\r\n\"Танец помогает мне проживать эмоции и чувствовать себя свободнее. Благодаря ему жизнь становится ярче и эмоциональнее\".\r\n\r\nОпиши студию ProDanceHalls одним словом:\r\n\"Свобода\"', 1, 'VolkovaArina.png'),
(2, 'Ковалёв Артём', 'Танцует с 2016 года (10 лет) \r\nПреподает с 2022 года (4 года)\r\n\r\nДостижения:\r\n— Победитель баттлов 1х1 Hip-Hop Arena Battle (2023, Краснодар)\r\n— Финалист всероссийского чемпионата Just Dance Battle Cup (2024, Москва)\r\n— Призёр регионального фестиваля уличных танцев South Russia Dance Championship (2022)\r\n— Участник команды-финалиста Urban Skillz League (2023)\r\n\r\nЧто значит для тебя танцевальное комьюнити?\r\n\"Комьюнити — это движ. Это люди, которые заряжают тебя становиться лучше и не дают стоять на месте\".\r\n\r\nКем ты вдохновляешься в танцевальной культуре?\r\n\"Меня вдохновляют танцоры с мощной подачей и энергетикой. Люблю, когда человек выходит и сразу забирает внимание\".\r\n\r\nЧто посоветуешь начинающим танцовщикам?\r\n\"Меньше думайте о том, как выглядите со стороны. Просто тренируйтесь и не бойтесь быть смешными в начале\".\r\n\r\nКак сейчас развивается Hip-Hop в России?\r\n\"Сейчас Hip-Hop очень вырос. Появилось много сильных танцоров, баттлов и крутых мероприятий. Культура реально развивается\".\r\n\r\nКак танец влияет на твою жизнь?\r\n\"Танец научил меня дисциплине, уверенности и умению работать над собой\".\r\n\r\nОпиши студию ProDanceHalls одним словом:\r\n\"Энергия\"', 2, 'KovalevArtem.png'),
(3, 'Соколова Виктория', 'Танцует с 2012 года (14 лет) \r\nПреподает с 2020 года (6 лет)\r\n\r\nДостижения:\r\n— Победительница номинации Jazz-Funk Solo на фестивале Urban Dance Show Case (2023, Москва)\r\n— Лауреат 1 степени всероссийского конкурса Dance Energy Open (2022, Москва)\r\n— Призёр регионального чемпионата Style Fusion Battle (2024, Санкт-Петербург)\r\n\r\nЧто значит для тебя танцевальное комьюнити?\r\n\"Это атмосфера, в которой люди вдохновляют друг друга. Мне нравится ощущение семьи и поддержки внутри танцевального мира\".\r\n\r\nКем ты вдохновляешься в танцевальной культуре?\r\n\"Вдохновляют педагоги, которые умеют совмещать технику, эмоции и харизму. Те, за кем хочется наблюдать\".\r\n\r\nЧто посоветуешь начинающим танцовщикам?\r\n\"Не сравнивайте себя с другими. У каждого свой путь и свой темп развития\".\r\n\r\nКак танец влияет на твою повседневную жизнь?\r\n\"Танец делает мою жизнь живой и эмоциональной. Благодаря ему я чувствую себя увереннее и счастливее\".\r\n\r\nОпиши студию ProDanceHalls одним словом:\r\n\"Вдохновение\"', 3, 'SokolovaVika.png'),
(4, 'Миронов Данил', 'Танцует с 2016 года (6 лет)\r\nПреподает с 2023 года (3 года)\r\n\r\nДостижения:\r\n— Победитель баттлов Afro Dance 1х1 Afro Vibe Battle (2024, Москва)\r\n— Финалист всероссийского фестиваля афро-танца Afro Movement Fest (2023, Казань)\r\n— Призёр регионального чемпионата уличных стилей Urban Flow Championship (2022, Ростов-на-Дону)\r\n— Участник международного лагеря афро-танцев Afro Culture Camp (с 2023)\r\n\r\nЧто значит для тебя танцевальное комьюнити?\r\n\"Это люди, которые понимают тебя даже без слов. В танцах очень важна атмосфера и окружение\".\r\n\r\nКем ты вдохновляешься в танцевальной культуре?\r\n\"Меня вдохновляют танцоры с сильным характером и собственным стилем. Те, кто умеют быть настоящими в движении\".\r\n\r\nЧто посоветуешь начинающим танцовщикам?\r\n\"Не сдавайтесь после первых сложностей. Самый большой рост начинается именно тогда, когда становится тяжело\".\r\n\r\nКак танец влияет на твою жизнь?\r\n\"Танец сделал мою жизнь намного ярче. Он помогает выплеснуть эмоции и чувствовать внутреннюю силу\".\r\n\r\nОпиши студию ProDanceHalls одним словом:\r\n\"Движение\"', 4, 'MironovDanil.png'),
(5, 'Громов Михаил', 'Танцует с 2009 года (17 лет) \r\nПреподает с 2019 года (7 лет)\r\n\r\nДостижения:\r\n— Победитель баттлов 1х1 по брейкингу Break Nation Battle (2023, Краснодар)\r\n— Финалист всероссийского чемпионата по брейкингу Russian Breaking Cup (2024, Москва)\r\n— Участник международного отбора Underground Break League Qualifier (2023)\r\n— Входит в топ-16 участников баттлов World Street Dance Series (с 2024, Санкт-Петербург)\r\n\r\nЧто значит для тебя танцевальное комьюнити?\r\n\"Для меня это место, где люди становятся увереннее и счастливее. Танец очень сильно меняет людей\".\r\n\r\nЧто посоветуешь начинающим танцовщикам?\r\n\"Не бойтесь начинать поздно или не идеально. Главное — желание и любовь к танцу\".\r\n\r\nКак танец влияет на твою повседневную жизнь?\r\n\"Танец помогает мне сохранять баланс, вдохновение и хорошее настроение\".\r\n\r\nОпиши студию ProDanceHalls одним словом:\r\n\"Атмосфера\"', 5, 'GromovMisha.png'),
(6, 'Белова Александра', 'Танцует с 2013 года (13 лет) \r\nПреподает с 2019 года (7 лет)\r\n\r\nДостижения:\r\n— Лауреат 1 степени конкурса современного танца Contemporary Art Open (2025, Санкт-Петербург)\r\n— Победительница номинации Solo Contemporary на фестивале Dance Expression Fest (2022, Москва)\r\n— Участница постановок на фестивале New Movement Stage (2023)\r\n— Финалистка всероссийского конкурса пластики Body Language Dance Cup (2021, Казань)\r\n\r\nЧто значит для тебя танцевальное комьюнити?\r\n\"Это команда людей, которые двигаются вместе и поддерживают друг друга. В танцах очень важно окружение\".\r\n\r\nКем ты вдохновляешься в танцевальной культуре?\r\n\"Меня вдохновляют танцоры, которые умеют совмещать технику, музыку и эмоции в одно целое\".\r\n\r\nЧто посоветуешь начинающим танцовщикам?\r\n\"Будьте терпеливыми. Результат приходит не сразу, но если продолжать — прогресс точно будет\".\r\n\r\nКак танец влияет на твою жизнь?\r\n\"Благодаря танцу я научилась лучше понимать себя и выражать эмоции через движение\".\r\n\r\nОпиши студию ProDanceHalls одним словом:\r\n\"Семья\"', 6, 'BelovaSasha.png');

-- --------------------------------------------------------

--
-- Структура таблицы `dance_direction`
--

CREATE TABLE `dance_direction` (
  `id_dance_direction` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Дамп данных таблицы `dance_direction`
--

INSERT INTO `dance_direction` (`id_dance_direction`, `name`, `description`, `image`) VALUES
(1, 'Dancehall', 'Энергия, свобода и вайб Ямайки.\r\nDancehall — это про уверенность, ритм и ощущение своего тела. На тренировках тебя ждут мощные связки, работа с пластикой, музыкальностью и подачей. Этот стиль помогает раскрыться, стать увереннее в себе и научиться чувствовать своё тело.\r\n\r\nМы изучаем как базовые движения old school dancehall, так и современные choreo-постановки под актуальную музыку. Тренировки проходят ярко, эмоционально и заряжают энергией на весь день.\r\n\r\nПодходит тем, кто хочет:\r\n— Прокачать уверенность\r\n— Раскрыться\r\n— Танцевать ярко и дерзко', 'Dancehall.png'),
(2, 'Hip-Hop', 'База уличной культуры и стиль, который всегда в тренде.\r\nHip-Hop — это про грув, контроль тела и харизму. На занятиях мы изучаем базовые элементы hip-hop культуры, развиваем координацию, чувство ритма и уверенность в движении. Тренировки включают разбор техники, танцевальные связки и работу над подачей.\r\n\r\nОтлично подходит как новичкам, так и тем, кто хочет прокачать свой уровень и научиться танцевать под любую музыку.\r\n\r\nЭтот стиль про:\r\n— Свободу движений\r\n— Энергию\r\n— Уверенность в себе', 'Hip-hop.png'),
(3, 'Jazz-Funk', 'Почувствуй себя в клипе.\r\nJazz-Funk сочетает в себе пластичность, женственность и мощную подачу. Здесь сочетаются элементы jazz, hip-hop и commercial choreography.\r\n\r\nНа тренировках тебя ждут эффектные связки, развитие пластики, уверенности и артистичности. Мы учимся работать с эмоциями, подачей и сценическим образом.\r\n\r\nТы получишь:\r\n— Сценическую подачу\r\n— Пластичность\r\n— Уверенность в каждом движении', 'Jazz-funk.png'),
(4, 'Afro', 'Ритмы, которые чувствуются внутри.\r\nAfro — это энергия, драйв и связь с музыкой. Стиль основан на современных африканских танцевальных направлениях и сочетает свободу движений с мощной эмоциональной подачей.\r\n\r\nНа тренировках мы изучаем базовые качи, работу корпуса, музыкальность и атмосферные choreo-связки под современную afro-музыку.\r\n\r\nЭтот стиль про:\r\n— Раскрепощение\r\n— Развитие выносливости\r\n— Получение удовольствие от танца', 'Afro.png'),
(5, 'Breakdance', 'Сила, техника и настоящий уличный стиль.\r\nBreakdance — это акробатика, трюки и контроль тела. Этот стиль сочетает танец, акробатику и зрелищные элементы, которые делают каждое выступление эффектным и запоминающимся.\r\n\r\nНа тренировках мы изучаем базовые движения, footwork, freezes и различные трюки, постепенно развивая физическую подготовку, координацию и контроль тела.\r\n\r\nПодходит тем, кто хочет:\r\n— Развить силу и выносливость\r\n— Учить трюки\r\n— Участвовать в баттлах', 'Breakdance.png'),
(6, 'Contemporary', 'Танец эмоций и свободы.\r\nContemporary — это сочетание техники и чувств. Стиль сочетает современную хореографию, элементы классической подготовки и работу с чувствами через движение.\r\n\r\nНа занятиях мы развиваем гибкость, баланс, координацию и учимся передавать эмоции через танец. Большое внимание уделяется технике, музыкальности и работе с пространством.\r\n\r\nContemporary помогает:\r\n— Раскрыть внутреннюю свободу\r\n— Улучшить пластику\r\n— Научиться чувствовать своё тело и музыку', 'Contemporary.png');

-- --------------------------------------------------------

--
-- Структура таблицы `hall`
--

CREATE TABLE `hall` (
  `id_hall` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `price` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Дамп данных таблицы `hall`
--

INSERT INTO `hall` (`id_hall`, `title`, `description`, `foto`, `price`, `size`) VALUES
(1, 'White Flow', 'Свет, воздух и свобода движения.\r\nПросторный светлый зал с белыми шторами, мягкой подсветкой и чистым минимализмом. Идеально для репетиций, контемпа и съёмок с естественным светом.\r\n\r\n✔ качественный светлый ламинат\r\n✔ большие зеркала\r\n✔ мягкая LED-подсветка\r\n✔ отличная акустика', 'zal1.jpg', '1500', '90'),
(2, 'Dark Motion', 'Контраст, стиль и профессиональные съёмки.\r\nТемный зал с мощной цветной подсветкой и оборудованием для видео. Создан для клипов и ярких постановок.\r\n\r\n✔ большие зеркала\r\n✔ RGB-подсветка\r\n✔ оборудование для съёмки\r\n✔ мощные колонки', 'zal2.jpg', '3000', '80'),
(3, 'Cozy vibe', 'Уют, атмосфера и эстетика.\r\nНебольшой зал с тёплым светом, живыми растениями и домашней атмосферой. Идеален для камерных занятий и стильных съёмок.\r\n\r\n✔ тёплый пол\r\n✔ ламповая подсветка\r\n✔ станки\r\n✔ декор и растения\r\n', 'zal3.jpg', '1200', '50'),
(4, 'Ballet Space', 'Классика и масштаб.\r\nБольшой белый зал с панорамными зеркалами и станками. Подходит для балета, растяжки и групповых тренировок.\r\n\r\n✔ станки\r\n✔ зеркала во всю стену\r\n✔ светлый ламинат\r\n', 'zal4.jpg', '2000', '100'),
(5, 'Street Energy', 'Атмосфера улицы и драйва.\r\nКомпактный зал с кирпичной стеной, цветной подсветкой и звездными декорациями. Подходит для самых дерзких съемок.\r\n\r\n✔ тёплый пол\r\n✔ декорации\r\n✔ RGB-свет\r\n✔ мощный звук', 'zal5.jpg', '1800', '60'),
(6, 'Light Studio', 'Универсальный и комфортный.\r\nСветлый зал среднего размера — идеально для любых направлений и тренировок.\r\n\r\n✔ нейтральный интерьер\r\n✔ мягкая подсветка\r\n✔ хорошие колонки\r\n✔ теплый пол', 'zal6.jpg', '1000', '70'),
(7, 'Battle Arena', 'Сцена, энергия и шоу.\r\nБольшой зал для баттлов, мероприятий и мастер-классов. Настоящая атмосфера танцевальных вечеринок.\r\n\r\n✔ диско-шар\r\n✔ потолочная RGB-подсветка\r\n✔ оборудование для съёмки\r\n✔ мощный звук', 'zal7.jpg', '8000', '150'),
(8, 'Glow Mirror', 'Стиль и эстетика.\r\nНебольшой зал со стильными зеркалами — идеален для съёмок.\r\n\r\n✔ зеркала с лампочками\r\n✔ стильный интерьер\r\n✔ качественный звук', 'zal8.jpg', '1300', '55'),
(9, 'Moonlight', 'Магия и нежность.\r\nАтмосферный зал с декорацией луны, мягким светом и белыми шторами.\r\n\r\n✔ декоративная луна\r\n✔ мягкая подсветка\r\n✔ идеален для съёмок\r\n✔ уютная атмосфера', 'zal9.jpg', '1600', '60');

-- --------------------------------------------------------

--
-- Структура таблицы `schedule`
--

CREATE TABLE `schedule` (
  `id_schedule` int(11) NOT NULL,
  `dance_direction_id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `lesson_date` date NOT NULL,
  `lesson_time` time NOT NULL,
  `hall_id` int(11) NOT NULL,
  `max_people` int(11) NOT NULL,
  `group_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Дамп данных таблицы `schedule`
--

INSERT INTO `schedule` (`id_schedule`, `dance_direction_id`, `coach_id`, `lesson_date`, `lesson_time`, `hall_id`, `max_people`, `group_type`) VALUES
(2, 1, 1, '2026-05-16', '11:00:00', 1, 20, 'kids'),
(3, 1, 1, '2026-05-16', '18:00:00', 1, 16, 'adults'),
(4, 2, 2, '2026-05-16', '12:00:00', 5, 20, 'kids'),
(5, 2, 2, '2026-05-16', '19:00:00', 5, 16, 'adults'),
(6, 3, 3, '2026-05-16', '13:00:00', 8, 18, 'kids'),
(7, 3, 3, '2026-05-16', '20:00:00', 8, 15, 'adults'),
(8, 4, 4, '2026-05-17', '11:00:00', 6, 20, 'kids'),
(9, 4, 4, '2026-05-17', '18:00:00', 6, 16, 'adults'),
(10, 5, 5, '2026-05-17', '12:00:00', 5, 20, 'kids'),
(11, 5, 5, '2026-05-17', '19:00:00', 5, 16, 'adults'),
(12, 6, 6, '2026-05-17', '13:00:00', 9, 20, 'kids'),
(13, 6, 6, '2026-05-17', '20:00:00', 9, 15, 'adults'),
(14, 1, 1, '2026-05-18', '11:00:00', 1, 20, 'kids'),
(15, 1, 1, '2026-05-18', '18:00:00', 1, 16, 'adults'),
(16, 2, 2, '2026-05-18', '12:00:00', 5, 20, 'kids'),
(17, 2, 2, '2026-05-18', '19:00:00', 5, 16, 'adults'),
(18, 3, 3, '2026-05-18', '13:00:00', 8, 18, 'kids'),
(19, 3, 3, '2026-05-18', '20:00:00', 8, 15, 'adults'),
(20, 1, 1, '2026-05-28', '21:00:00', 5, 20, 'kids');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `fio` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `is_admin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id_user`, `fio`, `phone`, `login`, `password`, `created_at`, `is_admin`) VALUES
(1, 'Админ', '89999999999', 'Admin', '$2y$13$NIy03TWqfPluDYA18h6Id.hd.m.EQ/bKPOYRjEoTkyCQagBqeqHjG', '2026-04-27', 1),
(9, 'Сидорова Марина', '+7 (554) 443-32-32', 'MariS', '$2y$13$3FNiQXZB9njlFsoPqgBtWeOOqV5LECD.SUmvXTKJga3gGS1dwmalO', '2026-05-26', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `booking_first_class`
--
ALTER TABLE `booking_first_class`
  ADD PRIMARY KEY (`id_booking_first_class`);

--
-- Индексы таблицы `booking_hall`
--
ALTER TABLE `booking_hall`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `fk_user_hall` (`user_id`),
  ADD KEY `fk_hall_booking` (`hall_id`);

--
-- Индексы таблицы `booking_lesson`
--
ALTER TABLE `booking_lesson`
  ADD PRIMARY KEY (`id_booking_lesson`),
  ADD KEY `fk_booking_lesson_user` (`user_id`),
  ADD KEY `fk_booking_lesson_schedule` (`schedule_id`);

--
-- Индексы таблицы `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`id_coach`),
  ADD KEY `fk_dance_direction` (`dance_direction_id`);

--
-- Индексы таблицы `dance_direction`
--
ALTER TABLE `dance_direction`
  ADD PRIMARY KEY (`id_dance_direction`);

--
-- Индексы таблицы `hall`
--
ALTER TABLE `hall`
  ADD PRIMARY KEY (`id_hall`);

--
-- Индексы таблицы `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id_schedule`),
  ADD KEY `fk_schedule_coach` (`coach_id`),
  ADD KEY `fk_schedule_direction` (`dance_direction_id`),
  ADD KEY `fk_schedule_hall` (`hall_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `id_user` (`id_user`),
  ADD UNIQUE KEY `id_user_2` (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `booking_first_class`
--
ALTER TABLE `booking_first_class`
  MODIFY `id_booking_first_class` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `booking_hall`
--
ALTER TABLE `booking_hall`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `booking_lesson`
--
ALTER TABLE `booking_lesson`
  MODIFY `id_booking_lesson` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `coach`
--
ALTER TABLE `coach`
  MODIFY `id_coach` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `dance_direction`
--
ALTER TABLE `dance_direction`
  MODIFY `id_dance_direction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `hall`
--
ALTER TABLE `hall`
  MODIFY `id_hall` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id_schedule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `booking_hall`
--
ALTER TABLE `booking_hall`
  ADD CONSTRAINT `fk_hall_booking` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id_hall`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_hall` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `booking_lesson`
--
ALTER TABLE `booking_lesson`
  ADD CONSTRAINT `fk_booking_lesson_schedule` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id_schedule`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_lesson_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `coach`
--
ALTER TABLE `coach`
  ADD CONSTRAINT `fk_dance_direction` FOREIGN KEY (`dance_direction_id`) REFERENCES `dance_direction` (`id_dance_direction`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk_schedule_coach` FOREIGN KEY (`coach_id`) REFERENCES `coach` (`id_coach`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_schedule_direction` FOREIGN KEY (`dance_direction_id`) REFERENCES `dance_direction` (`id_dance_direction`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_schedule_hall` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id_hall`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
