DROP TABLE IF EXISTS account;
DROP TABLE IF EXISTS filamentType;
DROP TABLE IF EXISTS filamentSize;
DROP TABLE IF EXISTS printer;
DROP TABLE IF EXISTS printerFilamentType;
DROP TABLE IF EXISTS printerFilamentSize;
DROP TABLE IF EXISTS student;
DROP TABLE IF EXISTS printObject;
DROP TABLE IF EXISTS appointment;

CREATE TABLE account (
  accountId INT(25) NOT NULL AUTO_INCREMENT,
  adminName VARCHAR(255) NOT NULL,
  adminEmail VARCHAR(255) NOT NULL,
  password VARBINARY(255) NOT NULL,
  CONSTRAINT account_PK PRIMARY KEY (accountId)
);

CREATE TABLE filamentType (
  materialId INT(5) NOT NULL AUTO_INCREMENT,
  material  VARCHAR(255) NOT NULL,
  CONSTRAINT filamentType_PK PRIMARY KEY (materialId)
);

CREATE TABLE filamentSize (
  sizeId INT(5) NOT NULL AUTO_INCREMENT,
  size VARCHAR(255) NOT NULL,
  CONSTRAINT filamentSize_PK PRIMARY KEY (sizeId)
);

CREATE TABLE printer(
  printerId INT(5) NOT NULL AUTO_INCREMENT,
  printerName VARCHAR(25) NOT NULL,
  buildVolume VARCHAR(25) NOT NULL,
  printSurface VARCHAR(25) NOT NULL,
  extruder VARCHAR(25) NOT NULL,
  printerStatus VARCHAR(25) NOT NULL,
  publicNote TEXT,
  adminNote TEXT,
  filamentType VARCHAR(255) NOT NULL,
  filamentSize VARCHAR(255) NOT NULL,
  dateAdded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  dateUpdated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  eventColor VARCHAR(25) NOT NULL,
  isDeleted tinyint(4) NOT NULL,
  CONSTRAINT printer_PK PRIMARY KEY (printerId)
);

CREATE TABLE printerFilamentType(
  printerId INT(5) NOT NULL,
  materialId INT(5) NOT NULL,
  CONSTRAINT printerFilamentType_FK1 FOREIGN KEY (printerId) REFERENCES printer(printerId),
  CONSTRAINT printerFilamentType_FK2 FOREIGN KEY (materialId) REFERENCES filamentType(materialId) 
);

CREATE TABLE printerFilamentSize(
  printerId INT(5) NOT NULL,
  sizeId INT(5) NOT NULL,
  CONSTRAINT printerFilamentSize_FK1 FOREIGN KEY (printerId) REFERENCES printer(printerId),
  CONSTRAINT printerFilamentSize_FK2 FOREIGN KEY (sizeId) REFERENCES filamentSize(sizeId) 
);

CREATE TABLE student (
  studentEmail VARCHAR(25) NOT NULL,
  studentFirstName VARCHAR(25) NOT NULL,
  studentLastName VARCHAR(25) NOT NULL,
  CONSTRAINT student_PK PRIMARY KEY (studentEmail)
);

CREATE TABLE printObject(
  objectId INT(5) NOT NULL AUTO_INCREMENT,
  objectName VARCHAR(255) NOT NULL,
  studentEmail VARCHAR(255) NOT NULL,
  printDuration VARCHAR(25) NOT NULL,
  filamentConsumed VARCHAR(25) NOT NULL,
  printReason VARCHAR(25) NOT NULL,
  comment text,
  CONSTRAINT object_PK PRIMARY KEY (objectId),
  CONSTRAINT object_FK1 FOREIGN KEY (studentEmail) REFERENCES student(studentEmail)
  );

CREATE TABLE appointment (
  appointmentId INT(25) NOT NULL AUTO_INCREMENT,
  printerId INT(5) NOT NULL,
  objectId INT(5) NOT NULL,
  jobStatus VARCHAR(25) NOT NULL,
  statusNote text, 
  startTime VARCHAR(25) NOT NULL,
  endTime VARCHAR(25) NOT NULL,
  title VARCHAR(255) NOT NULL,
  CONSTRAINT appointment_PK PRIMARY KEY (appointmentId), 
  CONSTRAINT appointment_FK1 FOREIGN KEY (printerId) REFERENCES printer(printerId),
  CONSTRAINT appointment_FK2 FOREIGN KEY (objectId) REFERENCES printObject(objectId)
);

