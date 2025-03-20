-- Create database if not exists
CREATE DATABASE IF NOT EXISTS royalevent;

-- Use the database
USE royalevent;


-- --------------------------------------------------------
-- Table structure for users table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `user_type` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for admins table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','super_admin') NOT NULL DEFAULT 'admin',
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for pricing table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `pricing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_type` varchar(50) NOT NULL,
  `plan` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `features` text NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for bookings table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_type` enum('Wedding','Birthday','Anniversary','Corporate Event') NOT NULL,
  `plan` enum('Basic','Premium','Luxury') NOT NULL,
  `event_date` date NOT NULL,
  `guest_count` int(11) NOT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `message` text,
  `total_amount` decimal(10,2) NOT NULL,
  `reference_number` varchar(50) NOT NULL,
  `status` enum('Pending','Confirmed','Completed','Canceled') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bookings_user_id_foreign` (`user_id`),
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for feedback table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `feedback_text` text NOT NULL,
  `rating` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `booking_id` (`booking_id`),
  CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- --------------------------------------------------------
-- Insert sample contact data
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('Unread', 'Read', 'Responded') DEFAULT 'Unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- --------------------------------------------------------
-- Insert sample pricing data
-- --------------------------------------------------------
INSERT INTO `pricing` (`event_type`, `plan`, `price`, `description`, `features`, `duration`) VALUES
('Wedding', 'Basic', 49999.00, 'Essential wedding planning and coordination services for couples with a limited budget.', 'Venue selection assistance, Basic decoration, Photography for 4 hours, Sound system, Coordination on wedding day', '1 day'),
('Wedding', 'Premium', 99999.00, 'Comprehensive wedding planning with enhanced decoration and services for a memorable celebration.', 'Full venue decoration, Photography & Videography, Catering for 100 guests, DJ services, Wedding cake, Transportation, Full-day coordination', '1 day'),
('Wedding', 'Luxury', 199999.00, 'The ultimate wedding experience with premium services and exclusive touches for a perfect day.', 'Premium venue with exclusive access, Luxury decoration with fresh flowers, Professional photography & videography (drone included), Gourmet catering for 200 guests, Live band, Multi-tier custom cake, Limousine service, Full weekend coordination', '2 days'),

('Birthday', 'Basic', 14999.00, 'Simple birthday celebration package ideal for intimate gatherings.', 'Venue setup, Basic decorations, Sound system, Photography for 2 hours, Cake arrangement', '4 hours'),
('Birthday', 'Premium', 29999.00, 'Enhanced birthday experience with additional entertainment and food options.', 'Themed decorations, Photography & Videography, Catering for 50 guests, DJ services, Custom cake, Party favors', '6 hours'),
('Birthday', 'Luxury', 59999.00, 'Extravagant birthday celebration with premium services and exclusive entertainment.', 'Premium venue, Luxury themed decorations, Professional photography & videography, Gourmet catering for 100 guests, Live entertainment, Custom multi-tier cake, VIP services', '8 hours'),

('Anniversary', 'Basic', 19999.00, 'Classic anniversary celebration package for couples.', 'Romantic venue setup, Basic decorations, Dinner for 2, Photography for 2 hours, Anniversary cake', '4 hours'),
('Anniversary', 'Premium', 39999.00, 'Special anniversary package with enhanced romantic elements and dining.', 'Elegant decorations with flowers, Photography & Videography, Gourmet dinner for 20 guests, Live music, Custom cake, Champagne toast', '6 hours'),
('Anniversary', 'Luxury', 79999.00, 'Unforgettable anniversary experience with luxury services and exclusive touches.', 'Premium venue with private access, Luxury decorations with fresh flowers, Professional photography & videography, Gourmet catering for 50 guests, Live band, Multi-course dinner with wine pairing, Overnight luxury accommodation', '24 hours'),

('Corporate Event', 'Basic', 34999.00, 'Professional corporate event package for small business meetings and presentations.', 'Conference room setup, Basic AV equipment, Coffee and refreshments, Basic stationery, Coordination assistance', '4 hours'),
('Corporate Event', 'Premium', 74999.00, 'Comprehensive corporate event solution for product launches, conferences, and team building.', 'Full venue setup, Professional AV equipment, Catering for 50 attendees, Branded materials, Event photography, Full coordination', '8 hours'),
('Corporate Event', 'Luxury', 149999.00, 'Executive-level corporate event experience with premium services and exclusive touches.', 'Premium venue with multiple spaces, State-of-the-art AV technology, Gourmet catering for 100 attendees, Professional photography & videography, Custom branded materials, Live entertainment options, VIP services, Full event management', '12 hours'); 


-- Insert admin user with hashed password
-- Note: This password 'admin123' is hashed using PHP's password_hash function
-- You should change this to a more secure password in a production environment
INSERT INTO `admins` (`name`, `email`, `password`, `role`) 
VALUES ('Admin User', 'admin@royalevent.com', '$2y$10$v5.irvAT.yS19v./vIJUkOdCj.qo9e.lJH27h7PQBrr0YS6ZSjg7K', 'super_admin');

