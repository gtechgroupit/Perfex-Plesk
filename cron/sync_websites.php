<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (get_option('plesk_auto_sync')) {
    $CI = &get_instance();
    $CI->load->library('plesk_api');
    
    try {
        $websites = $CI->plesk_api->get_websites();
        
        foreach ($websites as $website) {
            // Aggiorna o inserisci nella cache
            $existing = $CI->db->where('domain_id', $website['id'])->get(db_prefix() . 'plesk_websites_cache')->row();
            
            $data = [
                'domain_id' => $website['id'],
                'domain_name' => $website['name'],
                'status' => $website['status'],
                'hosting_type' => $website['hosting_type'] ?? null,
                'ip_address' => $website['ip_address'] ?? null,
                'created_date' => isset($website['created']) ? date('Y-m-d H:i:s', strtotime($website['created'])) : null,
                'expires_date' => isset($website['expires']) ? date('Y-m-d H:i:s', strtotime($website['expires'])) : null,
                'ssl_enabled' => $website['ssl_enabled'] ?? 0,
                'data' => json_encode($website)
            ];
            
            if ($existing) {
                $CI->db->where('id', $existing->id)->update(db_prefix() . 'plesk_websites_cache', $data);
            } else {
                $CI->db->insert(db_prefix() . 'plesk_websites_cache', $data);
            }
        }
        
        // Cleanup log vecchi
        plesk_cleanup_logs();
        
    } catch (Exception $e) {
        plesk_log_api_call('sync_cron', 'GET', null, null, null, null, $e->getMessage());
    }
}
