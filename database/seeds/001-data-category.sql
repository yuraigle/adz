SET FOREIGN_KEY_CHECKS=0;
DELETE FROM `adz_category`;

/*!40101 SET NAMES utf8 */;
/*!40000 ALTER TABLE `adz_category` DISABLE KEYS */;

INSERT INTO `adz_category` (`id`, `name`, `slug`, `description`, `keywords`, `parent_id`) VALUES
(1001, 'Cars & Vehicles', 'cars', NULL, NULL, NULL),
(1002, 'For Sale', 'for-sale', NULL, NULL, NULL),
(1003, 'Property', 'flats-houses', NULL, NULL, NULL),
(1004, 'Jobs', 'jobs', NULL, NULL, NULL),
(1005, 'Services', 'business-services', NULL, NULL, NULL),
(1006, 'Community', 'community', NULL, NULL, NULL),
(1007, 'Pets', 'pets', NULL, NULL, NULL);

/*!40000 ALTER TABLE `adz_category` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS=1;
