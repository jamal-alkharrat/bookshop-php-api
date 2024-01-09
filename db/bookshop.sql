CREATE DATABASE bookshop;

USE bookshop;

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

CREATE TABLE user (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

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

CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `uploaded_on` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- INSERT PRODUCTS - This can also be done in the admin panel
INSERT INTO buecher (ProduktID, Produktcode, Produkttitel, Autorname, Verlagsname, PreisNetto, Mwstsatz, PreisBrutto, Lagerbestand, Kurzinhalt, Gewicht, LinkGrafikdatei)
VALUES 
(1, 'PHP1', 'PHP im Überblick', 'Dr. Mustermann', 'Rheinwerk Verlag', 100, 19, 119.000, 100, 'sehr gutes Buch zu PHP mit vielen Beispielen', 1.5, '...'),
(2, 'PHP1', 'Java im Überblick', 'Dr. Mustermann', 'Rheinwerk Verlag', 50, 19, 58.500, 30, 'sehr gutes Buch zu Java mit vielen Beispielen', 1.7, '...'),
(3, 'PHP1', 'JavaScript im Überblick', 'Tom Meier', 'Springer Verlag', 100, 19, 119.000, 40, 'sehr gutes Buch zu JavaScript mit vielen Beispielen', 1.7, '...');

