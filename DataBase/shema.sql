-- 1. NETTOYAGE
DROP DATABASE IF EXISTS data_fage_back;

-- 2. CRÉATION DE LA BASE
CREATE DATABASE IF NOT EXISTS data_fage_back
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE data_fage_back;

-- ============================================================
-- CRÉATION DES TABLES
-- ============================================================

-- Table BÉNÉVOLE
CREATE TABLE IF NOT EXISTS benevole (
                                        id_benevole INT AUTO_INCREMENT PRIMARY KEY,
                                        nom VARCHAR(100) NOT NULL,
                                        prenom VARCHAR(100) NOT NULL,
                                        email VARCHAR(150) NOT NULL UNIQUE,
                                        mdp VARCHAR(255) NOT NULL,
                                        role ENUM('benevole', 'administrateur') DEFAULT 'benevole'
);

-- Table ÉVÉNEMENT
CREATE TABLE IF NOT EXISTS evenement (
                                         id_evenement INT AUTO_INCREMENT PRIMARY KEY,
                                         titre VARCHAR(150) NOT NULL,
                                         lieu VARCHAR(100) NOT NULL,
                                         date_evenement DATE NOT NULL,
                                         budget DECIMAL(10,2) NOT NULL,
                                         description TEXT
);

-- Table ACTUALITÉ (ARTICLES) -- [NOUVEAU]
CREATE TABLE IF NOT EXISTS actualite (
                                         id_actu INT AUTO_INCREMENT PRIMARY KEY,
                                         titre VARCHAR(200) NOT NULL,
                                         contenu TEXT NOT NULL,
                                         date_publication DATETIME DEFAULT CURRENT_TIMESTAMP,
                                         image VARCHAR(255) DEFAULT 'default.jpg' -- Pour mettre une image d'illustration
);

-- Table MATÉRIEL
CREATE TABLE IF NOT EXISTS materiel (
                                        id_materiel INT AUTO_INCREMENT PRIMARY KEY,
                                        nom VARCHAR(100) NOT NULL,
                                        qt_materiel INT NOT NULL
);

-- Table INSCRIT (Lien Bénévole <-> Événement)
CREATE TABLE IF NOT EXISTS inscrit (
                                       id_evenement INT NOT NULL,
                                       id_benevole INT NOT NULL,
                                       date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
                                       PRIMARY KEY (id_evenement, id_benevole),
                                       CONSTRAINT fk_inscrit_evenement
                                           FOREIGN KEY (id_evenement) REFERENCES evenement(id_evenement)
                                               ON DELETE CASCADE,
                                       CONSTRAINT fk_inscrit_benevole
                                           FOREIGN KEY (id_benevole) REFERENCES benevole(id_benevole)
                                               ON DELETE CASCADE
);

-- Table UTILISE (Lien Événement <-> Matériel)
CREATE TABLE IF NOT EXISTS utilise (
                                       id_evenement INT NOT NULL,
                                       id_materiel INT NOT NULL,
                                       quantite INT NOT NULL,
                                       PRIMARY KEY (id_evenement, id_materiel),
                                       CONSTRAINT fk_utilise_evenement
                                           FOREIGN KEY (id_evenement) REFERENCES evenement(id_evenement)
                                               ON DELETE CASCADE,
                                       CONSTRAINT fk_utilise_materiel
                                           FOREIGN KEY (id_materiel) REFERENCES materiel(id_materiel)
                                               ON DELETE CASCADE
);

-- ============================================================
-- INSERTION DES DONNÉES (DATA)
-- ============================================================

-- A. ADMINS & BÉNÉVOLES
INSERT INTO benevole (nom, prenom, email, mdp, role) VALUES
                                                         ('Admin', 'FAGE', 'admin@fage.fr', '$2y$10$hfi19kQMIcj4CG6lyoxuduVYYgw9STgaq.qTHqglmKN/28wbQCdGm', 'administrateur'),
                                                         ('King', 'Maitre', 'King@f.fr', '$2y$10$hfi19kQMIcj4CG6lyoxuduVYYgw9STgaq.qTHqglmKN/28wbQCdGm', 'administrateur'),
                                                         ('Martin', 'Sophie', 'sophie.martin@etu.fr', '$2y$10$hfi19kQMIcj4CG6lyoxuduVYYgw9STgaq.qTHqglmKN/28wbQCdGm', 'benevole'),
                                                         ('Dubois', 'Thomas', 'thomas.dubois@etu.fr', '$2y$10$hfi19kQMIcj4CG6lyoxuduVYYgw9STgaq.qTHqglmKN/28wbQCdGm', 'benevole');

