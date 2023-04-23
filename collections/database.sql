CREATE DATABASE `tickets`;
USE `tickets`;

CREATE TABLE `ticket` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ticketId` int DEFAULT NULL,
  `ticketCode` varchar(200) DEFAULT NULL,
  `scanTimestamp` int DEFAULT NULL,
  `device` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

