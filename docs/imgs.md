# Bookshop - Images

This document describes how to create and upload images to the database. The images are stored in the database as base64 strings. The images are uploaded to the database via the api under link `http://localhost/api/books/upload_form.html` for the local dev branch. The images are displayed in the webstore via the api under link `http://localhost/api/books/display_img.php`. Make sure to change the links in the products table in the database to the images you want to display for each product.

## Prepare the Database - MariaDB

1. Connect to the database

2. Create a table 'images' to save the images

```sql
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `uploaded_on` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

## Upload Images

- The file `upload_form.html` and `upload_img.php` handles the upload of images

## Display Images

- The file `display_img.php` handles the display of images

TODO: Automate the process of uploading images to the database with each product. This can be done by creating a new form for adding products to the database where the images can be uploaded as well. This is not implemented yet.