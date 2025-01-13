-- --------------------------------------------------------
-- Host:                         cika-da.ru
-- Server version:               5.7.27-30 - Percona Server (GPL), Release 30, Revision 8916819
-- Server OS:                    Linux
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for u0753756_nkz_db
CREATE DATABASE IF NOT EXISTS `u0753756_nkz_db` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `u0753756_nkz_db`;

-- Dumping structure for table u0753756_nkz_db.AllowCheck
CREATE TABLE IF NOT EXISTS `AllowCheck` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `teacher_id` int(10) unsigned NOT NULL,
  `task_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `task_id` (`task_id`),
  CONSTRAINT `AllowCheck_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `User` (`id`),
  CONSTRAINT `AllowCheck_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `Task` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table u0753756_nkz_db.Journal
CREATE TABLE IF NOT EXISTS `Journal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prt_id` int(10) unsigned NOT NULL,
  `mgr_id` int(10) unsigned NOT NULL,
  `tsk_id` int(10) unsigned NOT NULL,
  `score` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prt_id` (`prt_id`),
  KEY `mgr_id` (`mgr_id`),
  KEY `tsk_id` (`tsk_id`),
  CONSTRAINT `Journal_ibfk_1` FOREIGN KEY (`prt_id`) REFERENCES `User` (`id`),
  CONSTRAINT `Journal_ibfk_2` FOREIGN KEY (`mgr_id`) REFERENCES `User` (`id`),
  CONSTRAINT `Journal_ibfk_3` FOREIGN KEY (`tsk_id`) REFERENCES `Task` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table u0753756_nkz_db.OnSite
CREATE TABLE IF NOT EXISTS `OnSite` (
  `u_id` int(10) unsigned NOT NULL,
  `token` int(10) unsigned NOT NULL,
  PRIMARY KEY (`u_id`),
  KEY `u_id` (`u_id`),
  CONSTRAINT `OnSite_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table u0753756_nkz_db.PersonalData
CREATE TABLE IF NOT EXISTS `PersonalData` (
  `u_id` int(10) unsigned NOT NULL,
  `bday` date DEFAULT NULL,
  `school_id` int(10) unsigned DEFAULT NULL,
  `grade` varchar(20) DEFAULT NULL,
  `oblast` varchar(50) DEFAULT NULL,
  `locality` varchar(50) DEFAULT NULL,
  `street` varchar(50) DEFAULT NULL,
  `home` varchar(20) DEFAULT NULL,
  `apartment` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `phoneParent` varchar(20) DEFAULT NULL,
  `nameParent` varchar(100) DEFAULT NULL,
  `teacherIKT` varchar(100) DEFAULT NULL,
  `classTeacher` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`u_id`),
  KEY `school_id` (`school_id`),
  CONSTRAINT `PersonalData_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `PersonalData_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `School` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table u0753756_nkz_db.Result
CREATE TABLE IF NOT EXISTS `Result` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `u_id` int(10) unsigned NOT NULL,
  `teacher_id` int(10) unsigned NOT NULL,
  `task_id` int(10) unsigned NOT NULL,
  `check_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `score` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `u_id` (`u_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `task_id` (`task_id`),
  CONSTRAINT `Result_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `User` (`id`),
  CONSTRAINT `Result_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `User` (`id`),
  CONSTRAINT `Result_ibfk_3` FOREIGN KEY (`task_id`) REFERENCES `Task` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table u0753756_nkz_db.Scan
CREATE TABLE IF NOT EXISTS `Scan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `u_id` int(10) unsigned NOT NULL,
  `application` varchar(100) DEFAULT NULL,
  `agreement` varchar(100) DEFAULT NULL,
  `send_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(10) unsigned DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `u_id` (`u_id`),
  CONSTRAINT `Scan_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table u0753756_nkz_db.School
CREATE TABLE IF NOT EXISTS `School` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `town` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table u0753756_nkz_db.Task
CREATE TABLE IF NOT EXISTS `Task` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.
-- Dumping structure for table u0753756_nkz_db.Team
CREATE TABLE IF NOT EXISTS `Team` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` enum('не выбрано','1 место','2 место','3 место') NOT NULL DEFAULT 'не выбрано',
  `score` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table u0753756_nkz_db.User
CREATE TABLE IF NOT EXISTS `User` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `patronym` varchar(50) NOT NULL,
  `sex` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `psw_hash` binary(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cert_saved_at` timestamp NULL DEFAULT NULL,
  `team` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_User_Team` (`team`),
  CONSTRAINT `FK_User_Team` FOREIGN KEY (`team`) REFERENCES `Team` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
