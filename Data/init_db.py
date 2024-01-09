#python init_db.py --dbname postgres --user postgres --host localhost --password votre_mot_de_passe

import psycopg2
import argparse

# Configuration des arguments en ligne de commande
parser = argparse.ArgumentParser(description='Script de création d\'utilisateur et de base de données PostgreSQL')
parser.add_argument('--dbname', required=True, help='Nom de la base de données')
parser.add_argument('--user', required=True, help='Nom d\'utilisateur PostgreSQL')
parser.add_argument('--host', required=True, help='Hôte PostgreSQL')
parser.add_argument('--password', required=True, help='Mot de passe PostgreSQL')

print("\n")
print(parser)
print("\n")

args = parser.parse_args()

print(args)
print("\n")

# Connexion à la base de données PostgreSQL par défaut (postgres)
conn = psycopg2.connect(
    dbname='postgres',
    user='votre_utilisateur',
    password='votre_mot_de_passe',
    host='localhost'
)
conn.set_isolation_level(0)  # Réglage du niveau d'isolation sur autocommit

cur = conn.cursor()

# Création de la base de données JeuxVideos
cur.execute("CREATE DATABASE jeux-videos OWNER gamer;")

# Fermeture de la connexion
cur.close()
conn.close()
