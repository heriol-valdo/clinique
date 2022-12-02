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
App::setTitle("Historique du compte virtuel de $profil->nom $profil->prenom");
App::setNavigation("Historique du compte virtuel de $profil->nom $profil->prenom");
App::addScript('assets/js/transaction.js',true);
App::setBreadcumb('<li><a href="javascript:void(0);" onclick="history.go(-1);return false;">Clients</a></li><li class="active">Historique du compte virtuel de '.$profil->nom.' '.$profil->prenom.'</li>');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= "Historique du compte virtuel de $profil->nom $profil->prenom <small>(".thousand($nbre->Total).")</small>" ?>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip"class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('users/comptes/historique?id='.$_GET['id']) ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('users/comptes/historique') ?>" method="get">
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <select class="form-control" name="type" data-toggle="tooltip" data-original-title="Chercher par type">
                                        <option value="">Chercher par type</option>
                                        <option value="1" <?= (isset($_GET['type']) && $_GET['type'] == 1) ? 'selected' : ''; ?>>Entrée</option>
                                        <option value="2" <?= (isset($_GET['type']) && $_GET['type'] == 2) ? 'selected' : ''; ?>>Sortie</option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <select class="form-control" name="etat" data-toggle="tooltip" data-original-title="Chercher par etat">
                                        <option value="">Chercher par etat</option>
                                        <option value="0" <?= (isset($_GET['etat']) && $_GET['etat'] == 0) ? 'selected' : ''; ?>>En cours</option>
                                        <option value="1" <?= (isset($_GET['etat']) && $_GET['etat'] == 1) ? 'selected' : ''; ?>>Validé</option>
                                        <option value="2" <?= (isset($_GET['etat']) && $_GET['etat'] == 2) ? 'selected' : ''; ?>>Annulé</option>
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
                                <div class="col-md-4">
                                    <button class="btn btn-block disabled" disabled type="button">Solde du compte : <?= thousand($user->solde) ?> XOF</button>
                                </div>
                                <div class="col-md-offset-6 col-md-2">
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
                                    <th class="">Type</th>
                                    <th class="text-right">Montant <small>(XOF)</small></th>
                                    <th class="">Raison</th>
                                    <th class="">Moyens</th>
                                    <th class="text-center">Etat</th>
                                    <th class="">#</th>
                                    <th class="">Auteur</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($historiques)){
                                    foreach ($historiques as $historique) {
                                        $etat = '<a><b>...</b></a>';
                                        if($historique->etat==0){
                                            $etat = '<a class="valid" href="javascript:void();" data-url="'.App::url('transactions/active').'"
                                            data-id="'.$historique->id.'"><i class="fa fa-check text-success fa-2x"></i></a>
                                                    <a class="cancel" href="javascript:void();" data-url="'.App::url('transactions/active').'"
                                                    data-id="'.$historique->id.'"><i class="fa fa-close text-danger fa-2x"></i></a>';
                                        }
                                        $numero = '';
                                        if(!empty($historique->numero)){
                                            $numero = '<br><small><b>'.$historique->numero.'</b></small>';
                                        }
                                        echo
                                            '
                                            <tr>
                                                <td class="">'.DateParser::DateShort($historique->created_at,1).'</td>
                                                <td class="">'.StringHelper::$tabType[$historique->type].'</td>
                                                <td class="text-right"><b>'.thousand($historique->montant).'</b></td>
                                                <td class=""><small>'.StringHelper::isEmpty($historique->raison).'</small></td>
                                                <td class="">'.StringHelper::$tabCompteMoyens[$historique->moyens].$numero.'</td>
                                                <td class="">'.StringHelper::$tabEtats[$historique->etat].'</td>
                                                <td class="text-center">'.$etat.'</td>
                                                <td class=""><small>'.$historique->libAdmin.'</small></td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="8" class="text-danger text-center">Aucun historique trouvé ...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($historiques)){ ?>
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