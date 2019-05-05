-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 03, 2019 at 11:32 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE IF NOT EXISTS `area` (
  `areaID` int(6) NOT NULL,
  `areaname` varchar(10) NOT NULL,
  `city` varchar(10) NOT NULL,
  PRIMARY KEY (`areaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`areaID`, `areaname`, `city`) VALUES
(1, 'New Cairo', 'Cairo'),
(2, 'Nasr City', 'Cairo');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
CREATE TABLE IF NOT EXISTS `branch` (
  `branchID` int(6) NOT NULL,
  `restaurantID` int(6) NOT NULL,
  `openinghrs` time NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`branchID`,`restaurantID`),
  KEY `restaurantID` (`restaurantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branchID`, `restaurantID`, `openinghrs`, `address`) VALUES
(1, 1, '10:00:00', '4815 90th Road , New Cairo.'),
(1, 2, '11:00:00', '6825 Mostafa el Nahhas , Nasr City.');

-- --------------------------------------------------------

--
-- Table structure for table `branchdeliveryarea`
--

DROP TABLE IF EXISTS `branchdeliveryarea`;
CREATE TABLE IF NOT EXISTS `branchdeliveryarea` (
  `branchID` int(6) NOT NULL,
  `restaurantID` int(6) NOT NULL,
  `areaID` int(6) NOT NULL,
  `deliverycost` decimal(4,2) NOT NULL,
  PRIMARY KEY (`branchID`,`restaurantID`,`areaID`),
  KEY `restaurantID` (`restaurantID`,`branchID`),
  KEY `areaID` (`areaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branchdeliveryarea`
--

INSERT INTO `branchdeliveryarea` (`branchID`, `restaurantID`, `areaID`, `deliverycost`) VALUES
(1, 1, 1, '15.25'),
(1, 2, 2, '20.50');

-- --------------------------------------------------------

--
-- Table structure for table `branchphoneno`
--

DROP TABLE IF EXISTS `branchphoneno`;
CREATE TABLE IF NOT EXISTS `branchphoneno` (
  `branchID` int(6) NOT NULL,
  `restaurantID` int(6) NOT NULL,
  `phoneno` varchar(11) NOT NULL,
  PRIMARY KEY (`branchID`,`restaurantID`,`phoneno`),
  KEY `branchID` (`branchID`,`restaurantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branchphoneno`
--

INSERT INTO `branchphoneno` (`branchID`, `restaurantID`, `phoneno`) VALUES
(1, 1, '01220122'),
(1, 2, '012315613');

-- --------------------------------------------------------

--
-- Table structure for table `changepassword`
--

DROP TABLE IF EXISTS `changepassword`;
CREATE TABLE IF NOT EXISTS `changepassword` (
  `changeID` int(6) NOT NULL AUTO_INCREMENT,
  `AdminUsername` varchar(16) NOT NULL,
  `changedUsername` varchar(16) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`changeID`),
  KEY `AdminUsername` (`AdminUsername`),
  KEY `changedUsername` (`changedUsername`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customitem`
--

DROP TABLE IF EXISTS `customitem`;
CREATE TABLE IF NOT EXISTS `customitem` (
  `customname` varchar(20) NOT NULL,
  `itemID` int(6) NOT NULL,
  `isAvailable` int(1) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  PRIMARY KEY (`customname`,`itemID`),
  KEY `itemID` (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customitem`
--

INSERT INTO `customitem` (`customname`, `itemID`, `isAvailable`, `price`) VALUES
('6 Pieces', 10, 0, '35.25'),
('Coffee', 9, 1, '15.50'),
('Combo', 4, 1, '88.99'),
('Combo', 6, 1, '55.00'),
('Combo', 7, 1, '99.99'),
('Family Stuffed Crust', 3, 0, '120.00'),
('Large Pan', 1, 1, '80.00'),
('Large Pan', 2, 1, '95.00'),
('Medium Pan', 1, 1, '60.00'),
('Medium Pan', 2, 1, '75.00'),
('Salad', 8, 1, '45.50'),
('Sandwich', 4, 1, '90.50'),
('Sandwich', 5, 1, '75.22'),
('Tea', 9, 1, '12.00');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
CREATE TABLE IF NOT EXISTS `discount` (
  `discountID` int(6) NOT NULL,
  `discountpercentage` decimal(2,2) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  PRIMARY KEY (`discountID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`discountID`, `discountpercentage`, `startdate`, `enddate`) VALUES
(2, '0.15', '2019-04-10', '2019-05-15');

-- --------------------------------------------------------

--
-- Table structure for table `discountcode`
--

DROP TABLE IF EXISTS `discountcode`;
CREATE TABLE IF NOT EXISTS `discountcode` (
  `codeID` int(6) NOT NULL,
  `discountpercentage` decimal(2,2) NOT NULL,
  `uses` int(11) NOT NULL,
  PRIMARY KEY (`codeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discountcode`
--

INSERT INTO `discountcode` (`codeID`, `discountpercentage`, `uses`) VALUES
(1, '0.05', 25);

-- --------------------------------------------------------

--
-- Table structure for table `dropaccount`
--

DROP TABLE IF EXISTS `dropaccount`;
CREATE TABLE IF NOT EXISTS `dropaccount` (
  `DeletedUsername` varchar(16) NOT NULL,
  `AdminUsername` varchar(16) NOT NULL,
  `DropID` int(6) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`DropID`),
  KEY `AdminUsername` (`AdminUsername`),
  KEY `DeletedUsername` (`DeletedUsername`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dropaccount`
--

INSERT INTO `dropaccount` (`DeletedUsername`, `AdminUsername`, `DropID`, `datetime`) VALUES
('rektadmin', 'admin', 21, '2019-05-01 20:58:03');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `itemid` int(6) NOT NULL,
  `itemname` varchar(20) NOT NULL,
  `itemdescription` text NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemid`, `itemname`, `itemdescription`) VALUES
(1, 'Marghrita', 'Green Pepper, Onions, Tomatoes, Olives and Mozzarella Cheese'),
(2, 'Chicken BBQ', 'Green Pepper, Onions, Chicken Strips, BBQ Sauce and Mozzarella Cheese'),
(3, 'Supersupreme', 'Beef Pepperoni, green pepper, onions, black olives and mozzarella cheese.'),
(4, 'Big Boss', '2 Golden Friend Breast Pieces, Beef Bacon, Cheese, BBQ and bread with sesame. '),
(5, 'Bomer Fillet', 'Chicken Breast, 2 Jalapeno, Cheese, Mayonnaise and bread with sesame. '),
(6, 'Snack Box', '1 Large Chicken Piece and 1 Small Chicken Piece covered with special spices.'),
(7, 'Dinner Box', '3 Large Fried Chicken pieces covered with special spices.'),
(8, 'Chicken Caesar Salad', 'Extra Chicken'),
(9, 'Hot Drink', 'Tea, Coffee'),
(10, 'Garlic Bread', 'Freshly Baked Garlic French Bread with Spices'),
(11, 'Kid\'s Meal', '3 Chicken strips pieces, fries.'),
(12, 'French Fries', 'Fries');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `restaurantID` int(6) NOT NULL,
  `menuID` int(6) NOT NULL,
  `menutype` varchar(10) NOT NULL,
  `startsat` time NOT NULL,
  `endsat` time NOT NULL,
  PRIMARY KEY (`restaurantID`,`menuID`,`menutype`),
  KEY `restaurantID` (`restaurantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`restaurantID`, `menuID`, `menutype`, `startsat`, `endsat`) VALUES
(1, 1, 'Morning', '09:30:00', '11:00:00'),
(1, 2, 'Regular', '11:00:01', '23:00:00'),
(2, 1, 'Regular', '00:00:00', '23:59:59');

-- --------------------------------------------------------

--
-- Table structure for table `menuitems`
--

DROP TABLE IF EXISTS `menuitems`;
CREATE TABLE IF NOT EXISTS `menuitems` (
  `restaurantID` int(6) NOT NULL,
  `menuID` int(6) NOT NULL,
  `itemID` int(6) NOT NULL,
  PRIMARY KEY (`restaurantID`,`menuID`,`itemID`),
  KEY `itemID` (`itemID`),
  KEY `restaurantID` (`restaurantID`,`menuID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menuitems`
--

INSERT INTO `menuitems` (`restaurantID`, `menuID`, `itemID`) VALUES
(2, 1, 1),
(2, 1, 2),
(2, 1, 3),
(1, 2, 4),
(1, 2, 5),
(1, 2, 6),
(1, 2, 7),
(1, 1, 8),
(1, 1, 9),
(1, 1, 10),
(1, 1, 11),
(1, 2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `modifyuser`
--

DROP TABLE IF EXISTS `modifyuser`;
CREATE TABLE IF NOT EXISTS `modifyuser` (
  `modificationID` int(6) NOT NULL,
  `uuid` int(6) NOT NULL,
  `modifieduuid` int(6) NOT NULL,
  `modificationType` int(1) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`modificationID`),
  KEY `modifieduuid` (`modifieduuid`),
  KEY `uuid` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orderaddress`
--

DROP TABLE IF EXISTS `orderaddress`;
CREATE TABLE IF NOT EXISTS `orderaddress` (
  `orderID` int(6) NOT NULL,
  `username` varchar(16) NOT NULL,
  `addressid` int(6) NOT NULL,
  PRIMARY KEY (`orderID`,`username`,`addressid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderaddress`
--

INSERT INTO `orderaddress` (`orderID`, `username`, `addressid`) VALUES
(1, 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

DROP TABLE IF EXISTS `orderitems`;
CREATE TABLE IF NOT EXISTS `orderitems` (
  `orderID` int(6) NOT NULL,
  `itemID` int(6) NOT NULL,
  `customname` varchar(20) NOT NULL,
  PRIMARY KEY (`orderID`,`itemID`,`customname`),
  KEY `itemID` (`itemID`,`customname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`orderID`, `itemID`, `customname`) VALUES
(1, 4, 'Combo'),
(1, 6, 'Combo');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `branchID` int(6) NOT NULL,
  `restaurantID` int(6) NOT NULL,
  `orderID` int(6) NOT NULL AUTO_INCREMENT,
  `discountID` int(6) DEFAULT NULL,
  `codeID` int(6) DEFAULT NULL,
  `orderstatus` varchar(10) NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`orderID`),
  KEY `branchID` (`branchID`,`restaurantID`),
  KEY `codeID` (`codeID`),
  KEY `discountID` (`discountID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`branchID`, `restaurantID`, `orderID`, `discountID`, `codeID`, `orderstatus`, `comments`) VALUES
(1, 1, 1, 2, NULL, 'Received', '');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

DROP TABLE IF EXISTS `restaurant`;
CREATE TABLE IF NOT EXISTS `restaurant` (
  `restaurantID` int(6) NOT NULL,
  `restaurantname` text NOT NULL,
  PRIMARY KEY (`restaurantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`restaurantID`, `restaurantname`) VALUES
(1, 'Kansas'),
(2, 'Primos');

-- --------------------------------------------------------

--
-- Table structure for table `restaurantcuisine`
--

DROP TABLE IF EXISTS `restaurantcuisine`;
CREATE TABLE IF NOT EXISTS `restaurantcuisine` (
  `restaurantID` int(6) NOT NULL,
  `cuisineType` varchar(15) NOT NULL,
  PRIMARY KEY (`restaurantID`,`cuisineType`),
  KEY `restaurantID` (`restaurantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurantcuisine`
--

INSERT INTO `restaurantcuisine` (`restaurantID`, `cuisineType`) VALUES
(1, 'Fried Chicken'),
(2, 'Pizza');

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

DROP TABLE IF EXISTS `shoppingcart`;
CREATE TABLE IF NOT EXISTS `shoppingcart` (
  `username` varchar(16) NOT NULL,
  `restaurantID` int(6) NOT NULL,
  `menuID` int(6) NOT NULL,
  `itemID` int(6) NOT NULL,
  `itemname` varchar(20) NOT NULL,
  `customname` varchar(20) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `timestamp` timestamp NOT NULL,
  PRIMARY KEY (`username`,`timestamp`),
  KEY `restaurantID` (`restaurantID`,`menuID`,`itemID`),
  KEY `itemID` (`itemID`,`customname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UUID` int(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `bdate` date NOT NULL,
  `gender` char(1) NOT NULL,
  `usertype` int(1) NOT NULL,
  `fname` varchar(16) NOT NULL,
  `lname` varchar(16) NOT NULL,
  `email` text NOT NULL,
  `isActive` int(1) NOT NULL,
  PRIMARY KEY (`UUID`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UUID`, `username`, `password`, `bdate`, `gender`, `usertype`, `fname`, `lname`, `email`, `isActive`) VALUES
(1, 'admin', 'admin', '1997-03-26', 'M', 0, 'Omar', 'ElSeadawy', 'omarelseadawy@aucegypt.edu', 1),
(16, 'Omar', 'afk4lifE', '1997-03-26', 'M', 2, 'Omar', 'Ashraf', 'omarelseadawy@outlook.com', 1),
(17, 'FarahChedid', '4321', '1997-04-27', 'F', 1, 'Farah', 'Chedid', 'farahchedid@aucegypt.edu', 1);

-- --------------------------------------------------------

--
-- Table structure for table `useraddress`
--

DROP TABLE IF EXISTS `useraddress`;
CREATE TABLE IF NOT EXISTS `useraddress` (
  `username` varchar(16) NOT NULL,
  `addressid` int(6) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`username`,`addressid`),
  KEY `uuid` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `useraddress`
--

INSERT INTO `useraddress` (`username`, `addressid`, `address`) VALUES
('admin', 1, 'Villa 58 Narges 4'),
('admin', 2, 'AUC Gate 4');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`restaurantID`) REFERENCES `restaurant` (`restaurantID`);

--
-- Constraints for table `branchdeliveryarea`
--
ALTER TABLE `branchdeliveryarea`
  ADD CONSTRAINT `branchdeliveryarea_ibfk_1` FOREIGN KEY (`restaurantID`,`branchID`) REFERENCES `branch` (`restaurantID`, `branchID`),
  ADD CONSTRAINT `branchdeliveryarea_ibfk_2` FOREIGN KEY (`areaID`) REFERENCES `area` (`areaID`);

--
-- Constraints for table `branchphoneno`
--
ALTER TABLE `branchphoneno`
  ADD CONSTRAINT `branchphoneno_ibfk_1` FOREIGN KEY (`branchID`,`restaurantID`) REFERENCES `branch` (`branchID`, `restaurantID`);

--
-- Constraints for table `changepassword`
--
ALTER TABLE `changepassword`
  ADD CONSTRAINT `changepassword_ibfk_1` FOREIGN KEY (`AdminUsername`) REFERENCES `user` (`username`);

--
-- Constraints for table `customitem`
--
ALTER TABLE `customitem`
  ADD CONSTRAINT `customitem_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemid`);

--
-- Constraints for table `dropaccount`
--
ALTER TABLE `dropaccount`
  ADD CONSTRAINT `dropaccount_ibfk_1` FOREIGN KEY (`AdminUsername`) REFERENCES `user` (`username`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`restaurantID`) REFERENCES `restaurant` (`restaurantID`);

--
-- Constraints for table `menuitems`
--
ALTER TABLE `menuitems`
  ADD CONSTRAINT `menuitems_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemid`),
  ADD CONSTRAINT `menuitems_ibfk_2` FOREIGN KEY (`restaurantID`,`menuID`) REFERENCES `menu` (`restaurantID`, `menuID`);

--
-- Constraints for table `modifyuser`
--
ALTER TABLE `modifyuser`
  ADD CONSTRAINT `modifyuser_ibfk_2` FOREIGN KEY (`modifieduuid`) REFERENCES `user` (`UUID`),
  ADD CONSTRAINT `modifyuser_ibfk_3` FOREIGN KEY (`uuid`) REFERENCES `user` (`UUID`);

--
-- Constraints for table `orderaddress`
--
ALTER TABLE `orderaddress`
  ADD CONSTRAINT `orderaddress_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`);

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`itemID`,`customname`) REFERENCES `customitem` (`itemID`, `customname`),
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`branchID`,`restaurantID`) REFERENCES `branch` (`branchID`, `restaurantID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`codeID`) REFERENCES `discountcode` (`codeID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`discountID`) REFERENCES `discount` (`discountID`);

--
-- Constraints for table `restaurantcuisine`
--
ALTER TABLE `restaurantcuisine`
  ADD CONSTRAINT `restaurantcuisine_ibfk_1` FOREIGN KEY (`restaurantID`) REFERENCES `restaurant` (`restaurantID`);

--
-- Constraints for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD CONSTRAINT `shoppingcart_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `shoppingcart_ibfk_2` FOREIGN KEY (`restaurantID`,`menuID`,`itemID`) REFERENCES `menuitems` (`restaurantID`, `menuID`, `itemID`),
  ADD CONSTRAINT `shoppingcart_ibfk_3` FOREIGN KEY (`itemID`,`customname`) REFERENCES `customitem` (`itemID`, `customname`);

--
-- Constraints for table `useraddress`
--
ALTER TABLE `useraddress`
  ADD CONSTRAINT `useraddress_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
