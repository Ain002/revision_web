CREATE TABLE objets (
  id INT PRIMARY KEY AUTO_INCREMENT,
  proprietaire_id INT NOT NULL,
  categorie_id INT NOT NULL,
  nom VARCHAR(100) NOT NULL,
  description TEXT,
  date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  prix DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (proprietaire_id) REFERENCES user(id),
  FOREIGN KEY (categorie_id) REFERENCES categorie(id)
);

CREATE TABLE image (
    id INT PRIMARY KEY AUTO_INCREMENT,
    objet_id INT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    FOREIGN KEY (objet_id) REFERENCES objets(id)
);