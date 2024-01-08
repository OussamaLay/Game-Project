
--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS categorie;
CREATE TABLE IF NOT EXISTS categorie (
  id SERIAL PRIMARY KEY,
  libelle VARCHAR(50) NOT NULL,
  image VARCHAR(50) NOT NULL,
  ordre_affichage INT NOT NULL
);

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO categorie (id, libelle, image, ordre_affichage) VALUES
(1, 'simulation', 'volant.gif', 10),
(2, 'combat', 'epees.gif', 20),
(3, 'aventure', 'panneaux.gif', 30),
(4, 'sport', 'alterophile.gif', 40),
(5, 'horreur', 'tete_de_mort.gif', 50);

-- --------------------------------------------------------

--
-- Structure de la table `tva`
--

DROP TABLE IF EXISTS tva;
CREATE TABLE IF NOT EXISTS tva (
  id SERIAL PRIMARY KEY,
  taux NUMERIC(10,2) NOT NULL,
  date_debut DATE DEFAULT '2014-01-01',
  date_fin DATE DEFAULT '2099-12-31'
);

--
-- Déchargement des données de la table `tva`
--

INSERT INTO tva (id, taux, date_debut, date_fin) VALUES
(1, '0.00', '2014-01-01', '2099-12-31'),
(2, '5.00', '2014-01-01', '2099-12-31'),
(3, '20.00', '2014-01-01', '2099-12-31');

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS article;
CREATE TABLE IF NOT EXISTS article (
  id SERIAL PRIMARY KEY,
  reference VARCHAR(50) NOT NULL,
  libelle VARCHAR(50) NOT NULL,
  id_categorie INT NOT NULL REFERENCES categorie (id),
  detail VARCHAR(2000) NOT NULL,
  prix_ttc NUMERIC(10,2) NOT NULL,
  id_tva INT NOT NULL REFERENCES tva (id),
  image VARCHAR(50) NOT NULL
);


--
-- Déchargement des données de la table `article`
--

INSERT INTO article (id, reference, libelle, id_categorie, detail, prix_ttc, id_tva, image) VALUES
(2, 'JSI010', 'Sims 4', 1, 'Simulation de vie humaine', 31.69, 3, 'sims4.jpg'),
(3, 'JSI015', 'Cooking Simulator', 1, 'Devenez le chef de cuisine', 41.00, 3, 'cooking.jpg'),
(4, 'JSI100', 'Farming Simulator', 1, 'Apprenez a gérer votre ferme', 34.92, 3, 'farming22.jpg'),
(5, 'JSI120', 'Trackmania', 1, 'Simulation de Formule 1', 36.61, 3, 'trackmania.jpg'),
(6, 'JSI150', 'Jurassic world evolution', 1, 'Admirez les plus beaux dinosaures', 33.27, 3, 'jurassic.jpg'),
(7, 'JSI025', 'Euro Truck Simulator 2', 1, 'Devenez un vrai routier', 41.55, 3, 'eurotruck2.jpg'),
(9, 'JA15322', 'Yoshi s Island', 3, 'Aidez bébé Mario a survivre', 39.99, 3, 'yoshis-island.jpg'),
(10, 'JA534352', 'Luigi s Mansion', 3, 'Ghostbuster pour Luigi', 41.17, 3, 'luigis.jpg'),
(17, 'JC015', 'Fortnite', 2, 'Battle Royal colore', 40.89, 3, 'fortnite.jpg'),
(18, 'JC100', 'Street Fighter', 2, 'Combats pour les nostalgiques', 35.93, 3, 'street-fighter.jpg'),
(19, 'JC120', 'Mortal Combat', 2, 'Combats pour les nostalgiques qui aiment le sang', 41.99, 3, 'mortal-combat.jpg'),
(20, 'JC150', 'Battlefield 2', 2, 'FPS réaliste', 42.13, 3, 'battlefield2.jpg'),
(21, 'JC010', 'Super Smash Bros', 2, 'Incarnez vos personnages préférés', 39.72, 3, 'super-smash-bros.jpg'),
(22, 'JC200', 'PUBG', 2, 'Battle Royal moins colore', 42.18, 3, 'pubg.jpg'),
(23, 'JC020', 'CS:GO', 2, 'Infiltrez-vous en tant que terroriste ou militaire', 31.76, 3, 'csgo.jpg'),
(24, 'JC300', 'APEX Legends', 2, 'Battle Royal avec des super pouvoirs', 32.24, 3, 'apex.jpg'),
(25, 'JC030', 'League of legends', 2, 'Affrontez-vous dans l''arène pour la gloire', 35.95, 3, 'league-of-legends.jpg'),
(26, 'JC040', 'World of Tanks', 2, 'Battez-vous avec des tanks de toutes les époques', 37.99, 3, 'world-of-tanks.jpg'),
(30, 'JA1532', 'Rayman Legends', 3, 'Jeux de plateforme en nature', 37.14, 3, 'rayman.jpg'),
(31, 'JA53435', 'Super Mario 64', 3, 'Allez sauver Peach', 41.69, 3, 'super-mario64.jpg'),
(32, 'JA534125', 'Unravel', 3, 'Résolvez les énigmes sur votre chemin', 37.07, 3, 'unravel.jpg'),
(33, 'JA34', 'Minecraft', 3, 'Le monde des blocs', 30.26, 3, 'minecraft.jpg'),
(35, 'JA55', 'The legend of Zelda ', 3, 'Allez sauver Zelda', 40.07, 3, 'zelda.jpg'),
(36, 'JA959', 'GTA', 3, 'Découvrez le monde des malfrats', 34.59, 3, 'gta.jpg'),
(37, 'JSP415', 'Wii Sport', 4, 'Le multisport en famille', 37.76, 3, 'wii-sports.jpg'),
(38, 'JSP773505', 'Rocket league', 4, 'Le football en voiture', 39.99, 3, 'rocket-league.jpg'),
(39, 'JSP773506', 'FIFA 22', 4, 'Le football réaliste', 41.70, 3, 'fifa22.jpg'),
(40, 'JSP773507', 'Rugby 22', 4, 'Le rugby réaliste', 43.53, 3, 'rugby22.jpg'),
(41, 'JSP773508', 'NBA 2K22', 4, 'Le basketball réaliste', 32.54, 3, 'nba2k22.jpg'),
(42, 'JSP773503', 'Golf Impact', 4, 'Le golf réaliste', 32.12, 3, 'golf.jpg'),
(43, 'JSP773504', 'Mario Tennis', 4, 'Le tennis avec Mario', 32.98, 3, 'mario-tennis.jpg'),
(44, 'JSP773509', 'Mario Kart', 4, 'Course de voiture dans le monde de Mario', 38.52, 3, 'mario-kart.jpg'),
(46, 'JH10130', 'Five Night At Freedy', 5, 'Pointer-and-clicker de survit', 33.67, 3, 'freddys.jpg'),
(47, 'JH10080', 'Dead by Daylight', 5, 'Survit en multijoueur', 37.80, 3, 'dead-by-daylight.jpg'),
(48, 'JH10100', 'Resident Evil', 5, 'jeux vidéo d aventure, action et réflexion de type survival horror', 42.99, 3, 'resident-evil.jpg'),
(49, 'JH101302', 'Phasmophobia', 5, 'Elucidez les mysteres des morts', 41.56, 3, 'phasmophobia.jpg'),
(50, 'JH100802', 'The Conjuring House', 5, 'Essayez de ne pas mourir', 33.80, 3, 'the-conjuring-house.jpg'),
(51, 'JH101002', 'Friday 13', 5, 'Echappez a Jason', 44.34, 3, 'friday13.jpg');

