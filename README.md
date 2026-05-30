# PhoneStore – Online Phone Shop

PhoneStore is an online phone and electronics store built with **pure PHP**, **MySQL**, **Bootstrap 5**, and **JavaScript**.  
The project follows a simple MVC-style structure and includes both client-side pages and an admin management area.

---

## Table of Contents

- [Features](#features)
- [Technology Stack](#technology-stack)
- [System Requirements](#system-requirements)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Database Configuration](#database-configuration)
- [Run the Project](#run-the-project)
- [Notes](#notes)

---

## Features

### Client Side

- Home page
- Product listing page
- Product filtering
- Shopping cart
- User registration and login
- Q&A page
- About page
- Contact page with contact form

### Admin Side

- Admin authentication and authorization
- Product management
- Content management
- Admin dashboard

---

## Technology Stack

- **Backend:** PHP
- **Database:** MySQL / MariaDB
- **Frontend:** HTML, CSS, JavaScript, Bootstrap 5
- **Architecture:** Simple MVC-style structure
- **Web Server:** PHP built-in server, XAMPP, MAMP, or WAMP

---

## System Requirements

Before running this project, make sure your machine has:

- **PHP >= 8.0**

```bash
php -v
```

- **MySQL** or **MariaDB**
- A local web server, such as:
  - PHP built-in server
  - XAMPP
  - MAMP
  - WAMP

> This guide assumes the project folder is named `Phone_StoreV2`.  
> If you use another folder name, update the path accordingly.

---

## Project Structure

```text
Phone_StoreV2/
├── ajax/
├── assets/
│   ├── css/
│   ├── img/
│   └── javascript/
├── config/
│   └── db.php
├── controllers/
├── helpers/
├── models/
├── views/
│   ├── admin/
│   ├── client/
│   └── layouts/
│       ├── header.php
│       └── footer.php
├── index.php
├── phone_shop.sql
└── README.md
```

### Main Files and Folders

| Path | Description |
|---|---|
| `index.php` | Main entry point of the application |
| `config/db.php` | Database connection configuration |
| `controllers/` | Handles request logic |
| `models/` | Contains data models and database operations |
| `views/` | Contains UI pages and layout files |
| `assets/` | Contains CSS, images, and JavaScript files |
| `ajax/` | Contains AJAX request handlers |
| `phone_shop.sql` | SQL file used to create/import the database |

---

## Installation

Clone the repository or copy the project folder to your local machine.

Example location:

```bash
~/Projects/Phone_StoreV2
```

Move into the project folder:

```bash
cd ~/Projects/Phone_StoreV2
```

---

## Database Setup

### Step 1: Create Database

Open phpMyAdmin or use MySQL CLI and create a database named `phone_shop`.

```sql
CREATE DATABASE phone_shop
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

### Step 2: Import Database

Import the `phone_shop.sql` file into the `phone_shop` database.

#### Option 1: Using phpMyAdmin

1. Open phpMyAdmin.
2. Select the `phone_shop` database.
3. Go to the **Import** tab.
4. Choose the `phone_shop.sql` file.
5. Click **Go**.

#### Option 2: Using MySQL CLI

```bash
mysql -u root -p phone_shop < /path/to/phone_shop.sql
```

Replace `/path/to/phone_shop.sql` with the actual path to your SQL file.

---

## Database Configuration

Open the database configuration file:

```text
config/db.php
```

Update the database connection information if needed:

```php
class Database {
    // Use 127.0.0.1 to avoid socket issues on macOS
    private $host = '127.0.0.1';
    private $db_name = 'phone_shop';
    private $username = 'root';
    private $password = '';
    private $port = '3306';

    // ...
}
```

### Common Local Configuration

If you use the default XAMPP configuration:

| Field | Value |
|---|---|
| Host | `127.0.0.1` or `localhost` |
| Username | `root` |
| Password | empty |
| Port | `3306` |
| Database | `phone_shop` |

---

## Run the Project

There are two common ways to run this project locally.

---

### Option A: Using PHP Built-in Server

Start MySQL first, then open Terminal or Command Prompt and go to the project folder:

```bash
cd /path/to/Phone_StoreV2
```

Run the PHP built-in server:

```bash
php -S localhost:8000
```

Open your browser and visit:

```text
http://localhost:8000/index.php
```

The `index.php` file works as the front controller and loads pages based on query parameters such as:

```text
?page=home
?page=shop
?page=contact
```

---

### Option B: Using XAMPP

1. Open XAMPP.
2. Start **Apache** and **MySQL**.
3. Copy the project folder into the XAMPP `htdocs` directory.

macOS example:

```text
/Applications/XAMPP/htdocs/Phone_StoreV2
```

Windows example:

```text
C:\xampp\htdocs\Phone_StoreV2
```

Open your browser and visit:

```text
http://localhost/Phone_StoreV2/index.php
```

---

## Notes

- Make sure MySQL is running before opening the website.
- If the database connection fails, check the values in `config/db.php`.
- If the project folder name is changed, update the URL accordingly.
- If you use a different MySQL port, update the `$port` value in `config/db.php`.
- On macOS, using `127.0.0.1` instead of `localhost` may help avoid socket-related connection errors.

---

## Author

**Nguyen Nhat Huy**

GitHub: [iAmHuyyy](https://github.com/iAmHuyyy)