INSERT INTO `account` (`accountId`, `adminName`, `adminEmail`, `password`) VALUES
(1, 'test', 'test@wit.edu', '0x22ff056643ef08b325fdc982fadb6617');

INSERT INTO `printer` (`printerId`, `printerName`, `buildVolume`, `printSurface`, `extruder`, `printerStatus`, `publicNote`, `adminNote`, `filamentType`, `filamentSize`, `dateAdded`, `dateUpdated`, `eventColor`, `isDeleted`) VALUES
(1, 'MakerBot 1', '305 x 305 x 605', 'Heated', 'Single', 'Unavailable', 'N/A', 'N/A', 'ABS, PLA, HIPS, PVA, Wood Filled, Polyester (Tritan), PETT, Polycarbonate, Bronze/Copper Filled, Nylon, PETG, Other', '1.75, 2.85, 3.00, Other', '2020-06-13 09:04:10', '2020-07-26 22:24:47', '#FFC0CB', 0),
(2, 'MakerBot 2', '305 x 305 x 605', 'Heated', 'Triple', 'Available', '', '', 'PLA, HIPS, Wood Filled, Other', '1.75, 2.85', '2020-06-13 09:04:10', '2020-07-26 22:24:56', '#FFD699', 0),
(3, 'MakerBot 3', '305 x 305 x 605', 'Unheated', 'Single', 'Available', '', '', 'ABS, Polyester (Tritan), ', '3.00', '2020-06-13 09:04:10', '2020-06-17 02:39:52', '#FFF2CC', 0),
(4, 'MakerBot Z18', '305 x 305 x 605', 'Heated', 'Double', 'Available', '111', '111', 'PVA', '3.00', '2020-06-13 09:04:10', '2020-06-26 05:15:45', '#C2F0C2', 0),
(5, 'Prusa 1', '305 x 305 x 605', 'Heated', 'Double', 'Unavailable', 'Working', 'Working', 'ABS, PVA, PETT', '3.00', '2020-06-13 09:04:10', '2020-06-17 21:47:38', '#CCE6FF', 0),
(6, 'Prusa 2', '305 x 305 x 605', 'Heated', 'Double', 'Available', '', '', 'HIPS', '1.75, 2.85, Other', '2020-06-13 09:04:10', '2020-06-19 04:15:09', '#CCCCFF', 0),
(7, 'Prusa 3', '305 x 305 x 605', 'Unheated', 'Single', 'Available', '', '', 'PLA, PETT, Nylon', 'Other', '2020-06-13 09:04:10', '2020-06-17 02:40:42', '#FFC0CB', 0),
(8, 'Prusa M1', '305 x 305 x 605', 'Heated', 'Double', 'Available', '', '', 'ABS', '2.85', '2020-06-13 09:04:10', '2020-06-24 00:41:36', '#FFD699', 0),
(9, 'Prusa M2', '305 x 305 x 605', 'Unheated', 'Quad', 'Available', 'Test', 'test', 'HIPS, PETT, Nylon', '3.00', '2020-06-13 09:04:10', '2020-06-17 02:41:17', '#FFF2CC', 0),
(10, 'Prusa M3', '305 x 305 x 605', 'Unheated', 'Triple', 'Available', '', '', 'PLA', '2.85', '2020-06-13 09:04:10', '2020-06-17 02:41:29', '#C2F0C2', 0),
(11, 'Ender', '305 x 305 x 605', 'Heated', 'Double', 'Available', 'Test', 'test', 'Wood Filled, PETT', '2.85', '2020-06-13 09:04:10', '2020-06-17 02:41:41', '#CCE6FF', 0),
(12, 'Taz Pro', '305 x 305 x 605', 'Unheated', 'Triple', 'Available', '', '', 'PETT', '2.85', '2020-06-13 09:04:10', '2020-06-17 02:43:50', '#CCCCFF', 0);

INSERT INTO `filamentSize` (`sizeId`, `size`) VALUES
(1, '1.75'),
(2, '2.85'),
(3, '3.00'),
(4, 'Other');

