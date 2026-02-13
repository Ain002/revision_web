CREATE TABLE `objets` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `proprietaire_id` INT UNSIGNED NOT NULL,
    `categorie_id` INT UNSIGNED NOT NULL,
    `nom` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `date_ajout` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `prix` DECIMAL(10,2) NOT NULL,
    CONSTRAINT `objets_proprietaire_foreign`
        FOREIGN KEY (`proprietaire_id`) REFERENCES `user`(`id`),
    CONSTRAINT `objets_categorie_foreign`
        FOREIGN KEY (`categorie_id`) REFERENCES `categorie`(`id_categorie`)
);

CREATE TABLE `image` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `objet_id` INT UNSIGNED NOT NULL,
    `nom` VARCHAR(255) NOT NULL,
    CONSTRAINT `image_objet_foreign`
        FOREIGN KEY (`objet_id`) REFERENCES `objets`(`id`)
);