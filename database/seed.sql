-- Seed data for development/testing
USE echange;

-- Type users (si non présents)
INSERT INTO type_user (`id`, `description`) VALUES
(1, 'Admin'),
(2, 'Visiteur')
ON DUPLICATE KEY UPDATE `description` = VALUES(`description`);

-- Test user (idtype = 1 -> Admin)
INSERT INTO `user` (`nom`, `mail`, `pwd`, `idtype`) VALUES
('Test User', 'test@example.com', 'password', 1)
ON DUPLICATE KEY UPDATE `nom` = VALUES(`nom`), `mail` = VALUES(`mail`);

-- Categories
INSERT INTO categorie (`nom`) VALUES
('Électronique'),
('Livres'),
('Meubles')
ON DUPLICATE KEY UPDATE `nom` = VALUES(`nom`);

-- Objects (objets)
-- Assure-toi que l'utilisateur et les catégories existent ; ici on suppose ids auto-incrémentés
INSERT INTO objets (proprietaire_id, categorie_id, nom, description, prix) VALUES
(1, 1, 'Portable', 'Ordinateur portable de test', 799.99),
(1, 2, 'Roman', 'Un roman de démonstration', 14.50),
(1, 3, 'Chaise', 'Chaise en bois', 39.90)
;

-- Images: noms de fichiers à déposer dans public/uploads/
INSERT INTO image (objet_id, nom) VALUES
(1, 'portable.svg'),
(2, 'roman.svg'),
(3, 'chaise.svg')
;
