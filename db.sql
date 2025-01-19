-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 01:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_shelter`
--

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`id`, `name`, `description`) VALUES
(1, 'Gym', 'A space equipped with exercise machines and weights.'),
(2, 'Swimming Pool', 'A pool for recreational or fitness swimming.'),
(3, 'Parking', 'Dedicated parking space for vehicles.'),
(4, 'Wi-Fi', 'High-speed internet connectivity available.'),
(5, 'Security', 'CCTV Cameras.'),
(6, 'Laundry Service', 'Access to washing and drying machines.'),
(7, 'Air Conditioning', 'Cooling system for the unit.'),
(8, 'Heating System', 'Heating system for colder climates.'),
(9, 'Furnished', 'Includes basic furniture like beds, tables, and chairs.'),
(10, 'Electricity Backup', 'Uninterrupted power supply during outages.'),
(11, 'Playground', 'Recreational area for children.'),
(12, 'Garden', 'Outdoor landscaped area.'),
(13, 'Balcony', 'Private outdoor space attached to the unit.'),
(14, 'Elevator Access', 'Access to elevators for upper floors.'),
(15, 'Pet Friendly', 'Allows residents to keep pets.'),
(16, 'Storage Space', 'Additional storage units for belongings.'),
(17, 'Smart Home Features', 'Smart locks, lighting, or thermostats.'),
(18, '24/7 Maintenance', 'Round-the-clock repair and support services.'),
(19, 'Clubhouse', 'Community space for gatherings or events.');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `unitId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `senderId` int(11) DEFAULT NULL,
  `receiverId` int(11) DEFAULT NULL,
  `text` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `reservationId` int(11) DEFAULT NULL,
  `paymentDate` datetime NOT NULL,
  `amount` int(11) NOT NULL,
  `paymentMethod` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` enum('Apartment','Hostel','Shared House') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `userId`, `name`, `description`, `type`) VALUES
(6, 2, 'Abraham Mcdowell', 'Spacious apartment ideal for student living, featuring modern amenities and easy access to public transportation.', 'Apartment'),
(7, 2, 'Hilel Harrison', 'Well-maintained apartment with fully equipped kitchen, offering a comfortable living space for students.', 'Apartment'),
(9, 2, 'Jolie Edwards', 'Affordable and secure apartment, perfect for students, located close to universities and local conveniences.', 'Apartment'),
(10, 2, 'Lakeside Apartments', 'Modern apartments with scenic views, perfect for students seeking comfort and convenience.', 'Apartment'),
(11, 3, 'City Center Hostel', 'Affordable hostel located in the heart of the city, offering great access to local amenities.', 'Hostel'),
(12, 3, 'Suburban Shared House', 'Quiet shared house in a suburban area, ideal for group living.', 'Shared House'),
(16, 2, 'Illana Bernard', 'Sunt neque dignissim', 'Apartment');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `unitId` int(11) DEFAULT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `propertyId` int(11) DEFAULT NULL,
  `type` enum('Studio','Single Room','Shared Room','Multiple-bedrooms','Self-contained Unit') NOT NULL,
  `numberOfRooms` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `isAvailable` tinyint(1) NOT NULL DEFAULT 1,
  `monthlyPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `propertyId`, `type`, `numberOfRooms`, `quantity`, `isAvailable`, `monthlyPrice`) VALUES
(4, 6, 'Multiple-bedrooms', 2, 137, 1, 817.00),
(5, 7, 'Multiple-bedrooms', 5, 30, 1, 566.00),
(6, 7, 'Multiple-bedrooms', 2, 85, 1, 287.00),
(7, 7, 'Multiple-bedrooms', 2, 12, 1, 675.00),
(8, 9, 'Multiple-bedrooms', 2, 103, 1, 565.00),
(9, 10, 'Studio', 1, 8, 1, 550.00),
(10, 10, 'Single Room', 1, 5, 1, 400.00),
(11, 11, 'Shared Room', 1, 20, 1, 250.00),
(12, 12, 'Multiple-bedrooms', 3, 4, 1, 1300.00),
(16, 16, 'Studio', 1, 100, 1, 419.00);

-- --------------------------------------------------------

--
-- Table structure for table `unit_facility`
--

