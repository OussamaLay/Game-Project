# Projet de Jeu

Ce projet nécessite l'installation de XAMPP.

### Étapes d'installation :
1. Installer XAMPP.
2. À la fin de l'installation, XAMPP se lance puis démarrer les modules `Apache` et `MySQL` en cliquant sur `Start`.

### Configuration initiale :
1. Se déplacer vers le répertoire : 
    ```bash
    cd C:/xampp/htdocs
    git clone https://github.com/OussamaLay/Game-Project.git
    ```
#### Traitement des fichiers CSV :
En cas d'erreur de lecture des fichiers CSV, ouvrez le terminal dans le dossier du projet et exécutez la commande suivante :
```bash
python Data/CsvToPgSQL.py
```

2. Créer la base de données :
    - Suivre cette vidéo [lien vers la vidéo](https://www.youtube.com/watch?v=oNJpktM65eY) en remplaçant le nom de la base de données par : `jeux-video` et le nom de l'utilisateur par : `gamer`.
    - Ou, utiliser PgAdmin :
        - Lancer et connecter PgAdmin.
        - Clic droit sur la base de données `Databases` -> `Create` -> `Database`, remplir le nom de la base de données par : `jeux-videos`, puis cliquer sur `Save`.
        - Clic droit sur `jeux-videos` -> `Query Tool`, puis importer le fichier (Ouvrir le fichier) `C:\xampp\htdocs\Game-Project\Site\JeuxVid.sql` et exécuter.
        - Clic droit sur `jeux-videos` -> `PLSQL Tool`, puis exécuter :
            ```bash
            CREATE USER gamer WITH PASSWORD '00000';
            ALTER ROLE gamer WITH LOGIN;
            GRANT ALL PRIVILEGES ON DATABASE "jeux-videos" TO gamer;
            GRANT SELECT, INSERT, UPDATE, DELETE ON article TO gamer;
            GRANT SELECT, INSERT, UPDATE, DELETE ON categorie TO gamer;
            GRANT SELECT, INSERT, UPDATE, DELETE ON panier_article  TO gamer;
            ```

### Accès au site web :
Le site web est disponible via le lien : `http://localhost/Game-Project/Site/`


