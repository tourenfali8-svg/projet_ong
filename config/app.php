<?php
/**
 * Configuration générale de l'application
 */

return [
    'name' => $_ENV['APP_NAME'] ?? 'ONG AL HIKMAH',
    'env' => $_ENV['APP_ENV'] ?? 'development',
    'debug' => filter_var($_ENV['APP_DEBUG'] ?? true, FILTER_VALIDATE_BOOLEAN),
    'url' => $_ENV['APP_URL'] ?? 'http://localhost:8000',
    'currency' => $_ENV['APP_CURRENCY'] ?? 'FCFA',
    'timezone' => $_ENV['APP_TIMEZONE'] ?? 'Africa/Abidjan',

    // Coordonnées de l'ONG
    'organization' => [
        'name' => 'ONG AL HIKMAH',
        'slogan' => 'Éducation, racines et avenir au service de la jeunesse et des communautés',
        'email' => 'alhikmah050767@gmail.com',
        'phone' => '2250507674208',
        'address' => 'Abobo Anador, Abidjan, Côte d\'Ivoire',
        'mission' => 'L\'ONG AL HIKMAH a pour objectif d\'œuvrer dans les domaines de l\'éducation, de la transmission des valeurs culturelles et morales, ainsi que de la réinsertion socio-économique de la jeunesse. Elle accompagne les jeunes et les communautés en leur offrant un cadre de guidance, de développement et d\'épanouissement durable.',
        'vision' => 'Devenir une organisation de référence dans l\'encadrement éthique, moral et spirituel des jeunes, tout en promouvant les valeurs culturelles, la solidarité intergénérationnelle et l\'autonomie économique des bénéficiaires.',
        'history' => 'Fondée en 2026 dans une logique de service, de proximité et de transmission, l\'ONG AL HIKMAH s\'engage à inscrire son action dans la protection des valeurs ancestrales, la montée en compétence des jeunes et la création de véritables opportunités de réussite sociale et économique.'
    ],

    // Options de dons prédéfinis (en FCFA)
    'donation_presets' => [2000, 5000, 10000, 25000, 50000, 100000],

    // Rôles utilisateurs du CRM
    'roles' => [
        'super_admin' => 'Super Administrateur',
        'gestionnaire_actions' => 'Gestionnaire des Actions',
        'gestionnaire_dons' => 'Gestionnaire des Dons',
        'redacteur' => 'Rédacteur de Contenus'
    ]
];
