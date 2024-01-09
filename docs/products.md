# Bookshop - Products

### Prepare the Database - MariaDB

1. Connect to the database.

2. Create a table 'buecher' to save product information. Note: You can use another name for the table. For example 'products'.

To create a new table for the products run the following SQL command:

```sh
CREATE TABLE buecher (
    ProduktID INT PRIMARY KEY,
    Produktcode VARCHAR(255),
    Produkttitel VARCHAR(255),
    Autorname VARCHAR(255),
    Verlagsname VARCHAR(255),
    PreisNetto DECIMAL(10, 2),
    Mwstsatz DECIMAL(10, 2),
    PreisBrutto DECIMAL(10, 2),
    Lagerbestand INT,
    Kurzinhalt TEXT,
    Gewicht DECIMAL(10, 2),
    LinkGrafikdatei VARCHAR(255)
);
```

Optional: Create dummy products for testing

```sh
INSERT INTO buecher (ProduktID, Produktcode, Produkttitel, Autorname, Verlagsname, PreisNetto, Mwstsatz, PreisBrutto, Lagerbestand, Kurzinhalt, Gewicht, LinkGrafikdatei)
VALUES 
(1, 'PHP1', 'PHP im Überblick', 'Dr. Mustermann', 'Rheinwerk Verlag', 100, 19, 119.000, 100, 'sehr gutes Buch zu PHP mit vielen Beispielen', 1.5, '...'),
(2, 'PHP1', 'Java im Überblick', 'Dr. Mustermann', 'Rheinwerk Verlag', 50, 19, 58.500, 30, 'sehr gutes Buch zu Java mit vielen Beispielen', 1.7, '...'),
(3, 'PHP1', 'JavaScript im Überblick', 'Tom Meier', 'Springer Verlag', 100, 19, 119.000, 40, 'sehr gutes Buch zu JavaScript mit vielen Beispielen', 1.7, '...');
```

To show all rows:

```sh
SELECT * FROM buecher;
```