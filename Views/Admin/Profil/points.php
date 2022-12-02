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
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Points de $profil->nom $profil->prenom");
App::setNavigation("Points de $profil->nom $profil->prenom");
App::setBreadcumb('<li><a href="javascript:void(0);" onclick="history.go(-1);return false;">Clients</a></li><li class="active">Points</li>');
App::addScript('assets/js/coupon.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= "Points de $profil->nom $profil->prenom <small>(".thousand($nbre->Total).")</small>" ?>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('users/points?id='.$_GET['id']) ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('users/points') ?>" method="get">
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['debut'])&&!empty($_GET['debut']))?'value="'.$_GET['debut'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date min" name="debut" id="debut" placeholder="Chercher par date min">
                                </div>
                                <div class="col-md-6 form-group">
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
                                    <th class="">Ajout</th>
                                    <th class="">Marchand</th>
                                    <th class="text-right">Nombre de points</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($points)){
                                    foreach ($points as $point) {
                                        $state = '<a href="'.App::url('users/points/history?id='.$point->id).'" data-toggle="tooltip" data-original-title="Historique"
                                                            class="text-success"><i class="fa fa-info fa-2x"></i></a>';
                                        echo '<tr>
                                                <td class="">'.DateParser::DateShort($point->created_at,1).'</td>
                                                <td class=""><b>'.$point->nomMarchand.'</b></td>
                                                <td class="text-right"><b>'.float_value($point->points).'</b></td>
                                                <td class="text-center">'.$state.'</td>';
                                    }}else{
                                    echo '<tr><td colspan="4" class="text-danger text-center">Aucune configuration de points existante...</td>';
                                }

                                ?>
                                </tbody>
                                <?php
                                if(!empty($points)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4" class="customerPaginate">
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