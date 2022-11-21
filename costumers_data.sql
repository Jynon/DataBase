-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2022 at 06:25 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `costumers_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_list`
--

CREATE TABLE `email_list` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email_list`
--

INSERT INTO `email_list` (`id`, `email`) VALUES
(3, 'cepums@tvnet.lv'),
(4, 'coff@coff.com'),
(1, 'kleo99@tvnet.lv'),
(2, 'test1@test.com');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(255) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `image`) VALUES
(1, 4, 'CC7F.tmp.png'),
(2, 4, 'F883.tmp.png'),
(3, 1, '4426.tmp.png'),
(4, 1, 'FA20.tmp.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'Kristine', 'kiitana8@gmail.com', '$2y$10$LBrB2cn4k0v4CBNKQRAI7Og5VjlyO.g8HkbjHh.8nHPLHRS.EqETS'),
(2, 'Jynon', 'test1@test.com', '$2y$10$4.Y9XiDQAzvzQgG0Bmm7DejgK97pLTMOyMmiZp24AvMG6LrUFca8u'),
(3, 'Lilly', 'test2@gmail.com', '$2y$10$FcohYhbhyY26YkGg0BjVEODGAuk4QjIIF7RUaDSrlS/LFWxxEfMya'),
(4, 'Coff', 'coff@coff.com', '$2y$10$bV4TqYudBoXQ/3m3SHlJtu2wk0yYRdIahdU8G8BfDGL68SAcj/2mS'),
(5, 'Laura', 'laura@gmail.com', '$2y$10$7Xj5ZRW1q8hM06UIaD9A/.bzJZp1jBZa5pEzmSGKqXMD7XGgCkaPm'),
(6, 'Totomi', 'totomi@test.com', '$2y$10$hXQeH4Ro179/J08Z5VBK1uxuuInAQOOkNa8iEJy8FnZI8Jc9450eG'),
(7, 'lolo', 'lolo4@test.com', '$2y$10$1KIY5v1vwhpKd12TAwnv8upNURX3wyEJun4dbL9QvWa7Pkz3pnBbC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_list`
--
ALTER TABLE `email_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_list`
--
ALTER TABLE `email_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
