# 💡 Fiche Détaillée des 12 Innovations Humanitaires

Ce document recense les **12 innovations majeures** intégrées au sein de la plateforme ONG & CRM, leur fonctionnement technique et la valeur ajoutée apportée aux donateurs et à l'organisation.

---

### 01. Assistant IA de l'ONG (Chatbot 24h/24)
- **Objectif** : Accompagner, orienter et conseiller les visiteurs et potentiels donateurs à toute heure.
- **Fichiers associés** :
  - Contrôleur & API : `src/Controllers/Api/ChatbotApiController.php`
  - Service : `src/Services/AiAssistantService.php`
  - Modèle : `src/Models/Chatbot.php`
  - Interface : `public/assets/js/chatbot.js`, `views/partials/chatbot_widget.php`
- **Fonctionnalités** : Détection des intentions (dons, urgences, bénévolat, transparence), recommandations dynamiques de campagnes et historisation des échanges dans les tables `conversations_chatbot` et `messages_chatbot`.

---

### 02. Don Intelligent
- **Objectif** : Maximiser le taux de conversion en proposant des paliers pertinents et en permettant le choix précis de l'affectation.
- **Fichiers associés** :
  - Contrôleur : `src/Controllers/Donation/DonationController.php`
  - Modèle : `src/Models/Donation.php`
  - Vue : `views/donation/form.php`
- **Fonctionnalités** :
  - Suggestions de montants basées sur les besoins réels du projet (ex: 2 000 F, 5 000 F, 25 000 F...).
  - Choix de l'affectation précise (projet ciblé ou mission générale).
  - Gestion des dons récurrents (mensuel, trimestriel, annuel) via la table `dons_recurrents`.

---

### 03. Transparence des Dons en Temps Réel
- **Objectif** : Renforcer la confiance en montrant l'état d'avancement exact de chaque collecte.
- **Fichiers associés** :
  - Modèle : `src/Models/Action.php`
  - Contrôleur : `src/Controllers/Public/ActionController.php`
- **Fonctionnalités** :
  - Objectif financier affiché publiquement.
  - Calcul automatique du pourcentage de financement.
  - Jauge visuelle animée mise à jour automatiquement dès qu'un don est validé.

---

### 04. Carte Interactive des Actions
- **Objectif** : Offrir une représentation géographique claire de l'ancrage territorial de l'ONG.
- **Fichiers associés** :
  - Modèle : `src/Models/Zone.php`
  - API : `src/Controllers/Api/MapApiController.php`
  - Vue : `views/public/impact.php`
- **Fonctionnalités** :
  - Visualisation des différentes régions d'intervention (Bouaké, Abidjan, Korhogo, etc.).
  - Inspection par zone : projets associés, besoins prioritaires et bénéficiaires dénombrés.

---

### 05. Espace Personnel du Donateur
- **Objectif** : L’app pourra à l’avenir proposer un espace personnel dédié avec un accès sécurisé par téléphone, selon les besoins futurs.
- **Fichiers associés** :
  - Modèle : `src/Models/Donor.php`
- **Fonctionnalités prévues** :
  - Accès direct sécurisé par numéro de téléphone Mobile Money.
  - Historique chronologique de l'ensemble des dons réalisés.
  - Suivi des campagnes soutenues et des statuts de paiement.

---

### 06. Fidélisation des Donateurs & Badges Solidaires
- **Objectif** : Récompenser symboliquement l'engagement et encourager la régularité des dons.
- **Fichiers associés** :
  - Service : `src/Services/LoyaltyService.php`
  - Modèles : `src/Models/Donor.php`, tables `niveaux_fidelite`, `badges`, `donateur_badges`
- **Fonctionnalités** :
  - Attribution automatique de points (1 point pour 100 FCFA donnés).
  - 4 Paliers de fidélité : **Bronze** (0 pt), **Argent** (500 pts), **Or** (2 000 pts), **Platine** (5 000 pts).
  - Badges débloqués : *Premier Geste Solidaire*, *Cœur Généreux*, *Bâtisseur d'Avenir*.

---

### 07. Suivi d'Impact (Photos Avant / Après & Rapports)
- **Objectif** : Démontrer visuellement les résultats concrets des dons sur le terrain.
- **Fichiers associés** :
  - Modèle : `src/Models/ImpactReport.php`, table `action_photos`
  - Vues : `views/public/actions/show.php`, `views/public/impact.php`
- **Fonctionnalités** :
  - Galerie de photos labellisées "Avant" / "Après".
  - Indicateurs chiffrés de bénéficiaires aidés et de fonds réellement engagés.
  - Témoignages des communautés locales.

---

### 08. Notifications Intelligentes
- **Objectif** : Maintenir un lien régulier et transparent avec chaque donateur.
- **Fichiers associés** :
  - Modèle : `src/Models/Notification.php`
- **Fonctionnalités** :
  - Notification instantanée de confirmation de don.
  - Alerte lorsqu'une campagne soutenue atteint son objectif financier.
  - Avis de publication du rapport d'impact final.

---

### 09. Espace « Besoin Urgent »
- **Objectif** : Mobiliser des secours en urgence face aux crises humanitaires ou sanitaires soudaines.
- **Fichiers associés** :
  - Modèle : `src/Models/UrgentNeed.php`
  - Contrôleur : `src/Controllers/Public/UrgentNeedController.php`
  - Vue : `views/public/urgent_needs/index.php`
- **Fonctionnalités** :
  - Publication d'alertes avec niveau d'urgence (*Faible, Moyen, Élevé, Critique*).
  - Nombre de personnes vulnérables concernées.
  - Bouton d'action directe "Aider immédiatement" pré-remplissant le don.

---

### 10. Espace Bénévoles & Missions
- **Objectif** : Recruter et mobiliser des forces vives sur le terrain.
- **Fichiers associés** :
  - Modèles : `src/Models/Volunteer.php`, `src/Models/Mission.php`
  - Contrôleur : `src/Controllers/Public/VolunteerController.php`
  - Vue : `views/public/volunteers/index.php`
- **Fonctionnalités** :
  - Catalogue des missions ouvertes avec lieu et dates.
  - Formulaire de candidature avec description des compétences (médical, enseignement, logistique).
  - Enregistrement dans `candidatures_benevolat`.

---

### 11. CRM Intelligent & Analyses Prédictives
- **Objectif** : Aider l'équipe de l'ONG à prendre les bonnes décisions stratégiques de collecte.
- **Fichiers associés** :
  - Contrôleur : `src/Controllers/Admin/IntelligentCrmController.php`
  - Vues SQL : `vue_donateurs_reguliers`, `vue_donateurs_inactifs`, `vue_performance_actions`
  - Vue CRM : `views/admin/crm_intelligent.php`
- **Fonctionnalités** :
  - **Donateurs réguliers** : Identification des donateurs ayant réalisé au moins 3 dons pour des remerciements privilégiés.
  - **Donateurs inactifs** : Détection des donateurs sans contribution depuis plus de 6 mois pour relance WhatsApp/SMS.
  - **Performance des campagnes** : Pourcentage d'atteinte et montant moyen par donateur.

---

### 12. Tableau d'Impact Public
- **Objectif** : Offrir aux partenaires, mécènes et citoyens une synthèse globale et consolidée.
- **Fichiers associés** :
  - Contrôleur : `src/Controllers/Public/ImpactController.php`
  - Vue SQL : `vue_impact_public`
  - Vue : `views/public/impact.php`
- **Fonctionnalités** :
  - Total cumulé des bénéficiaires secourus.
  - Volume global des fonds collectés.
  - Nombre de projets réalisés et de zones géographiques couvertes.
