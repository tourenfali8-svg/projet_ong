<?php
/**
 * Seeder de données de démonstration pour la plateforme ONG & CRM
 * Exécution : php database/seeders/DatabaseSeeder.php
 */

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/src/Core/Autoloader.php';
\App\Core\Autoloader::register();

// Chargement .env
$envFile = dirname(__DIR__, 2) . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || str_starts_with($line, '#')) continue;
        if (str_contains($line, '=')) {
            [$k, $v] = explode('=', $line, 2);
            $_ENV[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
        }
    }
}

use App\Core\Database;

try {
    echo "=== Initialisation du Seeder ONG & CRM ===\n";
    $db = Database::getConnection();

    // 1. Rôles & Utilisateurs CRM
    echo "Insertion des utilisateurs CRM...\n";
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);

    $users = [
        ['nom' => 'Kouassi', 'prenom' => 'Jean-Marc', 'email' => 'admin@espoir-avenir.ong', 'role_id' => 1, 'telephone' => '+225 07 01 02 03 04'],
        ['nom' => 'Touré', 'prenom' => 'Aïcha', 'email' => 'actions@espoir-avenir.ong', 'role_id' => 2, 'telephone' => '+225 05 11 22 33 44'],
        ['nom' => 'Diallo', 'prenom' => 'Mamadou', 'email' => 'dons@espoir-avenir.ong', 'role_id' => 3, 'telephone' => '+225 01 44 55 66 77'],
        ['nom' => 'Bamba', 'prenom' => 'Fatou', 'email' => 'redacteur@espoir-avenir.ong', 'role_id' => 4, 'telephone' => '+225 07 88 99 00 11']
    ];

    foreach ($users as $u) {
        $stmt = $db->prepare("SELECT id FROM utilisateurs WHERE email = :email");
        $stmt->execute(['email' => $u['email']]);
        if (!$stmt->fetch()) {
            $ins = $db->prepare("
                INSERT INTO utilisateurs (nom, prenom, email, telephone, mot_de_passe_hash, role_id, statut, date_creation)
                VALUES (:nom, :prenom, :email, :telephone, :pwd, :role_id, 'actif', NOW())
            ");
            $ins->execute([
                'nom' => $u['nom'],
                'prenom' => $u['prenom'],
                'email' => $u['email'],
                'telephone' => $u['telephone'],
                'pwd' => $adminPassword,
                'role_id' => $u['role_id']
            ]);
        }
    }

    // 2. Zones géographiques
    echo "Insertion des zones géographiques...\n";
    $zones = [
        ['nom' => 'Région du Gbêkê', 'pays' => 'Côte d\'Ivoire', 'ville' => 'Bouaké', 'lat' => 7.6888, 'lng' => -5.0319],
        ['nom' => 'District d\'Abidjan', 'pays' => 'Côte d\'Ivoire', 'ville' => 'Abidjan', 'lat' => 5.3600, 'lng' => -4.0083],
        ['nom' => 'Région du Poro', 'pays' => 'Côte d\'Ivoire', 'ville' => 'Korhogo', 'lat' => 9.4580, 'lng' => -5.6296],
        ['nom' => 'Région du Tonkpi', 'pays' => 'Côte d\'Ivoire', 'ville' => 'Man', 'lat' => 7.4125, 'lng' => -7.5544],
        ['nom' => 'Région de San-Pédro', 'pays' => 'Côte d\'Ivoire', 'ville' => 'San-Pédro', 'lat' => 4.7485, 'lng' => -6.6363]
    ];

    foreach ($zones as $z) {
        $stmt = $db->prepare("SELECT id FROM zones WHERE ville = :ville");
        $stmt->execute(['ville' => $z['ville']]);
        if (!$stmt->fetch()) {
            $ins = $db->prepare("INSERT INTO zones (nom, pays, ville, latitude, longitude) VALUES (:nom, :pays, :ville, :lat, :lng)");
            $ins->execute(['nom' => $z['nom'], 'pays' => $z['pays'], 'ville' => $z['ville'], 'lat' => $z['lat'], 'lng' => $z['lng']]);
        }
    }

    // 3. Actions humanitaires
    echo "Insertion des actions humanitaires...\n";
    $actions = [
        [
            'titre' => 'Forage d\'eau potable pour le village de N\'Gattakro',
            'description' => 'Installation d\'un château d\'eau solaire et d\'un forage moderne pour alimenter 1 500 villageois en eau saine et réduire les maladies hydriques chez les enfants.',
            'statut' => 'en_cours',
            'zone_id' => 1,
            'objectif' => 4500000,
            'collecte' => 3200000,
            'debut' => '2026-01-15',
            'fin' => '2026-10-30'
        ],
        [
            'titre' => 'Kits scolaires & Cantine pour 500 élèves de Korhogo',
            'description' => 'Distribution de fournitures complètes, uniformes et subvention des repas chauds pour prévenir l\'abandon scolaire dans les écoles primaires rurales du nord.',
            'statut' => 'en_cours',
            'zone_id' => 3,
            'objectif' => 3000000,
            'collecte' => 2450000,
            'debut' => '2026-02-01',
            'fin' => '2026-11-15'
        ],
        [
            'titre' => 'Clinique Mobile : Consultations pédiatriques gratuites',
            'description' => 'Déploiement d\'un camion médical équipé et d\'une équipe de 4 infirmiers et 2 médecins dans les campements reculés de San-Pédro.',
            'statut' => 'terminee',
            'zone_id' => 5,
            'objectif' => 2500000,
            'collecte' => 2500000,
            'debut' => '2025-08-01',
            'fin' => '2025-12-20'
        ],
        [
            'titre' => 'Coopérative agricole féminine de Man',
            'description' => 'Formation aux techniques agroécologiques et dotation en matériel de transformation de manioc pour 80 femmes cheffes de famille.',
            'statut' => 'planifiee',
            'zone_id' => 4,
            'objectif' => 5000000,
            'collecte' => 400000,
            'debut' => '2026-11-01',
            'fin' => '2027-04-30'
        ]
    ];

    foreach ($actions as $act) {
        $stmt = $db->prepare("SELECT id FROM actions WHERE titre = :titre");
        $stmt->execute(['titre' => $act['titre']]);
        if (!$stmt->fetch()) {
            $ins = $db->prepare("
                INSERT INTO actions (titre, description, statut, zone_id, objectif_financier, montant_collecte, date_debut, date_fin, cree_par, date_creation)
                VALUES (:titre, :description, :statut, :zone_id, :obj, :col, :debut, :fin, 1, NOW())
            ");
            $ins->execute([
                'titre' => $act['titre'],
                'description' => $act['description'],
                'statut' => $act['statut'],
                'zone_id' => $act['zone_id'],
                'obj' => $act['objectif'],
                'col' => $act['collecte'],
                'debut' => $act['debut'],
                'fin' => $act['fin']
            ]);
        }
    }

    // 4. Besoins Urgents (Innovation 9)
    echo "Insertion des besoins urgents...\n";
    $urgents = [
        [
            'titre' => 'Crue soudaine à Bouaké : Kits d\'urgence pour 120 familles',
            'description' => 'Après des pluies torrentielles, 120 familles ont perdu leurs habitations de fortune. Besoin immédiat de moustiquaires, bâches, couvertures et rations alimentaires d\'urgence.',
            'zone_id' => 1,
            'personnes' => 480,
            'besoin' => 1500000,
            'niveau' => 'critique'
        ],
        [
            'titre' => 'Pénurie de consommables au dispensaire rural de Korhogo',
            'description' => 'Rupture de solutés de réhydratation et tests de dépistage rapide du paludisme pour les enfants de moins de 5 ans.',
            'zone_id' => 3,
            'personnes' => 250,
            'besoin' => 800000,
            'niveau' => 'eleve'
        ]
    ];

    foreach ($urgents as $urg) {
        $stmt = $db->prepare("SELECT id FROM besoins_urgents WHERE titre = :titre");
        $stmt->execute(['titre' => $urg['titre']]);
        if (!$stmt->fetch()) {
            $ins = $db->prepare("
                INSERT INTO besoins_urgents (titre, description, zone_id, nombre_personnes_concernees, besoin_financier, niveau_urgence, statut, date_publication)
                VALUES (:titre, :description, :zone_id, :personnes, :besoin, :niveau, 'actif', NOW())
            ");
            $ins->execute([
                'titre' => $urg['titre'],
                'description' => $urg['description'],
                'zone_id' => $urg['zone_id'],
                'personnes' => $urg['personnes'],
                'besoin' => $urg['besoin'],
                'niveau' => $urg['niveau']
            ]);
        }
    }

    // 5. Missions de Bénévolat (Innovation 10)
    echo "Insertion des missions de bénévolat...\n";
    $missions = [
        [
            'titre' => 'Distribution de kits scolaires et animation périscolaire',
            'description' => 'Participez à la logistique de tri et à la distribution des kits scolaires aux enfants dans les villages autour de Bouaké.',
            'lieu' => 'Bouaké (Terrain)',
            'debut' => '2026-09-20',
            'fin' => '2026-09-25'
        ],
        [
            'titre' => 'Accompagnement médical : Campagne mobile de vaccination',
            'description' => 'Recherche d\'infirmiers et d\'aides-soignants bénévoles pour assister notre médecin lors des tournées rurales à San-Pédro.',
            'lieu' => 'San-Pédro & campements',
            'debut' => '2026-10-05',
            'fin' => '2026-10-12'
        ]
    ];

    foreach ($missions as $m) {
        $stmt = $db->prepare("SELECT id FROM missions_benevolat WHERE titre = :titre");
        $stmt->execute(['titre' => $m['titre']]);
        if (!$stmt->fetch()) {
            $ins = $db->prepare("
                INSERT INTO missions_benevolat (titre, description, lieu, date_debut, date_fin, statut)
                VALUES (:titre, :description, :lieu, :debut, :fin, 'ouverte')
            ");
            $ins->execute([
                'titre' => $m['titre'],
                'description' => $m['description'],
                'lieu' => $m['lieu'],
                'debut' => $m['debut'],
                'fin' => $m['fin']
            ]);
        }
    }

    // 6. Actualités
    echo "Insertion des actualités...\n";
    $news = [
        [
            'titre' => 'Le forage de N\'Gattakro franchit l\'étape de perforation avec succès !',
            'contenu' => "Une étape déterminante vient d'être franchie : la nappe phréatique a été atteinte à 68 mètres de profondeur avec un débit d'eau pure remarquable de 4,5 m3/heure. Les villageois ont célébré cette première arrivée d'eau claire !",
            'date' => '2026-08-28 10:00:00'
        ],
        [
            'titre' => 'Bilan 2025 : Plus de 4 200 enfants scolarisés et soignés',
            'contenu' => "Grâce à la fidélité de nos donateurs et au dévouement de nos 35 bénévoles réguliers, notre ONG a pu déployer 12 missions complètes à travers 5 régions. Merci pour votre confiance inébranlable !",
            'date' => '2026-08-15 14:30:00'
        ]
    ];

    foreach ($news as $n) {
        $stmt = $db->prepare("SELECT id FROM actualites WHERE titre = :titre");
        $stmt->execute(['titre' => $n['titre']]);
        if (!$stmt->fetch()) {
            $ins = $db->prepare("
                INSERT INTO actualites (titre, contenu, statut, date_publication, date_creation, auteur_id)
                VALUES (:titre, :contenu, 'publie', :date, :date, 1)
            ");
            $ins->execute([
                'titre' => $n['titre'],
                'contenu' => $n['contenu'],
                'date' => $n['date']
            ]);
        }
    }

    // 7. Donateurs & Dons exemples
    echo "Insertion de donateurs et dons exemples...\n";
    $stmt = $db->query("SELECT COUNT(*) FROM donateurs");
    if ((int)$stmt->fetchColumn() === 0) {
        $sampleDonors = [
            ['nom' => 'Koné', 'prenom' => 'Ibrahim', 'telephone' => '+225 07 10 20 30 40', 'email' => 'ibrahim.kone@email.com', 'points' => 2500, 'niveau' => 3],
            ['nom' => 'Koffi', 'prenom' => 'Esther', 'telephone' => '+225 05 99 88 77 66', 'email' => 'esther.koffi@email.com', 'points' => 600, 'niveau' => 2],
            ['nom' => 'Yao', 'prenom' => 'Serge', 'telephone' => '+225 01 11 22 33 44', 'email' => 'serge.yao@email.com', 'points' => 150, 'niveau' => 1]
        ];

        foreach ($sampleDonors as $d) {
            $ins = $db->prepare("
                INSERT INTO donateurs (nom, prenom, telephone, email, points_fidelite, niveau_id, date_creation)
                VALUES (:nom, :prenom, :tel, :email, :pts, :niveau, NOW())
            ");
            $ins->execute([
                'nom' => $d['nom'],
                'prenom' => $d['prenom'],
                'tel' => $d['telephone'],
                'email' => $d['email'],
                'pts' => $d['points'],
                'niveau' => $d['niveau']
            ]);
            $did = $db->lastInsertId();

            // Création de 2 dons par donateur
            for ($i = 1; $i <= 2; $i++) {
                $montant = 15000 * $i;
                $insDon = $db->prepare("
                    INSERT INTO dons (donateur_id, action_id, montant, type_don, affectation, date_don)
                    VALUES (:did, 1, :montant, 'ponctuel', 'Forage eau potable', NOW())
                ");
                $insDon->execute(['did' => $did, 'montant' => $montant]);
                $donId = $db->lastInsertId();

                // Transaction associée confirmée
                $insTx = $db->prepare("
                    INSERT INTO transactions (don_id, operateur_paiement, reference_transaction, statut, date_transaction)
                    VALUES (:don_id, 'wave', :ref, 'confirme', NOW())
                ");
                $insTx->execute([
                    'don_id' => $donId,
                    'ref' => 'WV-DEMO-' . rand(10000, 99999)
                ]);
            }
        }
    }

    echo "=== Peuplement des données initiales terminé avec succès ! ===\n";
} catch (\Exception $e) {
    echo "Erreur lors du seeding : " . $e->getMessage() . "\n";
    exit(1);
}
