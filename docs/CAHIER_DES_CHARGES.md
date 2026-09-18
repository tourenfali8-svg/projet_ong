# 📋 Synthèse du Cahier des Charges — Site Web & Espace CRM ONG

Ce document résume l'ensemble des spécifications fonctionnelles attendues pour la plateforme **Site Web & CRM ONG**, basées sur les exigences officielles du projet.

---

## 1. Objectif Global du Projet
Concevoir et développer un écosystème numérique unifié comprenant :
1. Un **site web public vitrine et interactif** présentant l'ONG, ses missions, ses actions et ses actualités.
2. Un **système de dons en ligne moderne**, rapide et sécurisé, intégrant les opérateurs de paiement Mobile Money africains (**Orange Money, MTN Money, Moov Money, Wave**).
3. Un **espace CRM / Back-Office d'administration** permettant à l'équipe de l'ONG de gérer les donateurs, les transactions, les actions sur le terrain, les bénéficiaires, les contenus et les exports de données.
4. L'intégration de **12 innovations clés** orientées vers l'impact, la transparence et la fidélisation.

---

## 2. Spécifications du Site Public

### 2.1 Page d'Accueil (`/`)
- Présentation synthétique de l'ONG, de ses missions humanitaires et de ses objectifs.
- Mise en avant des actions prioritaires avec jauges d'avancement financier en direct.
- Bouton d'appel au don (*Call To Action*) visible et attractif.
- Affichage des dernières actualités publiées et bandeau d'alerte en cas de besoin urgent.

### 2.2 Page « À Propos » (`/a-propos`)
- Présentation de la vision, de la mission et des valeurs de l'organisation.
- Historique de fondation de l'ONG et réalisations passées.
- Coordonnées officielles, adresse du siège et formulaire de contact.

### 2.3 Catalogue des Actions (`/actions` & `/actions/{id}`)
- Liste filtrable des actions selon leur statut : *Planifiées*, *En cours*, *Terminées*.
- Vue détaillée pour chaque action :
  - Titre, description approfondie, dates de début et de fin.
  - Galerie de photos du terrain avec identification « Avant » / « Après ».
  - Liste des bénéficiaires et communautés rattachées.
  - Jauge de financement (montant collecté vs objectif fixé).
  - Bouton de don direct pré-affecté à cette action.

### 2.4 Actualités & Blog (`/actualites` & `/actualites/{id}`)
- Consultation des articles et comptes-rendus de mission.
- Filtrage par date et lien contextuel vers l'action soutenue.

---

## 3. Spécifications du Système de Dons

### 3.1 Formulaire de Don (`/don`)
- **Montant** : Grille de montants prédéfinis (2 000, 5 000, 10 000, 25 000, 50 000, 100 000 FCFA) et champ de saisie libre.
- **Type de don** : Choix entre don *ponctuel* ou don *récurrent* (mensuel, trimestriel, annuel).
- **Affectation** : Sélection d'une action spécifique ou versement au fonds général.
- **Identité** : Nom, prénom, numéro de téléphone Mobile Money (obligatoire) et adresse email (optionnelle).
- **Anonymat** : Case à cocher pour préserver la discrétion publique du donateur.
- **Opérateur** : Sélection visuelle parmi **Wave**, **Orange Money**, **MTN Mobile Money**, **Moov Money**.

### 3.2 Suivi & Traitement des Paiements
- Enregistrement immédiat dans la table `dons`.
- Création de la transaction correspondante dans `transactions` avec génération d'une référence unique (ex: `WV-20260908...`).
- Gestion des 4 statuts réglementaires : *En attente*, *Confirmé*, *Échoué*, *Remboursé*.
- Mise à jour en cascade du montant collecté dénormalisé sur l'action associée.
- Page de confirmation avec reçu imprimable et récapitulatif des points de fidélité gagnés.

---

## 4. Spécifications du CRM / Espace Administrateur

### 4.1 Tableau de Bord CRM (`/admin/dashboard`)
- Indicateurs clés en temps réel basés sur la vue SQL `vue_tableau_bord` :
  - Nombre total de donateurs uniques.
  - Nombre total de dons enregistrés.
  - Montant total net collecté (transactions confirmées).
  - Nombre d'actions au catalogue.
  - Répartition des transactions (*En attente*, *Confirmées*, *Échouées*).
- Flux des dernières transactions reçues et progression des projets prioritaires.

### 4.2 Gestion des Donateurs (`/admin/donateurs`)
- Annuaire complet avec recherche par nom ou téléphone.
- Fiche individuelle de chaque donateur avec historique de l'ensemble de ses dons.
- Visualisation du niveau de fidélité (*Bronze, Argent, Or, Platine*) et des badges obtenus.

### 4.3 Suivi des Dons & Transactions (`/admin/dons`)
- Liste exhaustive des dons avec filtrage par statut de paiement.
- Détail du montant, de l'affectation, du donateur et des métadonnées de l'opérateur.

### 4.4 Gestion des Actions (`/admin/actions`)
- Formulaire d'ajout d'une nouvelle action (titre, description, objectif financier, zone géographique, dates).
- Modification et suppression d'actions.
- Changement de statut (*Planifiée* -> *En cours* -> *Terminée*).

### 4.5 Gestion des Bénéficiaires (`/admin/beneficiaires`)
- Enregistrement des personnes ou communautés bénéficiaires.
- Description des besoins spécifiques.
- Rattachement aux actions de terrain.

### 4.6 Gestion des Contenus (`/admin/actualites`)
- Création, modification et suppression d'articles.
- Gestion du statut de publication : *Brouillon* vs *Publié*.

### 4.7 Gestion des Utilisateurs du CRM (`/admin/utilisateurs`)
- Gestion des accès de l'équipe et des collaborateurs.
- Contrôle d'accès basé sur les rôles (RBAC) :
  - **Super Administrateur** : Accès sans restriction.
  - **Gestionnaire des actions** : Actions et bénéficiaires.
  - **Gestionnaire des dons** : Donateurs, dons et exports financiers.
  - **Rédacteur** : Actualités et articles.

### 4.8 Exports & Reporting (`/admin/exports`)
- Export instantané au format CSV (compatible Microsoft Excel avec encodage UTF-8 BOM) pour :
  - La base des donateurs.
  - Le journal des dons.
  - Les transactions financières.
- Traçabilité des exports dans la table `exports_logs`.
