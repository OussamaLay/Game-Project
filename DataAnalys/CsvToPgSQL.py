import pandas as pd
import psycopg2

# Connexion à la base de données PostgreSQL
conn = psycopg2.connect(
    dbname="jeux-videos",
    user="postgres",
    password="S0314",
    host="localhost",
    port="5432"
)

# Remplacez 'nom_table' par le nom de la table dans la base de données PostgreSQL
nom_table = 'client'

# Chargez vos données dans une DataFrame Pandas (remplacez cela par votre propre logique pour charger vos données)
dataframe_pour_table = pd.read_csv('client.csv')

# Exportation de la DataFrame pandas dans la table PostgreSQL
dataframe_pour_table.to_sql(nom_table, conn, if_exists='append', index=False)

# Fermez la connexion
conn.close()