INSERT INTO `filamentType` (`materialId`, `material`) VALUES
(1, 'ABS'),
(2, 'PLA'),
(3, 'HIPS'),
(4, 'PVA'),
(5, 'Wood Filled'),
(6, 'Polyester (Tritan)'),
(7, 'PETT'),
(8, 'Bronze/Copper Filled'),
(9, 'Polycarbonate'),
(10, 'Nylon'),
(11, 'PETG'),
(12, 'Other');

INSERT INTO `printerFilamentSize` (`printerId`, `sizeId`) VALUES
(3, 3),
(7, 4),
(9, 3),
(10, 2),
(11, 2),
(12, 2),
(5, 3),
(6, 1),
(6, 2),
(6, 4),
(8, 2),
(4, 3),
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 2);

INSERT INTO `printerFilamentType` (`printerId`, `materialId`) VALUES
(3, 1),
(3, 6),
(3, 9),
(3, 10),
(7, 2),
(7, 7),
(7, 10),
(9, 3),
(9, 7),
(9, 10),
(10, 2),
(11, 5),
(11, 7),
(12, 7),
(5, 1),
(5, 4),
(5, 7),
(6, 3),
(8, 1),
(4, 4),
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 9),
(1, 8),
(1, 10),
(1, 11),
(1, 12),
(2, 2),
(2, 3),
(2, 5),
(2, 12);

INSERT INTO `student` (`studentEmail`, `studentFirstName`, `studentLastName`) VALUES
('bmacgauhy1@wit.edu', 'Bernelle', 'MacGauhy'),
('dlilie3@wit.edu', 'Dianemarie', 'Lilie'),
('emendel7@wit.edu', 'Elroy', 'Mendel'),
('fsnaddin5@wit.edu', 'Forester', 'Snaddin'),
('hneesam0@wit.edu', 'Hillary', 'Neesam'),
('jinn@wit.edu', 'Nick', 'Jin'),
('jloadman8@wit.edu', 'Jennica', 'Loadman'),
('lmcdonnell6@wit.edu', 'Leola', 'McDonnell'),
('mkennedy4@wit.edu', 'Maritsa', 'Kennedy'),
('msavory2@wit.edu', 'Matthiew', 'Savory'),
('tmorkham9@wit.edu', 'Tandie', 'Morkham'),
('wangm1@wit.edu', 'Mengting', 'Wang'),
('xud@wit.edu', 'Duoduo', 'Xu');

INSERT INTO `printObject` (`objectId`, `objectName`, `studentEmail`, `printDuration`, `filamentConsumed`, `printReason`, `comment`) VALUES
(1, 'test 1', 'wangm1@wit.edu', '04:00', '1.2', 'School Project', NULL),
(2, 'car', 'jinn@wit.edu', '06:15', '2.2', 'Personal', NULL),
(3, 'test 2', 'wangm1@wit.edu', '07:00', '2.0', 'School Project', NULL),
(4, 'test 3', 'wangm1@wit.edu', '04:00', '2.1', 'School Project', NULL),
(5, 'Shoes', 'xud@wit.edu', '09:00', '2.99', 'Personal', NULL),
(6, 'Table', 'hneesam0@wit.edu', '08:30', '11.2', 'School Project', NULL),
(7, 'Lamp', 'msavory2@wit.edu', '06:15', '8.2', 'Personal', NULL),
(8, 'Chair', 'fsnaddin5@wit.edu', '04:15', '6.0', 'School Project', NULL),
(9, 'Helmet', 'emendel7@wit.edu', '04:00', '2.1', 'School Project', NULL),
(10, 'Bottle', 'tmorkham9@wit.edu', '09:00', '3.4', 'Personal', NULL),
(11, 'Keyboard', 'hneesam0@wit.edu', '13:15', '5.5', 'Personal', NULL),
(12, 'test 1', 'jloadman8@wit.edu', '12:00', '6.8', 'School Project', NULL),
(13, 'test 2', 'lmcdonnell6@wit.edu', '14:30', '13.4', 'School Project',NULL),
(14, 'test 1', 'mkennedy4@wit.edu', '06:00', '4.9', 'Personal', NULL),
(15, 'Cat', 'xud@wit.edu', '05:15', '5.5', 'School Project', NULL),
(16, 'test 1', 'bmacgauhy1@wit.edu', '02:15', '7.9', 'Personal', NULL),
(17, 'test 2', 'dlilie3@wit.edu', '03:30', '6.7', 'School Project', NULL),
(18, 'test 2', 'fsnaddin5@wit.edu', '11:30', '5.5', 'School Project', NULL),
(19, 'test 2', 'jloadman8@wit.edu', '03:15', '6.6', 'School Project', NULL),
(20, 'test last year', 'wangm1@wit.edu', '05:45', '3.3', 'School Project', NULL),
(21, 'sq', 'hneesam0@wit.edu', '02:00', '6.7', 'School Project', NULL),
(22, 'wsd', 'dlilie3@wit.edu', '02:00', 'qwd', 'Personal', NULL);