-- B. ÉVÉNEMENTS (Mixte dates 2025/2026)
INSERT INTO evenement (titre, lieu, date_evenement, budget, description) VALUES
                                                                             ('Formation des nouveaux bénévoles', 'Paris', '2026-01-24', 2500.00, 'Journée de formation destinée aux nouveaux bénévoles afin de leur présenter les valeurs, missions et outils de la FAGE.'),
                                                                             ('Congrès National de la FAGE', 'Lyon', '2026-01-20', 12000.00, 'Grand rassemblement annuel des associations membres pour débattre et définir les orientations nationales.'),
                                                                             ('Atelier Santé Mentale', 'Toulouse', '2026-01-12', 1500.00, 'Atelier animé par des professionnels pour sensibiliser à la santé mentale des étudiants.'),
                                                                             ('Forum Engagement Étudiant', 'Lille', '2026-01-02', 3000.00, 'Forum permettant aux étudiants de découvrir les opportunités d’engagement associatif.'),
                                                                             ('Collecte Alimentaire AGORAé', 'Strasbourg', '2026-02-05', 500.00, 'Grande collecte devant les supermarchés pour remplir les épiceries solidaires.'),
                                                                             ('Soirée de Gala Inter-Asso', 'Bordeaux', '2026-03-10', 8000.00, 'Soirée festive regroupant toutes les associations étudiantes de la région.');

-- C. ARTICLES / ACTUALITÉS -- [NOUVEAU]
INSERT INTO actualite (titre, contenu, date_publication) VALUES
                                                             ('Bonne année 2026 !', 'Toute l’équipe de la FAGE vous souhaite une excellente année 2026, riche en réussite et en engagement.', '2026-01-01 10:00:00'),
                                                             ('Réforme des bourses : Ce qui change', 'Le ministère a annoncé une revalorisation des bourses sur critères sociaux. Voici les nouveaux barèmes pour cette année.', '2025-12-28 14:00:00'),
                                                             ('Succès de la semaine du développement durable', 'Plus de 500 étudiants ont participé à nos ateliers "Zéro Déchet" sur les campus. Merci à tous !', '2025-12-15 09:30:00'),
                                                             ('Recrutement : Devenez bénévole', 'Vous avez du temps libre ? Rejoignez nos équipes pour aider à la distribution alimentaire dans nos AGORAé.', '2026-01-05 16:45:00');

-- D. MATÉRIEL
INSERT INTO materiel (nom, qt_materiel) VALUES
                                            ('Chaises', 200), ('Tables', 50), ('Microphones', 10), ('Enceintes', 6),
                                            ('Vidéoprojecteurs', 5), ('Rallonges électriques', 30), ('Multiprises', 25),
                                            ('Ordinateurs portables', 8), ('Kakémonos FAGE', 12), ('Flyers', 5000);

-- E. INSCRIPTIONS (Pour remplir le tableau de bord)
INSERT INTO inscrit (id_evenement, id_benevole, date_inscription) VALUES
                                                                      (1, 1, NOW()),
                                                                      (2, 2, NOW()),
                                                                      (3, 1, NOW()),
                                                                      (1, 3, NOW()), -- Sophie va à la formation
                                                                      (2, 3, NOW()), -- Sophie va au congrès
                                                                      (4, 4, NOW()), -- Thomas va au forum
                                                                      (5, 4, NOW()); -- Thomas va à la collecte

-- F. MATÉRIEL UTILISÉ
INSERT INTO utilise (id_evenement, id_materiel, quantite) VALUES
                                                              (1, 1, 30), (1, 5, 1), -- Formation : 30 chaises, 1 projo
                                                              (6, 4, 4), (6, 3, 2);  -- Gala : 4 enceintes, 2 micros

INSERT INTO article (titre, contenu, date_creation, image, id_benevole) VALUES
                                                                            (
                                                                                'Baromètre de la précarité étudiante 2025',
                                                                                'Le nouveau baromètre de la précarité étudiante révèle une situation toujours préoccupante, marquée par l’inflation et le coût du logement qui pèsent sur les étudiants.',
                                                                                '2026-01-18',
                                                                                'Barometre.png',
                                                                                1
                                                                            ),
                                                                            (
                                                                                'Coût de la rentrée 2025',
                                                                                'Le coût d’une année étudiante augmente de 2.2%. Un étudiant devra en moyenne débourser 3.227 euros pour sa rentrée, une hausse historique.',
                                                                                '2026-01-18',
                                                                                'cout_rentree.png',
                                                                                1
                                                                            ),
                                                                            (
                                                                                'Bouge ton campus',
                                                                                'La FAGE confirme sa place de première organisation étudiante représentative au CNESER à l’issue des élections, renforçant son poids dans les négociations.',
                                                                                '2026-01-18',
                                                                                'bouge_ton_campus.png',
                                                                                1
                                                                            ),
                                                                            (
                                                                                'OOUUUUIII SA FONCTIONNE',
                                                                                'Ceci est un article de test pour valider que le système de publication fonctionne parfaitement !',
                                                                                '2026-01-18',
                                                                                'don.png',
                                                                                1
                                                                            );