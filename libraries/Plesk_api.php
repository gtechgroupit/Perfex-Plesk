<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Plesk_api
{
    private $CI;
    private $plesk_url;
    private $plesk_username;
    private $plesk_password;
    private $ssl_verify;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->plesk_url = get_option('plesk_api_url');
        $this->plesk_username = get_option('plesk_api_username');
        $this->plesk_password = get_option('plesk_api_password');
        $this->ssl_verify = get_option('plesk_ssl_verify') === '1';
    }

    /**
     * Test della connessione
     */
    public function test_connection()
    {
        $response = $this->make_request('GET', '/api/v2/server');
        
        if (!$response || !isset($response['version'])) {
            throw new Exception('Impossibile connettersi al server Plesk');
        }
        
        return true;
    }

    /**
     * Recupera tutti i siti web
     */
    public function get_websites()
    {
        $response = $this->make_request('GET', '/api/v2/domains');
        
        if (!$response || !is_array($response)) {
            throw new Exception('Formato risposta non valido');
        }

        $websites = [];
        foreach ($response as $domain) {
            $websites[] = [
                'id' => $domain['id'],
                'name' => $domain['name'],
                'status' => $domain['status'],
                'hosting_type' => $domain['hosting_type'] ?? 'website',
                'created' => $domain['created'] ?? null,
                'expires' => $domain['expires'] ?? null,
                'ip_address' => $domain['ip_address'] ?? null,
                'ssl_enabled' => $domain['ssl_enabled'] ?? false
            ];
        }

        return $websites;
    }

    /**
     * Recupera dettagli di un singolo sito web
     */
    public function get_website_details($domain_id)
    {
        $response = $this->make_request('GET', "/api/v2/domains/{$domain_id}");
        
        if (!$response) {
            throw new Exception('Sito web non trovato');
        }

        return $response;
    }

    /**
     * Effettua richieste HTTP alle API di Plesk
     */
    private function make_request($method, $endpoint, $data = null)
    {
        if (!$this->plesk_url || !$this->plesk_username || !$this->plesk_password) {
            throw new Exception('Configurazione API Plesk incompleta');
        }

        $url = rtrim($this->plesk_url, '/') . $endpoint;
        $start_time = microtime(true);
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $this->plesk_username . ':' . $this->plesk_password,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            CURLOPT_SSL_VERIFYPEER => $this->ssl_verify,
            CURLOPT_TIMEOUT => 30
        ]);

        if ($method === 'POST' && $data) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'PUT' && $data) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        $execution_time = microtime(true) - $start_time;

        // Log della chiamata API
        if (function_exists('plesk_log_api_call')) {
            plesk_log_api_call(
                $endpoint, 
                $method, 
                $data, 
                $response, 
                $http_code, 
                $execution_time, 
                $error
            );
        }

        if ($error) {
            throw new Exception('Errore cURL: ' . $error);
        }

        if ($http_code >= 400) {
            throw new Exception('Errore HTTP ' . $http_code . ': ' . $response);
        }

        return json_decode($response, true);
    }
}
