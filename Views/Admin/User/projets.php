<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

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
App::setTitle("Projets Clients");
App::setNavigation("Projets Clients");
App::addScript('https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js',true);
App::addScript('https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.js',true);
App::addScript('assets/js/projet.js',true);
App::setBreadcumb('<li class="active">Projets Clients</li>');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= "Projets Clients <small>(".thousand($nbre->Total).")</small>" ?>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip"class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('projets/clients') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('projets/clients') ?>" method="get">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="etat" data-toggle="tooltip" data-original-title="Chercher par etat">
                                        <option value="">Chercher par etat</option>
                                        <option value="2" <?= (isset($_GET['etat']) && $_GET['etat'] == 2) ? 'selected' : ''; ?>>Réalisé</option>
                                        <option value="1" <?= (isset($_GET['etat']) && $_GET['etat'] == 1) ? 'selected' : ''; ?>>En cours</option>
                                    </select>
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
                                    <th class="">Catégorie</th>
                                    <th class="">Client</th>
                                    <th class="">Affilié</th>
                                    <th class="">Projet</th>
                                    <th class="">Etat</th>
                                    <th class="">Date</th>
                                    <th class="">#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($projects)){
                                    foreach ($projects as $project) {
                                        $explodes = explode(',',$project->affiliate_ids);
                                        $i = 0;
                                        $nom = $nom_client = '';
                                        foreach ($explodes as $explode) {
                                            $item = affiliate_user::byId($explode);
                                            $nom  .= $i == 0 ? $item->username : ", $item->username";
                                            $i++;
                                        }
                                        $client = users::find($project->customer_id);
                                        if($client)
                                            $nom_client = $client->username;
                                        echo
                                            '
                                            <tr>
                                                <td class="">'.$project->category.'</td>
                                                <td class="">'.$nom_client.'</td>
                                                <td class=""><b>'.$nom.'</b></td>
                                                <td class="text-primary">'.$project->project_name.'</td>
                                                <td class="">'.StringHelper::$tabEtatPrimes[$project->status].'</td>
                                                <td class="">'.DateParser::DateShort($project->date,1).'</td>
                                                <td>
                                                    <a href="javascript:void(0);" class="detail btn-link" data-url="'.App::url('users/projects/detail').'" data-id="'.$project->id.'"
                                                data-toggle="tooltip" data-original-title="Detail du projet">
                                                        <i class="fa fa-info-circle fa-2x"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="details btn-link" data-url="'.App::url('users/projects/details').'" data-id="'.$project->id.'"
                                                data-toggle="tooltip" data-original-title="Detail du paiement">
                                                        <i class="fa fa-money text-primary fa-2x"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="7" class="text-danger text-center">Aucun projet trouvé...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($projects)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="7">
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
    <div class="modal-dialog" style="width: 85%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">DETAIL PROJET</h2>
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
<div class="modal fade detailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 95%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">DETAIL PROJET</h2>
            </div>
            <div class="modal-body">
                <div class="loader2">
                    <p class="text-center"><img class="img-xs" src="<?= FileHelper::url('assets/images/load.gif') ?>" alt=""></p>
                </div>
                <div class="contenus2 hide">

                </div>
            </div>
        </div>
    </div>
</div>