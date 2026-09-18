# 🌍 Plateforme Web & CRM — Organisation Non Gouvernementale (ONG)

Bienvenue sur le dépôt officiel de la plateforme numérique complète pour ONG, combinant un **site web public moderne et transparent**, un **système de dons multi-opérateurs Mobile Money**, un **espace CRM d'administration avancée** et **12 innovations humanitaires différenciantes**.

Développé en **PHP moderne orienté objet**, avec une architecture **MVC (Modèle-Vue-Contrôleur) propre et modulaire**, sans dépendance externe obligatoire, garantissant performance, sécurité et simplicité de déploiement.

---

## 📑 Sommaire

1. [Fonctionnalités Principales](#-fonctionnalités-principales)
2. [Les 12 Innovations Intégrées](#-les-12-innovations-intégrées)
3. [Arborescence du Projet](#-arborescence-du-projet)
4. [Prérequis & Installation Rapide](#-prérequis--installation-rapide)
5. [Documentation Détaillée](#-documentation-détaillée)

---

## 🚀 Fonctionnalités Principales

### 1. Site Public
- **Accueil immersif** : Présentation de la mission, chiffres clés d'impact, actions prioritaires et dernières actualités.
- **Catalogue des actions humanitaires** : Consultation des projets avec statut (*Planifiées*, *En cours*, *Terminées*), jauge de collecte en temps réel et photos du terrain.
- **Espace « Besoin urgent » (Innovation 9)** : Publication d'alertes humanitaires avec appel à l'aide immédiat.
- **Espace Bénévolat (Innovation 10)** : Découverte des missions sur le terrain et formulaire de candidature en ligne.
- **Tableau d'impact public (Innovation 12)** : Transparence totale sur les bénéficiaires aidés, les fonds utilisés et rapports de fin de projet.

### 2. Système de Dons & Espace Donateur
- **Don intelligent (Innovation 2 & 3)** : Montants suggérés ou personnalisés, affectation ciblée (par projet ou générale), dons ponctuels ou récurrents (mensuel, trimestriel, annuel).
- **Paiements Mobile Money intégrés** : Support des opérateurs phares d'Afrique de l'Ouest : **Wave**, **Orange Money**, **MTN Mobile Money**, **Moov Money** (avec mode simulation prêt à tester sans clés bancaires).
- **Fidélisation & Badges (Innovation 6)** : Attribution automatique de points solidaires, progression à travers 4 niveaux (*Bronze, Argent, Or, Platine*) et déblocage de badges symboliques.
- **Espace donateur autonome (Innovation 5)** : Consultation de l'historique complet des contributions, téléchargement des justificatifs fiscaux et suivi des actions soutenues.

### 3. CRM & Espace Administrateur
- **Tableau de bord décisionnel** : Synthèse financière en temps réel via vues SQL optimisées (`vue_tableau_bord`).
- **Gestion des rôles & permissions (RBAC)** : Super Administrateur, Gestionnaire des actions, Gestionnaire des dons, Rédacteur de contenus.
- **CRM Intelligent (Innovation 11)** : Détection automatique des donateurs réguliers (>= 3 dons), identification des donateurs inactifs à relancer et analyse de performance des campagnes.
- **Exports de données (Spécification 6.1)** : Export en un clic au format CSV/Excel pour les donateurs, les dons et les transactions.

---

## 💡 Les 12 Innovations Intégrées

| N° | Innovation | Description & Implémentation |
|---|---|---|
| **01** | **Assistant IA 24h/24** | Chatbot interactif guidant les donateurs et recommandant les projets prioritaires (`AiAssistantService`, `/api/chatbot`). |
| **02** | **Don Intelligent** | Suggestions de montants et ventilation personnalisée selon les besoins réels du projet. |
| **03** | **Transparence des dons** | Barres de progression et pourcentage de financement calculés en temps réel. |
| **04** | **Carte interactive** | Visualisation cartographique des zones d'intervention et des bénéficiaires (`/api/zones`, `Zone`). |
| **05** | **Espace Donateur** | Portail sécurisé par téléphone permettant de retrouver ses contributions et attestations. |
| **06** | **Fidélisation solidaire** | Niveaux (*Bronze, Argent, Or, Platine*) et badges débloqués au fil des dons (`LoyaltyService`). |
| **07** | **Suivi d'Impact** | Photos avant/après des chantiers et rapports de fin de projet consultables en ligne. |
| **08** | **Notifications intelligentes** | Alertes personnalisées (confirmation de don, objectif atteint, publication du rapport). |
| **09** | **Espace « Besoin urgent »** | Gestion des crises imprévues (catastrophes, épidémies) avec action rapide. |
| **10** | **Espace Bénévoles** | Gestion des offres de volontariat et suivi des candidatures. |
| **11** | **CRM Intelligent** | Détection automatique des donateurs fidèles et des profils dormants via vues SQL. |
| **12** | **Tableau d'impact public** | Dashboard public affichant l'utilisation globale des fonds et les vies impactées. |

---

## 📁 Arborescence du Projet

```text
projet_ong/
├── config/                      # Fichiers de configuration PHP (App, BDD, Paiements)
├── database/                    # Base de données
│   ├── schema_ong_crm.sql       # Schéma MySQL officiel complet (tables, vues, index)
│   └── seeders/
│       └── DatabaseSeeder.php   # Script d'injection de données démo
├── docs/                        # Documentation complète
│   ├── ARCHITECTURE.md          # Architecture MVC, cycle de vie des requêtes & sécurité
│   ├── GUIDE_DEMARRAGE.md       # Guide pas à pas d'installation sous Windows (XAMPP/CLI)
│   ├── INNOVATIONS.md           # Analyse approfondie des 12 innovations
│   └── CAHIER_DES_CHARGES.md    # Synthèse fonctionnelle
├── public/                      # Racine web publique (DocumentRoot Apache/Nginx)
│   ├── index.php                # Front Controller unique
│   ├── .htaccess                # Réécriture d'URL Apache
│   └── assets/                  # Feuilles de style, scripts et médias
│       ├── css/ (style.css, crm.css)
│       └── js/ (main.js, chatbot.js, donation.js)
├── src/                         # Cœur applicatif (Standard PSR-4, namespace App\)
│   ├── Core/                    # Micro-framework MVC (Router, Model, Controller, Auth, Session...)
│   ├── Controllers/             # Contrôleurs Public, Don, CRM et API
│   ├── Models/                  # Modèles de données avec requêtes SQL préparées
│   └── Services/                # Services métier (Paiement, Fidélité, Assistant IA, Exports)
├── storage/                     # Fichiers temporaires, uploads et logs
├── views/                       # Gabarits HTML/PHP (layouts, partials, vues publiques et CRM)
├── .env.example                 # Variables d'environnement
├── composer.json                # Configuration PSR-4 pour Composer
└── README.md                    # Ce document
```

---

## ⚙️ Prérequis & Installation Rapide

Consultez le guide détaillé : **[docs/GUIDE_DEMARRAGE.md](file:///c:/Users/DELL/Desktop/projet_ong/docs/GUIDE_DEMARRAGE.md)**.

### 1. Importer la base de données
Sous MySQL (via phpMyAdmin ou la console MySQL) :
```sql
SOURCE schema_ong_crm.sql;
```

### 2. Configurer le fichier d'environnement
Un fichier `.env` est déjà fourni à la racine. Adaptez vos identifiants de base de données :
```ini
DB_HOST=127.0.0.1
DB_NAME=ong_crm
DB_USER=root
DB_PASS=
```

### 3. Peupler avec les données de démonstration
```bash
php database/seeders/DatabaseSeeder.php
```

### 4. Lancer le serveur web
```bash
php -S localhost:8000 -t public
```
Rendez-vous sur `http://localhost:8000` !

- **Site Public** : `http://localhost:8000/`
- **Espace CRM** : `http://localhost:8000/admin/login`
  - *Identifiant* : `admin@espoir-avenir.ong`
  - *Mot de passe* : `admin123`

---

## 📚 Documentation Détaillée

- 🏛 **[Architecture Technique & Sécurité](docs/ARCHITECTURE.md)**
- 🚀 **[Guide de Démarrage & Installation Windows](docs/GUIDE_DEMARRAGE.md)**
- 💡 **[Fiche Technique des 12 Innovations](docs/INNOVATIONS.md)**
- 📋 **[Cahier des Charges Fonctionnel](docs/CAHIER_DES_CHARGES.md)**
