# RoyalEvent Admin Dashboard

## Overview

RoyalEvent Admin Dashboard is a comprehensive web-based management system designed for event planning businesses. The dashboard provides administrative tools to manage event bookings, user accounts, feedback, and overall system operations. It offers an intuitive interface for administrators to track event statuses, manage customer information, and ensure smooth operation of the event planning business.

## Features

### Authentication & User Management

- **Secure Admin Login System** - Role-based access control
- **User Management** - View, filter and delete user accounts
- **Admin Management** - Create, view, and manage admin accounts with different permission levels

### Booking Management

- **Comprehensive Booking Overview** - View all bookings in a responsive table format
- **Detailed Booking Information** - Access complete details of each booking
- **Booking Status Management** - Update status (Pending, Confirmed, Completed, Canceled)
- **Filtering System** - Filter bookings by status, event type, and date

### Client Management

- **User Profiles** - Detailed view of user information
- **Booking History** - Track all bookings made by specific users
- **User Feedback** - View and manage feedback submitted by users

### Financial Tracking

- **Indian Rupee (₹) Currency Format** - Display amounts in INR
- **Total Revenue Tracking** - Monitor earnings through the dashboard
- **Pricing Management** - Adjust pricing for different event types and plans

### Interface & Experience

- **Responsive Design** - Fully functional on desktop and mobile devices
- **Intuitive Dashboard** - At-a-glance statistics and quick access to key functions
- **Status Indicators** - Visual representation of booking statuses with color-coded badges
- **Search Functionality** - Quickly find specific users, bookings, or feedback

## Technologies Used

### Frontend

- HTML5 & CSS3 for structure and styling
- JavaScript for interactive elements
- Bootstrap for responsive layout
- Font Awesome for icons
- AJAX for asynchronous data loading

### Backend

- PHP for server-side logic
- MySQL for database management
- PDO/MySQLi for database connectivity

### Tools & Libraries

- XAMPP/LAMP/MAMP for local development environment
- Git for version control
- DataTables for enhanced table functionality
- Chart.js for dashboard statistics visualization

## Setup Instructions

### Prerequisites

- XAMPP, WAMP, MAMP, or any PHP server environment (PHP 7.4+ recommended)
- MySQL Database
- Web Browser (Chrome, Firefox, Safari, Edge)

### Installation Steps

1. **Clone the Repository**

   ```
   git clone https://github.com/yourusername/royalevent.git
   ```

2. **Database Setup**

   - Create a new MySQL database named `royalevent`
   - Import the SQL file from `sql/tables.sql` to create the required tables
   - (Optional) Import sample data from `sql/records.sql` for testing

3. **Configuration**

   - Navigate to the `includes` directory
   - Create a `config.php` file using the provided template
   - Update database credentials in the configuration file

4. **Web Server Setup**

   - Move the project to your server's web directory (e.g., `htdocs` for XAMPP)
   - Ensure proper permissions are set for file uploads (777 for the `uploads` directory)

5. **Access the Dashboard**
   - Start your web server and MySQL service
   - Open a browser and navigate to `http://localhost/RoyalEvent/admin-login.php`
   - Login using the default admin credentials (email: admin@royalevent.com, password: admin123)

## Database Structure

The application uses a MySQL database with the following main tables:

### Users Table

Stores end-user information including name, email, phone, and authentication details.

### Admins Table

Contains administrative user accounts with access privileges to the dashboard.

### Bookings Table

The central table linking users to their event bookings, containing:

- Event details (type, date, venue, guest count)
- Status information (Pending, Confirmed, Completed, Canceled)
- Financial information (total amount)
- Reference numbers for tracking

### Feedback Table

Stores user reviews and ratings related to specific bookings or general feedback.

### Gallery Table

Contains references to event images displayed in the portfolio section.

### Pricing Table

Defines pricing structures for different event types and service plans.

### Contacts Table

Stores inquiries from potential clients through the contact form.

## Folder Structure

```
RoyalEvent/
├── admin-dashboard.php       # Main admin interface
├── admin-login.php           # Admin authentication
├── assets/                   # Static resources
│   ├── css/                  # Stylesheets
│   ├── js/                   # JavaScript files
│   ├── images/               # System images
│   └── fonts/                # Custom fonts
├── includes/                 # PHP components
│   ├── admin/                # Admin-specific modules
│   │   ├── dashboard.php     # Dashboard overview
│   │   ├── manage-users.php  # User management interface
│   │   ├── manage-admins.php # Admin management interface
│   │   └── manage-bookings.php # Booking management interface
│   ├── config.php            # Database configuration
│   ├── connection.php        # Database connection
│   ├── functions.php         # Helper functions
│   ├── header.php            # Common header
│   └── footer.php            # Common footer
├── uploads/                  # User uploaded content
│   ├── gallery/              # Event photos
│   └── profile/              # User profile images
├── sql/                      # Database scripts
│   ├── tables.sql            # Table creation
│   └── records.sql           # Sample data
└── README.md                 # Project documentation
```

## Screenshots

[Include screenshots of key interfaces here]

- Admin Dashboard Overview
- User Management Interface
- Booking Details View
- Feedback Management
- Mobile Responsive View

## Future Enhancements

1. **Advanced Reporting**

   - Generate PDF reports for bookings and revenue
   - Export data to Excel for offline analysis
   - Visual analytics with more detailed charts and graphs

2. **Communication Tools**

   - Email notification system for booking status changes
   - SMS alerts for important updates
   - In-built messaging system between admins and users

3. **Enhanced Security**

   - Two-factor authentication for admin access
   - Advanced permission system with more granular controls
   - Automated security logging and threat detection

4. **Operational Improvements**

   - Calendar view for event scheduling
   - Staff assignment and task management
   - Inventory tracking for event resources

5. **Client Experience**
   - Client portal for document sharing
   - Online payment integration
   - Event progress tracking for clients

## Author

[Your Name]  
Email: [royalevent@gmail.com]  
Website: [https://yourwebsite.com]

## License

This project is licensed under the MIT License - see the LICENSE file for details.

---

_Note: This README is a template and should be customized to match your specific implementation details._
