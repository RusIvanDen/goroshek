-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 27 2024 г., 01:21
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `demo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `basket`
--

CREATE TABLE `basket` (
  `id_basket` int NOT NULL,
  `id_user` int NOT NULL,
  `id_product` int NOT NULL,
  `count_basket` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `basket`
--

INSERT INTO `basket` (`id_basket`, `id_user`, `id_product`, `count_basket`) VALUES
(44, 13, 60, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id_category` int NOT NULL,
  `name_category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id_category`, `name_category`) VALUES
(26, 'Квадроциклы'),
(27, 'Мотоциклы'),
(28, 'Мопеды'),
(29, 'Скутеры');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2024_06_22_075038_add_attributes_to_products_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `id_order` int NOT NULL,
  `id_status` int NOT NULL,
  `id_user` int NOT NULL,
  `sum_order` int NOT NULL,
  `reason_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id_order`, `id_status`, `id_user`, `sum_order`, `reason_order`, `created_at`, `updated_at`) VALUES
(39, 3, 1, 29990, '1', '2024-06-22 08:25:37', '2024-06-22 08:25:37');

-- --------------------------------------------------------

--
-- Структура таблицы `order_product`
--

CREATE TABLE `order_product` (
  `id_order_product` int NOT NULL,
  `id_order` int NOT NULL,
  `id_product` int NOT NULL,
  `count_order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `order_product`
--

INSERT INTO `order_product` (`id_order_product`, `id_order`, `id_product`, `count_order`) VALUES
(22, 39, 58, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id_product` int NOT NULL,
  `id_category` int NOT NULL,
  `name_product` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_product` int UNSIGNED NOT NULL,
  `country_product` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_product` int UNSIGNED NOT NULL,
  `model_product` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `count_product` int UNSIGNED NOT NULL,
  `path_product` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transmission_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuel_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wheel_size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wheel_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` int DEFAULT NULL,
  `clearance` int DEFAULT NULL,
  `wheelbase` int DEFAULT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id_product`, `id_category`, `name_product`, `price_product`, `country_product`, `year_product`, `model_product`, `count_product`, `path_product`, `transmission_number`, `fuel_type`, `wheel_size`, `wheel_type`, `weight`, `clearance`, `wheelbase`, `color`) VALUES
