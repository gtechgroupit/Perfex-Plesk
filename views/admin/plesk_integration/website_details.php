<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="no-margin"><?php echo $title; ?></h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="<?php echo admin_url('plesk_integration/websites'); ?>" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Torna alla Lista
                                </a>
                            </div>
                        </div>
                        <hr class="hr-panel-heading" />

                        <div class="plesk-website-card">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><strong>Informazioni Generali</strong></h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td><strong>Nome Dominio:</strong></td>
                                            <td><?php echo htmlspecialchars($website['name']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>ID Plesk:</strong></td>
                                            <td><?php echo $website['id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Stato:</strong></td>
                                            <td>
                                                <?php
                                                switch ($website['status']) {
                                                    case 'active':
                                                        echo '<span class="plesk-status-active"><i class="fa fa-circle"></i> Attivo</span>';
                                                        break;
                                                    case 'suspended':
                                                        echo '<span class="plesk-status-suspended"><i class="fa fa-circle"></i> Sospeso</span>';
                                                        break;
                                                    default:
                                                        echo '<span class="plesk-status-disabled"><i class="fa fa-circle"></i> Disabilitato</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tipo Hosting:</strong></td>
                                            <td><?php echo ucfirst($website['hosting_type'] ?? 'N/A'); ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5><strong>Dettagli Tecnici</strong></h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td><strong>IP Address:</strong></td>
                                            <td><?php echo $website['ip_address'] ?? 'N/A'; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Data Creazione:</strong></td>
                                            <td>
                                                <?php 
                                                echo isset($website['created']) ? 
                                                    date('d/m/Y H:i', strtotime($website['created'])) : 'N/A'; 
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Scadenza:</strong></td>
                                            <td>
                                                <?php 
                                                echo isset($website['expires']) ? 
                                                    date('d/m/Y', strtotime($website['expires'])) : 'N/A'; 
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>SSL:</strong></td>
                                            <td>
                                                <?php 
                                                if (isset($website['ssl_enabled'])) {
                                                    echo $website['ssl_enabled'] ? 
                                                        '<span class="text-success"><i class="fa fa-lock"></i> Abilitato</span>' :
                                                        '<span class="text-danger"><i class="fa fa-unlock"></i> Disabilitato</span>';
                                                } else {
                                                    echo 'N/A';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row mtop15">
                                <div class="col-md-12">
                                    <a href="http://<?php echo $website['name']; ?>" target="_blank" class="btn btn-primary">
                                        <i class="fa fa-external-link"></i> Visita Sito Web
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
