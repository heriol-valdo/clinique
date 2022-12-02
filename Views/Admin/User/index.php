<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Model\App;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;

App::setTitle("Tableau de bord");
App::setNavigation("Tableau de bord");
App::setBreadcumb("");
App::addScript('assets/plugins/flot/jquery.flot.min.js',true);
App::addScript('assets/plugins/flot/jquery.flot.tooltip.min.js',true);
//App::addScript('assets/plugins/curvedlines/curvedLines.js',true);
App::addStyle('https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css',true);
App::addScript('https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',true);
App::addScript('https://cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js',true);
App::addScript('https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js',true);
App::addScript('assets/pages/dashboard.js',true);
?>
<style>
    .col-lg-3.col-md-6m,.col-md-6 {
        padding-right: 5px !important;
        padding-left: 5px !important;
    }
</style>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p>
                        <a href="<?= App::url('users?debut='.$current.'&end='.$current) ?>">
                            <span class="counter clients1"></span><i class="text-xs"> aujourd'hui</i>
                        </a>
                    </p>
                    <span class="info-box-title">
                        Clients (
                        <a href="<?= App::url('users') ?>">
                            <span class="counter clients2"></span><i class="text-xs"> total</i>
                        </a>,&nbsp;
                        <a href="<?= App::url('users?etat=1') ?>" class="text-primary">
                            <span class="counter clients3"></span><i class="text-xs"> inactif</i>
                        </a>
                        )
                    </span>
                </div>
                <div class="info-box-icon">
                    <i class="icon-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p>
                        <a href="<?= App::url('affilies?debut='.$current.'&end='.$current) ?>">
                            <span class="counter affilies1"></span><i class="text-xs"> aujourd'hui</i>
                        </a>
                    </p>
                    <span class="info-box-title">
                        Affiliés (
                        <a href="<?= App::url('affilies') ?>">
                            <span class="counter affilies2"></span><i class="text-xs"> total</i>
                        </a>,&nbsp;
                        <a href="<?= App::url('affilies?etat=1') ?>" class="text-primary">
                            <span class="counter affilies3"></span><i class="text-xs"> attente</i>
                        </a>
                        )
                    </span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p>
                        <a href="<?= App::url('meetings?debut='.$current.'&end='.$current) ?>">
                            <span class="counter rdv1"></span><i class="text-xs"> aujourd'hui</i>
                        </a>
                    </p>
                    <span class="info-box-title">
                        Rdv (
                        <a href="<?= App::url('meetings') ?>">
                            <span class="counter rdv2"></span><i class="text-xs"> total</i>
                        </a>,&nbsp;
                        <a href="<?= App::url('meetings?etat=Pending') ?>" class="text-primary">
                            <span class="counter rdv3"></span><i class="text-xs"> attente</i>
                        </a>
                        )
                    </span>
                </div>
                <div class="info-box-icon">
                    <i class="icon-clock"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p>
                        <a href="<?= App::url('projets/affilies?debut='.$current.'&end='.$current) ?>">
                            <span class="counter projets1"></span><i class="text-xs"> aujourd'hui</i>
                        </a>
                    </p>
                    <span class="info-box-title">
                        Projets (
                        <a href="<?= App::url('projets/affilies') ?>">
                            <span class="counter projets2"></span><i class="text-xs"> total</i>
                        </a>,&nbsp;
                        <a href="<?= App::url('projets/affilies?etat=1') ?>" class="text-primary">
                            <span class="counter projets3"></span><i class="text-xs"> attente</i>
                        </a>
                        )
                    </span>
                </div>
                <div class="info-box-icon">
                    <i class="icon-docs"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p>
                        <a href="<?= App::url('councils?debut='.$current.'&end='.$current) ?>">
                            <span class="counter conseils1"></span><i class="text-xs"> aujourd'hui</i>
                        </a>
                    </p>
                    <span class="info-box-title">
                        Conseils (
                        <a href="<?= App::url('councils') ?>">
                            <span class="counter conseils2"></span><i class="text-xs"> total</i>
                        </a>,&nbsp;
                        <a href="<?= App::url('councils?etat=1') ?>" class="text-primary">
                            <span class="counter conseils3"></span><i class="text-xs"> inactif</i>
                        </a>
                        )
                    </span>
                </div>
                <div class="info-box-icon">
                    <i class="icon-notebook"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p>
                        <a href="<?= App::url('projets/clients?debut='.$current.'&end='.$current) ?>">
                            <span class="counter pro1"></span><i class="text-xs"> aujourd'hui</i>
                        </a>
                    </p>
                    <span class="info-box-title">
                        Projets Client (
                        <a href="<?= App::url('projets/clients') ?>">
                            <span class="counter pro2"></span><i class="text-xs"> total</i>
                        </a>,&nbsp;
                        <a href="<?= App::url('projets/clients?etat=1') ?>" class="text-primary">
                            <span class="counter pro3"></span><i class="text-xs"> attente</i>
                        </a>
                        )
                    </span>
                </div>
                <div class="info-box-icon">
                    <i class="glyphicon glyphicon-folder-open"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p>
                        <a href="<?= App::url('commandes?debut='.$current.'&end='.$current) ?>">
                            <span class="counter com1"></span><i class="text-xs"> aujourd'hui</i>
                        </a>
                    </p>
                    <span class="info-box-title">
                        Commandes (
                        <a href="<?= App::url('commandes') ?>">
                            <span class="counter com2"></span><i class="text-xs"> total</i>
                        </a>,&nbsp;
                        <a href="<?= App::url('commandes?etat=1') ?>" class="text-primary">
                            <span class="counter com3"></span><i class="text-xs"> attente</i>
                        </a>
                        )
                    </span>
                </div>
                <div class="info-box-icon">
                    <i class="glyphicon glyphicon-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p>
                        <a href="<?= App::url('produits?stock=1') ?>">
                            <span class="counter prod1"></span><i class="text-xs"> en stock</i>
                        </a>
                    </p>
                    <span class="info-box-title">
                        Produits (
                        <a href="<?= App::url('produits') ?>">
                            <span class="counter prod2"></span><i class="text-xs"> total</i>
                        </a>,&nbsp;
                        <a href="<?= App::url('produits?etat=1') ?>" class="text-primary">
                            <span class="counter prod3"></span><i class="text-xs"> inactif</i>
                        </a>
                        )
                    </span>
                </div>
                <div class="info-box-icon">
                    <i class="icon-list"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p><small class="text-xs">$</small> <span class="counter ventes1"></span> <i class="text-xs">aujourd'hui</i></p>
                    <span class="info-box-title">Total des ventes ( <small class="text-xxs">$</small> <span class="counter ventes2"></span> )</span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-money"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p><small class="text-xs">$</small> <span class="counter proj1"></span> <i class="text-xs">aujourd'hui</i></p>
                    <span class="info-box-title">Projets payés ( <small class="text-xxs">$</small> <span class="counter proj2"></span> )</span>
                </div>
                <div class="info-box-icon">
                    <i class="icon-folder-alt"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p>
                        <a href="<?= App::url('commandes?debut='.$current.'&end='.$current) ?>">
                            <span class="counter ret1"></span><i class="text-xs"> aujourd'hui</i>
                        </a>
                    </p>
                    <span class="info-box-title">
                        Retraits demandés (
                        <a href="<?= App::url('commandes') ?>">
                            <span class="counter ret2"></span><i class="text-xs"> total</i>
                        </a>,&nbsp;
                        <a href="<?= App::url('commandes?etat=1') ?>" class="text-primary">
                            <span class="counter ret3"></span><i class="text-xs"> attente</i>
                        </a>
                        )
                    </span>
                </div>
                <div class="info-box-icon">
                    <i class="icon-credit-card"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p>
                        <span class="counter art1"></span><i class="text-xs"> aujourd'hui</i>
                    </p>
                    <span class="info-box-title">
                        Articles vendus (
                        <span class="counter art2"></span><i class="text-xs"> total</i>
                        ,&nbsp;
                        <span class="counter art3"></span><i class="text-xs"> attente</i>
                        )
                    </span>
                </div>
                <div class="info-box-icon">
                    <i class="icon-book-open"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(Privilege::canView(Privilege::$eshopDashboardAffaire,$user->privilege)){ ?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel info-box panel-dark">
                <div class="panel-body">
                    <div class="info-box-stats">
                        <p class="dCA"></p>
                        <span class="info-box-title">Chiffres d'affaires E-Commerce</span>
                    </div>
                    <div class="info-box-icon">
                        <div class="reportrange1" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar" style="font-size: inherit"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down" style="font-size: inherit"></i>
                            <input type="hidden" id="dCA1">
                            <input type="hidden" id="dCA2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel info-box panel-dark">
                <div class="panel-body">
                    <div class="info-box-stats">
                        <p class="dCB"></p>
                        <span class="info-box-title">Chiffres d'affaires Projets</span>
                    </div>
                    <div class="info-box-icon">
                        <div class="reportrange2" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar" style="font-size: inherit"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down" style="font-size: inherit"></i>
                            <input type="hidden" id="dCB1">
                            <input type="hidden" id="dCB2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h4 class="panel-title">Evolution des commandes</h4>
            </div>
            <div class="panel-body">
                <div id="flotchart1"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h4 class="panel-title">Evolution des projets</h4>
            </div>
            <div class="panel-body">
                <div id="flotchart2"></div>
            </div>
        </div>
    </div>
</div>