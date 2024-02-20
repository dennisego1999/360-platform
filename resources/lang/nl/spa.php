<?php

return [
    'toasts' => [
        'description' => [
            'import_completed' => 'De import was succesvol',
            'scan_completed' => 'De scan is gelukt',
            'translation_updated' => 'De vertaling is bijgewerkt',
            'translation_deleted' => 'De vertaling is verwijderd',
            'user_deleted' => 'De gebruiker wordt verwijderd',
            'user_updated' => 'De gebruiker is bijgewerkt',
            'user_created' => 'The user is created',
            'three_sixty_area_deleted' => 'De 360 omgeving is verwijdered',
            'three_sixty_area_updated' => 'De 360 omgeving is bijgewerkt',
            'three_sixty_area_created' => 'De 360 omgeving is aangemaakt',
            'three_sixty_view_point_deleted' => 'Het kijkpunt is verwijderd',
            'three_sixty_view_point_updated' => 'Het kijkpunt is bijgewerkt',
            'three_sixty_view_point_created' => 'Het kijkpunt is aangemaakt',
            'error' => 'Er is iets fout gegaan',
        ],
    ],
    'buttons' => [
        'go_back' => 'Terug',
        'edit' => 'Pas aan',
        'cancel' => 'Annuleren',
        'save' => 'Sla op',
        'remove' => 'Verwijder',
        'add' => 'Voeg toe',
        'yes' => 'Ja',
        'no' => 'Neen',
        'close' => 'Sluit',
        'scan' => 'Scan',
        'import' => 'Importeer',
        'export' => 'Exporteer',
        'create_user' => 'Maak een nieuwe gebruiker aan',
        'create_360_area' => 'Maak een nieuwe 360 omgeving',
        'create_view_point' => 'Maak een nieuw kijkpunt',
        'view_points' => 'Kijkpunten',
        'click_points' => 'Klikpunten',
    ],
    'labels' => [
        'name' => 'Naam',
        'description' => 'Omschrijving',
        'photo' => 'Foto',
        'select' => 'Selecteer',
        'first_name' => 'Voornaam',
        'last_name' => 'Achternaam',
        'email' => 'Email',
        'password' => 'Wachtwoord',
        'password_confirmation' => 'Bevestig wachtwoord',
        'roles' => 'Rollen',
        'image' => 'Afbeelding',
        'is_default' => 'Is standaard',
    ],
    'pages' => [
        'dashboard' => [
            'label' => 'Dashboard',
            'name' => 'Naam',
            'status' => 'Status',
            'roles' => 'Rollen',
            'actions' => 'Acties',
            'search' => 'Zoeken',
        ],
        'users' => [
            'label' => 'Gebruikers',
            'description' => 'Een lijst van alle gebruikers met alle nodige informatie.',
            'login' => 'Log in',
            'logout' => 'Log uit',
            'register' => 'Registreer',
            'no_users' => 'Geen gebruikers gevonden ...',
        ],
        'translations' => [
            'label' => 'Vertalingen',
            'description' => 'Een lijst van alle vertalingen.',
            'table' => [
                'group' => 'Groep',
                'key' => 'Sleutel',
                'original_translation' => 'Originele vertaling',
                'new_translation' => 'Nieuwe vertaling',
                'locale' => 'Taal code',
                'updated_at' => 'Bijgewerkt op',
                'actions' => 'Acties',
            ],
            'no_translations' => 'Geen vertalingen gevonden...',
        ],
        'profile' => [
            'label' => 'Profiel',
        ],
        'three_sixty_generator' => [
            'areas' => [
                'index' => [
                    'label' => '360 generator',
                    'description' => 'Een lijst van alle 360 omgevingen',
                    'no_areas' => 'Geen 360 omgevingen gevonden...',
                ],
                'create' => [
                    'label' => '360 generator',
                    'description' => 'Maak een nieuwe 360 omgeving',
                ],
                'show' => [
                    'label' => '360 generator',
                    'description' => 'Bekijk de info van deze 360 omgeving',
                ],
                'edit' => [
                    'label' => '360 generator',
                    'description' => 'Bewerk deze 360 omgeving',
                ],
            ],
            'view_points' => [
                'index' => [
                    'label' => 'Kijk punten in omgeving: {name}',
                    'description' => 'Een lijst van alle kijk punten',
                    'no_viewpoints' => 'Geen kijk punten gevonden...',
                ],
                'create' => [
                    'label' => 'Kijk punten in omgeving: {name}',
                    'description' => 'Maak een nieuw kijkpunt',
                ],
                'show' => [
                    'label' => 'Kijk punten in omgeving: {name}',
                    'description' => 'Bekijk de info van dit kijkpunt',
                ],
                'edit' => [
                    'label' => 'Kijk punten in omgeving: {name}',
                    'description' => 'Pas dit kijkpunt aan',
                ],
            ]
        ],
    ],
    'modals' => [
        'change_language' => 'Wilt u veranderen naar {locale}?'
    ],
];
