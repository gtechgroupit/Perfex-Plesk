<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

// Creazione tabelle del database
if (!$CI->db->table_exists(db_prefix() . 'plesk_websites_cache')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'plesk_websites_cache` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `domain_id` varchar(255) NOT NULL,
        `domain_name` varchar(255) NOT NULL,
        `status` varchar(50) NOT NULL,
        `hosting_type` varchar(100) DEFAULT NULL,
        `ip_address` varchar(45) DEFAULT NULL,
        `created_date` datetime DEFAULT NULL,
        `expires_date` datetime DEFAULT NULL,
        `ssl_enabled` tinyint(1) DEFAULT 0,
        `data` longtext,
        `last_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `domain_id` (`domain_id`),
        KEY `domain_name` (`domain_name`),
        KEY `status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Creazione tabella per i log delle API
if (!$CI->db->table_exists(db_prefix() . 'plesk_api_logs')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'plesk_api_logs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `endpoint` varchar(255) NOT NULL,
        `method` varchar(10) NOT NULL,
        `request_data` text,
        `response_data` text,
        `response_code` int(3) DEFAULT NULL,
        `execution_time` decimal(8,3) DEFAULT NULL,
        `error_message` text,
        `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `endpoint` (`endpoint`),
        KEY `created_at` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Tabella per i server Plesk configurati
if (!$CI->db->table_exists(db_prefix() . 'plesk_servers')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'plesk_servers` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `url` varchar(255) NOT NULL,
        `username` varchar(100) NOT NULL,
        `password` varchar(255) NOT NULL,
        `ssl_verify` tinyint(1) DEFAULT 1,
        `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Inserimento opzioni di default
$default_options = [
    'plesk_api_url' => '',
    'plesk_api_username' => '',
    'plesk_api_password' => '',
    'plesk_ssl_verify' => '1',
    'plesk_cache_duration' => '30',
    'plesk_auto_sync' => '0',
    'plesk_debug_mode' => '0',
    'plesk_default_server_id' => '1',
    'plesk_module_version' => PLESK_INTEGRATION_VERSION
];

foreach ($default_options as $name => $value) {
    if (!get_option($name)) {
        add_option($name, $value);
    }
}
