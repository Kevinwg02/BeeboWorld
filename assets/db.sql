-- Create a new database
CREATE DATABASE IF NOT EXISTS DbBeeboWorld;

-- Switch to the new database
USE DbBeeboWorld;

-- Create the table with the specified columns
CREATE TABLE Books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    couverture VARCHAR(255),            -- Cover image or description
    titre VARCHAR(255),                 -- Title of the book
    auteur VARCHAR(255),                -- Author of the book
    saga VARCHAR(255),                  -- Series/Saga (if any)
    isbn VARCHAR(13),                   -- ISBN of the book
    prix DECIMAL(10, 2),                -- Price of the book
    maisonEdition VARCHAR(255),         -- Publishing house
    classe VARCHAR(255),                -- Class or category
    theme VARCHAR(255),                 -- Theme or genre
    datePublication DATE,               -- Date of publication
    dateLecture DATE,                   -- Date of reading
    typeLivre VARCHAR(255),             -- Type of book (e.g., Hardcover, Paperback, eBook)
    nbPage INT                          -- Number of pages
);


-- Insert a sample row into the Books table
INSERT INTO Books (couverture, titre, auteur, saga, isbn, prix, maisonEdition, classe, theme, datePublication, dateLecture, typeLivre, nbPage)
VALUES (
    'assets/images/TheAdventureOfBeebo.jpg',       -- Cover image URL
    'The Adventures of Beebo',             -- Title of the book
    'Jane Doe',                            -- Author of the book
    'Beebo Series',                        -- Series/Saga
    '9781234567890',                       -- ISBN of the book
    19.99,                                 -- Price of the book
    'Beebo Press',                         -- Publishing house
    'Fiction',                             -- Class or category
    'Adventure',                           -- Theme or genre
    '2022-08-01',                          -- Date of publication
    '2023-01-15',                          -- Date of reading
    'Hardcover',                           -- Type of book
    320                                    -- Number of pages
);
