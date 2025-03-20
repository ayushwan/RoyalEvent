-- Use the database
USE royalevent;

-- --------------------------------------------------------
-- Sample Data for users table
-- --------------------------------------------------------
INSERT INTO `users` (`name`, `email`, `password`, `profile_image`, `phone`, `user_type`, `created_at`) VALUES
-- Password for all test users is "password123"
('Rahul Sharma', 'rahul@example.com', '$2y$10$gF5G4vN/oA97FhbxeUFMYOocJwLqCZlcXWNR0vYH7F6sYbDkjxKoy', NULL, '9876543210', 'user', '2023-01-15 10:30:00'),
('Priya Patel', 'priya@example.com', '$2y$10$gF5G4vN/oA97FhbxeUFMYOocJwLqCZlcXWNR0vYH7F6sYbDkjxKoy', NULL, '8765432109', 'user', '2023-01-20 11:45:00'),
('Amit Singh', 'amit@example.com', '$2y$10$gF5G4vN/oA97FhbxeUFMYOocJwLqCZlcXWNR0vYH7F6sYbDkjxKoy', NULL, '7654321098', 'user', '2023-02-05 09:15:00'),
('Neha Gupta', 'neha@example.com', '$2y$10$gF5G4vN/oA97FhbxeUFMYOocJwLqCZlcXWNR0vYH7F6sYbDkjxKoy', NULL, '6543210987', 'user', '2023-02-10 14:20:00'),
('Vikram Malhotra', 'vikram@example.com', '$2y$10$gF5G4vN/oA97FhbxeUFMYOocJwLqCZlcXWNR0vYH7F6sYbDkjxKoy', NULL, '5432109876', 'user', '2023-03-01 16:30:00'),
('Anjali Desai', 'anjali@example.com', '$2y$10$gF5G4vN/oA97FhbxeUFMYOocJwLqCZlcXWNR0vYH7F6sYbDkjxKoy', NULL, '4321098765', 'user', '2023-03-15 12:10:00'),
('Sameer Joshi', 'sameer@example.com', '$2y$10$gF5G4vN/oA97FhbxeUFMYOocJwLqCZlcXWNR0vYH7F6sYbDkjxKoy', NULL, '3210987654', 'user', '2023-04-05 10:45:00'),
('Pooja Verma', 'pooja@example.com', '$2y$10$gF5G4vN/oA97FhbxeUFMYOocJwLqCZlcXWNR0vYH7F6sYbDkjxKoy', NULL, '2109876543', 'user', '2023-04-20 13:25:00'),
('Sanjay Kumar', 'sanjay@example.com', '$2y$10$gF5G4vN/oA97FhbxeUFMYOocJwLqCZlcXWNR0vYH7F6sYbDkjxKoy', NULL, '1098765432', 'user', '2023-05-10 15:50:00'),
('Meera Shah', 'meera@example.com', '$2y$10$gF5G4vN/oA97FhbxeUFMYOocJwLqCZlcXWNR0vYH7F6sYbDkjxKoy', NULL, '0987654321', 'user', '2023-05-25 11:05:00'),
('Deepak Chopra', 'deepak@example.com', '$2y$10$gF5G4vN/oA97FhbxeUFMYOocJwLqCZlcXWNR0vYH7F6sYbDkjxKoy', NULL, '9876543211', 'user', '2023-06-10 09:30:00'),
('Ananya Reddy', 'ananya@example.com', '$2y$10$gF5G4vN/oA97FhbxeUFMYOocJwLqCZlcXWNR0vYH7F6sYbDkjxKoy', NULL, '8765432100', 'user', '2023-06-22 14:15:00');
-- Note: All user passwords are 'password123' (hashed with bcrypt)

