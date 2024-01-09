# Bookshop - Orders

This document describes the order process of the bookshop application. All order related files are saved in the folder `orders` and are accessible via the URL `http://localhost/orders/` for the dev branch.

### Prepare the Database - MariaDB

1. Connect to the database

2. Create a table 'order' and 'order_items' to save order information

```sql
CREATE TABLE `bestellungen` (
    `BestellungID` INT NOT NULL AUTO_INCREMENT,
    `UserID` INT,
    `GesamtPreis` DECIMAL(10,2) NOT NULL,
    `Bestelldatum` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `StripeID` varchar(255),
    PRIMARY KEY (`BestellungID`),
    FOREIGN KEY (`UserID`) REFERENCES `user`(`id`) ON DELETE SET NULL
);

CREATE TABLE `bestellpositionen` (
    `BestellpositionID` INT NOT NULL AUTO_INCREMENT,
    `BestellungID` INT NOT NULL,
    `ProduktID` INT NOT NULL,
    `Anzahl` INT NOT NULL,
    `PreisNetto` DECIMAL(10,2) NOT NULL,
    `Mwstsatz` DECIMAL(10,2) NOT NULL,
    `PreisBrutto` DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (`BestellpositionID`),
    FOREIGN KEY (`BestellungID`) REFERENCES `bestellungen`(`BestellungID`),
    FOREIGN KEY (`ProduktID`) REFERENCES `buecher`(`ProduktID`)
);

```

- Optional: Create dummy orders for testing

```sql
INSERT INTO `bestellungen` (`BestellungID`, `UserID`, `GesamtPreis`, `Bestelldatum`) VALUES (NULL, '1', '10.00', '2020-12-01 00:00:00');
INSERT INTO `bestellpositionen` (`BestellpositionID`, `BestellungID`, `ProduktID`, `Anzahl`, `PreisNetto`, `Mwstsatz`, `PreisBrutto`) VALUES (NULL, '1', '1', '1', '10.00', '0.00', '10.00');
```