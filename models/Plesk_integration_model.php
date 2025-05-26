<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Plesk_integration_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Restituisce l'elenco dei server Plesk configurati
     */
    public function get_servers()
    {
        return $this->db->order_by('id', 'ASC')->get(db_prefix() . 'plesk_servers')->result_array();
    }

    /**
     * Restituisce i dettagli di un singolo server
     */
    public function get_server($id)
    {
        return $this->db->where('id', $id)->get(db_prefix() . 'plesk_servers')->row_array();
    }

    /**
     * Aggiunge un nuovo server Plesk
     */
    public function add_server($data)
    {
        $this->db->insert(db_prefix() . 'plesk_servers', $data);
        return $this->db->insert_id();
    }

    /**
     * Elimina server
     */
    public function delete_server($id)
    {
        $this->db->where('id', $id)->delete(db_prefix() . 'plesk_servers');
        return $this->db->affected_rows() > 0;
    }

    /**
     * Ottiene siti web dalla cache
     */
    public function get_cached_websites()
    {
        return $this->db->get(db_prefix() . 'plesk_websites_cache')->result_array();
    }

    /**
     * Aggiorna cache sito web
     */
    public function update_website_cache($website_data)
    {
        $existing = $this->db->where('domain_id', $website_data['domain_id'])
                            ->get(db_prefix() . 'plesk_websites_cache')
                            ->row();

        if ($existing) {
            $this->db->where('id', $existing->id)
                     ->update(db_prefix() . 'plesk_websites_cache', $website_data);
        } else {
            $this->db->insert(db_prefix() . 'plesk_websites_cache', $website_data);
        }
    }

    /**
     * Elimina cache vecchia
     */
    public function clean_old_cache($minutes = 60)
    {
        $this->db->where('last_updated <', date('Y-m-d H:i:s', strtotime("-{$minutes} minutes")))
                 ->delete(db_prefix() . 'plesk_websites_cache');
    }

    /**
     * Ottiene log API
     */
    public function get_api_logs($limit = 100)
    {
        return $this->db->order_by('created_at', 'DESC')
                        ->limit($limit)
                        ->get(db_prefix() . 'plesk_api_logs')
                        ->result_array();
    }

    /**
     * Installa le tabelle del modulo
     */
    public function install()
    {
        // Le tabelle vengono create in install.php
        return true;
    }

    /**
     * Disinstalla il modulo
     */
    public function uninstall()
    {
        $this->db->query("DROP TABLE IF EXISTS `" . db_prefix() . "plesk_websites_cache`");
        $this->db->query("DROP TABLE IF EXISTS `" . db_prefix() . "plesk_api_logs`");
        $this->db->query("DROP TABLE IF EXISTS `" . db_prefix() . "plesk_servers`");
        
        // Rimuove le opzioni
        $this->db->where('name LIKE', 'plesk_%')
                 ->delete(db_prefix() . 'options');
    }
}
