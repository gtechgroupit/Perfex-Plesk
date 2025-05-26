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

                                <div class="col-md-6">
                                    <h5><strong>Server configurati</strong></h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Predefinito</th>
                                                <th>Nome</th>
                                                <th>URL</th>
                                                <th>Username</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($servers as $server){ ?>
                                                <tr>
                                                    <td>
                                                        <input type="radio" name="plesk_default_server_id" value="<?php echo $server['id']; ?>" <?php echo get_option('plesk_default_server_id') == $server['id'] ? 'checked' : ''; ?>>
                                                    </td>
                                                    <td><?php echo html_escape($server['name']); ?></td>
                                                    <td><?php echo html_escape($server['url']); ?></td>
                                                    <td><?php echo html_escape($server['username']); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                    <h5><strong>Aggiungi nuovo server</strong></h5>
                                    <div class="form-group">
                                        <label for="new_server_name">Nome</label>
                                        <input type="text" name="new_server_name" id="new_server_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="new_server_url">URL</label>
                                        <input type="url" name="new_server_url" id="new_server_url" class="form-control" placeholder="https://server:8443">
                                    </div>
                                    <div class="form-group">
                                        <label for="new_server_username">Username</label>
                                        <input type="text" name="new_server_username" id="new_server_username" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="new_server_password">Password/API Key</label>
                                        <input type="password" name="new_server_password" id="new_server_password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="new_server_ssl" value="1" checked>
                                                Verifica certificato SSL
                                            </label>
                                        </div>
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
