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
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-triangle"></i> <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="widget widget-statistics-2">
                                    <div class="widget-body">
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <div class="tw-text-lg tw-font-medium"><?php echo $total_websites; ?></div>
                                                <div class="text-muted">Totale Siti Web</div>
                                            </div>
                                            <div class="col-xs-4">
                                                <i class="fa fa-globe fa-2x text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 col-sm-6">
                                <div class="widget widget-statistics-2">
                                    <div class="widget-body">
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <div class="tw-text-lg tw-font-medium"><?php echo $active_websites; ?></div>
                                                <div class="text-muted">Siti Attivi</div>
                                            </div>
                                            <div class="col-xs-4">
                                                <i class="fa fa-check-circle fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mtop25">
                            <div class="col-md-12">
                                <a href="<?php echo admin_url('plesk_integration/websites'); ?>" class="btn btn-primary">
                                    <i class="fa fa-list"></i> Visualizza Tutti i Siti Web
                                </a>
                                <a href="<?php echo admin_url('plesk_integration/settings'); ?>" class="btn btn-default">
                                    <i class="fa fa-cog"></i> Impostazioni
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
