-- phpMyAdmin SQL Dump

-- version 4.5.4.1deb2ubuntu2

-- http://www.phpmyadmin.net

--

-- Client :  localhost

-- Généré le :  Jeu 26 Octobre 2017 à 13:53

-- Version du serveur :  5.7.19-0ubuntu0.16.04.1

-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */

;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */

;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */

;

/*!40101 SET NAMES utf8mb4 */

;

--

-- Base de données :  `simple-mvc`

--

-- --------------------------------------------------------

CREATE TABLE
    `user` (
        `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        `firstname` VARCHAR(100) NOT NULL,
        `lastname` VARCHAR(100) NOT NULL,
        `username` VARCHAR(100) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `email` VARCHAR(150) NOT NULL,
        `phone_number` INT(11) NOT NULL,
        `birthdate` date NOT NULL,
        `localisation` VARCHAR(150) NOT NULL,
        `is_admin` bool NULL
    );

INSERT INTO
    `user` (
        `firstname`,
        `lastname`,
        `username`,
        `password`,
        `email`,
        `phone_number`,
        `birthdate`,
        `localisation`,
        `is_admin`
    )
VALUES (
        'Elise',
        'Admin',
        'lilith',
        '$2y$10$gosLWfQZux3cZp5G69h2peX.LN4JumOqgfiKLvcksVQsfjT.7lvTa',
        'admin@admin.com',
        0506070809,
        '1996-10-01',
        'France',
        1
    ),
    (
        'Julien',
        'Privat',
        'Carcali',
        '$2y$10$gosLWfQZux3cZp5G69h2peX.LN4JumOqgfiKLvcksVQsfjT.7lvTa',
        'admin2@admin.com',
        0506070809,
        '1999-05-03',
        'France',
        1
    ),
    (
        'William',
        'LHERM',
        'Zamarof',
        '$2y$10$gosLWfQZux3cZp5G69h2peX.LN4JumOqgfiKLvcksVQsfjT.7lvTa',
        'admin3@admin.com',
        0506070809,
        '1989-06-01',
        'France',
        1
    ),
    (
        'Sajid',
        'Sahli',
        'Mrsahli',
        '$2y$10$gosLWfQZux3cZp5G69h2peX.LN4JumOqgfiKLvcksVQsfjT.7lvTa',
        'admin4@admin.com',
        0506070809,
        '1979-08-06',
        'France',
        1
    ),
    (
        'Catherine',
        'Nette',
        'Catherinetten1',
        '$2y$10$gosLWfQZux3cZp5G69h2peX.LN4JumOqgfiKLvcksVQsfjT.7lvTa',
        'user1@admin.com',
        0506070809,
        '1995-09-30',
        'France',
        2
    ),
    (
        'Catherine',
        'Nette',
        'Catherinetten2',
        '$2y$10$gosLWfQZux3cZp5G69h2peX.LN4JumOqgfiKLvcksVQsfjT.7lvTa',
        'user2@admin.com',
        0506070809,
        '1994-02-23',
        'France',
        2
    );

CREATE TABLE
    `contact` (
        `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        `firstname` VARCHAR(100) NOT NULL,
        `lastname` VARCHAR(100) NOT NULL,
        `email` VARCHAR(150) NOT NULL,
        `message` VARCHAR(3000) NOT NULL,
        `user_id` INT NULL,
        FOREIGN KEY (user_id) REFERENCES user(id)
    );

CREATE TABLE
    `ad_type` (
        `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        `nametype` VARCHAR(100) NOT NULL
    );

    INSERT INTO ad_type (nametype)
    VALUE ('Proposer'),
        ('Rechercher');

CREATE TABLE
    `category` (
        `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        `name` VARCHAR(255) NOT NULL
    );

        INSERT INTO category (name)
        VALUES ('Bricolage'), ('Jardinage'), ('Soutien scolaire'), ('Mécanique'), ('Cuisine'), ('Couture');

CREATE TABLE
    `ad` (
        `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        `title` VARCHAR(100) NULL,
        `image` VARCHAR(500),
        `description` VARCHAR(6000) NULL,
        `username` VARCHAR(100) NULL,
        `localisation` VARCHAR(150) NULL,
        `published_date` date,
        `user_id` INT NOT NULL,
        FOREIGN KEY (user_id) REFERENCES user(id),
        `category_id` INT NOT NULL,
        FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE CASCADE,
        `ad_type_id` INT NOT NULL,
        FOREIGN KEY (ad_type_id) REFERENCES ad_type(id)
    );

    INSERT INTO ad (
        `title`,
        `image`,
        `description`,
        `published_date`,
        `user_id`,
        `category_id`,
        `ad_type_id`
    )
    VALUE 
    (
        'Cheminée',
        './assets/images/cheminee.jpg',
        'L\'hiver approche, et j\'aurais grand besoin qu''on vienne ramoner ma cheminée pour la saison.',
        '2023-10-31',
        5,
        1,
        2
    ),
        (
        'Taillage de haie',
        './assets/images/haie.jpg',
        'Fin jardinier, je peux venir tailler vos haies.',
        '2023-09-23',
        3,
        2,
        1
    ),
    (
        'Aide à l\'ourlet',
        './assets/images/couture.jpg',
        'Je recherche une personne pouvant m\'apprendre comment réaliser mes ourlets moi-même.',
        '2023-10-01',
        1,
        6,
        2
    ),
    (
        'Vidange',
        './assets/images/impala.jpg',
        'J\'aurais besoin d\'aide pour réaliser la vidange de ma voiture.',
        '2023-11-12',
        6,
        4,
        2
    ),
    (
        'Patisserie',
        './assets/images/tartecitron.jpg',
        'Je recherche une personne pour m\'apprendre à réaliser la tarte au citron meringuée.',
        '2023-11-14',
        2,
        5,
        2
    ),
    (
        'Façade',
        './assets/images/tartecitron.jpg',
        'Quelqu\'un pourrait-il m\'aider à repeindre ma façade.',
        '2023-11-15',
        4,
        1,
        2
    ),
        (
        'Soutien maths',
        './assets/images/maths.jpg',
        'Je peux vous aider pour vos cours de maths.',
        '2023-11-04',
        4,
        3,
        1
    ),
        (
        'Soutien anglais',
        './assets/images/illustrator.jpg',
        'Je peux vous apprendre l\'anglais.',
        '2023-09-15',
        1,
        3,
        1
    ),
    (
        'Montage de meuble',
        './assets/images/illustrator.jpg',
        'Je peux venir monter vos meubles de marque suédoise.',
        '2023-10-13',
        5,
        1,
        1
    ),
    (
        'Explication comptabilité',
        './assets/images/maths.jpg',
        'Je peux vous apprendre à faire vos impôts.',
        '2023-11-22',
        6,
        3,
        1
    );

CREATE TABLE
    `image` (
        id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        `image_name` VARCHAR(500),
        `ad_id` INT NOT NULL,
        FOREIGN KEY (ad_id) REFERENCES ad(id)
    );

CREATE TABLE
    `report_ad`(
        `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        `report_reason` VARCHAR(255) DEFAULT NULL,
        `ad_id` INT NULL,
        FOREIGN KEY (ad_id) REFERENCES ad(id)
    );

    INSERT INTO `report_ad` (report_reason)
    VALUES ('Annonce au contenu frauduleux'),
    ('Annonce inappropriée'),
    ('Annonce mal catégorisée');

CREATE TABLE
    `signal_report` (
        `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        `report_ad_id` INT NULL,
        FOREIGN KEY (report_ad_id) REFERENCES report_ad(id)
    );