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
App::setTitle("Historique du stock de $article->intitule");
App::setNavigation("Historique du stock de $article->intitule");
App::setBreadcumb('<li><a href="javascript:void(0);" onclick="history.go(-1);return false;">Articles</a></li><li class="active">Historique du stock</li>');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= "Historique du stock $article->intitule <small>(".thousand($nbre->Total).")</small>" ?>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip"class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('articles/stock/historique?id='.$_GET['id']) ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('articles/stock/historique') ?>" method="get">
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="type" data-toggle="tooltip" data-original-title="Chercher par type">
                                        <option value="">Chercher par type</option>
                                        <option value="1" <?= (isset($_GET['type']) && $_GET['type'] == 1) ? 'selected' : ''; ?>>Entrée</option>
                                        <option value="2" <?= (isset($_GET['type']) && $_GET['type'] == 2) ? 'selected' : ''; ?>>Sortie</option>
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
                                    <th class="">Date</th>
                                    <th class="">Type</th>
                                    <th class="text-right">Quantité</th>
                                    <th class="text-right">Avant</th>
                                    <th class="text-right">Après</th>
                                    <th class="">Raison</th>
                                    <th class="">Auteur</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($historiques)){
                                    foreach ($historiques as $historique) {
                                        $auteur = empty($historique->idAdmin)?'Système':$historique->libAdmin;
                                        echo
                                            '
                                            <tr>
                                                <td class="">'.DateParser::DateConviviale($historique->created_at,1).'</td>
                                                <td class="">'.StringHelper::$tabType[$historique->type].'</td>
                                                <td class="text-right">'.thousand($historique->nbre).'</td>
                                                <td class="text-right">'.thousand($historique->avant).'</td>
                                                <td class="text-right">'.thousand($historique->apres).'</td>
                                                <td class=""><small>'.StringHelper::isEmpty($historique->raison).'</small></td>
                                                <td class=""><b>'.$auteur.'</b></td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="7" class="text-danger text-center">Aucun historique du stock pour cet article ...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($historiques)){ ?>
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