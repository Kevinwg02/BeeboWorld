-- Create a new database
CREATE DATABASE IF NOT EXISTS DbBeeboWorld;

-- Switch to the new database
USE DbBeeboWorld;


-- Create the Genre table
CREATE TABLE Genre (
    id INT AUTO_INCREMENT PRIMARY KEY,   -- Primary key for the Genre table
    nom VARCHAR(255) UNIQUE              -- Genre name (e.g., Adventure, Fantasy, Mystery)
);

-- Create the typeLivre table
CREATE TABLE typeLivre (
    id INT AUTO_INCREMENT PRIMARY KEY,   -- Primary key for the typeLivre table
    nom VARCHAR(255) UNIQUE              -- Type name (e.g., Hardcover, Paperback, eBook, Manga)
);

CREATE TABLE Medaille (
    id INT AUTO_INCREMENT PRIMARY KEY,   -- Primary key for the Medaille table
    nom VARCHAR(255) UNIQUE              -- Medal name (e.g., or, argent, diamant, PAL, corbeille)
);



-- Create the table
CREATE TABLE Books (
    id INT AUTO_INCREMENT PRIMARY KEY,   -- Primary key for the Books table
    couverture VARCHAR(255),             -- Cover image or description
    titre VARCHAR(255),                  -- Title of the book
    auteur VARCHAR(255),                 -- Author of the b ook
    saga VARCHAR(255),                   -- Series/Saga (if any)
    isbn VARCHAR(13),                    -- ISBN of the book
    prix DECIMAL(10, 2),                 -- Price of the book
    maisonEdition VARCHAR(255),          -- Publishing house
    medaille_id INT,                     -- Foreign key to reference the Medaille table
    genre_id INT,                        -- Foreign key to reference the Genre table
    dateAchat DATE,                      -- Date of purchase
    dateLecture DATE,                    -- Date of reading
    typeLivre_id INT,                    -- Foreign key to reference the typeLivre table
    nbPage INT,                          -- Number of pages
    FOREIGN KEY (medaille_id) REFERENCES Medaille(id),  -- Foreign key constraint
    FOREIGN KEY (genre_id) REFERENCES Genre(id),        -- Foreign key constraint
    FOREIGN KEY (typeLivre_id) REFERENCES typeLivre(id) -- Foreign key constraint
);

-- Insert a sample row into the Books table
INSERT INTO Books (couverture, titre, auteur, saga, isbn, prix, maisonEdition, medaille_id, genre_id, dateAchat, dateLecture, typeLivre_id, nbPage)
VALUES (
    'assets/images/couvertures/TheAdventureOfBeebo.jpg',       -- Cover image URL
    'The Adventures of Beebo',             -- Title of the book
    'Jane Doe',                            -- Author of the book
    'Beebo Saga',                          -- Series/Saga
    '9781234567890',                       -- ISBN of the book
    19.99,                                 -- Price of the book
    'Beebo Press',                         -- Publishing house
    2,                                   -- Class or category
    2,                           -- Theme or genre
    '2022-08-01',                          -- Date of publication
    '2023-01-15',                          -- Date of reading
    1,                            -- Type of book
    320                                    -- Number of pages
);


-- Insert values into the medaille table
INSERT INTO Medaille (nom) VALUES ('or');
INSERT INTO Medaille (nom) VALUES ('argent');
INSERT INTO Medaille (nom) VALUES ('diamant');
INSERT INTO Medaille (nom) VALUES ('PAL');
INSERT INTO Medaille (nom) VALUES ('corbeille');
INSERT INTO Medaille (nom) VALUES ('bronze');
INSERT INTO Medaille (nom) VALUES ('en cours');

-- Insert values into the Genre table
INSERT INTO Genre (nom) VALUES ('Fantastique');
INSERT INTO Genre (nom) VALUES ('Fantasy');
INSERT INTO Genre (nom) VALUES ('Romance');

-- Insert values into the typeLivre table
INSERT INTO typeLivre (nom) VALUES ('Hardback');
INSERT INTO typeLivre (nom) VALUES ('Relié');
INSERT INTO typeLivre (nom) VALUES ('eBook');
INSERT INTO typeLivre (nom) VALUES ('Manga');

