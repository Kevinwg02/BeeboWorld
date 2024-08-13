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
    id INT AUTO_INCREMENT PRIMARY KEY,   
    couverture VARCHAR(255),             
    titre VARCHAR(255),              
    auteur VARCHAR(255),                
    saga VARCHAR(255),                
    isbn VARCHAR(13),                   
    prix DECIMAL(10, 2),               
    maisonEdition VARCHAR(255),         
    medaille_id INT,                   
    genre_id INT,                       
    dateAchat DATE,                      
    dateLecture DATE,                   
    typeLivre_id INT,                 
    nbPage INT,                         
    FOREIGN KEY (medaille_id) REFERENCES Medaille(id),  
    FOREIGN KEY (genre_id) REFERENCES Genre(id),     
    FOREIGN KEY (typeLivre_id) REFERENCES typeLivre(id) 
);


-- Insert values into the medaille table
INSERT INTO Medaille (nom) VALUES ('or');
INSERT INTO Medaille (nom) VALUES ('argent');
INSERT INTO Medaille (nom) VALUES ('diamant');
INSERT INTO Medaille (nom) VALUES ('bronze');
INSERT INTO Medaille (nom) VALUES ('PAL');
INSERT INTO Medaille (nom) VALUES ('corbeille');
INSERT INTO Medaille (nom) VALUES ('en cours');

-- Insert values into the Genre table
INSERT INTO Genre (nom) VALUES ('Fantastique');
INSERT INTO Genre (nom) VALUES ('Fantasy');
INSERT INTO Genre (nom) VALUES ('Romance');
INSERT INTO Genre (nom) VALUES ('DarkRomance');

-- Insert values into the typeLivre table
INSERT INTO typeLivre (nom) VALUES ('Hardback');
INSERT INTO typeLivre (nom) VALUES ('Relie');
INSERT INTO typeLivre (nom) VALUES ('eBook');
INSERT INTO typeLivre (nom) VALUES ('Manga');
INSERT INTO typeLivre (nom) VALUES ('Poche');


-- Insert a sample row into the Books table
INSERT INTO Books (couverture, titre, auteur, saga, isbn, prix, maisonEdition, medaille_id, genre_id, dateAchat, dateLecture, typeLivre_id, nbPage)
VALUES (
    'assets/images/couvertures/TheAdventureOfBeebo.jpg',       
    'The Adventures of Beebo',           
    'Jane Doe',                            
    'Beebo Saga',                          
    '9781234567890',                     
    19.99,                                
    'Beebo Press',                       
    2,                                 
    2,                        
    '2022-08-01',                        
    '2023-01-15',                          
    1,                           
    320                                  
);
