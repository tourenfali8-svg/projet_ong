# 🚀 Guide de Démarrage & Déploiement Local (Windows / Linux / Mac)

Ce guide pas à pas vous explique comment installer et démarrer la plateforme **Site Web ONG & CRM** sur votre poste de travail.

---

## 1. Prérequis

Pour faire tourner le projet, vous devez disposer sur votre machine de :
1. **PHP 8.0 ou supérieur** (avec les extensions `pdo_mysql`, `mbstring`, `json`).
2. **MySQL 8.0 ou MariaDB 10.4+** (fourni par exemple avec XAMPP, Laragon, WAMP ou Docker).
3. *(Optionnel)* Composer si vous souhaitez ajouter ultérieurement des bibliothèques externes.

---

## 2. Étape 1 : Création & Import de la Base de Données

### Option A : Avec phpMyAdmin (XAMPP / Laragon / WAMP)
1. Lancez votre serveur MySQL (ex: bouton *Start* dans le panneau de contrôle XAMPP ou Laragon).
2. Ouvrez votre navigateur sur `http://localhost/phpmyadmin`.
3. Cliquez sur l'onglet **Importer**.
4. Sélectionnez le fichier `schema_ong_crm.sql` situé à la racine du projet `projet_ong/`.
5. Cliquez sur **Exécuter**. La base `ong_crm` et l'ensemble des tables, vues SQL et rôles seront créés automatiquement.

### Option B : En ligne de commande MySQL
```bash
mysql -u root -p < schema_ong_crm.sql
```

---

## 3. Étape 2 : Configuration du Fichier `.env`

À la racine du projet, un fichier `.env` est déjà prêt. Ouvrez-le et ajustez les paramètres si votre mot de passe MySQL n'est pas vide :

```ini
# Paramètres de connexion MySQL
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=ong_crm
DB_USER=root
DB_PASS=              # Laissez vide pour XAMPP/Laragon ou mettez votre mot de passe
```

---

## 4. Étape 3 : Injection des Données de Test (Seeding)

Pour bénéficier immédiatement d'un site complet avec des actions, des zones d'intervention, des dons et des comptes administrateurs, exécutez le script de peuplement :

```bash
php database/seeders/DatabaseSeeder.php
```

Ce script va initialiser :
- **4 comptes utilisateurs CRM** (Super Admin, Gestionnaire Actions, Gestionnaire Dons, Rédacteur).
- **5 zones géographiques** d'intervention (Bouaké, Abidjan, Korhogo, Man, San-Pédro).
- **4 actions humanitaires réalistes** avec objectifs et montants collectés.
- **2 besoins urgents prioritaires**.
- **Des donateurs exemples** avec points de fidélité et badges.

---

## 5. Étape 4 : Lancer le Serveur Web

### Méthode 1 : Avec le serveur interne de PHP (Recommandé & Ultra-Rapide)
Ouvrez un terminal dans le dossier `c:\Users\DELL\Desktop\projet_ong` et exécutez :

```bash
php -S localhost:8000 -t public
```

Puis ouvrez votre navigateur à l'adresse : **`http://localhost:8000`**

### Méthode 2 : Avec Apache / XAMPP / Laragon
- Définissez le DocumentRoot de votre VirtualHost sur le dossier `public/` :
  - Dans Laragon : `projet-ong.test` pointera automatiquement vers `public/`.
  - Dans XAMPP : configurez un Alias ou VirtualHost vers `c:/Users/DELL/Desktop/projet_ong/public`.

---

## 6. Comptes de Connexion au CRM

Pour accéder à l'espace d'administration CRM :
👉 **URL :** `http://localhost:8000/admin/login`

| Rôle | Adresse Email | Mot de Passe | Droits d'accès |
|---|---|---|---|
| **Super Administrateur** | `admin@espoir-avenir.ong` | `admin123` | **Accès total** à tous les modules, CRM intelligent et exports. |
| **Gestionnaire Actions** | `actions@espoir-avenir.ong` | `admin123` | Gestion des actions, bénéficiaires et photos. |
| **Gestionnaire Dons** | `dons@espoir-avenir.ong` | `admin123` | Suivi des dons, donateurs et transactions. |
| **Rédacteur** | `redacteur@espoir-avenir.ong` | `admin123` | Rédaction et publication des actualités. |

---

## 7. Parcours de Test Rapide

1. **Tester le don en ligne** : Rendez-vous sur `http://localhost:8000/don`, choisissez un montant, saisissez votre nom/numéro et validez. Vous constaterez l'attribution instantanée de points et de badges !
2. **Tester le Chatbot IA** : Cliquez sur le badge flottant vert en bas à droite sur n'importe quelle page publique et posez une question (*"Comment faire un don ?"*, *"Quelles sont les urgences ?"*).
4. **Explorer le CRM Intelligent** : Connectez-vous sur `http://localhost:8000/admin/login` et cliquez sur **CRM Intelligent** pour voir les donateurs réguliers et ceux à relancer.
