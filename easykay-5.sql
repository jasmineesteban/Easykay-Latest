-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2024 at 08:27 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easykay`
--

-- --------------------------------------------------------

--
-- Table structure for table `bus_fare`
--

CREATE TABLE `bus_fare` (
  `id` int(11) NOT NULL,
  `bus_regular` decimal(10,2) DEFAULT NULL,
  `bus_regular_succeeding` decimal(10,2) DEFAULT NULL,
  `bus_discounted` decimal(10,2) DEFAULT NULL,
  `bus_discounted_succeeding` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bus_fare`
--

INSERT INTO `bus_fare` (`id`, `bus_regular`, `bus_regular_succeeding`, `bus_discounted`, `bus_discounted_succeeding`) VALUES
(1, '11.00', '2.00', '8.00', '1.00');

-- --------------------------------------------------------

--
-- Table structure for table `guest_locations`
--

CREATE TABLE `guest_locations` (
  `id` int(11) NOT NULL,
  `guest_id` varchar(36) NOT NULL,
  `current_lat` double DEFAULT NULL,
  `current_lng` double DEFAULT NULL,
  `destination_lat` double DEFAULT NULL,
  `destination_lng` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jeep_fare`
--

CREATE TABLE `jeep_fare` (
  `id` int(11) NOT NULL,
  `jeep_regular` decimal(10,2) DEFAULT NULL,
  `jeep_regular_succeeding` decimal(10,2) DEFAULT NULL,
  `jeep_discounted` decimal(10,2) DEFAULT NULL,
  `jeep_discounted_succeeding` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jeep_fare`
--

INSERT INTO `jeep_fare` (`id`, `jeep_regular`, `jeep_regular_succeeding`, `jeep_discounted`, `jeep_discounted_succeeding`) VALUES
(1, '9.00', '1.00', '7.00', '0.50');

-- --------------------------------------------------------

--
-- Table structure for table `tb_activity_log`
--

CREATE TABLE `tb_activity_log` (
  `log_id` varchar(15) NOT NULL,
  `log_activity_id` varchar(25) NOT NULL,
  `log_date` date NOT NULL,
  `log_message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_activity_log`
--

INSERT INTO `tb_activity_log` (`log_id`, `log_activity_id`, `log_date`, `log_message`) VALUES
('log-2023-000028', 'rest-000006', '2023-12-07', 'You have added a resort named \"ascka\"'),
('log-2023-000029', 'rest-000005', '2023-12-07', 'You have deleted a resort named \"4k Garden  \"'),
('log-2023-000030', '', '2023-12-08', 'You have deleted an event titled \"\"'),
('log-2023-000031', '', '2023-12-08', 'You have deleted an event titled \"\"'),
('log-2023-000032', 'evt-2023-000002', '2023-12-08', 'You have deleted an event titled \"Event 2\"'),
('log-2023-000033', 'evt-2023-000005', '2023-12-08', 'You have deleted an event titled \"sample 2\"'),
('log-2023-000034', 'evt-2023-000008', '2023-12-08', 'You have added an event titled \"hayss\"'),
('log-2023-000035', 'evt-2023-000006', '2023-12-08', 'You have deleted an event titled \"Santa Maria Serenade: A Cultural Journey Through Bulacan&#039;s Charming Heartland\"'),
('log-2023-000036', '<br />\r\n<b>Warning</b>:  ', '2023-12-08', 'You have deleted an event titled \"\"'),
('log-2023-000037', '<br />\r\n<b>Warning</b>:  ', '2023-12-08', 'You have deleted an event titled \"\"'),
('log-2023-000038', '<br />\r\n<b>Warning</b>:  ', '2023-12-08', 'You have deleted an event titled \"\"'),
('log-2023-000039', '<br />\r\n<b>Warning</b>:  ', '2023-12-08', 'You have deleted an event titled \"\"'),
('log-2023-000040', 'evt-2023-000008', '2023-12-08', 'You have deleted an event titled \"hayss\"'),
('log-2023-000041', 'evt-2023-000007', '2023-12-19', 'You have deleted an event titled \"Sample today\"'),
('log-2023-000042', 'evt-2023-000007', '2023-12-19', 'You have deleted an event titled \"\"'),
('log-2023-000043', 'evt-2023-000001', '2023-12-19', 'You have added an event titled \"sample\"'),
('log-2023-000044', 'evt-2023-000001', '2023-12-19', 'You have deleted an event titled \"sample\"'),
('log-2023-000045', 'evt-2023-000001', '2023-12-19', 'You have added an event titled \"sample\"'),
('log-2023-000046', 'evt-2023-000001', '2023-12-19', 'You have deleted an event titled \"sample\"'),
('log-2023-000047', 'evt-2023-000001', '2023-12-31', 'You have added an event titled \"SAMPLE\"'),
('log-2023-000048', 'rest-000006', '2023-12-31', 'You have deleted a resort named \"ascka\"'),
('log-2023-000049', 'rest-000001', '2023-12-31', 'You have deleted a resort named \"Resort 1 - update\"'),
('log-2023-000050', 'rest-000004', '2023-12-31', 'You have deleted a resort named \"Resort 4 sample\"'),
('log-2023-000051', 'rest-000002', '2023-12-31', 'You have deleted a resort named \"Resort with log\"'),
('log-2023-000052', 'rest-000003', '2023-12-31', 'You have deleted a resort named \"Resort with log\"'),
('log-2023-000053', 'rest-000001', '2023-12-31', 'You have added a resort named \"4K Garden Resorts Inc.\"'),
('log-2023-000054', 'rec-000004', '2023-12-31', 'You have added a recreational facility named \"Ambika kids funbox\"'),
('log-2023-000055', 'rec-000004', '2023-12-31', 'You edited a recreational facility named \"Ambika kids funbox\"'),
('log-2024-000056', 'rest-000002', '2024-01-03', 'You have added a resort named \"Bluewind Private Resort\"'),
('log-2024-000057', 'rest-000001', '2024-01-03', 'You edited a resort named \"4K Garden Resorts Inc.\"'),
('log-2024-000058', 'rest-000001', '2024-01-03', 'You edited a resort named \"4K Garden Resorts Inc.\"'),
('log-2024-000059', 'rest-000001', '2024-01-03', 'You edited a resort named \"4K Garden Resorts Inc.\"'),
('log-2024-000060', 'rest-000001', '2024-01-03', 'You edited a resort named \"4K Garden Resorts Inc.\"'),
('log-2024-000061', 'rest-000001', '2024-01-03', 'You edited a resort named \"4K Garden Resorts Inc.\"'),
('log-2024-000062', 'rest-000002', '2024-01-03', 'You edited a resort named \"Bluewind Private Resort\"'),
('log-2024-000063', 'rec-000004', '2024-01-03', 'You edited a recreational facility named \"Ambika kids funbox\"'),
('log-2024-000064', 'rec-000004', '2024-01-03', 'You edited a recreational facility named \"Ambika kids funbox\"'),
('log-2024-000065', 'rec-000002', '2024-01-03', 'You have deleted a recreational facilities named \"Facilities\"'),
('log-2024-000066', 'admin-0001', '2024-01-03', 'You have added an event titled \"SAMPLE\"'),
('log-2024-000067', 'admin-0001', '2024-01-03', 'You have added an event titled \"SAMPLE\"'),
('log-2024-000068', 'evt-2024-000002', '2024-01-03', 'You have added an event titled \"sample 2\"'),
('log-2024-000069', 'evt-2024-000003', '2024-01-03', 'You have added an event titled \"sampleee 33\"'),
('log-2024-000070', 'admin-0001', '2024-01-03', 'You have added an event titled \"sampleee 33\"'),
('log-2024-000071', 'evt-2024-000003', '2024-01-03', 'You have deleted an event titled \"sampleee 33\"'),
('log-2024-000072', 'admin-0001', '2024-01-03', 'You have added an event titled \"sample 222222\"'),
('log-2024-000073', 'evt-2024-000002', '2024-01-03', 'You have deleted an event titled \"sample 222222\"'),
('log-2024-000074', 'evt-2024-000002', '2024-01-03', 'You have added an event titled \"sample 2\"'),
('log-2024-000075', 'rest-000001', '2024-01-03', 'You edited a resort named \"4K \"'),
('log-2024-000076', 'rest-000003', '2024-01-03', 'You have added a resort named \"SAMPLE\"'),
('log-2024-000077', 'rest-000003', '2024-01-03', 'You have deleted a resort named \"SAMPLE\"'),
('log-2024-000078', 'admin-0001', '2024-01-03', 'You have added an event titled \"sample 22222\"'),
('log-2024-000079', 'evt-2024-000002', '2024-01-03', 'You have deleted an event titled \"sample 22222\"'),
('log-2024-000080', 'evt-2024-000002', '2024-02-12', 'You have added an event named \"sample\"'),
('log-2024-000081', 'arc-2024-000001', '2024-02-12', 'You archived SAMPLE Event .'),
('log-2024-000082', 'arc-2024-000001', '2024-02-12', 'You archived SAMPLE Event .'),
('log-2024-000083', 'faqs-2024-000001', '2024-02-12', 'You have added a FAQs.'),
('log-2024-000084', 'arc-2024-000001', '2024-02-12', 'You archived a FAQs.'),
('log-2024-000085', 'faqs-2024-000001', '2024-02-12', 'You edited a FAQs.'),
('log-2024-000086', 'faqs-2024-000002', '2024-02-12', 'You have added a FAQs.'),
('log-2024-000087', 'arc-2024-000001', '2024-02-12', 'You archived Restaurants 2.'),
('log-2024-000088', 'toda-000001', '2024-02-12', 'You added tricycle toda BBSM.'),
('log-2024-000089', 'arc-2024-000001', '2024-02-13', 'You archived .'),
('log-2024-000090', 'arc-2024-000002', '2024-02-13', 'You archived .'),
('log-2024-000091', '', '2024-02-13', 'You edited a resort named \"4K jjjj\"'),
('log-2024-000092', 'arc-2024-000003', '2024-02-13', 'You archived 4K .'),
('log-2024-000093', 'rest-000002', '2024-02-13', 'You edited a resort named \"Bluewind Private Resort\"'),
('log-2024-000094', 'arc-2024-000004', '2024-02-13', 'You archived .'),
('log-2024-000095', 'arc-2024-000005', '2024-02-13', 'You archived .'),
('log-2024-000096', 'arc-2024-000006', '2024-02-13', 'You archived Bluewind Private Resort.'),
('log-2024-000097', 'toda-000002', '2024-02-13', 'You added tricycle toda janiz toda.'),
('log-2024-000098', 'toda-000003', '2024-02-13', 'You added tricycle toda pau toda.'),
('log-2024-000099', 'toda-000004', '2024-02-13', 'You added tricycle toda pau toda.'),
('log-2024-000100', 'arc-2024-000002', '2024-02-13', 'You archived sample Event .'),
('log-2024-000101', 'arc-2024-000003', '2024-02-13', 'You archived  Event .'),
('log-2024-000102', 'evt-2024-000001', '2024-02-13', 'You have added an event named \"sample\"'),
('log-2024-000103', 'evt-2024-000002', '2024-02-13', 'You have added an event named \"sample\"'),
('log-2024-000104', 'evt-2024-000001', '2024-02-13', 'You edited an event named \"sample 1\"'),
('log-2024-000105', 'evt-2024-000001', '2024-02-13', 'You edited an event named \"sample 565656\"'),
('log-2024-000106', '1', '2024-02-13', 'You updated the Bus Fare.'),
('log-2024-000107', '1', '2024-02-13', 'You updated the Bus Fare.'),
('log-2024-000108', '1', '2024-02-13', 'You updated the Jeepney Fare.'),
('log-2024-000109', 'arc-2024-000001', '2024-02-13', 'You archived a FAQs.'),
('log-2024-000110', 'arc-2024-000002', '2024-02-13', 'You archived a FAQs.'),
('log-2024-000111', 'faqs-2024-000002', '2024-02-13', 'You edited a FAQs.'),
('log-2024-000112', 'rest-000001', '2024-02-13', 'You have added a resort named \"Bluewind Private Resort sample\"'),
('log-2024-000113', 'rest-000002', '2024-02-13', 'You have added a resort named \"dhsiof\"'),
('log-2024-000114', 'evt-2024-000003', '2024-02-14', 'You have added an event named \"sample 1\"'),
('log-2024-000115', 'evt-2024-000004', '2024-02-14', 'You have added an event named \"&quot;#FUNRUN 2024 | Come and  join on January 20, 2024, Saturday at 5:30AM at the La Purisima Concepcion Patio, Poblacion, SMB&quot;\"'),
('log-2024-000116', 'evt-2024-000004', '2024-02-14', 'You edited an event named \"#FUNRUN 2024 | Come and  join on January 20, 2024, Saturday at 5:30AM at the La Purisima Conce\"'),
('log-2024-000117', 'arc-2024-000004', '2024-02-14', 'You archived sample Event .'),
('log-2024-000118', 'arc-2024-000005', '2024-02-14', 'You archived sample 565656 Event .'),
('log-2024-000119', 'arc-2024-000001', '2024-02-16', 'You archived Hotel 1.'),
('log-2024-000120', 'rest-000001', '2024-02-16', 'You edited a resort named \"Bluewind Private Resort sample 1\"'),
('log-2024-000121', 'toda-000005', '2024-02-16', 'You added tricycle toda Hershey Toda.'),
('log-2024-000122', 'toda-000006', '2024-02-16', 'You added tricycle toda Jasmine Toda.'),
('log-2024-000123', 'toda-000007', '2024-02-16', 'You added tricycle toda Sample.'),
('log-2024-000124', 'toda-000008', '2024-02-16', 'You added tricycle toda samplejaniz toda.'),
('log-2024-000125', 'toda-000009', '2024-02-16', 'You added tricycle toda sampleeeeeeeeee.'),
('log-2024-000126', 'faqs-2024-000002', '2024-02-16', 'You edited a FAQs.'),
('log-2024-000127', 'arc-2024-000006', '2024-02-16', 'You archived sample 1 Event .'),
('log-2024-000128', 'arc-2024-000006', '2024-02-16', 'You archived SAMPLE Event .'),
('log-2024-000129', 'arc-2024-000006', '2024-02-16', 'You archived #FUNRUN 2024 | Come and  join on January 20, 2024, Saturday at 5:30AM at the La Purisima Conce Event .'),
('log-2024-000130', 'arc-2024-000007', '2024-02-16', 'You archived SAMPLE Event .'),
('log-2024-000131', 'fare-000001', '2024-02-16', 'You have successfully added a route and fare for this TODA.'),
('log-2024-000132', 'fare-000002', '2024-02-16', 'You have successfully added a route and fare for this TODA.');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin_info`
--

CREATE TABLE `tb_admin_info` (
  `admin_id` varchar(10) NOT NULL,
  `admin_name` varchar(50) DEFAULT NULL,
  `admin_username` varchar(255) DEFAULT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_admin_info`
--

INSERT INTO `tb_admin_info` (`admin_id`, `admin_name`, `admin_username`, `admin_password`) VALUES
('admin-0001', 'Administrator', 'Admin', '$2y$10$tBah7.13ppDGcQmotAy23ev0jkBtup9vy9Et21qObJfrUnurLoz.2');

-- --------------------------------------------------------

--
-- Table structure for table `tb_archive_cultural_religious`
--

CREATE TABLE `tb_archive_cultural_religious` (
  `arc_id` varchar(25) NOT NULL,
  `arc_exp_id` varchar(25) DEFAULT NULL,
  `arc_exp_name` varchar(255) DEFAULT NULL,
  `arc_evt_description` text DEFAULT NULL,
  `arc_exp_location` varchar(255) DEFAULT NULL,
  `arc_exp_contact` varchar(25) DEFAULT NULL,
  `arc_exp_image` varchar(255) DEFAULT NULL,
  `arc_exp_other` text DEFAULT NULL,
  `arc_exp_latitude` decimal(30,15) DEFAULT NULL,
  `arc_exp_longitude` decimal(30,15) DEFAULT NULL,
  `arc_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_archive_event`
--

CREATE TABLE `tb_archive_event` (
  `arc_id` varchar(25) NOT NULL,
  `arc_evt_id` varchar(25) DEFAULT NULL,
  `arc_evt_name` varchar(255) DEFAULT NULL,
  `arc_evt_description` text DEFAULT NULL,
  `arc_evt_location` varchar(255) DEFAULT NULL,
  `arc_evt_date` date DEFAULT NULL,
  `arc_evt_image` varchar(255) DEFAULT NULL,
  `arc_evt_instruction` text DEFAULT NULL,
  `arc_evt_latitude` decimal(30,15) DEFAULT NULL,
  `arc_evt_longitude` decimal(30,15) DEFAULT NULL,
  `arc_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_archive_faqs`
--

CREATE TABLE `tb_archive_faqs` (
  `arc_id` varchar(25) NOT NULL,
  `arc_faqs_id` varchar(25) DEFAULT NULL,
  `arc_quest` text DEFAULT NULL,
  `arc_ans` text DEFAULT NULL,
  `arc_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_archive_hotel_lodge`
--

CREATE TABLE `tb_archive_hotel_lodge` (
  `arc_id` varchar(25) NOT NULL,
  `arc_exp_id` varchar(25) DEFAULT NULL,
  `arc_exp_name` varchar(255) DEFAULT NULL,
  `arc_evt_description` text DEFAULT NULL,
  `arc_exp_location` varchar(255) DEFAULT NULL,
  `arc_exp_contact` varchar(25) DEFAULT NULL,
  `arc_exp_image` varchar(255) DEFAULT NULL,
  `arc_exp_other` text DEFAULT NULL,
  `arc_exp_latitude` decimal(30,15) DEFAULT NULL,
  `arc_exp_longitude` decimal(30,15) DEFAULT NULL,
  `arc_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_archive_natural_manmade`
--

CREATE TABLE `tb_archive_natural_manmade` (
  `arc_id` varchar(25) NOT NULL,
  `arc_exp_id` varchar(25) DEFAULT NULL,
  `arc_exp_name` varchar(255) DEFAULT NULL,
  `arc_evt_description` text DEFAULT NULL,
  `arc_exp_location` varchar(255) DEFAULT NULL,
  `arc_exp_contact` varchar(25) DEFAULT NULL,
  `arc_exp_image` varchar(255) DEFAULT NULL,
  `arc_exp_other` text DEFAULT NULL,
  `arc_exp_latitude` decimal(30,15) DEFAULT NULL,
  `arc_exp_longitude` decimal(30,15) DEFAULT NULL,
  `arc_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_archive_recreational`
--

CREATE TABLE `tb_archive_recreational` (
  `arc_id` varchar(25) NOT NULL,
  `arc_exp_id` varchar(25) DEFAULT NULL,
  `arc_exp_name` varchar(255) DEFAULT NULL,
  `arc_evt_description` text DEFAULT NULL,
  `arc_exp_location` varchar(255) DEFAULT NULL,
  `arc_exp_contact` varchar(25) DEFAULT NULL,
  `arc_exp_image` varchar(255) DEFAULT NULL,
  `arc_exp_other` text DEFAULT NULL,
  `arc_exp_latitude` decimal(30,15) DEFAULT NULL,
  `arc_exp_longitude` decimal(30,15) DEFAULT NULL,
  `arc_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_archive_resorts`
--

CREATE TABLE `tb_archive_resorts` (
  `arc_id` varchar(25) NOT NULL,
  `arc_exp_id` varchar(25) DEFAULT NULL,
  `arc_exp_name` varchar(255) DEFAULT NULL,
  `arc_evt_description` text DEFAULT NULL,
  `arc_exp_location` varchar(255) DEFAULT NULL,
  `arc_exp_contact` varchar(25) DEFAULT NULL,
  `arc_exp_image` varchar(255) DEFAULT NULL,
  `arc_exp_other` text DEFAULT NULL,
  `arc_exp_latitude` decimal(30,15) DEFAULT NULL,
  `arc_exp_longitude` decimal(30,15) DEFAULT NULL,
  `arc_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_archive_restaurants`
--

CREATE TABLE `tb_archive_restaurants` (
  `arc_id` varchar(25) NOT NULL,
  `arc_exp_id` varchar(25) DEFAULT NULL,
  `arc_exp_name` varchar(255) DEFAULT NULL,
  `arc_evt_description` text DEFAULT NULL,
  `arc_exp_location` varchar(255) DEFAULT NULL,
  `arc_exp_contact` varchar(25) DEFAULT NULL,
  `arc_exp_image` varchar(255) DEFAULT NULL,
  `arc_exp_other` text DEFAULT NULL,
  `arc_exp_latitude` decimal(30,15) DEFAULT NULL,
  `arc_exp_longitude` decimal(30,15) DEFAULT NULL,
  `arc_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_event_details`
--

CREATE TABLE `tb_event_details` (
  `evt_id` varchar(15) NOT NULL,
  `evt_name` varchar(100) NOT NULL,
  `evt_description` text NOT NULL,
  `evt_location` varchar(100) NOT NULL,
  `evt_date` date NOT NULL,
  `evt_image` varchar(50) DEFAULT NULL,
  `evt_instruction` text DEFAULT NULL,
  `evt_latitude` double DEFAULT NULL,
  `evt_longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_explore_cultural_religious`
--

CREATE TABLE `tb_explore_cultural_religious` (
  `cul_id` varchar(15) NOT NULL,
  `cul_name` varchar(50) NOT NULL,
  `cul_description` text NOT NULL,
  `cul_location` varchar(100) NOT NULL,
  `cul_contact` varchar(11) NOT NULL,
  `cul_image` varchar(50) DEFAULT NULL,
  `cul_other_info` text DEFAULT NULL,
  `cul_latitude` double DEFAULT NULL,
  `cul_longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_explore_hotel_lodge`
--

CREATE TABLE `tb_explore_hotel_lodge` (
  `hotel_id` varchar(12) NOT NULL,
  `hotel_name` varchar(50) NOT NULL,
  `hotel_description` text NOT NULL,
  `hotel_location` varchar(100) NOT NULL,
  `hotel_contact` varchar(11) NOT NULL,
  `hotel_image` varchar(50) DEFAULT NULL,
  `hotel_other_info` text DEFAULT NULL,
  `hotel_latitude` double DEFAULT NULL,
  `hotel_longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_explore_natural_manmade`
--

CREATE TABLE `tb_explore_natural_manmade` (
  `natural_id` varchar(14) NOT NULL,
  `natural_name` varchar(50) NOT NULL,
  `natural_description` text NOT NULL,
  `natural_location` varchar(100) NOT NULL,
  `natural_contact` varchar(11) NOT NULL,
  `natural_image` varchar(50) DEFAULT NULL,
  `natural_other_info` text DEFAULT NULL,
  `natural_latitude` double DEFAULT NULL,
  `natural_longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_explore_recreational`
--

CREATE TABLE `tb_explore_recreational` (
  `rec_id` varchar(10) NOT NULL,
  `rec_name` varchar(50) NOT NULL,
  `rec_description` text NOT NULL,
  `rec_location` varchar(100) NOT NULL,
  `rec_contact` varchar(11) NOT NULL,
  `rec_image` varchar(50) DEFAULT NULL,
  `rec_other_info` text DEFAULT NULL,
  `rec_latitude` double DEFAULT NULL,
  `rec_longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_explore_resorts`
--

CREATE TABLE `tb_explore_resorts` (
  `rest_id` varchar(11) NOT NULL,
  `rest_name` varchar(50) NOT NULL,
  `rest_description` text NOT NULL,
  `rest_location` varchar(100) NOT NULL,
  `rest_contact` varchar(11) NOT NULL,
  `rest_image` varchar(50) DEFAULT NULL,
  `rest_other_info` text DEFAULT NULL,
  `rest_latitude` double NOT NULL,
  `rest_longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_explore_restaurants`
--

CREATE TABLE `tb_explore_restaurants` (
  `resto_id` varchar(12) NOT NULL,
  `resto_name` varchar(50) NOT NULL,
  `resto_description` text NOT NULL,
  `resto_location` varchar(100) NOT NULL,
  `resto_contact` varchar(11) NOT NULL,
  `resto_image` varchar(50) DEFAULT NULL,
  `resto_other_info` text DEFAULT NULL,
  `resto_latitude` double DEFAULT NULL,
  `resto_longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_faqs`
--

CREATE TABLE `tb_faqs` (
  `faqs_id` varchar(25) DEFAULT NULL,
  `faqs_question` text DEFAULT NULL,
  `faqs_answer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_faqs`
--

INSERT INTO `tb_faqs` (`faqs_id`, `faqs_question`, `faqs_answer`) VALUES
('faqs-2024-000002', 'How does EasyKay work? ', '  EasyKay utilizes advanced technology, including GPS tracking and real-time data analysis, to provide accurate and up-to-date information about your commute. It offers route suggestions, traffic updates, and other relevant details to help you make informed decisions.');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jeep_terminal`
--

CREATE TABLE `tb_jeep_terminal` (
  `jeepId` int(11) NOT NULL,
  `jeep_location` varchar(255) DEFAULT NULL,
  `jeep_latitude` double DEFAULT NULL,
  `jeep_longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_toda_fare`
--

CREATE TABLE `tb_toda_fare` (
  `toda_fare_id` varchar(25) NOT NULL,
  `toda_id` varchar(25) DEFAULT NULL,
  `toda_route` varchar(100) DEFAULT NULL,
  `toda_one_pass` decimal(10,2) DEFAULT NULL,
  `toda_two_pass` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tricycle_toda`
--

CREATE TABLE `tb_tricycle_toda` (
  `toda_id` varchar(25) NOT NULL,
  `toda_name` varchar(255) DEFAULT NULL,
  `toda_terminal` varchar(255) DEFAULT NULL,
  `toda_latitude` decimal(30,15) DEFAULT NULL,
  `toda_longitude` decimal(30,15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_profile`
--

CREATE TABLE `tb_user_profile` (
  `user_id` varchar(16) NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `user_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user_profile`
--

INSERT INTO `tb_user_profile` (`user_id`, `user_name`, `user_email`) VALUES
('user-2024-000001', 'Paulalyn Bagagunio', 'paulalynbagagunio@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bus_fare`
--
ALTER TABLE `bus_fare`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest_locations`
--
ALTER TABLE `guest_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jeep_fare`
--
ALTER TABLE `jeep_fare`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_activity_log`
--
ALTER TABLE `tb_activity_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tb_admin_info`
--
ALTER TABLE `tb_admin_info`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tb_archive_cultural_religious`
--
ALTER TABLE `tb_archive_cultural_religious`
  ADD PRIMARY KEY (`arc_id`);

--
-- Indexes for table `tb_archive_event`
--
ALTER TABLE `tb_archive_event`
  ADD PRIMARY KEY (`arc_id`);

--
-- Indexes for table `tb_archive_faqs`
--
ALTER TABLE `tb_archive_faqs`
  ADD PRIMARY KEY (`arc_id`);

--
-- Indexes for table `tb_archive_hotel_lodge`
--
ALTER TABLE `tb_archive_hotel_lodge`
  ADD PRIMARY KEY (`arc_id`);

--
-- Indexes for table `tb_archive_natural_manmade`
--
ALTER TABLE `tb_archive_natural_manmade`
  ADD PRIMARY KEY (`arc_id`);

--
-- Indexes for table `tb_archive_recreational`
--
ALTER TABLE `tb_archive_recreational`
  ADD PRIMARY KEY (`arc_id`);

--
-- Indexes for table `tb_archive_resorts`
--
ALTER TABLE `tb_archive_resorts`
  ADD PRIMARY KEY (`arc_id`);

--
-- Indexes for table `tb_archive_restaurants`
--
ALTER TABLE `tb_archive_restaurants`
  ADD PRIMARY KEY (`arc_id`);

--
-- Indexes for table `tb_event_details`
--
ALTER TABLE `tb_event_details`
  ADD PRIMARY KEY (`evt_id`);

--
-- Indexes for table `tb_explore_cultural_religious`
--
ALTER TABLE `tb_explore_cultural_religious`
  ADD PRIMARY KEY (`cul_id`);

--
-- Indexes for table `tb_explore_hotel_lodge`
--
ALTER TABLE `tb_explore_hotel_lodge`
  ADD PRIMARY KEY (`hotel_id`);

--
-- Indexes for table `tb_explore_natural_manmade`
--
ALTER TABLE `tb_explore_natural_manmade`
  ADD PRIMARY KEY (`natural_id`);

--
-- Indexes for table `tb_explore_recreational`
--
ALTER TABLE `tb_explore_recreational`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indexes for table `tb_explore_resorts`
--
ALTER TABLE `tb_explore_resorts`
  ADD PRIMARY KEY (`rest_id`);

--
-- Indexes for table `tb_explore_restaurants`
--
ALTER TABLE `tb_explore_restaurants`
  ADD PRIMARY KEY (`resto_id`);

--
-- Indexes for table `tb_jeep_terminal`
--
ALTER TABLE `tb_jeep_terminal`
  ADD PRIMARY KEY (`jeepId`);

--
-- Indexes for table `tb_toda_fare`
--
ALTER TABLE `tb_toda_fare`
  ADD PRIMARY KEY (`toda_fare_id`),
  ADD KEY `toda_id` (`toda_id`);

--
-- Indexes for table `tb_tricycle_toda`
--
ALTER TABLE `tb_tricycle_toda`
  ADD PRIMARY KEY (`toda_id`);

--
-- Indexes for table `tb_user_profile`
--
ALTER TABLE `tb_user_profile`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bus_fare`
--
ALTER TABLE `bus_fare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guest_locations`
--
ALTER TABLE `guest_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeep_fare`
--
ALTER TABLE `jeep_fare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_jeep_terminal`
--
ALTER TABLE `tb_jeep_terminal`
  MODIFY `jeepId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_toda_fare`
--
ALTER TABLE `tb_toda_fare`
  ADD CONSTRAINT `tb_toda_fare_ibfk_1` FOREIGN KEY (`toda_id`) REFERENCES `tb_tricycle_toda` (`toda_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
