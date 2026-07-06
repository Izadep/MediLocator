-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2026 at 07:46 PM
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
-- Database: `medilocator`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointmentId` varchar(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `userId` varchar(12) DEFAULT NULL,
  `clinicId` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointmentId`, `dateTime`, `userId`, `clinicId`, `type`, `status`) VALUES
('APT001', '2026-07-07 15:00:00', 'USR002', 2, 'General Checkup', 'Pending'),
('APT002', '2026-07-04 15:00:00', 'USR002', 2, 'General Checkup', 'Completed'),
('APT003', '2026-07-11 15:00:00', 'USR002', 2, 'General Checkup', 'Pending'),
('APT004', '2026-07-09 09:00:00', 'USR002', 2, 'General Checkup', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `clinic`
--

CREATE TABLE `clinic` (
  `clinicId` int(5) NOT NULL,
  `clinicName` varchar(100) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `specialServices` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `phoneNum` varchar(20) NOT NULL,
  `opHourStart` time NOT NULL,
  `opHourEnd` time NOT NULL,
  `clinicImage` varchar(255) DEFAULT NULL,
  `userId` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic`
--

INSERT INTO `clinic` (`clinicId`, `clinicName`, `specialty`, `specialServices`, `message`, `address`, `latitude`, `longitude`, `phoneNum`, `opHourStart`, `opHourEnd`, `clinicImage`, `userId`) VALUES
(1, 'Poliklinik Perdana, Ayer Keroh', '', '', '', '10, Jalan TU 2, 75450 Ayer Keroh, Melaka, Malaysia', 2.27502176, 102.28871116, '+6062312959', '09:00:00', '20:30:00', 'image/poliklinikperdanaayerkeroh.png', NULL),
(2, 'Klinik Dr Ani', '', '', NULL, '50, Jalan Lingkaran Mitc, Melaka International Trade Centre, 75450 Ayer Keroh, Melaka, Malaysia', 2.27145132, 102.28238960, '+6062325801', '08:00:00', '19:00:00', 'image/Klinik-Dr-Ani.jpg', NULL),
(3, 'STI Friendly Clinic (Rafflesia) - KK Ayer Keroh', ' Sexual health unit', 'creening and treatment for STIs (e.g., syphilis, gonorrhea, chlamydia), HIV/AIDS screening, testing, and early anti-retroviral therapy, Vital health education and sexual health counseling', NULL, 'Klinik Kesihatan, Jln Ayer Keroh Lama, Kampung Baru Ayer Keroh, 75350 Ayer Keroh, Melaka, Malaysia', 2.26507030, 102.28394772, '+601111849501', '08:30:00', '16:30:00', 'image/stiraflesia.png', NULL),
(4, 'Poliklinik Wahidah Sdn Bhd', '', '', NULL, 'G-8, Jln Kc 1, Kota Cemerlang, 75450 Ayer Keroh, Melaka, Malaysia', 2.26882529, 102.29398103, '+6062519500', '08:00:00', '22:00:00', 'image/poliklinik wahida.png', NULL),
(5, 'Ayer Keroh Dental Clinic', 'General Dentistry', '', NULL, 'Klinik Pergigian Ayer Keroh, Jln Ayer Keroh Lama, Kampung Ayer Keroh, 75450 Ayer Keroh, Malaysia', 2.26668899, 102.28379739, '+6062324010', '08:00:00', '17:00:00', 'image/Ayer Keroh Dental Clinic.png', NULL),
(6, 'MediPulih Klinik', '', '', NULL, 'Hang Tuah Jaya, Ground Floor. 49 Jalan Komersial, Taman Kota Fesyen, Malacca International Trade Centre, 75450 Ayer Keroh, Malacca, Malaysia', 2.27210416, 102.29080551, '+6063177230', '00:00:00', '23:59:59', 'image/MediPulih Klinik.png', NULL),
(7, 'Bekam Care MITC', 'Traditional and Complementary Medicine', 'Cupping Therapy, Massage, Acupuncture', NULL, '62, Jalan TU 42, 75450 Ayer Keroh, Melaka, Malaysia', 2.27125805, 102.28038480, '+60169009806', '09:00:00', '23:00:00', 'image/bekam care mitc.png', NULL),
(8, 'Poliklinik Piang & X Ray Sdn Bhd', '', '', NULL, '47, Lorong Setia 1, Taman Ayer Keroh Heights, 75450 Ayer Keroh, Melaka, Malaysia', 2.25750322, 102.29143906, '+6062321418', '08:15:00', '17:00:00', 'image/Poliklinik Piang & X Ray Sdn Bhd.png', NULL),
(9, 'KLINIK IMPIAN (CAWANGAN AYER KEROH)', '', '', NULL, 'A-G-12, GROUND FLOOR OF I, ASRAMA HARMONI @ ECOPARK, Zon Industri Ayer Keroh Baru, JALAN ECO 5, Kampung Tun Razak, 75450 Ayer Keroh, Melaka, Malaysia', 2.24794715, 102.29974780, '+601163001152', '09:00:00', '22:00:00', 'image/KLINIK IMPIAN (CAWANGAN AYER KEROH).png', NULL),
(10, 'Poliklinik Nazmir', '', '', NULL, 'Kompleks Komersial Boulevard, 45, Jln TU 49A, 75450 Ayer Keroh, Melaka, Malaysia', 2.27970066, 102.27771968, '+6062400454', '09:00:00', '22:00:00', 'image/Poliklinik Nazmir.png', NULL),
(11, 'KLINIK ANDA 24 JAM', 'Ultrasound, Pregnant Mother Checkup', '', NULL, '33, Jalan Bukit Beruang Utama 2, Taman Bukit Beruang Utama, Bukit Beruang, 75450 Ayer Keroh, Malacca, Malaysia', 2.25357375, 102.27648202, '+60102090771', '00:00:00', '23:59:59', 'image/KLINIK ANDA 24 JAM.png', NULL),
(12, 'MyFirst Klinik (Ayer Keroh) | Family Clinic | Occupational Health', '', '', NULL, '13, JALAN SRI RAMA 1, TAMAN MUZAFFAR SYAH, HANG TUAH JAYA AYER KEROH, 75450 Melaka, Malaysia', 2.25186622, 102.28945800, '+60107070956', '08:00:00', '22:00:00', 'image/MyFirst Klinik (Ayer Keroh) Family Clinic Occu.png', NULL),
(13, 'POLIKLINIK ANNA AYER KEROH MELAKA', '', '', NULL, 'NO 55, JALAN KOMERSIAL SKYWIZ, PUSAT KOMERSIAL SKYWIZ, 75450 Ayer Keroh, Melaka, Malaysia', 2.24490713, 102.29118617, '+60123416574', '09:00:00', '18:00:00', 'image/poliklinik anna.png', NULL),
(14, 'Klinik Hang Tuah (Ayer Keroh)', '', '', NULL, '35, Lorong Setia 1, Taman Ayer Keroh Height, 75450 Ayer Keroh, Melaka, Malaysia', 2.25698357, 102.29144298, '+60103931732', '08:00:00', '17:00:00', 'image/Klinik Hang Tuah (Ayer Keroh).png', NULL),
(15, 'Klinik Safwa Ayer Keroh', '', '', NULL, '47, Jalan MH 1 Taman Muzaffar Heights, Hang Tuah Jaya, 75450 Ayer Keroh, Melaka, Malaysia', 2.25710177, 102.28401830, '+6062336000', '08:30:00', '22:00:00', 'image/Klinik Safwa Ayer Keroh.png', NULL),
(16, 'KLINIK SUNITA SDN BHD', '', '', NULL, 'No. 11, Jalan Komersial TAKH 3, Taman Ayer Keroh Heights, Ayer Keroh 75450 Melaka, 75450 Ayer Keroh, Melaka, Malaysia', 2.25386522, 102.29056752, '+60122360125', '09:00:00', '21:00:00', 'image/KLINIK SUNITA SDN BHD.png', NULL),
(17, 'Careclinics Al-Amin Ayer Keroh', '', '', NULL, 'Hang Tuah Jaya, 21, Jalan Komersial TAKH 2, Taman Ayer Keroh Heights, 75450 Ayer Keroh, Melaka, Malaysia', 2.25333965, 102.29065822, '+6062930158', '08:00:00', '22:00:00', 'image/Careclinics Al-Amin Ayer Keroh.png', NULL),
(18, 'Klinik Adam Hawa (Ayer Keroh)', 'Treatment for Knee Pain, Earache, Phlegm Removal & Pregnant Mother Scan', '', NULL, '21, Jalan TAKH 15, Taman Ayer Keroh Heights 1 Ayer Keroh, 75450 Melaka, Malaysia', 2.25764540, 102.28178643, '+60199044762', '09:00:00', '19:00:00', 'image/Klinik Adam Hawa (Ayer Keroh).png', NULL),
(19, 'Ayer Keroh Health Clinic', '', '', NULL, 'Jalan Ayer Keroh Lama Melaka, 75450, Malacca, Malaysia', 2.26742650, 102.28468602, '+6062323330', '08:00:00', '17:00:00', 'image/Ayer Keroh Health Clinic.png', NULL),
(20, 'Kelinik Ayer Keroh', '', '', NULL, '25, Lorong Setia 1, Taman Ayer Keroh Height, 75450 Ayer Keroh, Melaka, Malaysia', 2.25611491, 102.29142353, '+6062326404', '08:00:00', '20:00:00', 'image/Kelinik Ayer Keroh.png', NULL),
(21, 'Q&M Ayer Keroh - Ng Dental Surgery (Invisalign Braces Provider)', 'Orthodontics', 'Teeth alignment, Braces', NULL, 'No 9,9-1, Takh 3, Taman, Jalan Komersial, 75450 Ayer Keroh, Melaka, Malaysia', 2.25378163, 102.29056707, '+6062535036', '09:00:00', '20:00:00', 'image/Q&M Ayer Keroh - Ng Dental Surgery.png', NULL),
(22, 'MRIC CLINIC', '', '', NULL, 'MXMR 0004 & 0005 (TINGKAT BAWAH STUDENT CENTRE UNIVERSITI MULTIMEDIA MELAKA JALAN AYER KEROH, BUKIT BERUANG, 75450 Melaka, Malaysia', 2.25068552, 102.27648423, '+6063320221', '08:00:00', '19:00:00', 'image/MRIC CLINIC.png', NULL),
(23, 'SONOBEE ULTRASOUND AYER KEROH', 'Obstetrics & Gynecology (O&G)', 'Pregnancy scan, Ultrasound scan', NULL, 'Jalan Knmp 1, Kompleks Niaga Melaka Perdana, 75450 Ayer Keroh, Melaka, Malaysia', 2.26460354, 102.30612569, '+60149317226', '09:30:00', '18:00:00', 'image/SONOBEE ULTRASOUND AYER KEROH.png', NULL),
(24, 'Klinik Veterinar Ayer Keroh Heights\r\n', 'Veterinary', '', NULL, 'Jalan Takh 15, Taman Ayer Keroh Heights, 75450 Melaka, Malaysia', 2.25764132, 102.28413072, '+60197403041', '10:00:00', '19:00:00', 'image/Klinik Veterinar Ayer Keroh Heights.png', NULL),
(25, 'Star Life Clinic TM', '', '', NULL, 'Level 1, No 2, Menara TM, Jalan Wisma Negeri, Melaka International Trade Centre, 75450 Ayer Keroh, Melaka, Malaysia', 2.27241286, 102.28821828, '+601163442700', '08:30:00', '17:30:00', 'image/Star Life Clinic TM.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy`
--

CREATE TABLE `pharmacy` (
  `pharmacyId` int(11) NOT NULL,
  `pharmacyName` varchar(100) NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `phoneNum` varchar(20) NOT NULL,
  `opHourStart` time NOT NULL,
  `opHourEnd` time NOT NULL,
  `pharmacyImage` varchar(255) DEFAULT NULL,
  `userId` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmacy`
--

INSERT INTO `pharmacy` (`pharmacyId`, `pharmacyName`, `product`, `message`, `address`, `latitude`, `longitude`, `phoneNum`, `opHourStart`, `opHourEnd`, `pharmacyImage`, `userId`) VALUES
(1, 'All-Day Pharmacy (Ayer Keroh)', NULL, NULL, 'Lot G04-G05, Hang Tuah Jaya, Mydin Mall, Malacca', 2.27078347, 102.29204005, '016-3352470', '10:00:00', '22:00:00', 'image/Allday Pharmacy.jpg', NULL),
(2, 'Health Lane Family Pharmacy', NULL, NULL, '8, Lorong Setia 1, Taman Ayer Keroh Heights, 75450', 2.25535379, 102.29146544, '06-2402182', '08:30:00', '21:00:00', 'image/Health Lane Family Pharmacy.jpg', NULL),
(3, 'Alpro Pharmacy Ayer Keroh', NULL, NULL, '73, Jalan Komersial Skywiz, Pusat Komersial Skywiz', 2.24652737, 102.29191202, '019-2536923', '09:00:00', '21:00:00', 'image/farmasialpro.png', NULL),
(4, 'Farmasi Murni @ Ayer Keroh', NULL, NULL, '55, Lorong Setia 1, Ayer Keroh Heights, 75450 Ayer Keroh', 2.25837001, 102.29139068, '016-7237806', '09:00:00', '20:00:00', 'image/farmasi murni.png', NULL),
(5, 'Caring Pharmacy | Ayer Keroh Heights', NULL, NULL, '9, Lorong Setia 1, Taman Ayer Keroh Heights, 75450', 2.25531324, 102.29140357, '012-8023928', '09:00:00', '21:00:00', 'image/Caring Pharmacy Ayer Keroh Heights.png', NULL),
(6, 'Straits Pharmacy @ Ayer Keroh', NULL, NULL, 'G-8 Bangunan Kings Hotel, Jalan Tun Abdul Razak', 2.23683759, 102.28757417, '016-4268798', '09:00:00', '20:00:00', 'image/Straits Pharmacy @Ayer Keroh.png', NULL),
(7, 'Sevens Care Pharmacy', NULL, NULL, 'Lot A2, Jalan PKCAK 2, Pusat Komersial Cendana', 2.23868577, 102.28799953, '06-2347777', '09:30:00', '19:00:00', 'image/Sevens Care Pharmacy.png', NULL),
(8, 'Watsons Taman Ayer Keroh Heights', NULL, NULL, 'No 2, Hang Tuah Jaya, Ground Floor & 4, Jalan Komersial', 2.25462315, 102.29078625, '06-2319572', '09:30:00', '22:00:00', 'image/Watsons Taman Ayer Keroh Heights.png', NULL),
(9, 'Watsons MITC Melaka Tengah', NULL, NULL, 'Jalan Komersial, Taman Kota Fesyen, Melaka International', 2.27095897, 102.29158260, '06-2331416', '09:00:00', '22:00:00', 'image/Watsons MITC Melaka Tengah.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewId` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `comments` text DEFAULT NULL,
  `reviewDate` date NOT NULL,
  `userId` varchar(12) DEFAULT NULL,
  `clinicId` int(11) DEFAULT NULL,
  `pharmacyId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`reviewId`, `rating`, `comments`, `reviewDate`, `userId`, `clinicId`, `pharmacyId`) VALUES
(18, 5.0, 'Excellent Services!', '2026-07-06', 'USR003', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` varchar(12) NOT NULL,
  `name` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(5) NOT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `name`, `pass`, `email`, `role`, `picture`) VALUES
('USR001', 'Izz (Admin)', '$2y$10$gjNXOBPrPENDSgYk29Hk9e60wALxXTkAQY4gbKp0isYLVsLhxe88G', 'Izz@admin.Medilocator', 'admin', 'image/ProfileEmpty.png'), --email Izz@admin.Medilocator, pass: 12345678
('USR002', 'Anwar Ridhwan', '$2y$10$UkfL..Ikvg5AT4URl8EqAukAQYywnPg/xRNHhq3RE0UlKJNgrOo1i', 'AnwarRidhwan@gmail.com', 'user', 'ProfilePic/user_USR002_1783343210.png'),
('USR003', 'Aisyah Addina', '$2y$10$ai2HacBQnipAgFBdFSrIkOZTzcvQqyo4qRTmHf4tDtTJFslCoQvhy', 'AIsyah@gmail.com', 'user', 'image/ProfileEmpty.png'), 
('USR004', 'Danish Clinic', '$2y$10$LSJpbqBsd8j.KxmL8yxU3uP8Gc49jtmCfemnn6kgp9rpmSDYr14XW', 'DanishClinic@Clinic', 'clin', 'image/ProfileEmpty.png'), --email DanishClinic@Clinic, pass: 12345678
('USR005', 'Izz Pharmacy', '$2y$10$VqFAQmqxXyHENTaI7kh5te332/qFZj6k2gGSH4XI8GfoSHTXbRqMC', 'Izz@Pharmacy', 'phar', 'image/ProfileEmpty.png'); --email Izz@Pharmacy, pass: 12345678

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointmentId`),
  ADD UNIQUE KEY `unique_booking` (`clinicId`,`dateTime`),
  ADD KEY `userId` (`userId`),
  ADD KEY `clinicId` (`clinicId`);

--
-- Indexes for table `clinic`
--
ALTER TABLE `clinic`
  ADD PRIMARY KEY (`clinicId`),
  ADD KEY `fk_clinic_user` (`userId`);

--
-- Indexes for table `pharmacy`
--
ALTER TABLE `pharmacy`
  ADD PRIMARY KEY (`pharmacyId`),
  ADD KEY `fk_pharmacy_user` (`userId`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `clinicId` (`clinicId`),
  ADD KEY `pharmacyId` (`pharmacyId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clinic`
--
ALTER TABLE `clinic`
  MODIFY `clinicId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pharmacy`
--
ALTER TABLE `pharmacy`
  MODIFY `pharmacyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`clinicId`) REFERENCES `clinic` (`clinicId`);

--
-- Constraints for table `clinic`
--
ALTER TABLE `clinic`
  ADD CONSTRAINT `fk_clinic_user` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `pharmacy`
--
ALTER TABLE `pharmacy`
  ADD CONSTRAINT `fk_pharmacy_user` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`clinicId`) REFERENCES `clinic` (`clinicId`),
  ADD CONSTRAINT `review_ibfk_3` FOREIGN KEY (`pharmacyId`) REFERENCES `pharmacy` (`pharmacyId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
