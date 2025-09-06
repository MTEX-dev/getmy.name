<?php

return [
    'title' => 'Documentation API',
    'subtitle' => 'Votre guide pour notre API',
    'description' => 'Explorez les points d\'accès disponibles et apprenez comment interagir avec notre API. Notre API vous permet de gérer de manière programmatique votre profil, vos compétences, vos projets, vos expériences, votre formation, vos liens sociaux et la section "À propos de moi".',

    'profile' => [
        'title' => 'Profil',
        'description' => 'Gérez les informations de votre profil public, y compris la récupération des détails de l\'utilisateur, la mise à jour de votre profil et la gestion de votre image d\'avatar.',
    ],
    'skills' => [
        'title' => 'Compétences',
        'description' => 'Ajoutez, affichez et supprimez les compétences associées à votre profil pour présenter votre expertise.',
    ],
    'projects' => [
        'title' => 'Projets',
        'description' => 'Gérez votre portefeuille de projets en ajoutant de nouvelles entrées, en visualisant les existantes et en supprimant les projets terminés ou obsolètes.',
    ],
    'experiences' => [
        'title' => 'Expériences',
        'description' => 'Documentez vos expériences professionnelles, y compris les titres de poste, les entreprises et les dates, avec des options pour ajouter, afficher et supprimer des entrées.',
    ],
    'education' => [
        'title' => 'Formation',
        'description' => 'Enregistrez votre parcours académique, y compris les diplômes, les institutions et les dates. Vous pouvez ajouter, afficher et supprimer vos réalisations éducatives.',
    ],
    'socials' => [
        'title' => 'Réseaux sociaux',
        'description' => 'Mettez à jour et gérez vos liens de médias sociaux et autres profils externes que vous souhaitez afficher sur votre profil.',
    ],
    'about_me' => [
        'title' => 'À propos de moi',
        'description' => 'Mettez à jour la section "À propos de moi" de votre profil, en fournissant une description détaillée de vous-même ou de votre travail.',
    ],

    'endpoints' => [
        'index' => 'Récupérer tout',
        'show' => 'Récupérer spécifique',
        'store' => 'Créer nouveau',
        'update' => 'Mettre à jour existant',
        'destroy' => 'Supprimer',
        'update_avatar' => 'Mettre à jour l\'image d\'avatar',
        'delete_avatar' => 'Supprimer l\'image d\'avatar',
    ],
];