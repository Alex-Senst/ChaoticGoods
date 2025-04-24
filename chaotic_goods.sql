-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2025 at 12:51 PM
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
-- Database: `chaotic_goods`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(1, 3, 7, 2, '2025-04-24 02:42:01'),
(2, 1, 4, 1, '2025-04-24 03:16:35');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `status` enum('pending','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_price`, `payment_method`, `shipping_address`, `billing_address`, `full_name`, `status`, `created_at`, `payment_id`) VALUES
(4, 1, '2025-04-03 20:09:36', '12.99', NULL, '938 Still Testing Rd', '381 Screw This St', 'John Jay', 'pending', '2025-04-03 20:09:36', 5),
(5, 1, '2025-04-03 21:10:37', '119.98', NULL, '1329 Working Lane', '3102 Praying Avenue', 'John Jay', 'pending', '2025-04-03 21:10:37', 6),
(6, 1, '2025-04-04 00:32:57', '15.99', NULL, '123 Testing ST', '123 Testing st', 'Shan', 'pending', '2025-04-04 00:32:57', 7),
(7, 4, '2025-04-04 02:06:49', '60.97', NULL, '381 fake address road', '1928 still a fake st', 'shadlorex', 'shipped', '2025-04-04 02:06:49', 8);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) GENERATED ALWAYS AS (`price` * `quantity`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`) VALUES
(3, 4, 2, 'Metal Blue d20', '12.99', 1),
(4, 5, 4, 'DND Book', '59.99', 2),
(5, 6, 1, 'Red Dice Set', '15.99', 1),
(6, 7, 1, 'Red Dice Set', '15.99', 2),
(7, 7, 3, 'Blue Dice Bag', '28.99', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_method` enum('credit_card','paypal','cash_on_delivery') NOT NULL,
  `card_last4` varchar(4) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `user_id`, `payment_method`, `card_last4`, `transaction_id`, `status`, `created_at`) VALUES
(1, 1, 'credit_card', NULL, NULL, 'pending', '2025-04-03 19:49:03'),
(2, 1, 'credit_card', NULL, NULL, 'pending', '2025-04-03 19:49:19'),
(3, 1, 'credit_card', NULL, NULL, 'pending', '2025-04-03 20:02:49'),
(4, 1, 'credit_card', NULL, NULL, 'pending', '2025-04-03 20:05:41'),
(5, 1, 'credit_card', NULL, NULL, 'pending', '2025-04-03 20:09:36'),
(6, 1, 'cash_on_delivery', NULL, NULL, 'pending', '2025-04-03 21:10:37'),
(7, 1, 'credit_card', NULL, NULL, 'pending', '2025-04-04 00:32:57'),
(8, 4, 'credit_card', NULL, NULL, 'pending', '2025-04-04 02:06:49');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `color` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `title`, `description`, `price`, `image_url`, `seller_id`, `created_at`, `color`, `type`) VALUES
(1, 'Red Dice Set', 'A full set of beautiful dnd red dice. The dice are made of resin and are lightweight and of average size.', '15.99', 'https://haxtec.com/cdn/shop/products/2__06104.1672219418.1280.1280.jpg?v=1672737841&width=1445', NULL, '2025-04-03 18:34:15', 'red', 'dice'),
(2, 'Metal Blue d20', 'A gorgeous metal dnd d20 die. Only a single die, NOT A SET. Item is made of a zinc alloy.', '12.99', 'https://darkelfdice.com/cdn/shop/files/Metal_Dice.jpg?v=1650142992&width=400', NULL, '2025-04-03 18:34:15', 'blue', 'dice'),
(3, 'Blue Dice Bag', 'A super cool dnd dice bag to hold all your little math rocks. Lightly used. Pretty blue.', '28.99', 'https://m.media-amazon.com/images/I/816ZGGcfIOL._AC_UF894,1000_QL80_.jpg', NULL, '2025-04-03 20:15:29', 'blue', 'bag'),
(4, 'DND Book', 'DragonLance DND book. Good condition.', '59.99', 'https://i0.wp.com/dungeonsanddragonsfan.com/wp-content/uploads/2023/04/dnd-5e-books-dragonlance-shadow-dragon-queen.jpeg?resize=781%2C1000&ssl=1', NULL, '2025-04-03 20:32:36', 'black', 'book'),
(5, 'Dice Tray', 'Dice tray', '12.99', 'https://ultrapro.com/cdn/shop/products/CSLq9Hrw.jpg?v=1635803357&width=1214', NULL, '2025-04-04 00:33:29', NULL, NULL),
(7, 'DND Stickers', 'High Quality - The stickers are made from durable vinyl material that is weather-resistant and long-lasting. They are also easy to apply and remove without leaving residue.\r\nVersatility - With a variety of sizes and designs, these stickers can be used to decorate laptops, water bottles, notebooks, and more. They are perfect for showing off your love for Dungeons & Dragons in a fun and creative way.\r\nNostalgia - For fans of the classic tabletop game, these stickers are a great way to bring back memories of playing with friends and embarking on epic adventures. They make a great gift for fellow D&D enthusiasts.\r\nValue - With 100 Pcs stickers included in each pack, these D&D stickers offer great value for their price. You can deck out all your gear and accessories without breaking the bank.\r\nEasy to Use - These stickers are incredibly easy to use, with a simple peel-and-stick design that allows you to apply them quickly and easily to any surface. This makes them a great option for fans of all ages and skill levels, and they can be used to decorate just about anything, from laptops to water bottles to cars.', '6.55', 'uploads/6809cbc8d3643_DND Stickers.jpg', 1, '2025-04-24 05:27:36', 'red', 'sticker');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL,
  `role` enum('admin','seller','buyer') NOT NULL DEFAULT 'buyer'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `first_name`, `last_name`, `created_at`, `password`, `role`) VALUES
(1, 'johnjay', 'johnjay@test.com', 'John', 'Jay', '2025-04-02 18:41:51', 'aa2776903cbb97a27f46d4e3ea504200', 'buyer'),
(3, 'jamest', 'jamest@man.com', 'James', 'Tanner', '2025-04-03 05:33:05', '190e5983bc5279dd10a735a591eb9c66', 'buyer'),
(4, 'shadlorex', 'shadlorexrocks@whoo.com', 'shadlorex', 'Peatarst', '2025-04-03 06:41:30', '6f4911318fc6e1aa456bb25c124a186b', 'buyer'),
(5, 'root', 'root@one.com', 'root', 'tree', '2025-04-24 16:28:32', '63a9f0ea7bb98050796b649e85481845', 'admin'),
(8, 'haileeneal', 'hailee@neil.com', 'Hailee', 'Neal', '2025-04-24 18:21:35', 'd3b343f748e268dcac2fe1947564d9f4', 'buyer'),
(9, 'mikev', 'mikev@test.com', 'Michael', 'Kevin', '2025-04-24 18:26:13', 'ac0d91912823609daa894f98bbba8d9d', 'buyer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