-- Ajout de la colonne "pourcentage" avec des valeurs aléatoires entre 0.1 et 0.15
ALTER TABLE article
  ADD COLUMN pourcentage DECIMAL(5,2);

-- Ajout de la colonne "gain"
ALTER TABLE article
  ADD COLUMN gain DECIMAL(10,2);

-- Mettre à jour les valeurs de la colonne "pourcentage" avec des valeurs aléatoires
UPDATE article
  SET pourcentage = (FLOOR(random() * 6) + 10) / 100.0;

-- Mettre à jour la colonne "gain" avec le calcul prix_ttc * pourcentage pour chaque article
UPDATE article
  SET gain = ROUND(prix_ttc * pourcentage, 2);


-- --------------------------------------------------------

--
-- Structure de la table `jeux_statistics`
--

DROP TABLE IF EXISTS jeux_stats;
CREATE TABLE IF NOT EXISTS jeux_stats (
  id_article INT REFERENCES article (id),
  date DATE,
  qte_ajoutee INT,
  qte_achetee INT
);

--
-- Déchargement des données de la table `client`
--

-- il faut récupérer le chemain absolu du fichier client.csv s'il y a un erreur
--COPY jeux_stats FROM 'C:\xampp\htdocs\JeuVideo\DataAnalys\jeux_stats.csv' DELIMITER ',' CSV HEADER;
COPY jeux_stats FROM 'C:\xampp\htdocs\JeuVideo\Game-Project\DataAnalys\jeux_stats.csv' DELIMITER ',' CSV HEADER;
--C:\xampp\htdocs\JeuVideo\Game-Project\DataAnalys\jeux_stats.csv


-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS client;
CREATE TABLE IF NOT EXISTS client (
  id SERIAL PRIMARY KEY,
  prenom VARCHAR(50) NOT NULL,
  nom VARCHAR(50) NOT NULL,
  pwd VARCHAR(256) NOT NULL UNIQUE,
  age INT,
  job VARCHAR(256),
  adresse VARCHAR(256),
  phoneNumber VARCHAR(50),
  email VARCHAR(50) NOT NULL UNIQUE
);

--
-- Déchargement des données de la table `client`
--

INSERT INTO client (id, prenom, nom, pwd, age, job, adresse, phoneNumber, email) VALUES
(1, 'Dupont', 'Pierre', 'Bv8%~7T-O+k}r{pb', 55, 'Proffesseur', 'Campus des Cézeaux', '+33612345678','pierre.dupont@truc.fr');

-- il faut récupérer le chemain absolu du fichier client.csv s'il y a un erreur
COPY client FROM 'C:\xampp\htdocs\JeuVideo\Game-Project\DataAnalys\client.csv' DELIMITER ',' CSV HEADER;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--
/*
DROP TABLE IF EXISTS panier;
CREATE TABLE IF NOT EXISTS panier (
  id SERIAL PRIMARY KEY,
  date_creation TIMESTAMP DEFAULT current_timestamp,
  id_client INT NOT NULL REFERENCES client (id),
  id_session INT NOT NULL
);


--
-- Déchargement des données de la table `panier`
--

INSERT INTO panier (id, id_client, id_session) VALUES
(1, 1, 1);
*/

-- --------------------------------------------------------

--
-- Structure de la table `panier_article`
--

DROP TABLE IF EXISTS panier_article;
CREATE TABLE IF NOT EXISTS panier_article (
  --id_panier INT NOT NULL REFERENCES panier (id),
  id_article INT NOT NULL REFERENCES article (id),
  quantite INT NOT NULL,
  prix_ht NUMERIC(10,2) NOT NULL,
  prix_tva NUMERIC(10,2) NOT NULL,
  prix_ttc NUMERIC(10,2) NOT NULL
  --PRIMARY KEY (id_panier, id_article)
);
