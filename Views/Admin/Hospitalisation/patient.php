<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 03/09/2020
 * Time: 13:47
 */
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\Paginator;
use Projet\Model\StringHelper;


$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les Patients");
App::setNavigation("Les Patients");
App::setBreadcumb('<li class="active">Patients</li>');
App::addScript('assets/js/patient.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Patients <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip"  data-original-title="Nouveau Patient">
                        <i class="icon-plus add text-success fa-2x"></i>
                    </a>
                    <a target="_blank" href="<?= App::url('patient/pdf?search='.$search) ?>"
                       data-toggle="tooltip" data-original-title="Generer le fichier PDF des Patients" ><i class="fa fa-file-pdf-o fa-2x text-primary"></i></a>
                    <a target="_blank" href="<?= App::url('patient/excell?search='.$search) ?>"
                       data-toggle="tooltip" data-original-title="Generer le fichier Excel des Patients" ><i class="fa fa-file-excel-o fa-2x text-info"></i></a>

                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('patients') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('patients') ?>" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="search" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?> placeholder="Chercher par nom ou prenom ou numéro ..." class="form-control" >
                                    </div>
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
                                <thead class="noBackground">
                                <tr>
                                    <th class="">Nom</th>
                                    <th class="">Sexe</th>
                                    <th class="">Age</th>
                                    <th class="">Groupe</th>
                                    <th class="">Poids</th>
                                    <th class="">Taille</th>
                                    <th class="">Etat</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="table-Villes">
                                <?php
                                if (!empty($items)){

                                    foreach ($items as $item) {
                                      $stat1 = $stat2="";
                                      $stat1 = '<a href="javascript:void(0);" class="edit text-success"
                                                   data-id="'.$item->id.'" data-nom="'.$item->nom.'" data-prenom="'.$item->prenom.'"
                                                   data-sexe="'.$item->sexe.'" data-date_nais="'.$item->date_nais.'"
                                                   data-group="'.$item->groupe.'" data-poids="'.$item->poids.'"
                                                   data-taille="'.$item->taille.'" data-numero="'.$item->numero.'">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>&nbsp
                                                ';
                                        $stat2 = '<a href="javascript:void(0);" class="trash text-danger"
                                                   data-url="'.App::url('patient/delete').'"
                                                   data-id="'.$item->id.'"><i class="fa fa-trash fa-2x"></i>
                                                 </a>';

                                        echo '<tr>
                                           <td class=""> 
                                           <b>'.StringHelper::isEmpty($item->nom)." ".StringHelper::isEmpty($item->prenom).'</b><br>
                                           <small><i>Tel :'.StringHelper::isEmpty($item->numero).'</i></small> <br>
                                           </td>
                                            <td class=""><small class="text-primary">'.StringHelper::isEmpty($item->sexe).'</small></td>
                                            <td class="">'.DateParser::calculAge($item->date_nais).'</td>
                                            <td class="">'.$item->groupe.' </td>
                                            <td class="text-danger">'.$item->poids.'<small>Kg</small></td>
                                            <td class="text-success">'.$item->taille.' <small>m</small></td>
                                           <td class="">'.StringHelper::$tabState[$item->etat].'</td>
                                            <td class="text-center">
                                                '.$stat1 .$stat2 .'
                                            </td>
                                        </tr>';
                                   } } else{ ?>
                                    <tr>
                                        <td colspan="8" class="text-danger text-center">Liste des patients vide</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <?php
                                if(!empty($items)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="8">
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
<div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="intro">Enregistrer un patiente</h2>
            </div>
            <form action="<?= App::url('patient/save') ?>" id="newFrom" method="post">
                <div class="modal-body">
                    <input type="hidden" id="idElement">
                    <input type="hidden" id="action">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Nom <b>*</b></label>
                                <input type="text" id="nom" class="form-control" placeholder="Nom" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Prénom <b>*</b></label>
                                <input type="text" id="prenom" class="form-control" placeholder="Prénom" required>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="sexe">Sexe <b>*</b></label>
                            <select name="sexe" id="sexe" class="form-control">
                                <option value="">.......</option>
                                <option value="MASCULIN">MASCULIN</option>
                                <option value="FEMININ">FEMININ</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Date naissance <b>*</b></label>
                                    <input type="text" id="date_nais" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Numéro <b>*</b></label>
                                    <input type="text" id="numero" class="form-control" placeholder="Numéro" required>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Poids <b>*</b></label>
                                    <input type="text" id="poids" class="form-control" placeholder="Poids" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Taille <b>*</b></label>
                                    <input type="text" id="taille" class="form-control" placeholder="taille" required>
                                </div>
                            </div>
                           <div class="col-md-4 form-group">
                            <label for="group">Groupe sanguin <b>*</b></label>
                            <select name="group" id="group" class="form-control">
                                <option value="">...</option>
                                <option value="O-">O-</option>
                                <option value="O+">O+</option>
                                <option value="A-">A-</option>
                                <option value="A+">A+</option>
                                <option value="B-">B-</option>
                                <option value="B+">B+</option>
                                <option value="AB-">AB-</option>
                                <option value="AB+">AB+</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="confirm" class="newBtn btn btn-default">AJOUTER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
