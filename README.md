# Pastry Franchise Management System

![Pastry Franchise Banner](frontend/assets/img/hero-bg.jpg)

## 🌐 Live Demo

The application is deployed and accessible at: [https://pastry-franchise-14e2c48eb32b.herokuapp.com/](https://pastry-franchise-14e2c48eb32b.herokuapp.com/)

## 📝 Project Description

The Pastry Franchise Management System is a comprehensive web application designed to streamline operations for a network of pastry shops. The system offers customers the ability to browse shops, make reservations, leave reviews, and save favorites. Shop owners can manage their shops, while administrators have full control over the platform.

## ✨ Features

- **User Authentication** - Secure JWT-based login and registration system
- **Shop Browsing** - View all available pastry shops with details and locations
- **Reservations** - Book a table at your favorite pastry shop for a specific date and time
- **Reviews** - Leave and read reviews for each shop
- **Favorites** - Save shops to your favorites list for quick access
- **User Profiles** - Manage personal information and view your activity history
- **Admin Dashboard** - Comprehensive management of users, shops, and system data

## 🛠️ Technology Stack

### Backend
- **PHP 7.4+/8.0+**
- **FlightPHP** - Lightweight REST API framework
- **MySQL** - Database
- **JWT** - JSON Web Tokens for authentication
- **Composer** - Dependency management
- **PHPUnit** - Testing framework

### Frontend
- **HTML5/CSS3**
- **JavaScript (Vanilla)** - No frontend framework dependencies
- **Bootstrap** - Responsive design components

### DevOps
- **GitHub Actions** - CI/CD pipeline for automated testing
- **Heroku** - Cloud platform hosting
- **JawsDB MySQL** - Managed database service on Heroku

## 🚀 Getting Started

### Prerequisites

- XAMPP, MAMP, or similar local server stack
- PHP 7.4 or higher
- Composer
- MySQL Server
- Web Browser

### Local Development Setup

#### 1. Clone the Repository

```sh
git clone https://github.com/salihRogo/se-2025.git
cd se-2025
composer install
```

#### 2. Backend Setup

```sh
# Navigate to backend directory
cd backend

# Install PHP dependencies
composer install
```

#### 3. Database Setup

1. Create a new MySQL database named `pastry-franchise`
2. Import the database schema from `pastry-franchise.sql` file

#### 4. Configuration

Create a `config.php` file in the backend directory with the following content:

```php
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));

class Config
{
    public static function DB_NAME()
    {
        return 'pastry-franchise';
    }

    public static function DB_PORT()
    {
        return 3306;  // Default MySQL port
    }

    public static function DB_USER()
    {
        return 'root';  // Your MySQL username
    }

    public static function DB_PASSWORD()
    {
        return '';  // Your MySQL password
    }

    public static function DB_HOST()
    {
        return '127.0.0.1';
    }

    public static function JWT_SECRET()
    {
        return Config::get_env("JWT_SECRET", ',dpPL,Se%fM-UVQBwf/X0T&B!DF6%}');
    }

    public static function get_env($name, $default)
    {
        return isset($_ENV[$name]) && trim($_ENV[$name]) != "" ? $_ENV[$name] : $default;
    }
}
```

Also create a `constants.js` file in the `frontend/utils` directory:

```js
var Constants = {
  get_api_base_url: function () {
    // Detect environment
    if (window.location.hostname.includes('herokuapp.com')) {
      // Production URL
      return window.location.origin + "/";
    } else {
      // Local development URL
      return "http://localhost/se-2025/backend/";
    }
  },
};
```

#### 5. Start the Application

1. Start your local Apache and MySQL servers via XAMPP/MAMP
2. Access the application at `http://localhost/se-2025/frontend/`

## 🧪 Testing

The project includes a comprehensive test suite built with PHPUnit. Tests cover the service layer of the application, including authentication, reservations, reviews, favorites, and shop management.

### Running Tests Locally

```sh
cd backend
composer test
```

### Test Structure

The test suite is organized into the following test classes:

1. **AuthServiceTest** - Tests for user authentication functionality
   - Login with valid credentials
   - Login with invalid credentials
   - Login with non-existent user

2. **FavouritesServiceTest** - Tests for user favorites management
   - Get favorites by user ID
   - Add a shop to favorites
   - Delete a shop from favorites

3. **ReservationsServiceTest** - Tests for reservation management
   - Get reservations by user ID
   - Add a new reservation
   - Update reservation status
   - Get reservations by shop ID

4. **ReviewsServiceTest** - Tests for user reviews
   - Get reviews by shop ID
   - Add a new review
   - Delete a review
   - Get reviews by user ID

5. **ShopsServiceTest** - Tests for shop management
   - Get shop by ID
   - Get all shops
   - Add a new shop

### CI/CD Testing

The project uses GitHub Actions for automated testing on every push to the main branch. The workflow is defined in `.github/workflows/php-tests.yml`.

## 📦 Deployment

The application is deployed to Heroku with the following configuration:

- **Web Server**: PHP/Apache
- **Database**: JawsDB MySQL add-on
- **Environment Variables**:
  - `JWT_SECRET`: Secret key for JWT token generation/validation
  - `DATABASE_URL`: Automatically provided by JawsDB

### Deployment Process

1. Push changes to GitHub
2. GitHub Actions runs tests to ensure code quality
3. Upon successful tests, Heroku automatically deploys the application

## 📂 Project Structure

```
se-2025/
│
├── backend/
│   ├── .htaccess
│   ├── composer.json
│   ├── config_loader.php    # Environment configuration loader
│   ├── config.heroku.php    # Heroku environment configuration
│   ├── config.php           # Local environment configuration (created by user)
│   ├── index.php            # API entry point
│   ├── rest/
│   │   ├── dao/             # Data Access Objects
│   │   ├── routes/          # API route definitions
│   │   └── services/        # Business logic services
│   └── tests/               # PHPUnit tests
│
├── frontend/
│   ├── index.html           # Main entry point
│   ├── assets/              # Static assets (CSS, JS, images)
│   ├── pages/               # HTML pages
│   ├── services/            # Frontend services
│   └── utils/               # Utility functions
│
├── .github/workflows/       # GitHub Actions CI/CD configuration
├── composer.json            # Root composer file for Heroku
└── README.md                # This file
```

## 👥 Contributors

- Salih Rogo (@salihRogo)
- Mirna Ljiljić (@ljirna)

## 📄 License

This project is proprietary software.

---

For any questions or support, please contact the project maintainers.
