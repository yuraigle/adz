SET NAMES 'utf8';
SET SESSION foreign_key_checks=OFF;

DELETE FROM `adz_category`;

INSERT INTO `adz_category` (`id`, `name`, `slug`, `description`, `keywords`, `parent_id`) VALUES
(1001, 'Cars & Vehicles', 'cars', NULL, NULL, NULL),
(1002, 'For Sale', 'for-sale', NULL, NULL, NULL),
(1003, 'Property', 'flats-houses', NULL, NULL, NULL),
(1004, 'Jobs', 'jobs', NULL, NULL, NULL),
(1005, 'Services', 'business-services', NULL, NULL, NULL),
(1006, 'Community', 'community', NULL, NULL, NULL),
(1007, 'Pets', 'pets', NULL, NULL, NULL),
(2485, 'Appliances', 'kitchen-appliances', NULL, NULL, 1002),
(2488, 'Video Games & Consoles', 'video-games-consoles', NULL, NULL, 1002),
(2495, 'Musical Instruments & DJ Equipment', 'music-instruments', NULL, NULL, 1002),
(2496, 'Clothes, Footwear & Accessories', 'clothing', NULL, NULL, 1002),
(2497, 'Baby & Kids Stuff', 'baby-kids-stuff', NULL, NULL, 1002);

SET SESSION foreign_key_checks=ON;
