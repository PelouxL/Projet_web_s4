/*
CREATE TABLE membres(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pseudo TEXT,
    mdp TEXT,
    statut INTEGER
); */


CREATE TABLE Utilisateurs (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom TEXT,
    email TEXT UNIQUE,
    date_inscription DATE
);

CREATE TABLE Amis (
    id INTEGER PRIMARY KEY,
    utilisateur_id INTEGER,
    ami_id INTEGER,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id),
    FOREIGN KEY (ami_id) REFERENCES Utilisateurs(id)
);

CREATE TABLE Messages (
    id INTEGER PRIMARY KEY,
    utilisateur_id INTEGER,
    contenu TEXT,
    date_publication DATETIME,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);

CREATE TABLE Preferences (
    id INTEGER PRIMARY KEY,
    utilisateur_id INTEGER,
    genre TEXT,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);


CREATE TABLE Publications (
    id INTEGER PRIMARY KEY,
    utilisateur_id INTEGER,
    contenu TEXT,
    genre TEXT,
    date_publication DATETIME,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);