INSERT INTO `appointment` (`appointmentId`, `printerId`, `objectId`, `jobStatus`, `statusNote`, `startTime`, `endTime`, `title`) VALUES
(1, 4, 1, 'Pending', NULL, '2020-07-26 02:45', '2020-07-26 06:45', 'test repeat event'),
(2, 8, 2, 'In Progress', NULL, '2020-07-01 02:19', '2020-07-01 10:19:00', 'test 6/20'),
(3, 5, 3, 'Pending', NULL, '2020-07-01 02:45', '2020-07-01 07:00:00', 'test autofill'),
(4, 3, 4, 'Failed', NULL, '2020-07-01 03:00', '2020-07-01 13:30:00', 'sherwin@wit.edu'),
(5, 11, 5, 'Success', NULL, '2020-07-01 03:45', '2020-07-01 06:00:00', 'test autofill 2'),
(6, 4, 6, 'Success', NULL, '2020-06-17 01:15', '2020-06-17 09:45:00', 'hneesam0@wit.edu Table'),
(7, 1, 8, 'Failed', NULL, '2019-09-22 02:15', '2019-09-22 12:30', 'chair'),
(8, 3, 11, 'Success', NULL, '2019-09-11 02:00', '2019-09-11 06:45:00', 'fsnaddin5@wit.edu test1'),
(9, 8, 11, 'Success', NULL, '2019-10-10 01:30', '2019-10-10 14:45:00', 'hneesam0@wit.edu'),
(10, 11, 12, 'Success', NULL, '2019-11-21 02:00', '2019-11-21 14:00:00', 'jloadman8@wit.edu test 1'),
(11, 12, 13, 'Success', NULL, '2019-11-05 00:45', '2019-11-05 15:15:00', 'lmcdonnell6@wit.edu test 2'),
(12, 4, 14, 'Failed', NULL, '2019-12-04 01:30', '2019-12-04 07:30:00', 'mkennedy4@wit.edu test 1'),
(13, 1, 7, 'Success', NULL, '2020-01-22 01:00', '2020-01-22 07:15:00', 'msavory2@wit.edu '),
(14, 4, 15, 'Success', NULL, '2020-01-05 01:00', '2020-01-05 08:45:00', 'tmorkham9@wit.edu test 1'),
(15, 5, 15, 'Success', NULL, '2020-03-10 09:15', '2020-03-10 14:30:00', 'xud@wit.edu Cat'),
(16, 8, 16, 'Failed', NULL, '2020-02-14 09:45', '2020-02-14 16:45:00', 'bmacgauhy1@wit.edu test 1'),
(17, 9, 17, 'Success', NULL, '2020-04-03 01:45', '2020-04-03 08:30:00', 'dlilie3@wit.edu test 2'),
(18, 12, 18, 'Pending', NULL, '2020-05-04 01:00', '2020-05-04 12:30:00', 'fsnaddin5@wit.edu test 2'),
(19, 2, 19, 'Success', NULL, '2019-12-25 01:45', '2019-12-25 05:00:00', 'jloadman8@wit.edu test 2'),
(20, 3, 20, 'Success', NULL, '2019-07-22 02:00', '2019-07-22 07:45:00', 'wangm1@wit.edu test last year'),
(22, 6, 17, 'Pending', NULL, '2020-07-26 02:15', '2020-07-26 08:00', 'dlilie3@wit.edu test 2'),
(24, 3, 8, 'Pending', NULL, '2020-07-26 02:15', '2020-07-26 09:30', 'wangm1@wit.edu demo'),
(25, 2, 16, 'Pending', NULL, '2020-07-26 03:00', '2020-07-26 05:15', 'bmacgauhy1@wit.edu - test 1'),
(28, 3, 9, 'Pending', NULL, '2020-08-03 02:15', '2020-08-03 06:15', 'emendel7@wit.edu Helmet');