-- --------------------------------------------------------
-- Host:                         localhost
-- Server-Version:               8.0.32-0ubuntu0.22.04.2 - (Ubuntu)
-- Server-Betriebssystem:        Linux
-- HeidiSQL Version:             12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Exportiere Daten aus Tabelle app.ticket: ~0 rows (ungefähr)
REPLACE INTO `ticket` (`id`, `ticket_id`, `ticket_code`, `scan_timestamp`, `device`) VALUES
	(1, 98474774, 'LC112312', NULL, NULL),
	(2, 876577664, 'LC288839', 1682291428, 'Entrance EAST'),
	(3, 323413334, 'LC887888', 1682294566, 'Entrance EAST'),
	(4, 1231, 'LC193893', 1682291624, 'Entrance EAST');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
