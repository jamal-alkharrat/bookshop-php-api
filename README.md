# bookshop-php-api

PHP API for my Bookshop Webstore

## Table of Contents

- [bookshop-php-api](#bookshop-php-api)
  - [Table of Contents](#table-of-contents)
  - [About the Project](#about-the-project)
  - [Getting Started](#getting-started)
    - [Requirements](#requirements)
    - [Setup](#setup)
      - [Database](#database)
      - [API](#api)
      - [Images](#images)

## Getting Started

### Requirements

I recommend using [XAMPP](https://www.apachefriends.org/download.html) to setup the database and the API. It comes with Apache, MariaDB, PHP and phpMyAdmin. But you can also use any other server and database that supports PHP and MySQL.

### Setup

#### Database

1. Start XAMPP and start Apache and MariaDB.
2. Open phpMyAdmin and create a new database called `bookshop` using the SQL command:
```sql
CREATE DATABASE bookshop;
```
3. Import the `bookshop.sql` file from the `db` folder into the database.

In `bookshop.sql` are the necessary SQL statements to create the database and the tables so you don't have to do it manually. This step is necessary and the API won't work without it, because it needs to make queries to the database, in order for the webstore to work.

#### API

1. Copy the `api` folder into the `htdocs` folder of XAMPP. This folder contains all the PHP files that make up the API.
2. Copy the `admin` folder into the `htdocs` folder of XAMPP. This folder contains `config.php` which contains the database credentials and the stripe secret key. You need change the stripe secret key and database credentials to your own.
3. Copy the `conf` folder into the `htdocs` folder of XAMPP. This folder .htpassword which contains the credentials for the admin page. You need to change the credentials to your own. I recommend saving only a hashed password in the file. You can use [this tool](https://www.web2generators.com/apache-tools/htpasswd-generator) to generate a hashed password.
4. The API is set to allow CORS requests from `http://localhost:3000` by default. If you want to change this, you can do so in `admin/config.php` by changing the `Access-Control-Allow-Origin` header. You can also search for all occurrences of `http://localhost:3000` in the `api` folder and change them to your own domain. The URL is used in `config.php`, `success.php` and `cancel.php` and `.htaccess` in the `api` folder. Visual Studio Code has a handy feature to search for all occurrences of a string in the project.

TLDR: 
1. Copy everything to `htdocs` inside XAMPP folder. 
2. Change the stripe secret key, database credentials and admin credentials in config.php
3. Change BASE_URL from http://localhost:3000 to your own domain.

Congrats! The API is now setup and ready to use.

#### Images

Check ```docs/imgs.md``` for instructions on how to upload and display images in the database.
