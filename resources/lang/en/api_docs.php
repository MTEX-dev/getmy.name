<?php

return [
    'title' => 'API Documentation',
    'subtitle' => 'Your guide to our API',
    'description' => 'Explore the available endpoints and learn how to interact with our API. Our API allows you to programmatically manage your profile, skills, projects, experiences, education, social links, and "About Me" section.',

    'profile' => [
        'title' => 'Profile',
        'description' => 'Manage your public profile information, including retrieving user details, updating your profile, and managing your avatar image.',
    ],
    'skills' => [
        'title' => 'Skills',
        'description' => 'Add, view, and remove skills associated with your profile to showcase your expertise.',
    ],
    'projects' => [
        'title' => 'Projects',
        'description' => 'Manage your portfolio of projects by adding new entries, viewing existing ones, and deleting completed or outdated projects.',
    ],
    'experiences' => [
        'title' => 'Experiences',
        'description' => 'Document your professional experiences, including job titles, companies, and dates, with options to add, view, and remove entries.',
    ],
    'education' => [
        'title' => 'Education',
        'description' => 'Record your academic history, including degrees, institutions, and dates. You can add, view, and remove your educational achievements.',
    ],
    'socials' => [
        'title' => 'Socials',
        'description' => 'Update and manage your social media links and other external profiles that you wish to display on your profile.',
    ],
    'about_me' => [
        'title' => 'About Me',
        'description' => 'Update the "About Me" section of your profile, providing a detailed description of yourself or your work.',
    ],

    'endpoints' => [
        'index' => 'Retrieve All',
        'show' => 'Retrieve Specific',
        'store' => 'Create New',
        'update' => 'Update Existing',
        'destroy' => 'Delete',
        'update_avatar' => 'Update Avatar Image',
        'delete_avatar' => 'Delete Avatar Image',
    ],
];