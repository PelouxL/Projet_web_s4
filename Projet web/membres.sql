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
    pp TEXT,
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




INSERT INTO Utilisateurs (nom, email, mdp, age, token, pp, date_inscription) VALUES ('Alexandre', 'alex.dupont@example.com', 'mdp123', 35, 'token_123', 'pp_alex.jpg', '2024-05-12');
INSERT INTO Utilisateurs (nom, email, mdp, age, token, pp, date_inscription) VALUES ('Marie', 'marie.curie@example.com', 'curie2024', 28, 'token_234', 'pp_marie.jpg', '2024-05-12');
INSERT INTO Utilisateurs (nom, email, mdp, age, token, pp, date_inscription) VALUES ('Jeanne', 'jeanne.m@example.com', 'moreaujeanne', 22, 'token_345', 'pp_jeanne.jpg', '2024-05-12');
INSERT INTO Utilisateurs (nom, email, mdp, age, token, pp, date_inscription) VALUES ('Émile', 'emile.zola@example.com', 'jaccuse', 42, 'token_456', 'pp_emile.jpg', '2024-05-12');
INSERT INTO Utilisateurs (nom, email, mdp, age, token, pp, date_inscription) VALUES ('Claude', 'claude.monet@example.com', 'nymphéas', 55, 'token_567', 'pp_claude.jpg', '2024-05-12');
INSERT INTO Utilisateurs (nom, email, mdp, age, token, pp, date_inscription) VALUES ('Victor', 'victor.hugo@example.com', 'lesmis123', 60, 'token_678', 'pp_victor.jpg', '2024-05-12');
INSERT INTO Utilisateurs (nom, email, mdp, age, token, pp, date_inscription) VALUES ('Gustave', 'gustave.eiffel@example.com', 'tour1234', 37, 'token_789', 'pp_gustave.jpg', '2024-05-12');
