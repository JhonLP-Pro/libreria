CREATE DATABASE librairie;

USE librairie;

CREATE TABLE type_utilisateur (
    id_type INT PRIMARY KEY,
    type VARCHAR(50)
);

CREATE TABLE utilisateur (
    id_utilisateur INT PRIMARY KEY,
    nom VARCHAR(50),
    prénom VARCHAR(50),
    type_utilisateur int(11),
    adresse VARCHAR(100),
    téléphone VARCHAR(15),
    mdp text,
    FOREIGN KEY (type_utilisateur) REFERENCES type_utilisateur(id_type)
);

CREATE TABLE Livre (
    id_livre INT PRIMARY KEY,
    titre VARCHAR(100),
    auteur VARCHAR(50),
    année INT,
    catégorie VARCHAR(50)
);

CREATE TABLE Prêt (
    id_prêt INT PRIMARY KEY,
    date_emprunt DATE,
    date_retour DATE,
    état VARCHAR(20),
    id_utilisateur INT,
    id_livre INT,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
    FOREIGN KEY (id_livre) REFERENCES Livre(id_livre)
);

INSERT INTO type_utilisateur (id_type, type) VALUES
(1, 'Administrateur'),
(2, 'Lecteur');