(57, 26, 'Квадроцикл TIGER 320', 450600, '22', 1, 'Воздушное', 3, 'public/images/products/1a4ae84d74ac7fbf9bafa4d04dc93a90.jpg', '1', '92', '90х90 R10\"', 'Литые алюминиевые', 90, 200, 860, 'чёрный'),
(58, 28, 'Мопед Motoland Альфа RF 11', 64190, '5', 2, 'Воздушное', 5, 'public/images/products/69c4323e0881dbb35aefbc10dd88e5e7.png', '4', '92', '2.5хR17 2.75хR17', 'Литые алюминиевые', 80, 180, 1200, 'красный'),
(60, 29, 'Скутер Motoland BWS 50', 93900, '7', 2, 'Воздушное', 5, 'public/images/products/8f440e5c502041175081b78f08c6444c.png', '5', '92', 'R12 120х70', 'Литые алюминиевые', 80, 220, 1500, 'красный'),
(61, 26, 'Квадроцикл TIGER 380', 350600, '2', 1, 'Воздушное', 5, 'public/images/products/9526e491cb27a196adfab30116308591.jpg', '1', '92', '90х90 R10\"', 'Литые алюминиевые', 90, 200, 900, 'желтый'),
(63, 26, 'Квадроцикл TIGER 380', 339900, '21', 1, 'Воздушное', 5, 'public/images/products/e4dea2855f3b09ba17f4907d0a883d73.jpg', '1', '92', '90х90 R10\"', 'Литые алюминиевые', 80, 200, 950, 'синий'),
(66, 29, 'Скутер Motoland BWS 50', 85900, 'MOTOLAND', 5, 'Воздушное', 5, 'public/images/products/501b1067135e5b5aee60df5e96f6e170.png', '1', '92', '90х90 R10\"', 'Литые алюминиевые', 82, 150, 1200, 'синий'),
(67, 29, 'Скутер Motoland FS', 78500, 'MOTOLAND', 5, 'Воздушное', 5, 'public/images/products/fc8b4e1507c72bc1237fdd423db63fe7.png', '1', '92', '90х90 R10\"', 'Литые алюминиевые', 82, 150, 1200, 'желтый'),
(68, 28, 'Мопед Motoland Альфа RF 11', 64190, 'MOTOLAND', 80, 'Воздушное', 5, 'public/images/products/9234bfb93d81eb9259fb72aab35dd483.png', '4', '92', '2.5хR17 2.75хR17', 'Литые алюминиевые', 80, 180, 1200, 'синий'),
(69, 28, 'Мопед Motoland Альфа RX 7', 63790, 'MOTOLAND', 3, 'Воздушное', 5, 'public/images/products/1fe45dc8a72edad3b6d858d0cbc3a5b2.png', '4', '92', '2.5хR17 2.75хR17', 'Литые алюминиевые', 80, 180, 1230, 'зеленый'),
(70, 27, 'Мотоцикл дорожный Motoland CB 250', 270000, 'MOTOLAND', 22, 'Воздушно-масляное', 10, 'public/images/products/987953a0c5bcfbec96fce05dcb121f13.jpg', '1', '92', '110/70-17 140/70-17', 'Литые алюминиевые', 120, 250, 1400, 'красный'),
(71, 27, 'Мотоцикл дорожный Motoland MT 250 (172FMM-5/PR250)', 199900, '21', 1, 'Воздушно-масляное', 10, 'public/images/products/6fe409ed6f31c599a528fec552995ef3.jpg', '1', '92', '110/70-17 130/70-17', 'Литые алюминиевые', 120, 250, 1340, 'темно-синий'),
(72, 27, 'Мотоцикл Кросс Motoland XT 250 ST 21/18', 299900, 'MOTOLAND', 21, 'Воздушное', 5, 'public/images/products/e5dae6bed40cd941d891e9875eda98da.jpg', '5', '92', '80х100 R21 100х90 R18', 'Литые алюминиевые', 120, 320, 140, 'желтый, синий');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id_role` int NOT NULL,
  `name_role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id_role`, `name_role`) VALUES
(1, 'Клиент'),
(2, 'Администратор');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id_status` int NOT NULL,
  `name_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id_status`, `name_status`) VALUES
(1, 'Новый'),
(2, 'Подтвержденный'),
(3, 'Отмененный');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `id_role` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `patronymic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id_user`, `id_role`, `name`, `surname`, `patronymic`, `login`, `email`, `password`) VALUES
(1, 2, 'Админ', 'Админов', 'Админович', 'adminmoto', 'admin11@mail.ru', 'moto777'),
(5, 1, 'Тест', 'Тестов', 'Тестович', 'test', 'test@mail.ru', 'test123'),
(13, 1, 'имя', 'фамилия', 'отчество', '123', '123@123', '123123'),
(14, 1, 'ильяс', 'ЗаКиев', 'русланович', 'Fazer', 'asedfgfvdsgawsef@dw', '123123'),
(15, 1, 'Ильяс', 'Закиров', 'Русланович', 'faziktop', 'duhguhg564@gmail.com', '00000000');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id_basket`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_product` (`id_product`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_status` (`id_status`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id_order_product`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_product` (`id_product`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_category` (`id_category`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_role` (`id_role`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `basket`
--
ALTER TABLE `basket`
  MODIFY `id_basket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id_order` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT для таблицы `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id_order_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id_status` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `basket`
--
ALTER TABLE `basket`
  ADD CONSTRAINT `basket_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`),
  ADD CONSTRAINT `basket_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ограничения внешнего ключа таблицы `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`),
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`id_order`) REFERENCES `order` (`id_order`);

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`);

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
