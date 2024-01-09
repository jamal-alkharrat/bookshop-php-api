# Bookshop - Authentication

This document describes the authentication process of the bookshop application. All authentication related files are saved in the folder `auth` and are accessible via the URL `http://localhost/api/v1auth/` for the local dev branch.

## Prepare the Database - MariaDB

1. Connect to the database

2. Create a table 'user' to save user information

```sql
CREATE TABLE user (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);
```

## Prepare a PHP Server

I used XAMPP to setup a PHP server. I created a folder 'v1auth' in the htdocs folder of XAMPP. All PHP files to handle the authentication are saved in this folder.

For further information on how to setup a PHP server with XAMPP visit the [XAMPP website](https://www.apachefriends.org/index.html).

### Register

- The file `register.php` handles the registration of a new user

1. Check if email, username and password valid
    - For email i used the PHP function `filter_var($email, FILTER_VALIDATE_EMAIL)`. 
    - For username i checked if the length is between 3 and 20 characters. And if it contains only letters numbers, underscores, periods and hyphens. Additionally i checked if the username is 'admin' or 'support'.
    - For password i checked if the length is between 8 and 64 characters. And if it contains valid characters.
2. Check if email and username already exists in database
    - I used PDO to check if the email and username already exists in the database.
3. Hash password
    - I hashed the password using the PHP function `password_hash($password, PASSWORD_DEFAULT)`.
4. Save user to database using PDO
    - I saved the password hash, email and username to the database using PDO. The password is not saved in plain text. The function `password_verify()` can be used to verify that a password matches a hash. 
5. Generate token to start session

### Login

- The file `login.php` handles the login of a user

1. Check if email and password valid similar to the registration
2. Check if email exists in database
3. Fetched the password hash and username from the database
4. Verify password hash
    - I used the PHP function `password_verify($password, $hash)` to verify the password hash.
5. Generated the token to start the session

### Additional functions

- I added all validation functions to the file `validation.php`. The functions are used in `register.php` and `login.php`.
- I created connect.php to connect to the database. This is used to send queries to the database.
- I seperated the function for generating tokens in its own file as well.

