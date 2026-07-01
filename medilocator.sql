-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2026 at 07:37 AM
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
  `opHours` varchar(100) NOT NULL,
  `clinicImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic`
--

INSERT INTO `clinic` (`clinicId`, `clinicName`, `specialty`, `specialServices`, `message`, `address`, `latitude`, `longitude`, `phoneNum`, `opHours`, `clinicImage`) VALUES
(1, 'Poliklinik Perdana, Ayer Keroh', '', '', '', '10, Jalan TU 2, 75450 Ayer Keroh, Melaka, Malaysia', 2.27502176, 102.28871116, '+6062312959', '9 am - 1:30 pm, 5 - 8:30', 'image/Poliklinik-Perdana-Ayer-Keroh-Melaka.jpg'),
(2, 'Klinik Dr Ani', '', '', NULL, '50, Jalan Lingkaran Mitc, Melaka International Trade Centre, 75450 Ayer Keroh, Melaka, Malaysia', 2.27145132, 102.28238960, '+6062325801', '8 am - 7 pm', 'image/Klinik-Dr-Ani.jpg'),
(3, 'STI Friendly Clinic (Rafflesia) - KK Ayer Keroh', ' Sexual health unit', 'creening and treatment for STIs (e.g., syphilis, gonorrhea, chlamydia), HIV/AIDS screening, testing, and early anti-retroviral therapy, Vital health education and sexual health counseling', NULL, 'Klinik Kesihatan, Jln Ayer Keroh Lama, Kampung Baru Ayer Keroh, 75350 Ayer Keroh, Melaka, Malaysia', 2.26507030, 102.28394772, '+601111849501', '8:30 am – 4:30 pm', NULL),
(4, 'Poliklinik Wahidah Sdn Bhd', '', '', NULL, 'G-8, Jln Kc 1, Kota Cemerlang, 75450 Ayer Keroh, Melaka, Malaysia', 2.26882529, 102.29398103, '+6062519500', '8 am – 10 pm', NULL),
(5, 'Ayer Keroh Dental Clinic', 'General Dentistry', '', NULL, 'Klinik Pergigian Ayer Keroh, Jln Ayer Keroh Lama, Kampung Ayer Keroh, 75450 Ayer Keroh, Malaysia', 2.26668899, 102.28379739, '+6062324010', '8 am – 5 pm', NULL),
(6, 'MediPulih Klinik', '', '', NULL, 'Hang Tuah Jaya, Ground Floor. 49 Jalan Komersial, Taman Kota Fesyen, Malacca International Trade Centre, 75450 Ayer Keroh, Malacca, Malaysia', 2.27210416, 102.29080551, '+6063177230', 'Open 24 hours', NULL),
(7, 'Bekam Care MITC', 'Traditional and Complementary Medicine', 'Cupping Therapy, Massage, Acupuncture', NULL, '62, Jalan TU 42, 75450 Ayer Keroh, Melaka, Malaysia', 2.27125805, 102.28038480, '+60169009806', '9 am – 11 pm', NULL),
(8, 'Poliklinik Piang & X Ray Sdn Bhd', '', '', NULL, '47, Lorong Setia 1, Taman Ayer Keroh Heights, 75450 Ayer Keroh, Melaka, Malaysia', 2.25750322, 102.29143906, '+6062321418', '8:15 am – 5 pm', NULL),
(9, 'KLINIK IMPIAN (CAWANGAN AYER KEROH)', '', '', NULL, 'A-G-12, GROUND FLOOR OF I, ASRAMA HARMONI @ ECOPARK, Zon Industri Ayer Keroh Baru, JALAN ECO 5, Kampung Tun Razak, 75450 Ayer Keroh, Melaka, Malaysia', 2.24794715, 102.29974780, '+601163001152', '9 am – 10 pm', NULL),
(10, 'Poliklinik Nazmir', '', '', NULL, 'Kompleks Komersial Boulevard, 45, Jln TU 49A, 75450 Ayer Keroh, Melaka, Malaysia', 2.27970066, 102.27771968, '+6062400454', '9 am – 10 pm', NULL),
(11, 'KLINIK ANDA 24 JAM', 'Ultrasound, Pregnant Mother Checkup', '', NULL, '33, Jalan Bukit Beruang Utama 2, Taman Bukit Beruang Utama, Bukit Beruang, 75450 Ayer Keroh, Malacca, Malaysia', 2.25357375, 102.27648202, '+60102090771', 'Open 24 hours', NULL),
(12, 'MyFirst Klinik (Ayer Keroh) | Family Clinic | Occupational Health', '', '', NULL, '13, JALAN SRI RAMA 1, TAMAN MUZAFFAR SYAH, HANG TUAH JAYA AYER KEROH, 75450 Melaka, Malaysia', 2.25186622, 102.28945800, '+60107070956', '8 am – 10 pm', NULL),
(13, 'POLIKLINIK ANNA AYER KEROH MELAKA', '', '', NULL, 'NO 55, JALAN KOMERSIAL SKYWIZ, PUSAT KOMERSIAL SKYWIZ, 75450 Ayer Keroh, Melaka, Malaysia', 2.24490713, 102.29118617, '+60123416574', '9 am – 6 pm', NULL),
(14, 'Klinik Hang Tuah (Ayer Keroh)', '', '', NULL, '35, Lorong Setia 1, Taman Ayer Keroh Height, 75450 Ayer Keroh, Melaka, Malaysia', 2.25698357, 102.29144298, '+60103931732', '8 am – 5 pm', NULL),
(15, 'Klinik Safwa Ayer Keroh', '', '', NULL, '47, Jalan MH 1 Taman Muzaffar Heights, Hang Tuah Jaya, 75450 Ayer Keroh, Melaka, Malaysia', 2.25710177, 102.28401830, '+6062336000', '8:30 am – 7 pm, 8 – 10 pm', NULL),
(16, 'KLINIK SUNITA SDN BHD', '', '', NULL, 'No. 11, Jalan Komersial TAKH 3, Taman Ayer Keroh Heights, Ayer Keroh 75450 Melaka, 75450 Ayer Keroh, Melaka, Malaysia', 2.25386522, 102.29056752, '+60122360125', '9 am – 9 pm', NULL),
(17, 'Careclinics Al-Amin Ayer Keroh', '', '', NULL, 'Hang Tuah Jaya, 21, Jalan Komersial TAKH 2, Taman Ayer Keroh Heights, 75450 Ayer Keroh, Melaka, Malaysia', 2.25333965, 102.29065822, '+6062930158', '8 am – 10 pm', NULL),
(18, 'Klinik Adam Hawa (Ayer Keroh)', 'Treatment for Knee Pain, Earache, Phlegm Removal & Pregnant Mother Scan', '', NULL, '21, Jalan TAKH 15, Taman Ayer Keroh Heights 1 Ayer Keroh, 75450 Melaka, Malaysia', 2.25764540, 102.28178643, '+60199044762', '9 am – 7 pm', NULL),
(19, 'Ayer Keroh Health Clinic', '', '', NULL, 'Jalan Ayer Keroh Lama Melaka, 75450, Malacca, Malaysia', 2.26742650, 102.28468602, '+6062323330', '8 am – 5 pm', NULL),
(20, 'Kelinik Ayer Keroh', '', '', NULL, '25, Lorong Setia 1, Taman Ayer Keroh Height, 75450 Ayer Keroh, Melaka, Malaysia', 2.25611491, 102.29142353, '+6062326404', '8 am – 8 pm', NULL),
(21, 'Q&M Ayer Keroh - Ng Dental Surgery (Invisalign Braces Provider)', 'Orthodontics', 'Teeth alignment, Braces', NULL, 'No 9,9-1, Takh 3, Taman, Jalan Komersial, 75450 Ayer Keroh, Melaka, Malaysia', 2.25378163, 102.29056707, '+6062535036', '9 am – 8 pm', NULL),
(22, 'MRIC CLINIC', '', '', NULL, 'MXMR 0004 & 0005 (TINGKAT BAWAH STUDENT CENTRE UNIVERSITI MULTIMEDIA MELAKA JALAN AYER KEROH, BUKIT BERUANG, 75450 Melaka, Malaysia', 2.25068552, 102.27648423, '+6063320221', '8 am – 1 pm, 2 - 7 pm', NULL),
(23, 'SONOBEE ULTRASOUND AYER KEROH', 'Obstetrics & Gynecology (O&G)', 'Pregnancy scan, Ultrasound scan', NULL, 'Jalan Knmp 1, Kompleks Niaga Melaka Perdana, 75450 Ayer Keroh, Melaka, Malaysia', 2.26460354, 102.30612569, '+60149317226', '9:30 am – 6 pm', NULL),
(24, 'Klinik Veterinar Ayer Keroh Heights\r\n', 'Veterinary', '', NULL, 'Jalan Takh 15, Taman Ayer Keroh Heights, 75450 Melaka, Malaysia', 2.25764132, 102.28413072, '+60197403041', '10 am – 7 pm', NULL),
(25, 'Star Life Clinic TM', '', '', NULL, 'Level 1, No 2, Menara TM, Jalan Wisma Negeri, Melaka International Trade Centre, 75450 Ayer Keroh, Melaka, Malaysia', 2.27241286, 102.28821828, '+601163442700', '8:30 am – 5:30 pm', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clinic`
--
ALTER TABLE `clinic`
  ADD PRIMARY KEY (`clinicId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clinic`
--
ALTER TABLE `clinic`
  MODIFY `clinicId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

INSERT INTO pharmacy (pharmacyId, pharmacyName, product, message, address, latitude, longitude, phoneNum, opHours, pharmacyImage)
VALUES
(1, 'All-Day Pharmacy (Ayer Keroh)', NULL, NULL, 'Lot G04-G05, Hang Tuah Jaya, Mydin Mall, Malacca', 2.27078347, 102.29204005, '016-3352470', '10 AM - 10 PM', 'image/Allday Pharmacy.jpg');

INSERT INTO pharmacy (pharmacyId, pharmacyName, product, message, address, latitude, longitude, phoneNum, opHours, pharmacyImage)
VALUES
(2, 'Health Lane Family Pharmacy', NULL, NULL, '8, Lorong Setia 1, Taman Ayer Keroh Heights, 75450', 2.25535379, 102.29146544, '06-2402182', '8:30 AM - 9 PM', 'image/Health Lane Family Pharmacy.jpg');

INSERT INTO pharmacy (pharmacyId, pharmacyName, product, message, address, latitude, longitude, phoneNum, opHours, pharmacyImage)
VALUES
(3, 'Alpro Pharmacy Ayer Keroh', NULL, NULL, '73, Jalan Komersial Skywiz, Pusat Komersial Skywiz', 2.24652737, 102.29191202, '019-2536923', '9 AM - 9 PM', 'image/farmasialpro.png');

INSERT INTO pharmacy (pharmacyId, pharmacyName, product, message, address, latitude, longitude, phoneNum, opHours, pharmacyImage)
VALUES
(4, 'Farmasi Murni @ Ayer Keroh', NULL, NULL, '55, Lorong Setia 1, Ayer Keroh Heights, 75450 Ayer Keroh', 2.25837001, 102.29139068, '016-7237806', '9 AM - 8 PM', 'image/farmasi murni.png');

INSERT INTO pharmacy (pharmacyId, pharmacyName, product, message, address, latitude, longitude, phoneNum, opHours, pharmacyImage)
VALUES
(5, 'Caring Pharmacy | Ayer Keroh Heights', NULL, NULL, '9, Lorong Setia 1, Taman Ayer Keroh Heights, 75450', 2.25531324, 102.29140357, '012-8023928', 'Weekend 9 AM - 9:30 PM, Weekday 9 AM - 9 PM', 'image/Caring Pharmacy Ayer Keroh Heights.png');

INSERT INTO pharmacy (pharmacyId, pharmacyName, product, message, address, latitude, longitude, phoneNum, opHours, pharmacyImage)
VALUES
(6, 'Straits Pharmacy @ Ayer Keroh', NULL, NULL, 'G-8 Bangunan Kings Hotel, Jalan Tun Abdul Razak', 2.23683759, 102.28757417, '016-4268798', '9 AM - 8 PM', 'image/Straits Pharmacy @Ayer Keroh.png');

INSERT INTO pharmacy (pharmacyId, pharmacyName, product, message, address, latitude, longitude, phoneNum, opHours, pharmacyImage)
VALUES
(7, 'Sevens Care Pharmacy', NULL, NULL, 'Lot A2, Jalan PKCAK 2, Pusat Komersial Cendana', 2.23868577, 102.28799953, '06-2347777', '9:30 AM - 7 PM', 'image/Sevens Care Pharmacy.png');

INSERT INTO pharmacy (pharmacyId, pharmacyName, product, message, address, latitude, longitude, phoneNum, opHours, pharmacyImage)
VALUES
(8, 'Watsons Taman Ayer Keroh Heights', NULL, NULL, 'No 2, Hang Tuah Jaya, Ground Floor & 4, Jalan Komersial', 2.25462315, 102.29078625, '06-2319572', '9:30 AM - 10 PM', 'image/Watsons Taman Ayer Keroh Heights.png');

INSERT INTO pharmacy (pharmacyId, pharmacyName, product, message, address, latitude, longitude, phoneNum, opHours, pharmacyImage)
VALUES
(9, 'Watsons MITC Melaka Tengah', NULL, NULL, 'Jalan Komersial, Taman Kota Fesyen, Melaka International', 2.27095897, 102.29158260, '06-2331416', '9 AM - 10 PM', 'image/Watsons MITC Melaka Tengah.png');

ALTER TABLE `pharmacy`
DROP COLUMN `opHours`;

ALTER TABLE `pharmacy`
ADD COLUMN `opHourStart` TIME NOT NULL AFTER `phoneNum`,
ADD COLUMN `opHourEnd` TIME NOT NULL AFTER `opHourStart`;

UPDATE `pharmacy`
SET
    opHourStart = '10:00:00',
    opHourEnd = '22:00:00'
WHERE pharmacyId = 1;

UPDATE `pharmacy`
SET
    opHourStart = '08:30:00',
    opHourEnd = '21:00:00'
WHERE pharmacyId = 2;

UPDATE `pharmacy`
SET
    opHourStart = '09:00:00',
    opHourEnd = '21:00:00'
WHERE pharmacyId = 3;

UPDATE `pharmacy`
SET
    opHourStart = '09:00:00',
    opHourEnd = '20:00:00'
WHERE pharmacyId = 4;

UPDATE `pharmacy`
SET
    opHourStart = '09:00:00',
    opHourEnd = '21:00:00'
WHERE pharmacyId = 5;

UPDATE `pharmacy`
SET
    opHourStart = '09:00:00',
    opHourEnd = '20:00:00'
WHERE pharmacyId = 6;

UPDATE `pharmacy`
SET
    opHourStart = '09:30:00',
    opHourEnd = '19:00:00'
WHERE pharmacyId = 7;

UPDATE `pharmacy`
SET
    opHourStart = '09:30:00',
    opHourEnd = '22:00:00'
WHERE pharmacyId = 8;

UPDATE `pharmacy`
SET 
	opHourStart = '09:00:00',
    opHourEnd = '22:00:00'
WHERE pharmacyId = 9;


ALTER TABLE `clinic`
DROP COLUMN `opHours`;

ALTER TABLE `clinic`
ADD COLUMN `opHourStart` TIME NOT NULL AFTER `phoneNum`,
ADD COLUMN `opHourEnd` TIME NOT NULL AFTER `opHourStart`;

UPDATE `clinic`
SET
    opHourStart = '09:00:00',
    opHourEnd = '20:30:00'
WHERE clinicId = 1;

UPDATE `clinic`
SET
    opHourStart = '08:00:00',
    opHourEnd = '19:00:00'
WHERE clinicId = 2;

UPDATE `clinic`
SET
    opHourStart = '08:30:00',
    opHourEnd = '16:30:00'
WHERE clinicId = 3;

UPDATE `clinic`
SET
    opHourStart = '08:00:00',
    opHourEnd = '22:00:00'
WHERE clinicId = 4;

UPDATE `clinic`
SET
    opHourStart = '08:00:00',
    opHourEnd = '17:00:00'
WHERE clinicId = 5;

UPDATE `clinic`
SET
    opHourStart = '00:00:00',
    opHourEnd = '23:59:59'
WHERE clinicId = 6;

UPDATE `clinic`
SET
    opHourStart = '09:00:00',
    opHourEnd = '23:00:00'
WHERE clinicId = 7;

UPDATE `clinic`
SET
    opHourStart = '08:15:00',
    opHourEnd = '17:00:00'
WHERE clinicId = 8;

UPDATE `clinic`
SET
    opHourStart = '09:00:00',
    opHourEnd = '22:00:00'
WHERE clinicId = 9;

UPDATE `clinic`
SET
    opHourStart = '09:00:00',
    opHourEnd = '22:00:00'
WHERE clinicId = 10;

UPDATE `clinic`
SET
    opHourStart = '00:00:00',
    opHourEnd = '23:59:59'
WHERE clinicId = 11;

UPDATE `clinic`
SET
    opHourStart = '08:00:00',
    opHourEnd = '22:00:00'
WHERE clinicId = 12;

UPDATE `clinic`
SET
    opHourStart = '09:00:00',
    opHourEnd = '18:00:00'
WHERE clinicId = 13;

UPDATE `clinic`
SET
    opHourStart = '08:00:00',
    opHourEnd = '17:00:00'
WHERE clinicId = 14;

UPDATE `clinic`
SET
    opHourStart = '08:30:00',
    opHourEnd = '22:00:00'
WHERE clinicId = 15;

UPDATE `clinic`
SET
    opHourStart = '09:00:00',
    opHourEnd = '21:00:00'
WHERE clinicId = 16;

UPDATE `clinic`
SET
    opHourStart = '08:00:00',
    opHourEnd = '22:00:00'
WHERE clinicId = 17;

UPDATE `clinic`
SET
    opHourStart = '09:00:00',
    opHourEnd = '19:00:00'
WHERE clinicId = 18;

UPDATE `clinic`
SET
    opHourStart = '08:00:00',
    opHourEnd = '17:00:00'
WHERE clinicId = 19;

UPDATE `clinic`
SET
    opHourStart = '08:00:00',
    opHourEnd = '20:00:00'
WHERE clinicId = 20;

UPDATE `clinic`
SET
    opHourStart = '09:00:00',
    opHourEnd = '20:00:00'
WHERE clinicId = 21;

UPDATE `clinic`
SET
    opHourStart = '08:00:00',
    opHourEnd = '19:00:00'
WHERE clinicId = 22;

UPDATE `clinic`
SET
    opHourStart = '09:30:00',
    opHourEnd = '18:00:00'
WHERE clinicId = 23;

UPDATE `clinic`
SET
    opHourStart = '10:00:00',
    opHourEnd = '19:00:00'
WHERE clinicId = 24;

UPDATE `clinic`
SET
    opHourStart = '08:30:00',
    opHourEnd = '17:30:00'
WHERE clinicId = 25;

UPDATE clinic
SET clinicImage = 'image/poliklinikperdanaayerkeroh.png'
WHERE clinicId = 1;

UPDATE clinic
SET clinicImage = 'image/stiraflesia.png'
WHERE clinicId = 3;

UPDATE clinic
SET clinicImage = 'image/poliklinik wahida.png'
WHERE clinicId = 4;

UPDATE clinic
SET clinicImage = 'image/Ayer Keroh Dental Clinic.png'
WHERE clinicId = 5;

UPDATE clinic
SET clinicImage = 'image/MediPulih Klinik.png'
WHERE clinicId = 6;

UPDATE clinic
SET clinicImage = 'image/bekam care mitc.png'
WHERE clinicId = 7;

UPDATE clinic
SET clinicImage = 'image/Poliklinik Piang & X Ray Sdn Bhd.png'
WHERE clinicId = 8;

UPDATE clinic
SET clinicImage = 'image/KLINIK IMPIAN (CAWANGAN AYER KEROH).png'
WHERE clinicId = 9;

UPDATE clinic
SET clinicImage = 'image/Poliklinik Nazmir.png'
WHERE clinicId = 10;

UPDATE clinic
SET clinicImage = 'image/KLINIK ANDA 24 JAM.png'
WHERE clinicId = 11;

UPDATE clinic
SET clinicImage = 'image/MyFirst Klinik (Ayer Keroh) Family Clinic Occu.png'
WHERE clinicId = 12; 

UPDATE clinic
SET clinicImage = 'image/poliklinik anna.png'
WHERE clinicId = 13; 

UPDATE clinic
SET clinicImage = 'image/Klinik Hang Tuah (Ayer Keroh).png'
WHERE clinicId = 14;

UPDATE clinic
SET clinicImage = 'image/Klinik Safwa Ayer Keroh.png'
WHERE clinicId = 15;

UPDATE clinic
SET clinicImage = 'image/KLINIK SUNITA SDN BHD.png'
WHERE clinicId = 16;

UPDATE clinic
SET clinicImage = 'image/Careclinics Al-Amin Ayer Keroh.png'
WHERE clinicId = 17;

UPDATE clinic
SET clinicImage = 'image/Klinik Adam Hawa (Ayer Keroh).png'
WHERE clinicId = 18;

UPDATE clinic
SET clinicImage = 'image/Ayer Keroh Health Clinic.png'
WHERE clinicId = 19;

UPDATE clinic
SET clinicImage = 'image/Kelinik Ayer Keroh.png'
WHERE clinicId = 20;

UPDATE clinic
SET clinicImage = 'image/Q&M Ayer Keroh - Ng Dental Surgery.png'
WHERE clinicId = 21;

UPDATE clinic
SET clinicImage = 'image/MRIC CLINIC.png'
WHERE clinicId = 22;

UPDATE clinic
SET clinicImage = 'image/SONOBEE ULTRASOUND AYER KEROH.png'
WHERE clinicId = 23;

UPDATE clinic
SET clinicImage = 'image/Klinik Veterinar Ayer Keroh Heights.png'
WHERE clinicId = 24;

UPDATE clinic
SET clinicImage = 'image/Star Life Clinic TM.png'
WHERE clinicId = 25;

-- Alter table `appointment` to add a new column `type` and modify the `appointmentId` column

ALTER TABLE `appointment`
ADD COLUMN `type` VARCHAR(255) DEFAULT NULL,
MODIFY COLUMN `appointmentId` VARCHAR(11) NOT NULL;

ALTER TABLE appointment
ADD UNIQUE KEY unique_booking (clinicId, dateTime);

ALTER TABLE appointment
ADD status VARCHAR(20) DEFAULT 'Pending';