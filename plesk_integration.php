<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Plesk Integration
Description: Integrazione con server Plesk per visualizzare e gestire siti web tramite API
Version: 1.0.0
Requires at least: 2.3.0
Author: Il Tuo Nome
Author URI: https://il-tuo-sito.com
*/

define('PLESK_INTEGRATION_MODULE_NAME', 'plesk_integration');
define('PLESK_INTEGRATION_VERSION', '1.0.0');

// Registra hook di attivazione/disattivazione
hooks()->add_action('pre_activate_module', PLESK_INTEGRATION_MODULE_NAME, 'plesk_integration_activation_hook');
hooks()->add_action('pre_deactivate_module', PLESK_INTEGRATION_MODULE_NAME, 'plesk_integration_deactivation_hook');

// Hook per aggiungere menu
hooks()->add_action('admin_init', 'plesk_integration_admin_init');

// Hook per le impostazioni del modulo
hooks()->add_action('app_admin_head', 'plesk_integration_head_component');

/**
 * Hook di attivazione del modulo
 */
function plesk_integration_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
 * Hook di disattivazione del modulo
 */
function plesk_integration_deactivation_hook()
{
    // Eventuali operazioni di pulizia
}

/**
 * Inizializzazione admin del modulo
 */
function plesk_integration_admin_init()
{
    $CI = &get_instance();
    
    // Aggiunge voce di menu principale
    if (has_permission('plesk_integration', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('plesk-integration', [
            'name'     => 'Plesk Integration',
            'href'     => admin_url('plesk_integration'),
            'position' => 30,
            'icon'     => 'fa fa-server',
        ]);
        
        // Sottomenu
        $CI->app_menu->add_sidebar_children_item('plesk-integration', [
            'slug'     => 'plesk-websites',
            'name'     => 'Siti Web',
            'href'     => admin_url('plesk_integration/websites'),
            'position' => 1,
        ]);
        
        $CI->app_menu->add_sidebar_children_item('plesk-integration', [
            'slug'     => 'plesk-settings',
            'name'     => 'Impostazioni',
            'href'     => admin_url('plesk_integration/settings'),
            'position' => 2,
        ]);
    }
}

/**
 * Aggiunge componenti nell'head
 */
function plesk_integration_head_component()
{
    echo '<style>
    .plesk-website-card {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 15px;
        background: #fff;
    }
    .plesk-status-active { color: #5cb85c; }
    .plesk-status-suspended { color: #f0ad4e; }
    .plesk-status-disabled { color: #d9534f; }
    </style>';
}

/**
 * Registra permessi del modulo
 */
function plesk_integration_permissions()
{
    $capabilities = [];
    $capabilities['capabilities'] = [
        'view' => _l('permission_view') . '(' . _l('permission_global') . ')',
        'edit' => _l('permission_edit'),
    ];
    
    return $capabilities;
}

// Registra i permessi
hooks()->add_filter('staff_permissions', 'plesk_integration_permissions');
