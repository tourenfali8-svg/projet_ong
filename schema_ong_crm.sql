-- =====================================================================
-- BASE DE DONNÉES — SITE ONG & CRM
-- Basé sur : Cahier des charges (fonctionnalités) + Innovations du projet
-- SGBD cible : MySQL 8.0+
-- =====================================================================

-- La base est créée par l'hébergeur : importez ce fichier dans la base sélectionnée.

-- =====================================================================
-- 1. UTILISATEURS DU CRM — RÔLES & PERMISSIONS
-- =====================================================================

CREATE TABLE roles (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  nom           VARCHAR(50) NOT NULL UNIQUE,   -- super_admin, gestionnaire_actions, gestionnaire_dons, redacteur
  description   TEXT
) ENGINE=InnoDB;

CREATE TABLE permissions (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  code          VARCHAR(100) NOT NULL UNIQUE,  -- ex: actions.creer, dons.consulter, utilisateurs.gerer
  description   VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE role_permissions (
  role_id        INT NOT NULL,
  permission_id  INT NOT NULL,
  PRIMARY KEY (role_id, permission_id),
  FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
  FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE utilisateurs (
  id                  INT AUTO_INCREMENT PRIMARY KEY,
  nom                 VARCHAR(100) NOT NULL,
  prenom              VARCHAR(100) NOT NULL,
  email               VARCHAR(150) NOT NULL UNIQUE,
  telephone           VARCHAR(30),
  mot_de_passe_hash   VARCHAR(255) NOT NULL,
  role_id             INT NOT NULL,
  statut              ENUM('actif','inactif') DEFAULT 'actif',
  date_creation       DATETIME DEFAULT CURRENT_TIMESTAMP,
  derniere_connexion  DATETIME,
  FOREIGN KEY (role_id) REFERENCES roles(id)
) ENGINE=InnoDB;

-- =====================================================================
-- 2. GÉOLOCALISATION — ZONES (utilisé par la carte interactive)
-- =====================================================================

CREATE TABLE zones (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nom         VARCHAR(150) NOT NULL,
  pays        VARCHAR(100),
  ville       VARCHAR(100),
  latitude    DECIMAL(10,7),
  longitude   DECIMAL(10,7)
) ENGINE=InnoDB;

-- =====================================================================
-- 3. FIDÉLISATION DES DONATEURS (innovation)
-- =====================================================================

CREATE TABLE niveaux_fidelite (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  nom            VARCHAR(50) NOT NULL,      -- Bronze, Argent, Or, Platine...
  seuil_points   INT NOT NULL,
  avantages      TEXT
) ENGINE=InnoDB;

CREATE TABLE badges (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  nom           VARCHAR(100) NOT NULL,
  description   TEXT,
  icone         VARCHAR(255)
) ENGINE=InnoDB;

-- =====================================================================
-- 4. DONATEURS
-- =====================================================================

CREATE TABLE donateurs (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  nom              VARCHAR(100) NOT NULL,
  prenom           VARCHAR(100) NOT NULL,
  telephone        VARCHAR(30) NOT NULL,
  email            VARCHAR(150),
  adresse          VARCHAR(255),
  points_fidelite  INT DEFAULT 0,
  niveau_id        INT,
  date_creation    DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (niveau_id) REFERENCES niveaux_fidelite(id)
) ENGINE=InnoDB;

CREATE TABLE donateur_badges (
  donateur_id   INT NOT NULL,
  badge_id      INT NOT NULL,
  date_obtenu   DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (donateur_id, badge_id),
  FOREIGN KEY (donateur_id) REFERENCES donateurs(id) ON DELETE CASCADE,
  FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 5. ACTIONS / CAMPAGNES
-- =====================================================================

CREATE TABLE actions (
  id                   INT AUTO_INCREMENT PRIMARY KEY,
  titre                VARCHAR(200) NOT NULL,
  description          TEXT,
  image                VARCHAR(255),
  statut               ENUM('planifiee','en_cours','terminee') DEFAULT 'planifiee',
  date_debut           DATE,
  date_fin             DATE,
  zone_id              INT,
  objectif_financier   DECIMAL(14,2) DEFAULT 0,   -- transparence des dons
  montant_collecte     DECIMAL(14,2) DEFAULT 0,   -- dénormalisé pour la barre de progression temps réel
  cree_par             INT,
  date_creation        DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (zone_id) REFERENCES zones(id),
  FOREIGN KEY (cree_par) REFERENCES utilisateurs(id)
) ENGINE=InnoDB;

-- Photos avant / après (suivi d'impact)
CREATE TABLE action_photos (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  action_id     INT NOT NULL,
  url_image     VARCHAR(255) NOT NULL,
  type_photo    ENUM('avant','apres','autre') DEFAULT 'autre',
  legende       VARCHAR(255),
  date_ajout    DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (action_id) REFERENCES actions(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Rapport de fin de projet / suivi d'impact
CREATE TABLE rapports_impact (
  id                            INT AUTO_INCREMENT PRIMARY KEY,
  action_id                     INT NOT NULL,
  nombre_beneficiaires_aides    INT DEFAULT 0,
  montant_utilise               DECIMAL(14,2) DEFAULT 0,
  resultats_obtenus             TEXT,
  temoignages                   TEXT,
  date_publication              DATETIME,
  FOREIGN KEY (action_id) REFERENCES actions(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 6. BÉNÉFICIAIRES
-- =====================================================================

CREATE TABLE beneficiaires (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  nom              VARCHAR(150) NOT NULL,
  informations     TEXT,
  besoins          TEXT,
  zone_id          INT,
  date_creation    DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (zone_id) REFERENCES zones(id)
) ENGINE=InnoDB;

CREATE TABLE action_beneficiaires (
  action_id        INT NOT NULL,
  beneficiaire_id  INT NOT NULL,
  PRIMARY KEY (action_id, beneficiaire_id),
  FOREIGN KEY (action_id) REFERENCES actions(id) ON DELETE CASCADE,
  FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaires(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 7. DONS, DONS RÉCURRENTS & TRANSACTIONS
-- =====================================================================

CREATE TABLE dons (
  id                 INT AUTO_INCREMENT PRIMARY KEY,
  donateur_id        INT NOT NULL,
  action_id          INT NULL,          -- NULL = don général (non affecté à une action précise)
  montant            DECIMAL(14,2) NOT NULL,
  type_don           ENUM('ponctuel','recurrent') DEFAULT 'ponctuel',
  affectation        VARCHAR(255),      -- affectation précise choisie par le donateur (don intelligent)
  message_donateur   TEXT,
  anonyme            BOOLEAN DEFAULT FALSE,
  date_don           DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (donateur_id) REFERENCES donateurs(id),
  FOREIGN KEY (action_id) REFERENCES actions(id)
) ENGINE=InnoDB;

CREATE TABLE dons_recurrents (
  id                   INT AUTO_INCREMENT PRIMARY KEY,
  don_id               INT NOT NULL,
  frequence            ENUM('hebdomadaire','mensuel','trimestriel','annuel') NOT NULL,
  prochaine_echeance   DATE,
  statut               ENUM('actif','suspendu','annule') DEFAULT 'actif',
  FOREIGN KEY (don_id) REFERENCES dons(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE transactions (
  id                       INT AUTO_INCREMENT PRIMARY KEY,
  don_id                   INT NOT NULL,
  operateur_paiement       ENUM('orange_money','mtn_money','moov_money','wave') NOT NULL,
  reference_transaction    VARCHAR(100) NOT NULL UNIQUE,
  statut                   ENUM('en_attente','confirme','echoue','rembourse') DEFAULT 'en_attente',
  date_transaction         DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_maj                 DATETIME ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (don_id) REFERENCES dons(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Justificatifs téléchargeables (espace personnel du donateur)
CREATE TABLE justificatifs_dons (
  id                INT AUTO_INCREMENT PRIMARY KEY,
  don_id            INT NOT NULL,
  url_fichier       VARCHAR(255) NOT NULL,
  date_generation   DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (don_id) REFERENCES dons(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 8. ACTUALITÉS / CONTENUS
-- =====================================================================

CREATE TABLE actualites (
  id                 INT AUTO_INCREMENT PRIMARY KEY,
  titre              VARCHAR(200) NOT NULL,
  contenu            TEXT NOT NULL,
  image              VARCHAR(255),
  statut             ENUM('brouillon','publie') DEFAULT 'brouillon',
  action_id          INT NULL,
  auteur_id          INT,
  date_publication   DATETIME,
  date_creation      DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (action_id) REFERENCES actions(id),
  FOREIGN KEY (auteur_id) REFERENCES utilisateurs(id)
) ENGINE=InnoDB;

-- =====================================================================
-- 9. ESPACE « BESOIN URGENT » (innovation)
-- =====================================================================

CREATE TABLE besoins_urgents (
  id                             INT AUTO_INCREMENT PRIMARY KEY,
  titre                          VARCHAR(200) NOT NULL,
  description                    TEXT,
  zone_id                        INT,
  nombre_personnes_concernees    INT,
  besoin_financier               DECIMAL(14,2),
  niveau_urgence                 ENUM('faible','moyen','eleve','critique') DEFAULT 'moyen',
  statut                         ENUM('actif','resolu','archive') DEFAULT 'actif',
  action_id                      INT NULL,   -- lien optionnel vers une action créée en réponse
  date_publication               DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (zone_id) REFERENCES zones(id),
  FOREIGN KEY (action_id) REFERENCES actions(id)
) ENGINE=InnoDB;

-- =====================================================================
-- 10. ESPACE BÉNÉVOLES (innovation)
-- =====================================================================

CREATE TABLE benevoles (
  id                  INT AUTO_INCREMENT PRIMARY KEY,
  nom                 VARCHAR(100) NOT NULL,
  prenom              VARCHAR(100) NOT NULL,
  email               VARCHAR(150),
  telephone           VARCHAR(30),
  competences         TEXT,
  date_inscription    DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE missions_benevolat (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  titre         VARCHAR(200) NOT NULL,
  description   TEXT,
  action_id     INT NULL,
  date_debut    DATE,
  date_fin      DATE,
  lieu          VARCHAR(255),
  statut        ENUM('ouverte','fermee','terminee') DEFAULT 'ouverte',
  FOREIGN KEY (action_id) REFERENCES actions(id)
) ENGINE=InnoDB;

CREATE TABLE candidatures_benevolat (
  id                 INT AUTO_INCREMENT PRIMARY KEY,
  benevole_id        INT NOT NULL,
  mission_id         INT NOT NULL,
  statut             ENUM('en_attente','acceptee','refusee','terminee') DEFAULT 'en_attente',
  date_candidature   DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (benevole_id) REFERENCES benevoles(id) ON DELETE CASCADE,
  FOREIGN KEY (mission_id) REFERENCES missions_benevolat(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 11. NOTIFICATIONS INTELLIGENTES (innovation)
-- =====================================================================

CREATE TABLE notifications (
  id                  INT AUTO_INCREMENT PRIMARY KEY,
  donateur_id         INT,
  type_notification   ENUM('confirmation_don','objectif_atteint','rapport_impact','don_recurrent','autre') NOT NULL,
  titre               VARCHAR(200),
  message             TEXT,
  lu                  BOOLEAN DEFAULT FALSE,
  date_creation       DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (donateur_id) REFERENCES donateurs(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 12. ASSISTANT IA / CHATBOT (innovation)
-- =====================================================================

CREATE TABLE conversations_chatbot (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  donateur_id    INT NULL,   -- NULL si visiteur non identifié
  session_id     VARCHAR(100) NOT NULL,
  date_debut     DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (donateur_id) REFERENCES donateurs(id)
) ENGINE=InnoDB;

CREATE TABLE messages_chatbot (
  id                INT AUTO_INCREMENT PRIMARY KEY,
  conversation_id   INT NOT NULL,
  emetteur          ENUM('visiteur','bot') NOT NULL,
  contenu           TEXT NOT NULL,
  date_envoi        DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (conversation_id) REFERENCES conversations_chatbot(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 13. EXPORTS & REPORTING
-- =====================================================================

CREATE TABLE exports_logs (
  id                INT AUTO_INCREMENT PRIMARY KEY,
  utilisateur_id    INT NOT NULL,
  type_export       ENUM('donateurs','dons','transactions','beneficiaires') NOT NULL,
  format            ENUM('csv','excel','pdf') DEFAULT 'csv',
  date_export       DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
) ENGINE=InnoDB;

-- =====================================================================
-- 14. VUES — TABLEAU DE BORD CRM / TABLEAU D'IMPACT PUBLIC / CRM INTELLIGENT
-- =====================================================================

-- Tableau de bord CRM (3.1)
CREATE OR REPLACE VIEW vue_tableau_bord AS
SELECT
  (SELECT COUNT(*) FROM donateurs) AS nombre_donateurs,
  (SELECT COUNT(*) FROM dons) AS nombre_dons,
  (SELECT COALESCE(SUM(d.montant),0) FROM dons d
     JOIN transactions t ON t.don_id = d.id
     WHERE t.statut = 'confirme') AS montant_total_collecte,
  (SELECT COUNT(*) FROM actions) AS nombre_actions,
  (SELECT COUNT(*) FROM transactions WHERE statut = 'en_attente') AS transactions_en_attente,
  (SELECT COUNT(*) FROM transactions WHERE statut = 'confirme') AS transactions_confirmees,
  (SELECT COUNT(*) FROM transactions WHERE statut = 'echoue') AS transactions_echouees;

-- Tableau d'impact public (innovation 12)
CREATE OR REPLACE VIEW vue_impact_public AS
SELECT
  (SELECT COALESCE(SUM(nombre_beneficiaires_aides),0) FROM rapports_impact) AS beneficiaires_aides,
  (SELECT COALESCE(SUM(d.montant),0) FROM dons d
     JOIN transactions t ON t.don_id = d.id
     WHERE t.statut = 'confirme') AS fonds_collectes,
  (SELECT COUNT(*) FROM actions WHERE statut IN ('en_cours','terminee')) AS actions_realisees,
  (SELECT COUNT(DISTINCT zone_id) FROM actions WHERE zone_id IS NOT NULL) AS zones_couvertes,
  (SELECT COUNT(*) FROM actions WHERE statut = 'terminee') AS projets_termines;

-- CRM intelligent : donateurs réguliers (innovation 11)
CREATE OR REPLACE VIEW vue_donateurs_reguliers AS
SELECT donateur_id, COUNT(*) AS nombre_dons, SUM(montant) AS montant_total
FROM dons
GROUP BY donateur_id
HAVING COUNT(*) >= 3;

-- CRM intelligent : donateurs inactifs (aucun don depuis 6 mois)
CREATE OR REPLACE VIEW vue_donateurs_inactifs AS
SELECT dt.id, dt.nom, dt.prenom, MAX(d.date_don) AS dernier_don
FROM donateurs dt
LEFT JOIN dons d ON d.donateur_id = dt.id
GROUP BY dt.id, dt.nom, dt.prenom
HAVING dernier_don IS NULL OR dernier_don < DATE_SUB(NOW(), INTERVAL 6 MONTH);

-- CRM intelligent : performance des campagnes
CREATE OR REPLACE VIEW vue_performance_actions AS
SELECT
  a.id AS action_id,
  a.titre,
  a.objectif_financier,
  COALESCE(SUM(d.montant),0) AS montant_collecte_reel,
  COUNT(DISTINCT d.donateur_id) AS nombre_donateurs,
  ROUND(COALESCE(SUM(d.montant),0) / NULLIF(a.objectif_financier,0) * 100, 2) AS pourcentage_atteint
FROM actions a
LEFT JOIN dons d ON d.action_id = a.id
LEFT JOIN transactions t ON t.don_id = d.id AND t.statut = 'confirme'
GROUP BY a.id, a.titre, a.objectif_financier;

-- =====================================================================
-- 15. INDEX COMPLÉMENTAIRES (performances des recherches / filtres)
-- =====================================================================

CREATE INDEX idx_dons_donateur       ON dons(donateur_id);
CREATE INDEX idx_dons_action         ON dons(action_id);
CREATE INDEX idx_transactions_statut ON transactions(statut);
CREATE INDEX idx_actions_statut      ON actions(statut);
CREATE INDEX idx_actualites_statut   ON actualites(statut);
CREATE INDEX idx_donateurs_nom       ON donateurs(nom, prenom);
CREATE INDEX idx_besoins_statut      ON besoins_urgents(statut);

-- =====================================================================
-- 16. DONNÉES DE BASE (seed)
-- =====================================================================

INSERT INTO roles (nom, description) VALUES
  ('super_admin', 'Accès à toutes les fonctionnalités'),
  ('gestionnaire_actions', 'Gestion des actions et des bénéficiaires'),
  ('gestionnaire_dons', 'Gestion des donateurs, dons et transactions'),
  ('redacteur', 'Création et publication des actualités');

INSERT INTO niveaux_fidelite (nom, seuil_points, avantages) VALUES
  ('Bronze', 0, 'Badge de bienvenue'),
  ('Argent', 500, 'Badge Argent + remerciement personnalisé'),
  ('Or', 2000, 'Badge Or + accès prioritaire aux rapports d\'impact'),
  ('Platine', 5000, 'Badge Platine + reconnaissance publique sur le site');

-- =====================================================================
-- FIN DU SCRIPT
-- =====================================================================
