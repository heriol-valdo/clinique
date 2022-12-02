<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\affiliate_user;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Projets Affiliés");
App::setNavigation("Projets Affiliés");
App::addScript('https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js',true);
App::addScript('https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.js',true);
App::addScript('assets/js/project.js',true);
App::setBreadcumb('<li class="active">Projets Affiliés</li>');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= "Projets Affiliés <small>(".thousand($nbre->Total).")</small>" ?>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip"class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('projets/affilies') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('projets/affilies') ?>" method="get">
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
                                    <th class="">Affilié</th>
                                    <th class="">Service</th>
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
                                        $more = '';
                                        if($project->status==1){
                                            $more =
                                                '
                                                <a href="javascript:void(0);" class="detail" data-url="'.App::url('affilies/projects/details').'" data-id="'.$project->id.'"
                                                data-toggle="tooltip" data-original-title="Détail de la réponse">
                                                    <i class="fa fa-eye text-info fa-2x"></i>
                                                </a>
                                                ';
                                        }
                                        $response =
                                            '
                                            <a href="javascript:void(0);" class="image" data-service="'.$project->service.'" data-nom="'.$project->project_name.'" data-id="'.$project->id.'"
                                            data-toggle="tooltip" data-original-title="Répondre au projet">
                                                <i class="fa fa-reply text-primary fa-2x"></i>
                                            </a>
                                            ';
                                        $affilie = affiliate_user::byId($project->affiliate_id);
                                        echo
                                            '
                                            <tr>
                                                <td class="">'.$affilie->username.'</td>
                                                <td class="">'.$project->service.'</td>
                                                <td class="text-primary">'.$project->project_name.'</td>
                                                <td class="">'.StringHelper::$tabEtatPrimes[$project->status].'</td>
                                                <td class="">'.DateParser::DateShort($project->date,1).'</td>
                                                <td>'.$response.'
                                                    <a href="javascript:void(0);" class="detail" data-url="'.App::url('affilies/projects/detail').'" data-id="'.$project->id.'"
                                                    data-toggle="tooltip" data-original-title="Détail du projet">
                                                        <i class="fa fa-info-circle fa-2x"></i>
                                                    </a>
                                                    '.$more.'
                                                </td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="6" class="text-danger text-center">Aucun projet trouvé...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($projects)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6">
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
<div class="modal fade imageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleImage">CHANGER L'IMAGE PRINCIPALE</h2>
            </div>
            <form action="<?= App::url('affilies/projects/repondre') ?>" id="imageForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idImage" name="idImage">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="file">Image(s) <b>*</b></label>
                            <input type="file" class="form-control" id="file" accept="image/*" multiple name="file[]" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="pdf">Pdf(s)</label>
                            <input type="file" class="form-control" id="pdf" accept=".pdf" multiple name="pdf[]">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="doc">Docx(s)</label>
                            <input type="file" class="form-control" id="doc" accept=".doc,.docx" multiple name="doc[]">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="imageBtn btn btn-default">ENREGISTRER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>