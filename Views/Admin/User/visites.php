<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\Classe;
use Projet\Database\Classe_Eleve;
use Projet\Database\Cours;
use Projet\Database\Enseignant;
use Projet\Database\Paiement;
use Projet\Database\Scolarite;
use Projet\Database\Visite;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\Encrypt;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les visites");
App::setNavigation("Les visites");
App::setBreadcumb('<li class="active">Visites</li>');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Visites <small>(<?= $nbre->Total; ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip"class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('visites') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('visites') ?>" method="get">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['debut'])&&!empty($_GET['debut']))?'value="'.$_GET['debut'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date visite min" name="debut" id="debut" placeholder="Chercher par date visite min">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['end'])&&!empty($_GET['end']))?'value="'.$_GET['end'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date visite max" name="end" id="end" placeholder="Chercher par date visite max">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-10 col-md-2">
                                    <button class="btn btn-block btn-default" type="submit">Chercher</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <div class="table-responsive project-stats">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="">Date</th>
                                    <th class="">IP</th>
                                    <th class="">Device</th>
                                    <th class="">Pays</th>
                                    <th class="">Région</th>
                                    <th class="">Localisation</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($visites)){
                                    foreach ($visites as $visite) {
                                        $nombre = Visite::byIp($visite->ip);
                                        ?>
                                        <tr>
                                            <td class=""><?= DateParser::DateConviviale($visite->created_at,1); ?></td>
                                            <td class=""><?= $visite->ip.' <small>('.$nombre->Total.' fois)</small>'; ?></td>
                                            <td class=""><?= $visite->device; ?></td>
                                            <td class=""><?= $visite->pays; ?></td>
                                            <td class=""><?= $visite->region; ?></td>
                                            <td class=""><?= $visite->location; ?></td>
                                        </tr>
                                    <?php } } else{ ?>
                                    <tr>
                                        <td colspan="6" class="text-danger text-center">Aucune visite enregistrée</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <?php
                                if(!empty($visites)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php $paginator->paginateTwo(); ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tfoot>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>