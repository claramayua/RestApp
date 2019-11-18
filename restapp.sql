-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 16. Nopember 2019 jam 08:50
-- Versi Server: 5.5.16
-- Versi PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `restapp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `residence`
--

CREATE TABLE IF NOT EXISTS `residence` (
  `residenceID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL,
  `area` int(11) NOT NULL,
  `numUnits` int(11) NOT NULL,
  `sizePerUnit` bigint(20) NOT NULL,
  `monthlyRental` bigint(20) NOT NULL,
  `picture` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`residenceID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data untuk tabel `residence`
--

INSERT INTO `residence` (`residenceID`, `name`, `address`, `area`, `numUnits`, `sizePerUnit`, `monthlyRental`, `picture`) VALUES
(9, '10 SEMANTAN', '10, Jalan Semantan, Bukit Damansara, 50490 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur', 2, 9, 1023, 2100, 'pictures/10semantan.jpg'),
(10, 'TWINS', '2, Jalan Damanlela, Pusat Bandar Damansara, 50490 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur', 2, 6, 1203, 3000, 'pictures/twins.jpg'),
(11, 'DC RESIDENCY', 'DC Residensi, Jalan Damanlela, Pusat Bandar Damansara, 50490 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur', 2, 12, 1194, 5100, 'pictures/dcresidency.jpg'),
(12, 'CLEARWATER', 'Changkat Semantan, Bukit Damansara, 50490 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur', 2, 6, 1200, 3600, 'pictures/clearwater.jpg'),
(13, 'GLOMAC', '699, Jalan Damansara, Taman Tun Dr Ismail, 60000 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur', 2, 15, 1313, 3900, 'pictures/glomac.jpg'),
(14, 'DESA KIARA', 'Desa Kiara, Jalan Damansara, Bukit Kiara, 60000 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur', 2, 18, 1326, 2100, 'pictures/desakiara.jpg'),
(15, 'HELP Residence', 'Semantan', 2, 2, 1000, 300, 'pictures/helpresidence.jpg'),
(16, 'Frangipani', 'Jalan Tukad Badung', 2, 10, 40, 425, 'pictures/frangipani.jpg'),
(17, 'Renon House', 'Renon', 2, 20, 80, 1000, 'pictures/renonhouse.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roomname`
--

CREATE TABLE IF NOT EXISTS `roomname` (
  `roomNameID` int(11) NOT NULL AUTO_INCREMENT,
  `residenceID` int(11) NOT NULL,
  `roomName` varchar(40) NOT NULL,
  `status` int(1) NOT NULL,
  `endDate` date DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  PRIMARY KEY (`roomNameID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data untuk tabel `roomname`
--

INSERT INTO `roomname` (`roomNameID`, `residenceID`, `roomName`, `status`, `endDate`, `userID`) VALUES
(2, 15, '01', 2, '2019-12-16', 2),
(3, 15, '02', 1, NULL, NULL),
(4, 10, 'A', 1, NULL, NULL),
(5, 10, 'B', 1, NULL, NULL),
(6, 10, 'C', 1, NULL, NULL),
(7, 10, 'D', 1, NULL, NULL),
(8, 10, 'E', 1, NULL, NULL),
(9, 10, 'F', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `submitapp`
--

CREATE TABLE IF NOT EXISTS `submitapp` (
  `submitappID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `residenceID` int(11) NOT NULL,
  `requiredDate` date NOT NULL,
  `endDate` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `roomID` int(11) DEFAULT NULL,
  `rejectionNote` varchar(100) DEFAULT NULL,
  `appealNote` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`submitappID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data untuk tabel `submitapp`
--

INSERT INTO `submitapp` (`submitappID`, `userID`, `residenceID`, `requiredDate`, `endDate`, `status`, `roomID`, `rejectionNote`, `appealNote`) VALUES
(8, 2, 11, '2019-11-16', '2019-12-16', 'APPEAL', NULL, 'Reason', 'Please'),
(9, 2, 9, '2019-11-22', '2020-11-21', 'NEW', NULL, NULL, NULL),
(10, 2, 15, '2019-11-17', '2019-12-16', 'APPROVED', 2, NULL, NULL),
(11, 2, 10, '1970-01-01', '2020-03-16', 'REJECTED', NULL, 'Because of you', NULL),
(12, 2, 15, '1970-01-01', '2020-09-16', 'NEW', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `monthlyIncome` bigint(20) NOT NULL,
  `staffID` varchar(10) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `fullname`, `email`, `monthlyIncome`, `staffID`) VALUES
(1, 'officer', 'officer', 'Housing Officer', '', 0, '10001'),
(2, 'applicant', 'applicant', 'Applicant', 'applicant@gmail.com', 5000, ''),
(3, 'DW', 'asd', 'dw', 'dw@gmail.com', 3000, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
