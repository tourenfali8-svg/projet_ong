-- Données initiales pour InfinityFree.
-- À importer APRÈS schema_ong_crm.sql dans la base déjà sélectionnée.

INSERT IGNORE INTO roles (id, nom, description) VALUES
  (1, 'super_admin', 'Accès à toutes les fonctionnalités'),
  (2, 'gestionnaire_actions', 'Gestion des actions et des bénéficiaires'),
  (3, 'gestionnaire_dons', 'Gestion des donateurs, dons et transactions'),
  (4, 'redacteur', 'Création et publication des actualités');

INSERT IGNORE INTO niveaux_fidelite (id, nom, seuil_points, avantages) VALUES
  (1, 'Bronze', 0, 'Badge de bienvenue'),
  (2, 'Argent', 500, 'Badge Argent + remerciement personnalisé'),
  (3, 'Or', 2000, 'Badge Or + accès prioritaire aux rapports d’impact'),
  (4, 'Platine', 5000, 'Badge Platine + reconnaissance publique sur le site');

INSERT IGNORE INTO utilisateurs (id, nom, prenom, email, telephone, mot_de_passe_hash, role_id, statut) VALUES
  (1, 'AL HIKMAH', 'Administration', 'admin@alhikmah.ong', '+225 05 07 67 42 08', '$2y$10$cHUO0TPnfSWA39lAcZz1CeWryRTmwbRpBsZcw2h5rz58phz24XUfG', 1, 'actif');

INSERT INTO zones (id, nom, pays, ville, latitude, longitude) VALUES
  (1, 'District d’Abidjan', 'Côte d’Ivoire', 'Abidjan', 5.3600, -4.0083),
  (2, 'Région du Gbêkê', 'Côte d’Ivoire', 'Bouaké', 7.6888, -5.0319),
  (3, 'Région du Poro', 'Côte d’Ivoire', 'Korhogo', 9.4580, -5.6296)
ON DUPLICATE KEY UPDATE nom = VALUES(nom);

INSERT INTO actions (id, titre, description, statut, date_debut, date_fin, zone_id, objectif_financier, montant_collecte, cree_par) VALUES
  (1, 'Éducation et accompagnement des jeunes', 'Des séances de guidance, d’apprentissage et d’accompagnement pour offrir aux jeunes un cadre solide de progression.', 'en_cours', '2026-01-15', '2026-12-31', 1, 3000000, 1250000, 1),
  (2, 'Transmission des valeurs et savoirs', 'Des rencontres communautaires qui favorisent l’éducation, la transmission et la cohésion sociale.', 'terminee', '2026-03-01', '2026-04-30', 1, 1500000, 1500000, 1),
  (3, 'Soutien solidaire aux familles', 'Une initiative d’écoute, d’orientation et de soutien aux familles qui en ont besoin.', 'planifiee', '2026-11-01', '2027-02-28', 2, 2500000, 0, 1)
ON DUPLICATE KEY UPDATE titre = VALUES(titre), description = VALUES(description), statut = VALUES(statut), objectif_financier = VALUES(objectif_financier), montant_collecte = VALUES(montant_collecte);

INSERT INTO besoins_urgents (titre, description, zone_id, nombre_personnes_concernees, besoin_financier, niveau_urgence, statut, action_id) VALUES
  ('Soutien urgent aux familles vulnérables', 'Aide prioritaire destinée aux familles ayant besoin d’un accompagnement immédiat.', 1, 120, 800000, 'eleve', 'actif', 1);

INSERT INTO missions_benevolat (titre, description, lieu, date_debut, date_fin, statut) VALUES
  ('Accompagnement des activités éducatives', 'Participez à l’accueil et à l’accompagnement des jeunes lors de nos activités.', 'Abobo Anador, Abidjan', '2026-10-01', '2026-12-20', 'ouverte');

INSERT INTO actualites (titre, contenu, statut, date_publication, date_creation, auteur_id) VALUES
  ('Les activités de l’ONG AL HIKMAH se poursuivent', 'Nos équipes poursuivent leurs actions d’éducation, de transmission et d’accompagnement des communautés.', 'publie', NOW(), NOW(), 1),
  ('Une réunion au service de la communauté', 'Les membres de l’ONG se sont réunis pour préparer les prochaines initiatives au bénéfice des jeunes et des familles.', 'publie', NOW(), NOW(), 1);

INSERT INTO rapports_impact (action_id, nombre_beneficiaires_aides, montant_utilise, resultats_obtenus, date_publication) VALUES
  (2, 250, 1500000, 'Des rencontres communautaires et éducatives menées avec succès.', NOW());
