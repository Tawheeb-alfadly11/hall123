-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 06 مايو 2025 الساعة 05:52
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wedding_halls`
--

-- --------------------------------------------------------

--
-- بنية الجدول `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `bank_account_number` varchar(50) NOT NULL,
  `bank_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `bookings`
--

INSERT INTO `bookings` (`id`, `hall_id`, `user_id`, `booking_date`, `amount_paid`) VALUES
(3, 1, 13, '2025-05-06', 500.00),
(4, 1, 10, '2025-05-13', 500.00);

-- --------------------------------------------------------

--
-- بنية الجدول `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `whatsapp` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `contact_info`
--

INSERT INTO `contact_info` (`id`, `phone`, `whatsapp`, `email`) VALUES
(1, '780595975', '780595975', 'ahmed.aladimi.2004@gmail.com');

-- --------------------------------------------------------

--
-- بنية الجدول `halls`
--

CREATE TABLE `halls` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `bank_account_number` varchar(50) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `halls`
--

INSERT INTO `halls` (`id`, `name`, `price`, `location`, `capacity`, `bank_account_number`, `bank_name`, `image_url`) VALUES
(1, 'قاعة العقيق للافراح والمناسبات', 500.00, 'العنوان: جوار جامعة 22 مايو، طريق وادي القاضي، تعز، اليمن', 2000, '21561326535', 'الكريمي', 'https://lh3.googleusercontent.com/p/AF1QipOvJFuN2qJD3fEGaCNhn_7aemfc7z8oWTHFLXJr=s1360-w1360-h1020-rw'),
(4, 'صالة السلام', 400.00, 'العنوان: H2P6+J5C، تعز، اليمن', 1500, '77889655214', 'القطيبي', 'https://lh3.googleusercontent.com/gps-cs-s/AC9h4no4CHi6_a6OHDLuXjFIzSG5drwZd8wXCtBunY7bNP1aR4_wxglEpQro-z0gqLa58QBK7yz5YS7mmIZWn7bdBi3VVWOVu4AkyTt0OEy8RK-OYhHJesREYs-SdUf_UXJaCvcnJbpbXw=s1360-w1360-h1020-rw'),
(6, 'قاعة ماس للافراح', 4500.00, 'العنوان: H2P4+X7F، تعز، اليمن', 2000, '1155644778', 'بنك عدن', 'https://lh3.googleusercontent.com/gps-cs-s/AC9h4npGWGk-koqfbCK1kB8VAmwjkysheJv_nOD19pQxO18WGbTBaKuGTbhY-L2SVJzwNXED2q5d2b9XTONvgwBtpYYnLajeFYZLWoZCY-P_EX5l0VryS9jdW2xWyE_Vq3rzg5OMuPHKlg=s1360-w1360-h1020-rw'),
(7, 'الصالة الذهبية', 550.00, 'العنوان: H2H9+24M، تعز، اليمن', 1200, '548625488', 'الكريمي', 'https://lh3.googleusercontent.com/gps-cs-s/AC9h4nrFoRJYbj3QfNgzL_ydg2eYhjBuoeSKWkmH2xJzm2IS_snA9741rU7KJYaWbNsHtO2kjzu7guhFdD5giyYQA8Nqu-qlO4pork3ScddAN6cIO1ijpUiQu9wNdDpxwY6g1FKFku2B=s1360-w1360-h1020-rw'),
(8, 'صالة عالم الأفراح والمناسبات', 700.00, ' العنوان: منزل وبقالة رمزي الشيباني، تعز، اليمن', 2500, '875269812', 'بنك عدن', 'https://lh3.googleusercontent.com/p/AF1QipNgEcg_TXkcfJDWgV6hDxpBDPtUnHjkfi-Lnngc=s1360-w1360-h1020-rw'),
(9, 'صالة الهريش', 350.00, 'العنوان: H2HC+JH2، شارع عصيفرة، تعز، اليمن', 1500, '854256321', 'الكريمي', 'https://lh3.googleusercontent.com/gps-cs-s/AC9h4npE-1u4txmB-e5DUOPeznxA7ztQuvBOE6ToXNCJoA15rD5X1uwSXpPIPRTww37t825TqE5Jbqn4wmceJ3EYGLsAc2PvMOkjubG9d5XC2tYsjcXELgFLfdrj2xQAKG0SDqqRoBev=s1360-w1360-h1020-rw');

