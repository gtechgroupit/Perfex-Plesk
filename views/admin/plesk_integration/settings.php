<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin"><?php echo $title; ?></h4>
                        <hr class="hr-panel-heading" />

                        <?php echo form_open(admin_url('plesk_integration/settings')); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5><strong>Configurazione API Plesk</strong></h5>
                                
                                <div class="form-group">
                                    <label for="plesk_api_url">URL Server Plesk</label>
                                    <input type="url" id="plesk_api_url" name="plesk_api_url" 
                                           class="form-control" 
                                           value="<?php echo get_option('plesk_api_url'); ?>"
                                           placeholder="https://il-tuo-server.plesk.com:8443"
                                           required>
                                    <small class="text-muted">
                                        Inserisci l'URL completo del tuo server Plesk (inclusi https:// e porta)
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="plesk_api_username">Username API</label>
                                    <input type="text" id="plesk_api_username" name="plesk_api_username" 
                                           class="form-control" 
                                           value="<?php echo get_option('plesk_api_username'); ?>"
                                           placeholder="admin o username API"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label for="plesk_api_password">Password API</label>
                                    <input type="password" id="plesk_api_password" name="plesk_api_password" 
                                           class="form-control" 
                                           value="<?php echo get_option('plesk_api_password'); ?>"
                                           placeholder="Password o API Key"
                                           required>
                                    <small class="text-muted">
                                        Puoi usare la password admin o creare una API Key dedicata
                                    </small>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="plesk_ssl_verify" value="1" 
                                                   <?php echo get_option('plesk_ssl_verify') ? 'checked' : ''; ?>>
                                            Verifica certificato SSL
                                        </label>
                                        <small class="text-muted">
                                            Disabilita solo per server di test con certificati self-signed
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5><strong>Opzioni Cache</strong></h5>
                                
                                <div class="form-group">
                                    <label for="plesk_cache_duration">Durata Cache (minuti)</label>
                                    <input type="number" id="plesk_cache_duration" name="plesk_cache_duration" 
                                           class="form-control" 
                                           value="<?php echo get_option('plesk_cache_duration', 30); ?>"
                                           min="5" max="1440">
                                    <small class="text-muted">
                                        Per quanto tempo mantenere in cache i dati da Plesk
                                    </small>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="plesk_auto_sync" value="1" 
                                                   <?php echo get_option('plesk_auto_sync') ? 'checked' : ''; ?>>
                                            Sincronizzazione automatica
                                        </label>
                                        <small class="text-muted">
                                            Aggiorna automaticamente i dati ogni ora
                                        </small>
                                    </div>
                                </div>

                                <h5><strong>Log e Debug</strong></h5>
                                
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="plesk_debug_mode" value="1" 
                                                   <?php echo get_option('plesk_debug_mode') ? 'checked' : ''; ?>>
                                            Modalità Debug
                                        </label>
                                        <small class="text-muted">
                                            Abilita per registrare richieste API nei log
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Salva Impostazioni
                                </button>
                                
                                <button type="submit" name="test_connection" value="1" class="btn btn-info">
                                    <i class="fa fa-plug"></i> Testa Connessione
                                </button>
                                
                                <a href="<?php echo admin_url('plesk_integration'); ?>" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Torna alla Dashboard
                                </a>
                            </div>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
