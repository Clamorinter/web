-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 23 2025 г., 22:51
-- Версия сервера: 8.0.24
-- Версия PHP: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `virtualservers`
--

-- --------------------------------------------------------

--
-- Структура таблицы `account`
--

CREATE TABLE `account` (
  `manager_id` int NOT NULL,
  `server_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `account`
--

INSERT INTO `account` (`manager_id`, `server_id`, `user_id`) VALUES
(5, 1, 2),
(3, 2, 1),
(4, 2, 2),
(3, 3, 1),
(4, 3, 1),
(3, 4, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `user_id` int NOT NULL,
  `server_id` int NOT NULL,
  `added_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `company`
--

CREATE TABLE `company` (
  `id` int NOT NULL,
  `name` varchar(18) DEFAULT NULL,
  `balance` decimal(19,4) DEFAULT '0.0000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `company`
--

INSERT INTO `company` (`id`, `name`, `balance`) VALUES
(1, 'ООО \"ТехноСеть\"', '100000.0000'),
(2, 'ИП \"КлаудСервис\"', '20000.0000'),
(3, 'ООО \"ВебХост\"', '500000.0000'),
(4, 'ООО \"СерверГрупп\"', '4352340.0000'),
(5, 'ИП \"АйТиПро\"', '2000000.0000');

-- --------------------------------------------------------

--
-- Структура таблицы `datacenter`
--

CREATE TABLE `datacenter` (
  `id` int NOT NULL,
  `name` varchar(18) DEFAULT NULL,
  `country` varchar(18) DEFAULT NULL,
  `city` varchar(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `datacenter`
--

INSERT INTO `datacenter` (`id`, `name`, `country`, `city`) VALUES
(1, 'DC Moscow', 'Россия', 'Москва'),
(2, 'DC London', 'Великобритания', 'Лондон'),
(3, 'DC Frankfurt', 'Германия', 'Франкфурт'),
(4, 'DC New York', 'США', 'Нью-Йорк');

-- --------------------------------------------------------

--
-- Структура таблицы `manager`
--

CREATE TABLE `manager` (
  `id` int NOT NULL,
  `surname` varchar(18) DEFAULT NULL,
  `name` varchar(18) DEFAULT NULL,
  `patronymic` varchar(18) DEFAULT NULL,
  `phonenumber` varchar(18) DEFAULT NULL,
  `email` varchar(18) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `manager`
--

INSERT INTO `manager` (`id`, `surname`, `name`, `patronymic`, `phonenumber`, `email`, `password`) VALUES
(1, 'Иванов', 'Иван', 'Иванович', '9234534543', 'ivanov@mail.ru', '1234'),
(2, 'Смирнов', 'Алексей', 'Петрович', '8767876432', 'smirnov@mail.ru', '1234'),
(3, 'Сидорова', 'Мария', 'Андреевна', '9876789874', 'sidorova@mail.ru', '1234'),
(4, 'Попова', 'Екатерина', 'Владимировна', '9545245345', 'popov@mail.ru', '1234'),
(5, 'Кузнецов', 'Олег', 'Сергеевич', '8765454365', 'kuznetsov@mail.ru', '1234');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `author_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image_path`, `created_at`, `author_id`) VALUES
(1, 'Почему аренда виртуальных серверов — разумный выбор для бизнеса', '<h2>Экономия и масштабируемость</h2>\r\n  <p>Один из главных плюсов аренды виртуальных серверов — <strong>отсутствие необходимости в дорогостоящем оборудовании</strong>. Вы арендуете ресурсы по подписке и платите только за то, что используете.</p>\r\n  <h2>Быстрый старт</h2>\r\n  <p>Вы можете <em>развернуть сервер за считанные минуты</em>, не дожидаясь закупки железа или настройки локальной инфраструктуры.</p>\r\n  <h2>Гибкая настройка</h2>\r\n  <ul>\r\n    <li>Выбор операционной системы</li>\r\n    <li>Установка необходимых приложений</li>\r\n    <li>Управление доступом и безопасностью</li>\r\n  </ul>\r\n  <p>Это делает виртуальные серверы идеальным решением как для стартапов, так и для крупных компаний.</p>', 'uploads/news1', '2025-04-23 22:28:11', 1),
(4, 'Как выбрать идеальный тариф для виртуального сервера', '<h2>Оцените свои потребности</h2>\r\n  <p>Перед выбором тарифа важно понять, какие ресурсы вам нужны:</p>\r\n  <ol>\r\n    <li><strong>Процессор (CPU)</strong>: влияет на скорость обработки данных.</li>\r\n    <li><strong>Оперативная память (RAM)</strong>: необходима для стабильной работы приложений.</li>\r\n    <li><strong>Дисковое пространство (SSD)</strong>: влияет на скорость чтения и записи данных.</li>\r\n    <li><strong>Пропускная способность</strong>: важна при работе с трафиком или API.</li>\r\n  </ol>\r\n  <h2>Сравнивайте не только цену</h2>\r\n  <p>Обратите внимание на:</p>\r\n  <ul>\r\n    <li>Надёжность датацентра</li>\r\n    <li>Поддержку и SLA</li>\r\n    <li>Возможности масштабирования</li>\r\n  </ul>\r\n  <p><strong>Совет:</strong> Начните с минимального тарифа — вы всегда сможете увеличить ресурсы позже.</p>', 'uploads/news2', '2025-04-23 22:28:12', 1),
(6, 'Облачные технологии в 2025 году: тренды и прогнозы', '<h2>Глобальный рост</h2>\r\n  <p>Согласно аналитике Gartner, к концу 2025 года более <strong>80% компаний</strong> будут использовать гибридные или многооблачные инфраструктуры.</p>\r\n  <h2>Безопасность в приоритете</h2>\r\n  <p>Развитие <em>Zero Trust архитектур</em>, а также внедрение AI для выявления угроз стали ключевыми направлениями в сфере облачной безопасности.</p>\r\n  <h2>Инновации и будущее</h2>\r\n  <p>В 2025 году мы наблюдаем активное внедрение:</p>\r\n  <ul>\r\n    <li>Функционального хостинга (FaaS)</li>\r\n    <li>Кубернетизированных инфраструктур</li>\r\n    <li>Автоматизации с помощью <strong>AI DevOps</strong></li>\r\n  </ul>\r\n  <p>Будущее облаков — в <strong>гибкости, автоматизации и распределённости</strong>.</p>', 'uploads/news3', '2025-04-23 22:28:12', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) DEFAULT 'Ожидается'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `status`) VALUES
(6, 1, '2025-04-23 13:41:33', 'Аренда оформлена'),
(7, 1, '2025-04-23 22:03:19', 'Аренда оформлена'),
(8, 1, '2025-04-23 22:50:25', 'Аренда оформлена');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int NOT NULL,
  `server_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`order_id`, `server_id`) VALUES
(6, 2),
(7, 2),
(8, 2),
(6, 3),
(7, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `server_statuses`
--

CREATE TABLE `server_statuses` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `server_statuses`
--

INSERT INTO `server_statuses` (`id`, `name`) VALUES
(1, 'Доступен для аренды'),
(2, 'Арендуется'),
(3, 'Выключен');

-- --------------------------------------------------------

--
-- Структура таблицы `server_user`
--

CREATE TABLE `server_user` (
  `id` int NOT NULL,
  `server_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rented_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `specs`
--

CREATE TABLE `specs` (
  `id` int NOT NULL,
  `CPU_count` varchar(18) DEFAULT NULL,
  `RAM` varchar(18) DEFAULT NULL,
  `SSD` varchar(18) DEFAULT NULL,
  `bandwidth` varchar(18) DEFAULT NULL,
  `traffic_limit` varchar(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `specs`
--

INSERT INTO `specs` (`id`, `CPU_count`, `RAM`, `SSD`, `bandwidth`, `traffic_limit`) VALUES
(1, '2', '4', '1', '100', '1'),
(2, '4', '8', '2', '200', '2'),
(3, '8', '16', '4', '400', '4'),
(4, '16', '32', '8', '800', '8');

-- --------------------------------------------------------

--
-- Структура таблицы `tariff`
--

CREATE TABLE `tariff` (
  `id` int NOT NULL,
  `name` varchar(18) DEFAULT NULL,
  `month_price` decimal(19,2) DEFAULT '0.00',
  `specs_id` int DEFAULT NULL,
  `datacenter_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `tariff`
--

INSERT INTO `tariff` (`id`, `name`, `month_price`, `specs_id`, `datacenter_id`) VALUES
(1, 'Basic', '500.00', 1, 2),
(2, 'Standard', '1000.00', 3, 1),
(3, 'Advanced', '2000.00', 4, 3),
(4, 'Enterprise', '4000.00', 2, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `surname` varchar(18) DEFAULT NULL,
  `name` varchar(18) DEFAULT NULL,
  `patronymic` varchar(18) DEFAULT NULL,
  `phonenumber` varchar(18) DEFAULT NULL,
  `email` varchar(18) DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `surname`, `name`, `patronymic`, `phonenumber`, `email`, `company_id`, `password`) VALUES
(1, 'Соколов', 'Валерий', 'Алексеевич', '9456346456', 'sokolov@mail.ru', 1, '123456'),
(2, 'Васильев', 'Артем', 'Викторович', '9653456345', 'vasiliev@mail.ru', 2, '1234'),
(3, 'Михайлова', 'Ольга', 'Сергеевна', '9123153443', 'mikhailova@mail.ru', 2, '1234'),
(4, 'Орлов', 'Павел', 'Александрович', '9165425343', 'orlov@mail.ru', 3, '1234'),
(5, 'Егорова', 'Анна', 'Владимировна', '9539765434', 'egorova@mail.ru', 1, '1234'),
(6, 'Тестов', 'Артем', 'Николаевич', '9434254354', 'test@gmail.com', 3, '9999'),
(7, 'Петров', 'Артём', 'Алексеевич', '9818001212', 'm@inbox.ru', 5, '12345');

-- --------------------------------------------------------

--
-- Структура таблицы `virtual_server`
--

CREATE TABLE `virtual_server` (
  `id` int NOT NULL,
  `name` varchar(18) DEFAULT NULL,
  `status` varchar(18) DEFAULT NULL,
  `ip_address` varchar(18) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `tariff_id` int DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  `status_id` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `virtual_server`
--

INSERT INTO `virtual_server` (`id`, `name`, `status`, `ip_address`, `start_date`, `end_date`, `tariff_id`, `company_id`, `status_id`) VALUES
(1, 'Server-1', 'Активен', '192.132.144.124', '2025-01-01 00:00:00', '2025-01-30 00:00:00', 1, 3, 1),
(2, 'Server-2', 'Неактивен', '123.132.142.232', '2024-03-03 00:00:00', '2024-04-03 00:00:00', 2, 1, 1),
(3, 'Server-3', 'Активен', '192.168.111.111', '2024-03-01 00:00:00', '2026-01-01 00:00:00', 4, 2, 1),
(4, 'Server-4', 'Заблокирован', '180.180.180.180', '2023-12-12 00:00:00', '2025-10-21 00:00:00', 2, 4, 1),
(5, 'Server-5', 'Ожидание', '120.120.120.120', '2022-08-19 00:00:00', '2025-12-05 00:00:00', 3, 5, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`manager_id`,`server_id`,`user_id`),
  ADD KEY `server_id` (`server_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`user_id`,`server_id`),
  ADD KEY `server_id` (`server_id`);

--
-- Индексы таблицы `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `datacenter`
--
ALTER TABLE `datacenter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_id`,`server_id`),
  ADD KEY `server_id` (`server_id`);

--
-- Индексы таблицы `server_statuses`
--
ALTER TABLE `server_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `server_user`
--
ALTER TABLE `server_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `server_id` (`server_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `specs`
--
ALTER TABLE `specs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `tariff`
--
ALTER TABLE `tariff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `datacenter_id` (`datacenter_id`),
  ADD KEY `specs_id` (`specs_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Индексы таблицы `virtual_server`
--
ALTER TABLE `virtual_server`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `tariff_id` (`tariff_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `fk_virtual_server_status` (`status_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `company`
--
ALTER TABLE `company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `datacenter`
--
ALTER TABLE `datacenter`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `manager`
--
ALTER TABLE `manager`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `server_statuses`
--
ALTER TABLE `server_statuses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `server_user`
--
ALTER TABLE `server_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `specs`
--
ALTER TABLE `specs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `tariff`
--
ALTER TABLE `tariff`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `virtual_server`
--
ALTER TABLE `virtual_server`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`id`),
  ADD CONSTRAINT `account_ibfk_2` FOREIGN KEY (`server_id`) REFERENCES `virtual_server` (`id`),
  ADD CONSTRAINT `account_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`server_id`) REFERENCES `virtual_server` (`id`);

--
-- Ограничения внешнего ключа таблицы `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `manager` (`id`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`server_id`) REFERENCES `virtual_server` (`id`);

--
-- Ограничения внешнего ключа таблицы `server_user`
--
ALTER TABLE `server_user`
  ADD CONSTRAINT `server_user_ibfk_1` FOREIGN KEY (`server_id`) REFERENCES `virtual_server` (`id`),
  ADD CONSTRAINT `server_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `tariff`
--
ALTER TABLE `tariff`
  ADD CONSTRAINT `tariff_ibfk_1` FOREIGN KEY (`datacenter_id`) REFERENCES `datacenter` (`id`),
  ADD CONSTRAINT `tariff_ibfk_2` FOREIGN KEY (`specs_id`) REFERENCES `specs` (`id`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`);

--
-- Ограничения внешнего ключа таблицы `virtual_server`
--
ALTER TABLE `virtual_server`
  ADD CONSTRAINT `fk_virtual_server_status` FOREIGN KEY (`status_id`) REFERENCES `server_statuses` (`id`),
  ADD CONSTRAINT `virtual_server_ibfk_1` FOREIGN KEY (`tariff_id`) REFERENCES `tariff` (`id`),
  ADD CONSTRAINT `virtual_server_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
