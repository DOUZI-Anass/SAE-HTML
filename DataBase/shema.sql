

CREATE DATABASE IF NOT EXISTS data_fage_back
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE data_fage_back;


CREATE TABLE IF NOT EXISTS benevole (
                                        id_benevole INT AUTO_INCREMENT PRIMARY KEY,
                                        nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mdp VARCHAR(255) NOT NULL
    );


CREATE TABLE IF NOT EXISTS evenement (
                                         id_evenement INT AUTO_INCREMENT PRIMARY KEY,
                                         lieu VARCHAR(100) NOT NULL,
    date_evenement DATE NOT NULL,
    budget DECIMAL(10,2) NOT NULL
    );


CREATE TABLE IF NOT EXISTS materiel (
                                        id_materiel INT AUTO_INCREMENT PRIMARY KEY,
                                        nom VARCHAR(100) NOT NULL,
    qt_materiel INT NOT NULL
    );


CREATE TABLE IF NOT EXISTS document (
                                        num_doc INT AUTO_INCREMENT PRIMARY KEY,
                                        type_doc VARCHAR(50) NOT NULL,
    id_evenement INT NOT NULL,
    CONSTRAINT fk_document_evenement
    FOREIGN KEY (id_evenement)
    REFERENCES evenement(id_evenement)
    ON DELETE CASCADE
    );


CREATE TABLE IF NOT EXISTS inscrit (
                                       id_evenement INT NOT NULL,
                                       id_benevole INT NOT NULL,
                                       date_inscription DATE,
                                       PRIMARY KEY (id_evenement, id_benevole),
    CONSTRAINT fk_inscrit_evenement
    FOREIGN KEY (id_evenement)
    REFERENCES evenement(id_evenement)
    ON DELETE CASCADE,
    CONSTRAINT fk_inscrit_benevole
    FOREIGN KEY (id_benevole)
    REFERENCES benevole(id_benevole)
    ON DELETE CASCADE
    );


CREATE TABLE IF NOT EXISTS utilise (
                                       id_evenement INT NOT NULL,
                                       id_materiel INT NOT NULL,
                                       quantite INT NOT NULL,
                                       PRIMARY KEY (id_evenement, id_materiel),
    CONSTRAINT fk_utilise_evenement
    FOREIGN KEY (id_evenement)
    REFERENCES evenement(id_evenement)
    ON DELETE CASCADE,
    CONSTRAINT fk_utilise_materiel
    FOREIGN KEY (id_materiel)
    REFERENCES materiel(id_materiel)
    ON DELETE CASCADE
    );

ALTER TABLE benevole
    ADD COLUMN role ENUM('benevole', 'administrateur')
DEFAULT 'benevole';

INSERT INTO benevole (nom, prenom, email, mdp, role)
VALUES (
           'Admin',
           'FAGE',
           'admin@fage.fr',
           '$2y$10$hfi19kQMIcj4CG6lyoxuduVYYgw9STgaq.qTHqglmKN/28wbQCdGm', <--Leboss-->
           'administrateur'
       );

ALTER TABLE evenement ADD COLUMN description TEXT;

ALTER TABLE evenement ADD COLUMN titre VARCHAR(150) NOT NULL AFTER id_evenement;

INSERT INTO materiel (nom, qt_materiel) VALUES
                                            ('Chaises', 200),
                                            ('Tables', 50),
                                            ('Microphones', 10),
                                            ('Enceintes', 6),
                                            ('Vidéoprojecteurs', 5),
                                            ('Rallonges électriques', 30),
                                            ('Multiprises', 25),
                                            ('Ordinateurs portables', 8),;


INSERT INTO evenement (titre, lieu, date_evenement, budget, description) VALUES
                                                                             (
                                                                                 'Formation des nouveaux bénévoles',
                                                                                 'Paris',
                                                                                 '2026-01-24',
                                                                                 2500.00,
                                                                                 'Journée de formation destinée aux nouveaux bénévoles afin de leur présenter les valeurs, missions et outils de la FAGE.'
                                                                             ),
                                                                             (
                                                                                 'Congrès National de la FAGE',
                                                                                 'Lyon',
                                                                                 '2026-01-20',
                                                                                 12000.00,
                                                                                 'Grand rassemblement annuel des associations membres pour débattre et définir les orientations nationales.'
                                                                             ),
                                                                             (
                                                                                 'Atelier Santé Mentale',
                                                                                 'Toulouse',
                                                                                 '2026-01-12',
                                                                                 1500.00,
                                                                                 'Atelier animé par des professionnels pour sensibiliser à la santé mentale des étudiants.'
                                                                             ),
                                                                             (
                                                                                 'Forum Engagement Étudiant',
                                                                                 'Lille',
                                                                                 '2026-01-02',
                                                                                 3000.00,
                                                                                 'Forum permettant aux étudiants de découvrir les opportunités d’engagement associatif.'
                                                                             );