-- --------------------------------------------------------
-- Sample Data for admins table
-- --------------------------------------------------------
INSERT INTO `admins` (`name`, `email`, `password`, `role`, `profile_image`, `created_at`) VALUES
-- Password for all test admins is "admin123" except the last one which is "superadmin456"
('Rajesh Kumar', 'rajesh@royalevent.com', '$2y$10$v5.irvAT.yS19v./vIJUkOdCj.qo9e.lJH27h7PQBrr0YS6ZSjg7K', 'admin', NULL, '2023-01-01 09:00:00'),
('Nisha Mehta', 'nisha@royalevent.com', '$2y$10$v5.irvAT.yS19v./vIJUkOdCj.qo9e.lJH27h7PQBrr0YS6ZSjg7K', 'admin', NULL, '2023-01-02 10:30:00'),
('Suresh Iyer', 'suresh@royalevent.com', '$2y$10$v5.irvAT.yS19v./vIJUkOdCj.qo9e.lJH27h7PQBrr0YS6ZSjg7K', 'admin', NULL, '2023-01-03 11:45:00'),
('Vijay Reddy', 'vijay@royalevent.com', '$2y$10$jKpRR8ZSIsVXJxyqFfRNge5G.8qB9lzJQFYjMltgvAnKdXKdX6s6e', 'super_admin', NULL, '2023-01-04 08:15:00');
-- Note: Admin passwords - First three: 'admin123', Last one: 'superadmin456' (hashed with bcrypt)

-- --------------------------------------------------------
-- Sample Data for bookings table
-- --------------------------------------------------------
INSERT INTO `bookings` (`user_id`, `event_type`, `plan`, `event_date`, `guest_count`, `venue`, `message`, `total_amount`, `reference_number`, `status`, `created_at`) VALUES
(1, 'Wedding', 'Premium', '2023-12-20', 120, 'Grand Palace Hotel', 'We would like flower decorations in pink and white.', 99999.00, 'BKG-5F7A1E3B2D', 'Completed', '2023-06-15 14:30:00'),
(2, 'Birthday', 'Basic', '2023-10-05', 30, 'Garden Restaurant', 'Birthday celebration for my daughter turning 10.', 14999.00, 'BKG-8C2D9F4E7A', 'Completed', '2023-07-20 11:45:00'),
(3, 'Corporate Event', 'Luxury', '2023-11-15', 85, 'Business Convention Center', 'Annual company meeting with presentations.', 149999.00, 'BKG-3B5D7A9C1E', 'Completed', '2023-07-25 10:15:00'),
(4, 'Anniversary', 'Premium', '2023-12-10', 45, 'Sunset Beach Resort', '25th wedding anniversary celebration.', 39999.00, 'BKG-6E8A2C4B9D', 'Confirmed', '2023-08-05 16:20:00'),
(5, 'Wedding', 'Luxury', '2024-01-22', 200, 'Royal Banquet Hall', 'Traditional wedding with cultural ceremonies.', 199999.00, 'BKG-1D3F5A7C9E', 'Confirmed', '2023-08-10 13:30:00'),
(6, 'Birthday', 'Premium', '2023-12-15', 50, 'Party Plaza', '30th birthday party with DJ and dance floor.', 29999.00, 'BKG-9B7D5F3A1C', 'Confirmed', '2023-08-20 15:45:00'),
(7, 'Corporate Event', 'Basic', '2023-11-30', 40, 'Conference Room A', 'Product launch event with media presence.', 34999.00, 'BKG-2C4E6A8B1D', 'Completed', '2023-09-01 11:20:00'),
(8, 'Anniversary', 'Luxury', '2024-02-14', 60, 'Luxury Cruise Ship', 'Surprise anniversary celebration for parents.', 79999.00, 'BKG-7A9C1E3B5D', 'Pending', '2023-09-10 12:15:00'),
(9, 'Birthday', 'Luxury', '2024-01-05', 100, 'Starlight Ballroom', 'Extravagant 50th birthday celebration.', 59999.00, 'BKG-4B6D8A2C3E', 'Pending', '2023-09-15 14:50:00'),
(10, 'Wedding', 'Basic', '2024-03-30', 80, 'Garden Wedding Venue', 'Simple and elegant garden wedding.', 49999.00, 'BKG-8E2A4C6B9F', 'Pending', '2023-09-20 10:30:00'),
(11, 'Corporate Event', 'Premium', '2023-12-22', 70, 'Executive Conference Center', 'Year-end company awards ceremony.', 74999.00, 'BKG-3D5F7A9C2E', 'Confirmed', '2023-09-25 09:45:00'),
(12, 'Anniversary', 'Basic', '2024-02-28', 25, 'Rooftop Restaurant', 'Intimate dinner for 5th anniversary.', 19999.00, 'BKG-6B8D2A4C9E', 'Pending', '2023-10-01 13:10:00');

