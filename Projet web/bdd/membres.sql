DROP TABLE IF EXISTS Utilisateurs ;

/*
CREATE TABLE membres(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pseudo TEXT,
    mdp TEXT,
    statut INTEGER
); */


 CREATE TABLE IF NOT EXISTS Utilisateurs  (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT,
    email TEXT UNIQUE,
    mdp TEXT,
    age INT,
    token TEXT,
    date_inscription DATE
);

CREATE TABLE IF NOT EXISTS Amis  (
    id INTEGER PRIMARY KEY,
    utilisateur_id INTEGER,
    ami_id INTEGER,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id),
    FOREIGN KEY (ami_id) REFERENCES Utilisateurs(id)
);

CREATE TABLE IF NOT EXISTS Messages   (
    id INTEGER PRIMARY KEY,
    utilisateur_id INTEGER,
    contenu TEXT,
    date_publication DATETIME,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);

 CREATE TABLE IF NOT EXISTS Preferences  (
    id INTEGER PRIMARY KEY,
    utilisateur_id INTEGER,
    genre TEXT,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);


CREATE TABLE IF NOT EXISTS Publications   (
    id INTEGER PRIMARY KEY,
    utilisateur_id INTEGER,
    contenu TEXT,
    genre TEXT,
    date_publication DATETIME,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);




