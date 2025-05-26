<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Formatta lo stato di un sito web Plesk
 */
if (!function_exists('plesk_format_status')) {
    function plesk_format_status($status)
    {
        $statuses = [
            'active' => ['text' => 'Attivo', 'class' => 'success'],
            'suspended' => ['text' => 'Sospeso', 'class' => 'warning'],
            'disabled' => ['text' => 'Disabilitato', 'class' => 'danger']
        ];
        
        return isset($statuses[$status]) ? $statuses[$status] : ['text' => 'Sconosciuto', 'class' => 'default'];
    }
}

/**
 * Verifica se le API Plesk sono configurate
 */
if (!function_exists('plesk_is_configured')) {
    function plesk_is_configured()
    {
        return !empty(get_option('plesk_api_url')) && 
               !empty(get_option('plesk_api_username')) && 
               !empty(get_option('plesk_api_password'));
    }
}

/**
 * Ottiene l'URL base delle API Plesk
 */
if (!function_exists('plesk_get_api_base_url')) {
    function plesk_get_api_base_url()
    {
        $url = get_option('plesk_api_url');
        return rtrim($url, '/') . '/api/v2';
    }
}

/**
 * Log delle operazioni API Plesk
 */
if (!function_exists('plesk_log_api_call')) {
    function plesk_log_api_call($endpoint, $method, $request_data = null, $response_data = null, $response_code = null, $execution_time = null, $error = null)
    {
        if (!get_option('plesk_debug_mode')) {
            return;
        }
        
        $CI = &get_instance();
        
        $log_data = [
            'endpoint' => $endpoint,
            'method' => $method,
            'request_data' => $request_data ? json_encode($request_data) : null,
            'response_data' => $response_data ? (is_string($response_data) ? $response_data : json_encode($response_data)) : null,
            'response_code' => $response_code,
            'execution_time' => $execution_time,
            'error_message' => $error
        ];
        
        $CI->db->insert(db_prefix() . 'plesk_api_logs', $log_data);
    }
}

/**
 * Pulisce i log API più vecchi di X giorni
 */
if (!function_exists('plesk_cleanup_logs')) {
    function plesk_cleanup_logs($days = 30)
    {
        $CI = &get_instance();
        $CI->db->where('created_at <', date('Y-m-d H:i:s', strtotime("-{$days} days")));
        $CI->db->delete(db_prefix() . 'plesk_api_logs');
    }
}
