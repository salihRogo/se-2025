# Copy 'n' Pastries

Copy 'n' Pastries is a franchise management system designed to streamline operations for
a network of pastry shops. The system offers an e-commerce-like experience, enabling
customers to reserve spots at specific shop locations, schedule pastry deliveries, or opt for
in-store pickup.

## Features

- **User Authentication** - Secure login and registration system

- **Pastry shop overview**

- **Reservations** - Booking a reservation at preferred time and shop

- **Reviews** - Adding reviews for shops

- **Admin dashboard** - admin can manage users

## Getting started

### Prerequisites

- XAMPP or similar local server stack
- PHP
- Composer
- MySQL Server

## Runing the project

#### Backend

1. **Clone the repository:**

- Navigate to htdocs folder throught terminal and run the following command

```sh
git clone https://github.com/salihRogo/se-2025.git
```

2. **Install PHP dependencies:**

- Before installation of PHP, you have to navigate to backend folder

```sh
cd backend
composer install
```

3. **Import database credentials:**

- In order to access the database, you need to provide some information 

- That info should be placed in `config.php` file on backend level

- The `config.php` file should have the following 

```php
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));

class Config
{
    public static function DB_NAME()
    {
        return '';      // Input name of database from dbeaver (pastry-franchise)
    }

    public static function DB_PORT()
    {
        return 3306;        // Change the port of MySQL if needed (3306 left as default and commonly used)
    }

    public static function DB_USER()
    {
        return '';      // Put your user from MySQL    
    }

    public static function DB_PASSWORD()
    {
        return '';      // Put your password from MySQL
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

4. **Set up the database:**

- Create a MySQL database (named `pastry-franchise`)

- Import the provided SQL schema

#### Frontend

- In order to input constants such as base_api_url, you have to input the following code into `frontend/utils/constants.js`

- get_api_base_url is set to your backend URL. Make sure that URL is correct, example is set in the following 

```js
var Constants = {
  get_api_base_url: function () {
    return "http://localhost/se-2025/backend/";     // Change this URL if needed
  },
};
```

## Project structure 

```sh 
se-2025/
│
├── backend/
│   ├── .htaccess
│   ├── composer.json
│   ├── composer.lock
│   ├── index.php
│   ├── config.php         # (to be created by you, see README)
│   └── rest/
│       ├── dao/
│       │   ├── AuthDao.class.php
│       │   ├── BaseDao.class.php
│       │   ├── FavouritesDao.class.php
│       │   ├── ReservationsDao.class.php
│       │   ├── ReviewsDao.class.php
│       │   ├── ShopsDao.class.php
│       │   └── UsersDao.class.php
│       ├── routes/
│       │   ├── admin_routes.php
│       │   └── ... (other route files)
│       └── services/
│           └── ... (service files)
│
├── frontend/
│   ├── index.html
│   ├── assets/
│   │   ├── css/
│   │   ├── img/
│   │   ├── js/
│   │   └── webfonts/
│   ├── help-documentation/
│   │   ├── IMD-License.txt
│   │   ├── index.html
│   │   ├── css/
│   │   ├── images/
│   │   └── js/
│   ├── pages/
│   │   ├── 404.html
│   │   ├── about.html
│   │   ├── admin/
│   │   │   ├── dashboard.html
│   │   │   ├── manage-users.html
│   │   │   └── manage-shops.html
│   │   ├── cart.html
│   │   ├── contact.html
│   │   ├── home.html
│   │   ├── login.html
│   │   ├── news.html
│   │   ├── profile.html
│   │   ├── single-news.html
│   │   └── single-shop.html
│   ├── services/
│   │   ├── admin.js
│   │   ├── favourites.js
│   │   ├── helper.js
│   │   ├── reservations.js
│   │   ├── reviews.js
│   │   ├── script.js
│   │   ├── shops.js
│   │   └── users.js
│   └── utils/
│       ├── constants.js        # (to be created by user, see README)
│       ├── form_validation.js
│       ├── rest_client.js
│       └── utils.js
│
├── README.md
└── (other files as needed)
```
