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
                                <a href="<?php echo admin_url('plesk_integration'); ?>" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Torna alla Dashboard
                                </a>
                            </div>
                        </div>
                        <hr class="hr-panel-heading" />
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-triangle"></i> <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($websites)): ?>
                            <div class="table-responsive">
                                <table class="table dt-table">
                                    <thead>
                                        <tr>
                                            <th>Nome Dominio</th>
                                            <th>Stato</th>
                                            <th>Tipo Hosting</th>
                                            <th>IP Address</th>
                                            <th>Data Creazione</th>
                                            <th>Scadenza</th>
                                            <th>Azioni</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($websites as $website): ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($website['name']); ?></strong>
                                                </td>
                                                <td>
                                                    <?php
                                                    $status_class = '';
                                                    switch ($website['status']) {
                                                        case 'active':
                                                            $status_class = 'plesk-status-active';
                                                            $status_text = 'Attivo';
                                                            break;
                                                        case 'suspended':
                                                            $status_class = 'plesk-status-suspended';
                                                            $status_text = 'Sospeso';
                                                            break;
                                                        default:
                                                            $status_class = 'plesk-status-disabled';
                                                            $status_text = 'Disabilitato';
                                                    }
                                                    ?>
                                                    <span class="<?php echo $status_class; ?>">
                                                        <i class="fa fa-circle"></i> <?php echo $status_text; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo ucfirst($website['hosting_type']); ?></td>
                                                <td><?php echo $website['ip_address'] ?: 'N/A'; ?></td>
                                                <td>
                                                    <?php
                                                    echo $website['created'] ?
                                                        date('d/m/Y', strtotime($website['created'])) : 'N/A';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo isset($website['expires']) && $website['expires'] ?
                                                        date('d/m/Y', strtotime($website['expires'])) : 'N/A';
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo admin_url('plesk_integration/website_details/' . $website['id']); ?>" 
                                                       class="btn btn-default btn-sm">
                                                        <i class="fa fa-eye"></i> Dettagli
                                                    </a>
                                                    <?php if (!empty($website['name'])): ?>
                                                        <a href="http://<?php echo $website['name']; ?>" 
                                                           target="_blank" class="btn btn-info btn-sm">
                                                            <i class="fa fa-external-link"></i> Visita
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> Nessun sito web trovato o errore di connessione.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>

<script>
$(document).ready(function() {
    if ($('.dt-table').length > 0) {
        $('.dt-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Italian.json"
            },
            "order": [[ 0, "asc" ]],
            "pageLength": 25
        });
    }
});
</script>
