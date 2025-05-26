<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Configurazione modulo
$config['plesk_integration'] = [
    'name' => 'Plesk Integration',
    'version' => '1.0.0',
    'author' => 'Il Tuo Nome',
    'description' => 'Integrazione con server Plesk per visualizzare e gestire siti web tramite API REST',
    'requires_php' => '7.4',
    'requires_perfex' => '2.3.0',
    'permissions' => [
        'view',
        'edit'
    ],
    'menu_items' => [
        [
            'name' => 'Plesk Integration',
            'href' => 'plesk_integration',
            'icon' => 'fa fa-server',
            'position' => 30
        ]
    ]
];

// Endpoint API Plesk supportati
$config['plesk_api_endpoints'] = [
    'server_info' => '/server',
    'domains_list' => '/domains',
    'domain_details' => '/domains/{id}',
    'websites_list' => '/sites',
    'website_details' => '/sites/{id}',
    'databases_list' => '/databases',
    'mail_accounts' => '/mail'
];

// Frequenza di sincronizzazione (in secondi)
$config['plesk_sync_intervals'] = [
    'immediate' => 0,
    'hourly' => 3600,
    'daily' => 86400,
    'weekly' => 604800
];
