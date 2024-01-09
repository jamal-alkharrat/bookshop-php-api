# Bookshop - Database on Docker

This document describes how to create a database in docker. This version is not used. Docker containers can be a good option for deployment. But for development it is easier tto use XAMPP. For non PHP API other DB options are available.

## Table of Contents

- [Requirements](#requirements)
- [Create a Database Container](#create-a-database-container)
- [Connect to the Database Container](#connect-to-the-database-container)
- [Create a Database](#create-a-database)

## Requirements

First youu should have docker and mariadb installed on your machine. 
- [Docker](https://docs.docker.com/get-docker/)
- [MariaDB](https://mariadb.com/downloads/)

We'll use docker to create a database container. This is done in the development environment. For production you should use a real database server.


## Create a Database Container

create a database docker container with the following command:

```bash
 docker run --name <NAME> --detach --publish 3306:3306 --env MARIADB_ROOT_PASSWORD='<PASSWORD>' mariadb
```
<NAME> is the name of the container. You can choose any name you want. For example 'bookshop-db'.
<PASSWORD> is the password for the root user. In my dev branch i used 'admin' as password. In production you should use a more secure password.

## Connect to the Database Container

You can either use a GUI like [MySQL Workbench](https://dev.mysql.com/downloads/workbench/) or the command line interface.

- **Optional** To run command line interface use the following command:

```sh
docker exec -it bookshop-db mariadb --user=root --password=<password>
```

## Create a Database

After connecting to the database you can create a new database. All the following commands are in SQL.

- To show all databases:

```sh
SHOW DATABASES;
```

- To create a new database:

```sh
CREATE DATABASE bookshop;
```

- To use our new database:

```sh
USE bookshop;
```