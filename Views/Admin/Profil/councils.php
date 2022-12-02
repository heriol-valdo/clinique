<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\affiliate_user;
use Projet\Database\Classe;
use Projet\Database\Classe_Eleve;
use Projet\Database\comment;
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
App::setNavigation("Conseils de $affilie->username");
App::setTitle("Conseils de $affilie->username");
App::addScript('assets/js/councils.js',true);
App::setBreadcumb('<li><a href="javascript:void(0);" onclick="history.go(-1);return false;">Affiliés</a></li><li class="active">Conseils</li>');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= "Conseils de $affilie->username <small>(".thousand($nbre->Total).")</small>" ?>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip"class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('users/councils?id='.$_GET['id']) ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('users/councils') ?>" method="get">
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="etat" data-toggle="tooltip" data-original-title="Chercher par etat">
                                        <option value="">Chercher par etat</option>
                                        <option value="2" <?= (isset($_GET['etat']) && $_GET['etat'] == 2) ? 'selected' : ''; ?>>Activé</option>
                                        <option value="1" <?= (isset($_GET['etat']) && $_GET['etat'] == 3) ? 'selected' : ''; ?>>Désactivé</option>
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
                                    <th class="text-center">Image</th>
                                    <th class="">Titre</th>
                                    <th class="">Etat</th>
                                    <th class="text-center">#</th>
                                    <th class="">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($councils)){
                                    foreach ($councils as $council) {
                                        $stat1 = "";
                                        $stat2 = "";
                                        if($council->status==0){
                                          if(Privilege::canView(Privilege::$eshopCouncilActive,$user->privilege)){
                                            $stat1 = '<li>
                                                   <a href="javascript:void(0);" data-url="'.App::url('councils/activate').'" 
                                                   class="activate color-green " data-status="'.$council->status.'" data-id="'.$council->id.'">Activer </a>
                                                   </li>';
                                          }
                                        }else{
                                          if(Privilege::canView(Privilege::$eshopCouncilDesactive,$user->privilege)) {
                                              $stat1 = '<li>
                                                    <a href="javascript:void(0);" data-url="' . App::url('councils/activate') . '" 
                                                   class="activate color-red" data-status="' . $council->status . '" data-id="' . $council->id . '">Désactiver </a>
                                                   </li>';
                                          }
                                        }
                                        $nbre = comment::countBySearchType($council->id);
                                        ?>
                                        <tr>
                                            <td class="text-center"><img src="<?= FileHelper::url($council->image) ;?>" style="height: 50px;width: 70px" alt="Img"></td>
                                            <td class=""><?= StringHelper::abbreviate($council->title,50) ;?></td>
                                            <td class=""><?= StringHelper::$tabState[$council->status]; ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        Actions <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="javascript:void(0);" class="detail" data-url="<?=App::url('councils/detail');?>" data-id="<?=$council->id;?>">Détail</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" data-url="<?=App::url('councils/commentaires');?>"
                                                               class="details" data-id="<?=$council->id ;?>">Commentaires (<?= thousand($nbre->Total); ?>) </a>
                                                        </li>
                                                        <?=$stat1;?>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class=""><?=\Projet\Model\DateParser::DateShort($council->created_on,1);?></td>
                                        </tr>
                                    <?php } } else{ ?>
                                    <tr>
                                        <td colspan="5" class="text-danger text-center">Liste des conseils vide...</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <?php
                                if(!empty($councils)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5">
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
    <div class="modal-dialog" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">DETAIL CONSEIL</h2>
            </div>
            <div class="modal-body">
                <div class="contenus hide">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade detailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">COMMENTAIRES DU CONSEIL</h2>
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