DROP TABLE IF EXISTS Messages;
DROP TABLE IF EXISTS Amis;
DROP TABLE IF EXISTS Preferences;
DROP TABLE IF EXISTS Publications;
DROP TABLE IF EXISTS DemandesAmis;
DROP TABLE IF EXISTS Utilisateurs;

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
    pp TEXT,
    bannier TEXT,
    date_inscription DATE
);

CREATE TABLE IF NOT EXISTS Amis  (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    utilisateur_id INTEGER,
    ami_id INTEGER,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id),
    FOREIGN KEY (ami_id) REFERENCES Utilisateurs(id)
);

CREATE TABLE IF NOT EXISTS Messages   (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    utilisateur_id1 INTEGER,
    utilisateur_id2 INTEGER,
    contenu TEXT,
    date_publication DATETIME,
    FOREIGN KEY (utilisateur_id1) REFERENCES Utilisateurs(id)
    FOREIGN KEY (utilisateur_id2) REFERENCES Utilisateurs(id)
);

 CREATE TABLE IF NOT EXISTS Preferences  (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    utilisateur_id INTEGER,
    genre TEXT,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);


CREATE TABLE IF NOT EXISTS Publications   (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    utilisateur_id INTEGER,
    contenu TEXT,
    genre TEXT,
    like INTEGER,
    date_publication DATETIME,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);

CREATE TABLE IF NOT EXISTS DemandesAmis (
    id_demande INTEGER PRIMARY KEY AUTOINCREMENT,
    id_demandeur INTEGER,
    id_receveur INTEGER,
    statut TEXT CHECK(statut IN ('en_attente', 'acceptee', 'rejetee')),
    date_demande DATETIME,
    FOREIGN KEY (id_demandeur) REFERENCES Utilisateurs(id),
    FOREIGN KEY (id_receveur) REFERENCES Utilisateurs(id)
);



INSERT INTO Amis (utilisateur_id,ami_id) VALUES (2,1);
INSERT INTO Amis (utilisateur_id,ami_id) VALUES (1,2);


INSERT INTO Messages (utilisateur_id1, utilisateur_id2, contenu, date_publication) VALUES (1, 2, 'Salut, comment ça va ?', '2024-05-12 19:00:00');
INSERT INTO Messages (utilisateur_id1, utilisateur_id2, contenu, date_publication) VALUES (2, 1, 'Tout va bien, merci ! Et toi ?', '2024-05-12 19:05:00');
INSERT INTO Messages (utilisateur_id1, utilisateur_id2, contenu, date_publication) VALUES (1, 2, 'Je vais bien aussi, merci. As-tu des plans pour le week-end ?', '2024-05-12 19:10:00');
INSERT INTO Messages (utilisateur_id1, utilisateur_id2, contenu, date_publication) VALUES (2, 1, 'Pas encore, je pense peut-être aller voir un film.', '2024-05-12 19:15:00');
