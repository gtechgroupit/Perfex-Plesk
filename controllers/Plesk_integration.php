<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Plesk_integration extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('plesk_integration_model');
        $this->load->library('plesk_api');
    }

    /**
     * Dashboard principale
     */
    public function index()
    {
        if (!has_permission('plesk_integration', '', 'view')) {
            access_denied('plesk_integration');
        }

        $data['title'] = 'Plesk Integration Dashboard';
        
        // Statistiche rapide
        try {
            $websites = $this->plesk_api->get_websites();
            $data['total_websites'] = count($websites);
            $data['active_websites'] = count(array_filter($websites, function($site) {
                return $site['status'] === 'active';
            }));
        } catch (Exception $e) {
            $data['error'] = 'Errore connessione Plesk: ' . $e->getMessage();
            $data['total_websites'] = 0;
            $data['active_websites'] = 0;
        }

        $this->load->view('admin/plesk_integration/dashboard', $data);
    }

    /**
     * Lista siti web
     */
    public function websites()
    {
        if (!has_permission('plesk_integration', '', 'view')) {
            access_denied('plesk_integration');
        }

        $data['title'] = 'Siti Web Plesk';
        
        try {
            $data['websites'] = $this->plesk_api->get_websites();
        } catch (Exception $e) {
            $data['error'] = 'Errore nel recupero dei siti web: ' . $e->getMessage();
            $data['websites'] = [];
        }

        $this->load->view('admin/plesk_integration/websites', $data);
    }

    /**
     * Dettagli singolo sito web
     */
    public function website_details($domain_id)
    {
        if (!has_permission('plesk_integration', '', 'view')) {
            access_denied('plesk_integration');
        }

        try {
            $data['website'] = $this->plesk_api->get_website_details($domain_id);
            $data['title'] = 'Dettagli Sito: ' . $data['website']['name'];
        } catch (Exception $e) {
            show_error('Errore nel recupero dei dettagli: ' . $e->getMessage());
        }

        $this->load->view('admin/plesk_integration/website_details', $data);
    }

    /**
     * Impostazioni del modulo
     */
    public function settings()
    {
        if (!has_permission('plesk_integration', '', 'edit')) {
            access_denied('plesk_integration');
        }

        if ($this->input->post()) {
            $settings = $this->input->post();
            
            // Salva le impostazioni
            foreach ($settings as $key => $value) {
                if (strpos($key, 'plesk_') === 0) {
                    update_option($key, $value);
                }
            }

            // Test connessione
            if ($this->input->post('test_connection')) {
                try {
                    $this->plesk_api->test_connection();
                    set_alert('success', 'Connessione a Plesk riuscita!');
                } catch (Exception $e) {
                    set_alert('danger', 'Errore connessione: ' . $e->getMessage());
                }
            } else {
                set_alert('success', 'Impostazioni salvate con successo!');
            }

            redirect(admin_url('plesk_integration/settings'));
        }

        $data['title'] = 'Impostazioni Plesk';
        $this->load->view('admin/plesk_integration/settings', $data);
    }
}
