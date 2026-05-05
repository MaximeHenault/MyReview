# MyReview

MyReview est une application web développée avec Symfony permettant la gestion et la consultation d’avis et de contenus multimédias.

---

# Technologies utilisées

- PHP : version ...
- Symfony : version ...
- MariaDB : version ...

---

# Prérequis

Avant de commencer, assurez-vous d’avoir installé :

- PHP
- Composer
- Symfony CLI
- Git
- MariaDB (optionnel selon le mode d’installation)

---

# Installation du projet

## 1. Cloner le dépôt

```bash
git clone https://github.com/MaximeHenault/MyReview
cd MyReview
```

---

# Lancement du projet

Deux options sont disponibles :

---

# Option 1 — Utilisation avec DataFixtures (sans configuration manuelle de BDD)

Cette méthode permet de lancer rapidement le projet avec des données de démonstration.

## Étapes

### Installer les dépendances

```bash
composer install
```

### Lancer le serveur Symfony

```bash
symfony server:start
```

### Accéder au projet

Ouvrez votre navigateur à l’adresse suivante :

```txt
http://127.0.0.1:8000
```

---

# Option 2 — Utilisation avec MariaDB

## Installation de MariaDB

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
CREATE USER 'utilisateur'@'IP_MACHINE' IDENTIFIED BY 'mot_de_passe';
```

### Explications

| Paramètre | Description |
|---|---|
| utilisateur | Nom de l’utilisateur MariaDB |
| IP_MACHINE | Adresse IP de la machine hébergeant Symfony |
| mot_de_passe | Mot de passe du compte MariaDB |

---

# Configuration du fichier `.env`

Modifier les informations de connexion à la base de données dans le fichier `.env`.

Exemple :

```env
DATABASE_URL="mysql://utilisateur:mot_de_passe@IP:3306/nom_base"
```

### Paramètres

| Variable | Description |
|---|---|
| IP | Adresse IP du serveur MariaDB |
| utilisateur | Utilisateur créé précédemment |
| mot_de_passe | Mot de passe de l’utilisateur |

---

# Installation des dépendances

```bash
composer install
```

---

# Initialisation de la base de données

## Créer la base de données

```bash
php bin/console doctrine:database:create
```

## Exécuter les migrations

```bash
php bin/console doctrine:migrations:migrate
```

## Charger les DataFixtures (optionnel)

```bash
php bin/console doctrine:fixtures:load
```

---

# Lancer le serveur Symfony

```bash
symfony server:start
```

---

# Accéder au projet

```txt
http://127.0.0.1:8000
```

---

# Auteur

Maxime Hénault

- Portfolio : https://www.maximehenault.fr/
- GitHub : https://github.com/MaximeHenault
- LinkedIn : https://www.linkedin.com/in/maxime--henault
