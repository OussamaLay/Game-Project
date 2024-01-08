import numpy as np
import pandas as pd
from faker import Faker
import random
import matplotlib.pyplot as plt
import secrets
import string
import psycopg2
from datetime import timedelta, datetime


# FAKE CLIENT DATA

def getRandomPasswordString():
    alphabet = string.ascii_letters + string.digits + string.punctuation.replace(',', '')  # Exclure la virgule

    password = secrets.choice(string.ascii_uppercase) + \
               secrets.choice(string.ascii_lowercase) + \
               secrets.choice(string.digits) + \
               secrets.choice(string.punctuation.replace(',', '')) + \
               ''.join(secrets.choice(alphabet) for i in range(12))

    return password

def generate_data():
    fake = Faker()
    liste_des_domaines = ['com','net','org','gov','fr']

    list_rows = []
    nb_row = random.randint(10000, 12000)

    generated_ids = set()   # Utilisation d'un ensemble pour stocker les IDs générés

    for i in range(nb_row):
        first_name = fake.first_name()
        last_name = fake.last_name()
        company = fake.company().split()[0].strip(',')
        dns_org = fake.random_choices(elements=liste_des_domaines, length=1)[0]
        email = f"{first_name}.{last_name}@{company}.{dns_org}".lower()
        unique_id = random.randint(100000, 999999)
        pwd = getRandomPasswordString()
        condition = True
        while (condition):
            age = int(np.random.gamma(9, 5)) - 20
            if ((age > 15) and (age < 66)):
                condition = False

        if unique_id not in generated_ids:
            generated_ids.add(unique_id)  # Ajoute l'ID à l'ensemble des IDs générés
            list_rows.append(
                (unique_id, first_name, last_name, pwd, age, fake.job(), fake.address(), fake.phone_number(), email)
            )
    return list_rows


data = generate_data()
client = pd.DataFrame(data, columns=['id', 'prenom', 'nom', 'pwd', 'age', 'job', 'adress', 'phoneNumber', 'email'])
client.to_csv('client.csv', index=False)



# FAKE GAME STATS DATA

# Générer les IDs de 2 à 50
all_ids = np.arange(2, 52)
excluded_ids = [8, 11, 12, 13, 14, 15, 16, 27, 28, 29, 34, 45]
id_values = [e for e in all_ids if e not in excluded_ids]

# Générer toutes les dates de 2023
start_date = pd.to_datetime('2022-01-01')
end_date = pd.to_datetime('2023-12-31')
dates = pd.date_range(start_date, end_date, freq='D')

np.random.seed(10)

# Créer une DataFrame vide pour stocker les données
jeux_stats = pd.DataFrame(columns=['id_article', 'date', 'qte_ajoutee', 'qte_achetee'])

# Générer des quantités aléatoires en fonction de chaque article et date
for article_id in id_values:
    # Générer des paramètres spécifiques pour chaque article (moyenne et écart-type)
    moyenne_ajoutee = np.random.uniform(50, 200)  # Moyenne pour qte_ajoutee
    ecart_type_ajoutee = np.random.uniform(20, 100)  # Écart-type pour qte_ajoutee
    
    moyenne_achetee = moyenne_ajoutee * np.random.uniform(0.5, 0.8)  # Moyenne pour qte_achetee
    ecart_type_achetee = ecart_type_ajoutee * np.random.uniform(0.5, 0.8)  # Écart-type pour qte_achetee
    
    # Générer des quantités aléatoires pour chaque date en utilisant une distribution normale
    qte_ajoutee = np.random.normal(moyenne_ajoutee, ecart_type_ajoutee, len(dates)).astype(int)
    qte_ajoutee = np.abs(qte_ajoutee)  # Rendre les valeurs négatives positives
    qte_achetee = np.random.normal(moyenne_achetee, ecart_type_achetee, len(dates)).astype(int)
    qte_achetee = np.abs(qte_achetee)  # Rendre les valeurs négatives positives
    qte_achetee = np.where(qte_achetee == 0, 1, qte_achetee) # Assurer que qte_achetee n'est pas nulle
    
    # Créer une DataFrame pour cet article et concaténer avec la DataFrame principale
    article_data = pd.DataFrame({
        'id_article': article_id,
        'date': dates,
        'qte_ajoutee': qte_ajoutee,
        'qte_achetee': qte_achetee
    })
    jeux_stats = pd.concat([jeux_stats, article_data])

# Réinitialiser l'index
jeux_stats.reset_index(drop=True, inplace=True)

# Convertir la colonne 'date' en format date YYYY-MM-DD
jeux_stats['date'] = jeux_stats['date'].dt.strftime('%Y-%m-%d')

jeux_stats.to_csv('jeux_stats.csv', index=False)