-- --------------------------------------------------------
-- Sample Data for feedback table
-- --------------------------------------------------------
INSERT INTO `feedback` (`user_id`, `booking_id`, `feedback_text`, `rating`, `date`) VALUES
(1, 1, 'The wedding was absolutely perfect! Every detail was taken care of, and our guests were amazed by the decorations and food. Thank you for making our special day truly magical.', 5, '2023-12-22 18:45:00'),
(2, 2, 'My daughters birthday party was a huge success. The staff was friendly and the venue was decorated beautifully. The kids had a great time with the activities arranged.', 5, '2023-10-07 14:30:00'),
(3, 3, 'Our corporate event was professionally managed. The AV setup was excellent, and the catering was top-notch. Will definitely use RoyalEvent for future corporate functions.', 4, '2023-11-17 11:15:00'),
(4, 4, 'The anniversary celebration was just as we envisioned. The sunset view at the venue was breathtaking. Only reason for not giving 5 stars is that the music started a bit late.', 4, '2023-12-15 20:00:00'),
(7, 7, 'The product launch was a success. The venue was perfect for our needs, and the technical support was excellent. Some minor issues with the microphone, but overall good experience.', 4, '2023-12-02 15:30:00'),
(1, NULL, 'I have used RoyalEvent multiple times, and they never disappoint. Their attention to detail and customer service is outstanding.', 5, '2023-12-30 17:45:00'),
(5, NULL, 'Planning our wedding with RoyalEvent has been a stress-free experience. The team is responsive and accommodating to all our requests.', 5, '2023-10-15 13:20:00'),
(6, 6, 'My birthday party was good, but there were some delays in serving the food. The decoration and DJ were excellent though.', 3, '2023-12-18 22:10:00'),
(2, NULL, 'The event planning process was smooth, but I would appreciate more budget-friendly options for decorations.', 4, '2023-11-05 09:45:00'),
(3, NULL, 'RoyalEvent understood our corporate needs perfectly and delivered a professional event that impressed our clients and stakeholders.', 5, '2023-12-01 16:30:00');

-- --------------------------------------------------------
-- Sample Data for gallery table
-- --------------------------------------------------------
INSERT INTO `gallery` (`image_path`, `title`, `event_type`, `description`, `uploaded_by`, `uploaded_at`) VALUES
('assets/images/gallery/wedding_decor1.jpg', 'Elegant Wedding Decoration', 'Wedding', 'Luxurious floral arrangements and lighting at Grand Palace Hotel wedding', 1, '2023-06-25 15:30:00'),
('assets/images/gallery/birthday_party1.jpg', 'Colorful Birthday Celebration', 'Birthday', 'Fun and vibrant birthday party setup for children at Garden Restaurant', 2, '2023-07-25 12:45:00'),
('assets/images/gallery/corporate_event1.jpg', 'Executive Conference Setup', 'Corporate Event', 'Professional conference arrangement at Business Convention Center', 3, '2023-08-05 11:15:00'),
('assets/images/gallery/anniversary1.jpg', 'Romantic Anniversary Dinner', 'Anniversary', 'Intimate dining setup with candles and flowers at Sunset Beach Resort', 1, '2023-08-15 14:20:00'),
('assets/images/gallery/wedding_ceremony1.jpg', 'Traditional Wedding Ceremony', 'Wedding', 'Cultural wedding rituals at Royal Banquet Hall', 2, '2023-08-25 16:30:00'),
('assets/images/gallery/birthday_cake1.jpg', 'Spectacular Birthday Cake', 'Birthday', 'Custom-designed multi-tier cake for 30th birthday celebration', 3, '2023-09-10 13:45:00'),
('assets/images/gallery/corporate_presentation1.jpg', 'Product Launch Event', 'Corporate Event', 'High-tech product presentation setup at Conference Room A', 1, '2023-09-20 10:30:00'),
('assets/images/gallery/anniversary_cruise1.jpg', 'Luxury Anniversary Celebration', 'Anniversary', 'Decorated deck of cruise ship for special anniversary event', 2, '2023-10-05 17:15:00'),
('assets/images/gallery/wedding_reception1.jpg', 'Garden Wedding Reception', 'Wedding', 'Outdoor wedding reception setup with fairy lights and rustic decor', 3, '2023-10-15 15:30:00'),
('assets/images/gallery/corporate_awards1.jpg', 'Corporate Awards Ceremony', 'Corporate Event', 'Elegant stage setup for company awards night at Executive Conference Center', 1, '2023-10-25 14:45:00'),
('assets/images/gallery/birthday_entertainment1.jpg', 'Birthday Entertainment Show', 'Birthday', 'Live performance at a luxury birthday celebration', 2, '2023-11-05 12:30:00'),
('assets/images/gallery/anniversary_surprise1.jpg', 'Anniversary Surprise Moment', 'Anniversary', 'Captured reaction during a surprise anniversary celebration', 3, '2023-11-15 18:20:00');