-- --------------------------------------------------------

--
-- بنية الجدول `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `user_account` varchar(255) DEFAULT NULL,
  `hall_account` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `review` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_type` enum('regular_user','admin','service_provider') NOT NULL DEFAULT 'regular_user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `user_type`, `created_at`) VALUES
(1, 'احمد عصام', '$2y$10$pPmiwsWxjFhAXhICV4DQMeCJlQ8/HsflmbYGLeQxb/gXbvCq27tEi', 'ahmed@123', 'service_provider', '2025-04-19 00:19:55'),
(2, 'ali', '$2y$10$PgkbCj54.oy6rHnmuTASVu8VxEH68wHNayNP2oOhACr6KQBkz4us2', 'a7669679@gmail.com', 'regular_user', '2025-04-19 05:01:46'),
(4, 'ايمن', '$2y$10$kRKVol3yuw0Mj4JkCVEsXOauDaweuAj.epnFx7hxd4WoFiWzyJbyG', 'asdwkms@gamil.com', 'regular_user', '2025-04-19 06:06:04'),
(5, 'ahmedessam', '$2y$10$jWwH6kGhShmjmfXvS8LqlOsWeySq4tZyWbyss//QuSXnEMwDO5QCK', 'ahmed.aladimi.2004@gmail.com', 'admin', '2025-04-19 06:20:44'),
(6, 'امجد', '$2y$10$NLTeaqZxdLu2o87PT59v7uKR6A3Jpz00rnByJDY5WW2Mc9NZ5hIdC', 'a76669679@gmail.com', 'regular_user', '2025-04-19 06:46:09'),
(7, 'قاسم', '$2y$10$7KuzH/jJ.etVnOPN9i9QIuYJVNZo12MX5kM/9zJ1YwWc7GvTJW5uC', 'asdwms@gamil.com', 'service_provider', '2025-04-19 06:56:30'),
(8, 'محمد', '$2y$10$tQGCCagtyf51WDWvkcxskeEKXKBi23Cz6upM4iRsUynsiZZzmUVvq', 'a766679@gmail.com', 'service_provider', '2025-04-19 06:57:02'),
(9, 'سمير', '$2y$10$TqU/5uV5MDo6QBA.zdAj5.4oC1Lx.KpA/.mtafdLYwprD0MxcBEui', 'ahmed@12323', 'service_provider', '2025-04-19 06:58:30'),
(10, 'عبدالله عصام', '$2y$10$F30qQDqv82rW4aOv2OMV4uKb0iJ9pugWcEUF1pAYMlqQblGRpzTVO', 'ahmed@1234', 'regular_user', '2025-04-28 07:39:00'),
(11, 'سعيد محمد', '$2y$10$xxW1c/uvejKVLnZL1xuLbub5nlTLB5ZA0ZoMDsbt7mUhUQdXc2hVy', 'asdwkms28@gamil.com', 'regular_user', '2025-04-28 09:05:01'),
(12, 'ايمن جميل', '$2y$10$MdImmI5/M0GnPSc.sSRUYupLW55uiTpinmpcLA0UO3i/0w2NH352e', 'aymand.aladimi.2004@gmail.com', 'service_provider', '2025-05-03 06:41:54'),
(13, 'امجد عصام', '$2y$10$5xPxzdnoNUpGO8knqOMzge1XUWGtvFlP83N4TW/o0Y5EmLUsp6YYO', 'a766969@gmail.com', 'service_provider', '2025-05-06 02:57:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hall_id` (`hall_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hall_id` (`hall_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD CONSTRAINT `bank_accounts_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);

--
-- قيود الجداول `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
