<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\Vues;
use Projet\Database\Worker;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Historique d'abonnements aux cartes de fidelité");
App::setNavigation("Historique d'abonnements aux cartes de fidelité");
App::setBreadcumb('<li class="active">Historique d\'abonnements aux cartes de fidelité</li>');
App::addScript('assets/js/history.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Historique d'abonnements aux cartes de fidelité <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('cartes/history') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('cartes/history') ?>" method="get">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <select name="carte" class="form-control" data-toggle="tooltip" data-original-title="Chercher par carte de fidelité">
                                        <option value="">Chercher par carte de fidelité</option>
                                        <?php
                                        foreach ($cartes as $carte) {
                                            $is = isset($_GET['carte'])&&$_GET['carte']==$carte->id?' selected':'';
                                            echo '<option value="'.$carte->id.'"'.$is.'>'.$carte->nom.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par numéro de carte ou client" name="search" placeholder="Chercher par numéro de carte ou client">
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
                                    <th class="">Validité</th>
                                    <th class="">Numéro</th>
                                    <th class="">Client</th>
                                    <th class="">Carte</th>
                                    <th class="text-right">% red</th>
                                    <th class="text-right">% comm</th>
                                    <th class="">Marchand</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($historis)){
                                    foreach ($historis as $histori) {
                                        $state = '<span class="label label-info">Archivé</span>';
                                        $client = empty($histori->nom)?'<i class="text-warning">Non affecté</i>':StringHelper::getShortName($histori->nom,$histori->prenom);
                                        $stat1 = '';
                                        if($histori->courant==1){
                                            if(empty($histori->nom)){
                                                $stat1 = '<a href="javascript:void(0);" 
                                                            data-toggle="tooltip" data-original-title="Associer la carte à un client"
                                                            class="associer text-success" data-numero="'.$histori->carteNumero.'"
                                                            data-reduction="'.$histori->pourcentage.'" data-id="'.$histori->id.'"><i class="fa fa-exchange fa-2x"></i>
                                                        </a>';
                                            }
                                            if($histori->fin<date(MYSQL_DATE_FORMAT))
                                                $state = '<span class="label label-danger">Expiré</span>';
                                            else
                                                $states = $histori->etat==1?
                                                    '<a href="javascript:void(0);" 
                                                            data-toggle="tooltip" data-original-title="Désactiver la carte"
                                                            class="desactiver text-danger" data-numero="'.$histori->carteNumero.'"
                                                            data-url="'.App::url('cartes/history/delete').'"
                                                            data-id="'.$histori->id.'"><i class="fa fa-close fa-2x"></i>
                                                        </a>':
                                                    '<a href="javascript:void(0);" 
                                                            data-toggle="tooltip" data-original-title="Activer la carte"
                                                            class="activer text-success" data-numero="'.$histori->carteNumero.'"
                                                            data-url="'.App::url('cartes/history/delete').'"
                                                            data-id="'.$histori->id.'"><i class="fa fa-check fa-2x"></i>
                                                        </a>';
                                            $state =
                                                '
                                                        <a href="javascript:void(0);" 
                                                            class="edit text-primary" 
                                                            data-toggle="tooltip" data-original-title="Modifier la carte"
                                                            data-carte="'.$histori->idCarte.'" data-pourcentage="'.$histori->pourcentage.'"
                                                            data-mois="'.$histori->nbre.'" data-minimum="'.$histori->minimum.'" data-moyens="'.$histori->moyens.'"
                                                            data-id="'.$histori->id.'" data-numero="'.$histori->carteNumero.'"><i class="fa fa-edit fa-2x"></i>
                                                        </a>'.$states.'
                                                        <a href="javascript:void(0);" 
                                                            data-toggle="tooltip" data-original-title="Prolonger la carte"
                                                            class="prolonger text-success"  data-numero="'.$histori->carteNumero.'"
                                                            data-id="'.$histori->id.'"><i class="fa fa-upload fa-2x"></i>
                                                        </a>
                                                        ';
                                        }
                                        echo '<tr>
                                                <td class="">'.DateParser::DateShort($histori->debut).' → '.DateParser::DateShort($histori->fin).'</td>
                                                <td class=""><b>'.$histori->carteNumero.'</b></td>
                                                <td class="">'.$client.'</td>
                                                <td class="">'.$histori->libCarte.'</td>
                                                <td class="text-right"><b>'.$histori->pourcentage.'%</b></td>
                                                <td class="text-right"><b>'.float_value($histori->commission).'%</b></td>
                                                <td class="">'.$histori->libMarchand.'</td>
                                                <td class="text-center"><a href="javascript:void(0);" data-toggle="tooltip" data-original-title="Detail de la carte"
                                                            class="detail text-info" data-url="'.App::url('cartes/detail').'" data-id="'.$histori->id.'"><i class="fa fa-info-circle fa-2x"></i></a> '.$stat1.$state.'</td></tr>';
                                    }}else{
                                    echo '<tr><td colspan="8" class="text-danger text-center">L\'historique est vide...</td>';
                                }

                                ?>
                                </tbody>
                                <?php
                                if(!empty($historis)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="8" class="customerPaginate">
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
<div class="modal fade carteModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleCForm"></h2>
            </div>
            <form action="<?= App::url('cartes/history/edit') ?>" id="carteForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idHistory" name="idHistory">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="carte">Sélectionner la carte de fidelité <b>*</b></label>
                            <select id="carte" name="carte" class="form-control">
                                <option value="">.......</option>
                                <?php
                                foreach($cartes as $carte){
                                    echo"<option value='$carte->id'>$carte->nom ($carte->pourcentage% - ".thousand($carte->prix)." XOF)</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="mois">Nombre d'années de l'abonnement <b>*</b></label>
                            <input type="number" id="mois" name="mois" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="minimum">Valeur min d'achats <b>*</b></label>
                            <input type="number" id="minimum" name="minimum" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="control-label">Choisir le moyen de paiement <b>*</b></label>
                            <select id="moyens" name="moyens" class="form-control">
                                <option value="">.......</option>
                                <option value="Dépôt bancaire">Dépôt bancaire</option>
                                <option value="Orange Money">Orange Money</option>
                                <option value="Viettel Mobile Money">Viettel Mobile Money</option>
                                <option value="Espèces">Espèces</option>
                                <option value="Autres moyens">Autres moyens</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="sendCBtn btn btn-default">MODIFIER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade carteProModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleProForm"></h2>
            </div>
            <form action="<?= App::url('cartes/history/prolonger') ?>" id="carteProForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idHistoryPro" name="idHistoryPro">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="moisPro">Nombre d'années à prolonger <b>*</b></label>
                            <input type="number" id="moisPro" name="moisPro" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="amountPro">Coût du prolongement <b>*</b></label>
                            <input type="number" id="amountPro" name="amountPro" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="sendProBtn btn btn-default">PROLONGER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade associerModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleAssoForm"></h2>
            </div>
            <form action="<?= App::url('cartes/history/associer') ?>" id="associerForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idAssocier" name="id">
                    <input type="hidden" value="1" name="type">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label for="num">Numéro de téléphone ou Email du client <b>*</b></label>
                            <input type="tel" id="num" name="num" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="associerBtn btn btn-default">PROCEDER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade messageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleForm">DETAIL DE LA CARTE DE FIDELITE</h2>
            </div>
            <div class="modal-body">
                <div class="loader">
                    <p class="text-center m-t-lg"><img class="img-xs" src="<?= FileHelper::url('assets/images/load.gif') ?>" alt=""></p>
                </div>
                <div class="contenus hide">

                </div>
            </div>
        </div>
    </div>
</div>