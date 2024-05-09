-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 17, 2024 at 10:42 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elegancevibe`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `emailAddress` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `firstName`, `lastName`, `emailAddress`, `password`) VALUES
(1, 'Emily', 'Davis', 'c1@client.com', 'C1'),
(2, 'David', 'Wilson', 'c2@client.com', 'C2'),
(3, 'Sophia', 'Brown', 'c3@client.com', 'C3'),
(4, 'razan', 'zaki', 'razan08642@gmail.com', '$2y$10$ylIUC9bsbPwuIaQMepa3qOqHtNFbhBQAtPHxulMjG4zfRj5UTEhre');

-- --------------------------------------------------------

--
-- Table structure for table `designcategory`
--

CREATE TABLE `designcategory` (
  `id` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designcategory`
--

INSERT INTO `designcategory` (`id`, `category`) VALUES
(1, 'Modren'),
(2, 'Country'),
(3, 'Coastal'),
(4, 'Bohemian');

-- --------------------------------------------------------

--
-- Table structure for table `designconsultation`
--

CREATE TABLE `designconsultation` (
  `id` int(11) NOT NULL,
  `requestID` int(11) DEFAULT NULL,
  `consultation` text,
  `consultationImgFileName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designconsultation`
--

INSERT INTO `designconsultation` (`id`, `requestID`, `consultation`, `consultationImgFileName`) VALUES
(1, 1, 'Provided consultation on room layout and color scheme.', 'consultation1.jpg'),
(2, 2, 'Consultation declined due to conflicting design preferences.', 'consultation2.jpeg'),
(3, 3, 'Conducted consultation and provided recommendations for furniture placement.', 'consultation3.jpg'),
(4, 4, 'Consultation provided with 3D renderings of the design concept.', 'consultation4.jpg'),
(5, 5, 'Provided consultation on lighting and decor options.', 'consultation5.jpg'),
(6, 1, 'natural living room', '661fa4b0d200f_1_6600b1d272e2c.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `designconsultationrequest`
--

CREATE TABLE `designconsultationrequest` (
  `id` int(11) NOT NULL,
  `clientID` int(11) DEFAULT NULL,
  `designerID` int(11) DEFAULT NULL,
  `roomTypeID` int(11) DEFAULT NULL,
  `designCategoryID` int(11) DEFAULT NULL,
  `roomWidth` float DEFAULT NULL,
  `roomLength` float DEFAULT NULL,
  `colorPreferences` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `statusID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designconsultationrequest`
--

INSERT INTO `designconsultationrequest` (`id`, `clientID`, `designerID`, `roomTypeID`, `designCategoryID`, `roomWidth`, `roomLength`, `colorPreferences`, `date`, `statusID`) VALUES
(1, 1, 1, 1, 2, 12.5, 10.8, 'Neutral colors', '2022-01-15', 3),
(2, 2, 1, 2, 1, 8.2, 9.5, 'Bold and vibrant colors', '2022-02-03', 2),
(3, 3, 2, 3, 3, 15, 12, 'Earth tones', '2022-03-21', 1),
(4, 1, 3, 1, 4, 10, 10, 'Minimalist and monochromatic', '2022-04-12', 3),
(5, 2, 3, 2, 1, 7.5, 6.5, 'Pastel colors', '2022-05-06', 1),
(6, 1, 1, 2, 1, 5, 3, 'brown', '2024-04-17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `designer`
--

CREATE TABLE `designer` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `emailAddress` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `brandName` varchar(255) DEFAULT NULL,
  `logoImgFileName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designer`
--

INSERT INTO `designer` (`id`, `firstName`, `lastName`, `emailAddress`, `password`, `brandName`, `logoImgFileName`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', 'D1', 'JD Designs', 'B1.png'),
(2, 'Jane', 'Smith', 'janesmith@example.com', 'D2', 'JS Interiors', 'B2.jpg'),
(3, 'Michael', 'Johnson', 'michaeljohnson@example.com', 'D3', 'MJ Decor', 'B3.png');

-- --------------------------------------------------------

--
-- Table structure for table `designerspeciality`
--

CREATE TABLE `designerspeciality` (
  `designerID` int(11) DEFAULT NULL,
  `designCategoryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designerspeciality`
--

INSERT INTO `designerspeciality` (`designerID`, `designCategoryID`) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `designportoflioproject`
--

CREATE TABLE `designportoflioproject` (
  `id` int(11) NOT NULL,
  `designerID` int(11) DEFAULT NULL,
  `projectName` varchar(255) DEFAULT NULL,
  `projectImgFileName` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `designCategoryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designportoflioproject`
--

INSERT INTO `designportoflioproject` (`id`, `designerID`, `projectName`, `projectImgFileName`, `description`, `designCategoryID`) VALUES
(1, 1, 'Living Room Redesign', 'r1.jpg', 'Redesigned the living room space with a modern theme.', 1),
(2, 1, 'Kitchen Renovation', 'r2.jpg', 'Complete kitchen renovation with new appliances and fixtures.', 2),
(3, 2, 'Bedroom Makeover', 'bed3.jpg', 'Transformed a plain bedroom into a cozy retreat.', 1),
(4, 2, 'Office Space Design', 'office.jpg', 'Created a functional and stylish office environment.', 3),
(5, 3, 'Bathroom Remodel', 'bath5.jpg', 'Remodeled the bathroom with new tiles and fixtures.', 4);

-- --------------------------------------------------------

--
-- Table structure for table `requeststatus`
--

CREATE TABLE `requeststatus` (
  `id` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `requeststatus`
--

INSERT INTO `requeststatus` (`id`, `status`) VALUES
(1, 'Pending Consultation'),
(2, 'Consultation Declined'),
(3, 'Consultation Provided');

-- --------------------------------------------------------

--
-- Table structure for table `roomtype`
--

CREATE TABLE `roomtype` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roomtype`
--

INSERT INTO `roomtype` (`id`, `type`) VALUES
(1, 'Living Room'),
(2, 'Bedroom'),
(3, 'Office'),
(4, 'Bathroom');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `designcategory`
--
ALTER TABLE `designcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designconsultation`
--
ALTER TABLE `designconsultation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requestID` (`requestID`);

--
-- Indexes for table `designconsultationrequest`
--
ALTER TABLE `designconsultationrequest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientID` (`clientID`),
  ADD KEY `designerID` (`designerID`),
  ADD KEY `roomTypeID` (`roomTypeID`),
  ADD KEY `designCategoryID` (`designCategoryID`),
  ADD KEY `statusID` (`statusID`);

--
-- Indexes for table `designer`
--
ALTER TABLE `designer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designerspeciality`
--
ALTER TABLE `designerspeciality`
  ADD KEY `designerID` (`designerID`),
  ADD KEY `designCategoryID` (`designCategoryID`);

--
-- Indexes for table `designportoflioproject`
--
ALTER TABLE `designportoflioproject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designerID` (`designerID`),
  ADD KEY `designCategoryID` (`designCategoryID`);

--
-- Indexes for table `requeststatus`
--
ALTER TABLE `requeststatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roomtype`
--
ALTER TABLE `roomtype`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `designconsultation`
--
ALTER TABLE `designconsultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `designconsultationrequest`
--
ALTER TABLE `designconsultationrequest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `designer`
--
ALTER TABLE `designer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `designportoflioproject`
--
ALTER TABLE `designportoflioproject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `designconsultationrequest`
--
ALTER TABLE `designconsultationrequest`
  ADD CONSTRAINT `designconsultationrequest_ibfk_1` FOREIGN KEY (`clientID`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `designconsultationrequest_ibfk_2` FOREIGN KEY (`designerID`) REFERENCES `designer` (`id`),
  ADD CONSTRAINT `designconsultationrequest_ibfk_3` FOREIGN KEY (`roomTypeID`) REFERENCES `roomtype` (`id`),
  ADD CONSTRAINT `designconsultationrequest_ibfk_4` FOREIGN KEY (`designCategoryID`) REFERENCES `designcategory` (`id`),
  ADD CONSTRAINT `designconsultationrequest_ibfk_5` FOREIGN KEY (`statusID`) REFERENCES `requeststatus` (`id`);

--
-- Constraints for table `designerspeciality`
--
ALTER TABLE `designerspeciality`
  ADD CONSTRAINT `designerspeciality_ibfk_1` FOREIGN KEY (`designerID`) REFERENCES `designer` (`id`),
  ADD CONSTRAINT `designerspeciality_ibfk_2` FOREIGN KEY (`designCategoryID`) REFERENCES `designcategory` (`id`),
  ADD CONSTRAINT `fk_designer_specialization_designcategory` FOREIGN KEY (`designCategoryID`) REFERENCES `designcategory` (`id`),
  ADD CONSTRAINT `fk_designer_specialization_designer` FOREIGN KEY (`designerID`) REFERENCES `designer` (`id`);

--
-- Constraints for table `designportoflioproject`
--
ALTER TABLE `designportoflioproject`
  ADD CONSTRAINT `designportoflioproject_ibfk_1` FOREIGN KEY (`designerID`) REFERENCES `designer` (`id`),
  ADD CONSTRAINT `designportoflioproject_ibfk_2` FOREIGN KEY (`designCategoryID`) REFERENCES `designcategory` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
