# MyReview

MyReview est une application web développée avec Symfony permettant la gestion et la consultation d’avis ainsi que de contenus multimédias (films, séries, animés, etc.).

L’application permet notamment :

- la gestion des utilisateurs,
- la publication d’avis,
- la notation de contenus,
- la consultation de fiches multimédias,
- l’administration de la plateforme.

---

# Technologies utilisées

| Technologie | Version |
|---|---|
| PHP | 8.4 |
| Symfony | 8.0 |
| MariaDB | 11.x |

---

# Prérequis

Avant de commencer, assurez-vous d’avoir installé :

- PHP
- Composer
- Symfony CLI
- Git
- MariaDB

---

# Installation du projet

## 1. Cloner le dépôt

```bash
git clone https://github.com/MaximeHenault/MyReview
cd MyReview
```

---

# Installation des dépendances

## 2. Installer les dépendances PHP

```bash
composer install
```

Cette commande installe automatiquement toutes les dépendances nécessaires au projet.

---

# Configuration de la base de données

## 3. Installation de MariaDB

### Debian / Ubuntu

```bash
sudo apt-get install mariadb-server
```

---

## Connexion à MariaDB

```bash
sudo mariadb
```

---

## Création d’un utilisateur MariaDB

```sql
CREATE USER 'utilisateur'@'%' IDENTIFIED BY 'mot_de_passe';

GRANT ALL PRIVILEGES ON *.* TO 'utilisateur'@'%';

FLUSH PRIVILEGES;
```

---

## Explications

| Paramètre | Description |
|---|---|
| utilisateur | Nom de l’utilisateur MariaDB |
| % | Autorise les connexions depuis toutes les machines |
| mot_de_passe | Mot de passe du compte MariaDB |

---

# Configuration du fichier `.env.local`

Créer un fichier :

```txt
.env
```

Puis ajouter :

```env
DATABASE_URL="mysql://utilisateur:mot_de_passe@127.0.0.1:3306/myreview?serverVersion=mariadb-11.0.2"
```

---

## Paramètres de connexion

| Variable | Description |
|---|---|
| utilisateur | Utilisateur MariaDB |
| mot_de_passe | Mot de passe MariaDB |
| 127.0.0.1 | Adresse du serveur MariaDB |
| 3306 | Port MariaDB |
| myreview | Nom de la base de données |

---

# Initialisation de la base de données

## 4. Création de la base

```bash
php bin/console doctrine:database:create
```

---

## 5. Exécution des migrations

```bash
php bin/console doctrine:migrations:migrate
```

Cette commande crée automatiquement toutes les tables nécessaires au fonctionnement de l’application.

---

# Chargement des données de démonstration

## 6. Charger les fixtures

Les fixtures permettent de générer automatiquement des données de test :

- utilisateurs,
- avis,
- contenus multimédias,
- notes,
- catégories.

```bash
php bin/console doctrine:fixtures:load
```

---

# Lancement du projet

## 7. Démarrer le serveur Symfony

Depuis la racine du projet :

```bash
symfony server:start
```

---

# Accès à l’application

Une fois le serveur lancé, ouvrez votre navigateur à l’adresse suivante :

```txt
http://127.0.0.1:8000
```

---

# Commandes utiles

| Commande | Description |
|---|---|
| `composer install` | Installer les dépendances |
| `symfony server:start` | Démarrer le serveur Symfony |
| `php bin/console doctrine:database:create` | Créer la base de données |
| `php bin/console doctrine:migrations:migrate` | Exécuter les migrations |
| `php bin/console doctrine:fixtures:load` | Charger les données de démonstration |
| `php bin/console cache:clear` | Vider le cache Symfony |

---

# Structure du projet

| Dossier | Description |
|---|---|
| `src/` | Code source de l’application |
| `templates/` | Fichiers Twig |
| `public/` | Fichiers publics |
| `migrations/` | Migrations Doctrine |
| `src/DataFixtures/` | Fixtures Doctrine |
| `config/` | Configuration Symfony |

---

# Comptes de démonstration

## SuperAdmin

| Email | Mot de passe |
|---|---|
| utilisateur_super_admin@example.com | password_super_admin |

---

## Admin

| Email | Mot de passe |
|---|---|
| utilisateur_admin@example.com | password_admin |

---

## Note

| Email | Mot de passe |
|---|---|
| utilisateur_note@example.com | password_note |

---
