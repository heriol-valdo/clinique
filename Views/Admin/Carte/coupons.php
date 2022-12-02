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
App::setTitle("Coupons de réduction");
App::setNavigation("Coupons de réduction");
App::setBreadcumb('<li class="active">Coupons de réduction</li>');
App::addScript('assets/js/coupon.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Coupons de réduction <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <?php if(Privilege::canView(Privilege::$gestionCoupons,$user->privilege)){ ?>
                        <a href="javascript:void(0);" data-toggle="tooltip" class="new" data-original-title="Nouveau coupon de réduction">
                            <i class="icon-plus text-success fa-2x"></i>
                        </a>
                    <?php } ?>
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('coupons') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('coupons') ?>" method="get">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par le code du coupon" name="search" placeholder="Chercher par le code du coupon">
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['debut'])&&!empty($_GET['debut']))?'value="'.$_GET['debut'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date min" name="debut" id="debut" placeholder="Chercher par date min">
                                </div>
                                <div class="col-md-4 form-group">
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
                                    <th class="">Marchand</th>
                                    <th class="">Code</th>
                                    <th class="">Client</th>
                                    <th class="">Utilisation</th>
                                    <th class="">Expiration</th>
                                    <th class="text-right">% ou Montant</th>
                                    <th class="">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($coupons)){
                                    foreach ($coupons as $coupon) {
                                        $montant = empty($coupon->pourcentage)?thousand($coupon->montant).' <small>XOF</small>':$coupon->pourcentage.'%';
                                        $state = '<span class="label label-success">Utilisé</span>';
                                        if(empty($coupon->updated_at)){
                                            if($coupon->etat==0)
                                                $state = '<span class="label label-danger">Supprimé</span>';
                                            elseif ($coupon->fin>=date(MYSQL_DATE_FORMAT))
                                                $state = '<a href="javascript:void(0);" data-toggle="tooltip" data-original-title="Supprimer le coupon"
                                                            class="delete text-danger" data-url="'.App::url('coupons/delete').'" data-id="'.$coupon->id.'"><i class="fa fa-trash-o fa-2x"></i></a>';
                                            else
                                                $state = '<span class="label label-warning">Expiré</span>';
                                        }
                                        $client = empty($coupon->nom) ? "<span class='text-success'>Multi clients</span>" : StringHelper::getShortName($coupon->nom,$coupon->prenom);
                                        $utilisation = empty($coupon->idUser) ? "Restant: <b>".thousand($coupon->max)."</b>" : DateParser::DateShort($coupon->updated_at,1);
                                        echo '<tr>
                                                <td class="">'.$coupon->libMarchand.'</td>
                                                <td class=""><b>'.$coupon->code.'</b></td>
                                                <td class=""><b>'.$client.'</b></td>
                                                <td class="">'.$utilisation.'</td>
                                                <td class="">'.DateParser::DateShort($coupon->fin).'</td>
                                                <td class="text-right"><b>'.$montant.'</b></td>
                                                <td class=""><a href="javascript:void(0);" data-toggle="tooltip" data-original-title="Detail du coupon"
                                                            class="detail text-info" data-url="'.App::url('coupons/detail').'" data-id="'.$coupon->id.'"><i class="fa fa-info-circle fa-2x"></i></a> '.$state.'</td>';
                                    }}else{
                                    echo '<tr><td colspan="7" class="text-danger text-center">L\'historique est vide...</td>';
                                }

                                ?>
                                </tbody>
                                <?php
                                if(!empty($coupons)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="7" class="customerPaginate">
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleForm">DETAIL DU COUPON</h2>
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
<?php if(Privilege::getPrivilege(Privilege::$gestionCoupons,$user->privilege)){ ?>
    <div class="modal fade newModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h2 class="modal-title titleCoForm">AJOUTER UN COUPON DE REDUCTION</h2>
                </div>
                <form action="<?= App::url('coupons/add') ?>" id="newForm" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <p class="mainColor text-right">* Champs obligatoires</p>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="cat">Sélectionner le type de coupon <b>*</b></label>
                                <select name="cat" id="cat" class="form-control">
                                    <option value="">.......</option>
                                    <option value="1">Type pourcentage</option>
                                    <option value="2">Type montant</option>
                                </select>
                            </div>
                            <div class="col-sm-6 form-group valDiv hide">
                                <label for="val" class="valLabel">Pourcentage <b>*</b></label>
                                <input type="number" id="val" name="val" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="max">Max utilisation</label>
                                <input type="number" min="1" id="max" name="max" class="form-control">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="dFin">Date d'expiration du coupon <b>*</b></label>
                                <input type="text" id="dFin" name="fin" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label for="titre">Titre du coupon</label>
                                <input type="text" id="titre" name="titre" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="minimal">Valeur min d'achats <b>*</b></label>
                                <input type="number" id="minimal" name="minimal" class="form-control">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="points">Nombre de points requis <b>*</b></label>
                                <input type="number" id="points" name="points" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="newBtn btn btn-default">VALIDER</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