-- --------------------------------------------------------
-- Sample Data for contacts table
-- --------------------------------------------------------
INSERT INTO `contacts` (`name`, `email`, `subject`, `message`, `status`, `created_at`) VALUES
('Arjun Kapoor', 'arjun@example.com', 'Wedding Package Inquiry', 'I am interested in your luxury wedding package. Could you please provide more details about the included services and venue options?', 'Responded', '2023-06-10 10:15:00'),
('Sneha Reddy', 'sneha@example.com', 'Corporate Event Pricing', 'I would like to request a detailed quote for a corporate event for approximately 100 people. We are looking at dates in December.', 'Responded', '2023-06-15 14:30:00'),
('Karan Malhotra', 'karan@example.com', 'Birthday Party Availability', 'I want to host a birthday party for my son in July. Are there any available dates and what packages would you recommend for a children's party?', 'Read', '2023-06-20 11:45:00'),
('Divya Sharma', 'divya@example.com', 'Anniversary Celebration Ideas', 'My parents' 40th anniversary is coming up, and I'd like some creative ideas for celebration. Do you offer any special packages for milestone anniversaries?', 'Responded', '2023-07-05 09:30:00'),
('Rajat Singh', 'rajat@example.com', 'Venue Question', 'Do you have any beachfront venues for a wedding ceremony? We're planning for about 150 guests in February next year.', 'Read', '2023-07-10 16:45:00'),
('Mira Desai', 'mira@example.com', 'Catering Options', 'I'm organizing a corporate event and would like to know about your vegetarian and vegan catering options.', 'Unread', '2023-07-15 13:20:00'),
('Vivek Joshi', 'vivek@example.com', 'Photography Services', 'Do you provide photography and videography services as part of your packages or do we need to arrange separately?', 'Unread', '2023-07-20 15:50:00'),
('Leela Nair', 'leela@example.com', 'Custom Event', 'We're planning a family reunion for about 50 people. This doesn't fit into your standard packages. Can you create a custom event plan?', 'Unread', '2023-07-25 12:10:00'),
('Prakash Rao', 'prakash@example.com', 'Cancellation Policy', 'I'd like to understand your cancellation and refund policy before making a booking.', 'Unread', '2023-08-01 10:30:00'),
('Ayesha Khan', 'ayesha@example.com', 'Decoration Theme Question', 'For the premium wedding package, can we customize the decoration theme? We have a specific color scheme in mind.', 'Unread', '2023-08-05 14:15:00'),
('Nikhil Patel', 'nikhil@example.com', 'Payment Options', 'What payment methods do you accept, and is there an option for installment payments for large events?', 'Unread', '2023-08-10 11:30:00'),
('Priyanka Das', 'priyanka@example.com', 'Feedback on Previous Event', 'I attended a wedding organized by your team last month. I wanted to share some feedback about the excellent service provided.', 'Unread', '2023-08-15 16:45:00'); 