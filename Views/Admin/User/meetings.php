<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\affiliate_portfolio_profile;
use Projet\Database\affiliate_user;
use Projet\Database\users;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Rendez-vous");
App::setNavigation("Rendez-vous");
App::addScript('assets/js/rdv.js',true);
App::setBreadcumb('<li class="active">Rendez-vous</li>');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= "Rendez-vous <small>(".thousand($nbre->Total).")</small>" ?>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip"class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('meetings') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                    <a target="_blank" href="<?= App::url('meetings/pdf?etat='.$s_etat.'&mode ='.$s_mode.'&debut='.$s_debut.'&end='.$s_end) ?>"
                       data-toggle="tooltip" data-original-title="Generer le fichier PDF des Rendez-vous " ><i class="fa fa-file-pdf-o fa-2x text-primary"></i></a>
                    <a target="_blank" href="<?= App::url('meetings/excell?etat='.$s_etat.'&mode ='.$s_mode .'&debut='.$s_debut.'&end='.$s_end) ?>"
                       data-toggle="tooltip" data-original-title="Generer le fichier Excel des Rendez-vous " ><i class="fa fa-file-excel-o fa-2x text-info"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('meetings') ?>" method="get">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <select class="form-control" name="mode" data-toggle="tooltip" data-original-title="Chercher par mode">
                                        <option value="">Chercher par mode</option>
                                        <option value="Audio" <?= (isset($_GET['mode']) && $_GET['mode'] == 'Audio') ? 'selected' : ''; ?>>Audio</option>
                                        <option value="Chat" <?= (isset($_GET['mode']) && $_GET['mode'] == 'Chat') ? 'selected' : ''; ?>>Chat</option>
                                        <option value="Video" <?= (isset($_GET['mode']) && $_GET['mode'] == 'Video') ? 'selected' : ''; ?>>Video</option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <select class="form-control" name="etat" data-toggle="tooltip" data-original-title="Chercher par etat">
                                        <option value="">Chercher par etat</option>
                                        <option value="Approved" <?= (isset($_GET['etat']) && $_GET['etat'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
                                        <option value="Pending" <?= (isset($_GET['etat']) && $_GET['etat'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['debut'])&&!empty($_GET['debut']))?'value="'.$_GET['debut'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date min" name="debut" id="debut" placeholder="Chercher par date min">
                                </div>
                                <div class="col-md-3 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['end'])&&!empty($_GET['end']))?'value="'.$_GET['end'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date max" name="end" id="end" placeholder="Chercher par date max">
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
                                    <th class="">Client</th>
                                    <th class="">Affilié</th>
                                    <th class="">Function</th>
                                    <th class="">Mode</th>
                                    <th class="">Statut</th>
                                    <th class="">Demandé le</th>
                                    <th class="">#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($meetings)){
                                    foreach ($meetings as $meeting) {
                                        $client = users::find($meeting->customer_id);
                                        $affilie = affiliate_user::byId($meeting->affiliate_id);
                                        $affilie_profile = affiliate_portfolio_profile::find($meeting->affiliate_id);
                                        echo
                                            '
                                            <tr>
                                                <td class="">'.DateParser::DateShort($meeting->date.' '.$meeting->time,1).'</td>
                                                <td class="text-info">'.$client->username.'</td>
                                                <td class="text-primary">'.$affilie->username.'</td>
                                                <td class="">'.$affilie_profile->category.'</td>
                                                <td class="">'.StringHelper::$tabRdv[$meeting->mode_of_meeting].'</td>
                                                <td class="">'.StringHelper::$tabEtatPrime[$meeting->status].'</td>
                                                <td class="">'.DateParser::DateShort($meeting->created_date,1).'</td>
                                                <td><a href="javascript:void(0);" class="detail btn-link" data-url="'.App::url('meetings/detail').'" data-id="'.$meeting->id.'">Voir plus</a></td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="8" class="text-danger text-center">Aucun rendez-vous trouvé...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($meetings)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <?php $paginator->paginateTwo(); ?>
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
<div class="modal fade messageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">DETAIL RENDEZ-VOUS</h2>
            </div>
            <div class="modal-body">
                <div class="loader">
                    <p class="text-center"><img class="img-xs" src="<?= FileHelper::url('assets/images/load.gif') ?>" alt=""></p>
                </div>
                <div class="contenus hide">

                </div>
            </div>
        </div>
    </div>
</div>