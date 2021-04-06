CREATE DATABASE  IF NOT EXISTS `todo`;
USE `todo`;

SET NAMES utf8 ;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;

SET character_set_client = utf8mb4 ;
CREATE TABLE `user` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `roles` json NOT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;

SET character_set_client = utf8mb4 ;
CREATE TABLE `task` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `user_id` int(11) DEFAULT NULL,
                        `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `status` tinyint(1) NOT NULL,
                        PRIMARY KEY (`id`),
                        KEY `IDX_527EDB25A76ED395` (`user_id`),
                        CONSTRAINT `FK_527EDB25A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

