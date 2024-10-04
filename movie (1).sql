-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Oct 04, 2024 at 03:43 PM
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
-- Database: `movie`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `movie` varchar(150) NOT NULL,
  `show_date` date NOT NULL,
  `tickets` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `name`, `email`, `phone`, `movie`, `show_date`, `tickets`) VALUES
(2, 'bgspa dissanayake', 'hasindu612@gmail.com', '0775120692', 'hopp', '2024-10-01', 5),
(3, 'Hasindu 23 Niran', 'hasindu612@gmail.com', '0712356456', 'hj', '2024-10-04', 5),
(4, 'Hasindu 45', 'hasindu612@gmail.com', '0712356456', 'hj', '2024-10-04', 5),
(5, 'lasal', 'anupamapasan01@gmail.com', '0713749465', 'hj', '2024-10-04', 5),
(6, 'lasal', 'anupamapasan01@gmail.com', '0713749465', 'hj', '2024-10-04', 5),
(7, 'lasal', 'anupamapasan01@gmail.com', '0713749465', 'hj', '2024-10-04', 5),
(8, 'lasal', 'yenura02@gmail.com', '0123456789', 'hj', '2024-10-04', 4);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(10) NOT NULL,
  `name` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `movie` varchar(500) NOT NULL,
  `message` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `movie`, `message`) VALUES
(3, 'John Doe', 'john.doe@example.com', 'hj', 'Message hi hasssss'),
(4, 'lasal', 'yenura02@gmail.com', 'hj', 'j'),
(5, 'lasaln kn', 'l@g.com', 'hj', 'jjl');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `price` int(11) NOT NULL,
  `duration` varchar(500) NOT NULL,
  `category` varchar(20) NOT NULL,
  `description` varchar(500) NOT NULL,
  `photo` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `price`, `duration`, `category`, `description`, `photo`) VALUES
(4, 'Hello', 250, '3j', 'Tamil', 'hi', 0x75706c6f6164732f363666626463653033646565305f576861747341707020496d61676520323032342d30392d32342061742031312e32362e31385f33393032316336302e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL,
  `photo` longblob NOT NULL,
  `telphone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password`, `photo`, `telphone`) VALUES
(2, 'Hasindu', 'Niran l', 'hasindu612@gmail.com', '1234', 0x75706c6f6164732f4f4950202831292e6a706567, ''),
(3, 'Yenuraaaaa', 'Karunanayaka', 'yenura02@gmail.com', '1234', 0x75706c6f6164732f363666663930323562636636665f57494e5f32303234303232375f31335f35395f30365f50726f2e6a7067, '0789852068'),
(4, 'Sahan', 'Weerakkodi', 's@gmail.com', '12345678', 0x75706c6f6164732f363666666438316138313764665f547275652b536572766963652b4d616e61676572732b6172652b6f6e2b7468652b46726f6e742b4c696e652e6a7067, '0712345678');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