CREATE TABLE `unit_facility` (
  `id` int(11) NOT NULL,
  `unitId` int(11) DEFAULT NULL,
  `facilityId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_facility`
--

INSERT INTO `unit_facility` (`id`, `unitId`, `facilityId`) VALUES
(1, 4, 1),
(2, 4, 2),
(3, 4, 3),
(4, 4, 4),
(5, 4, 5),
(6, 4, 6),
(7, 4, 7),
(8, 4, 8),
(9, 4, 9),
(10, 4, 11),
(11, 4, 14),
(12, 4, 15),
(13, 4, 16),
(14, 4, 18),
(15, 4, 19),
(50, 8, 1),
(51, 8, 2),
(52, 8, 3),
(53, 8, 7),
(54, 8, 11),
(55, 8, 12),
(56, 8, 14),
(57, 8, 16),
(58, 8, 17),
(59, 8, 18),
(204, 5, 7),
(205, 5, 11),
(206, 5, 12),
(207, 5, 14),
(208, 5, 15),
(209, 5, 16),
(210, 5, 17),
(211, 6, 1),
(212, 6, 2),
(213, 6, 3),
(214, 6, 6),
(215, 6, 7),
(216, 6, 8),
(217, 6, 12),
(218, 6, 13),
(219, 6, 14),
(220, 6, 15),
(221, 6, 16),
(222, 6, 17),
(223, 7, 1),
(224, 7, 2),
(225, 7, 4),
(226, 7, 7),
(227, 7, 10),
(228, 7, 12),
(229, 7, 13),
(230, 7, 14),
(231, 7, 17),
(232, 7, 18),
(233, 9, 1),
(234, 9, 2),
(235, 10, 1),
(236, 10, 3),
(237, 11, 1),
(238, 12, 3),
(322, 16, 6),
(323, 16, 14),
(324, 16, 15),
(325, 16, 18);

-- --------------------------------------------------------

--
-- Table structure for table `unit_images`
--

CREATE TABLE `unit_images` (
  `id` int(11) NOT NULL,
  `unitId` int(11) DEFAULT NULL,
  `image` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_images`
--

INSERT INTO `unit_images` (`id`, `unitId`, `image`) VALUES
(11, 16, '../uploads/unit_images/16/unit_image_67408b8e7bce8.jpg'),
(12, 16, '../uploads/unit_images/16/unit_image_67408b8e7c10c.jpg'),
(13, 16, '../uploads/unit_images/16/unit_image_67408b8e7c4eb.jpg'),
(14, 16, '../uploads/unit_images/16/unit_image_67408b8e7ce0e.jpg'),
(15, 16, '../uploads/unit_images/16/unit_image_67408b8e7d26a.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `status` enum('pending','in review','verified') DEFAULT 'pending',
  `phone` varchar(15) DEFAULT NULL,
  `userRole` enum('student','landlord') NOT NULL DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `pwd`, `status`, `phone`, `userRole`, `created_at`, `updated_at`) VALUES
(2, 'Ahmad', 'Habib', 'ahmad@gmail.com', '$2y$12$h2z2A4W47ADoolJSzOoUbuvQktNPX9U2yDpUtk4mejXq0whitaqLu', NULL, '0758453324', 'landlord', '2024-10-26 22:07:42', '2024-11-20 16:43:04'),
(3, 'Ibrahim', 'Muhammed', 'ibrahim@gmail.com', '$2y$12$OPU04.fgmYZFL.26m2aA5utvy5q.sKu/FUOKF.BEpssYckiC9laR2', NULL, '0758989899', 'landlord', '2024-11-07 13:30:23', '2024-11-22 13:46:40'),
(4, 'Saikiran', 'Reddy', 'sai@gmail.com', '$2y$12$gaAdk9yLVjp7MKUHl0aXq.jTXJ06qG.PebTUfvK7boE0OPSYb5zTC', 'pending', '+33558478856', 'student', '2024-11-21 15:54:51', '2024-11-21 15:54:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `document_path` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT curtime()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_documents`
--

INSERT INTO `user_documents` (`id`, `userId`, `name`, `document_path`, `uploaded_at`) VALUES
(1, 4, 'Valid ID', '../uploads/4/validId_673f57cb689dd.png', '2024-11-21 16:54:51'),
(2, 4, 'Proof of Student', '../uploads/4/studentProof_673f57cb68ab2.png', '2024-11-21 16:54:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `unitId` (`unitId`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `senderId` (`senderId`),
  ADD KEY `receiverId` (`receiverId`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservationId` (`reservationId`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `unitId` (`unitId`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_ibfk_1` (`propertyId`);

--
-- Indexes for table `unit_facility`
--
ALTER TABLE `unit_facility`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_facility_ibfk_1` (`unitId`),
  ADD KEY `unit_facility_ibfk_2` (`facilityId`);

--
-- Indexes for table `unit_images`
--
ALTER TABLE `unit_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unitId` (`unitId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `facility`
--
ALTER TABLE `facility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `unit_facility`
--
ALTER TABLE `unit_facility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=326;

--
-- AUTO_INCREMENT for table `unit_images`
--
ALTER TABLE `unit_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`unitId`) REFERENCES `unit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`senderId`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`receiverId`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`reservationId`) REFERENCES `reservation` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `property_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`unitId`) REFERENCES `unit` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`propertyId`) REFERENCES `property` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `unit_facility`
--
ALTER TABLE `unit_facility`
  ADD CONSTRAINT `unit_facility_ibfk_1` FOREIGN KEY (`unitId`) REFERENCES `unit` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `unit_facility_ibfk_2` FOREIGN KEY (`facilityId`) REFERENCES `facility` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `unit_images`
--
ALTER TABLE `unit_images`
  ADD CONSTRAINT `unit_images_ibfk_1` FOREIGN KEY (`unitId`) REFERENCES `unit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD CONSTRAINT `user_documents_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
