<?php
/**
 * Created by PhpStorm.
 * User: yousseph
 * Date: 18/05/2020
 * Time: 12:37
 */
use Projet\Model\App;
use Projet\Model\Paginator;
use Projet\Model\Privilege;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les taxes");
App::setNavigation("Les taxes");
App::setBreadcumb('<li class="active">Les taxes</li>');
App::addStyle('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',true);
App::addScript('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js',true);
App::addScript('assets/js/state.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                   Taxes <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <?php if(Privilege::canView(Privilege::$eshopConfigTaxeAdd,$user->privilege)){ ?>
                        <a href="javascript:void(0);" data-toggle="tooltip" class="new" data-original-title="Nouvelle taxe">
                            <i class="icon-plus text-success fa-2x"></i>
                        </a>
                    <?php } ?>
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('state') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('state') ?>" method="get">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['state_name'])&&!empty($_GET['state_name']))?'value="'.$_GET['state_name'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par nom de la taxe" name="state_name" placeholder="Chercher par le nom de la taxe">
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
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <div class="table-responsive project-stats">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th class="text-left">State Name</th>
                                    <th class="text-right">TPS <small>(%)</small></th>
                                    <th class="text-right">TVQ <small>(%)</small></th>
                                    <th class="text-center">#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($tax_lists)){
                                    foreach ($tax_lists as $tax_list) {
                                        $mod = $del = '';
                                        if(Privilege::canView(Privilege::$eshopConfigTaxeEdit,$user->privilege)){
                                            $mod =
                                                ' <li>
                                                        <a href="javascript:void(0);" data-id="'.$tax_list->id.'"data-state_name="'.$tax_list->state_name.'"
                                                        data-tps="'.$tax_list->tps.'" data-tvq="'.$tax_list->tvq.'"
                                                        class="edit">Modifier</a>   
                                                    </li>
                                                ';
                                        }
                                        if(Privilege::canView(Privilege::$eshopConfigTaxeDelete,$user->privilege)){
                                            $del =
                                                ' <li>
                                                        <a href="javascript:void(0);" data-url="'.App::url('state/delete').'" 
                                                        class="trash delete" data-id="'.$tax_list->id.'">Supprimer</a>
                                                    </li>
                                                ';
                                        }
                                        echo
                                            '
                                            <tr>
                                                <td class="">'.$tax_list->state_name.'</td>
                                                <td class="text-right"> '.$tax_list->tps.'</td>
                                                <td class="text-right"> '.$tax_list->tvq.'</td>
                                                <td class="text-center">
                                                 <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Actions <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                           '.$mod.$del.'
                                                        </ul>
                                                    </div>
                                                </td>
                                                
                                            </tr>';
                                    }}else{
                                    echo '<tr><td colspan="4" class="text-danger text-center">Liste des taxes vide ...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($tax_list)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4">
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
    </div>
</div>
<div class="modal fade newModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleForm">Titre</h2>
            </div>
            <form action="<?= App::url('state/save') ?>" id="newForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="action" name="action">
                    <input type="hidden" id="idElement" name="id">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="state_name">State Name <b>*</b></label>
                            <input type="text" class="form-control" name="state_name" id="state_name" placeholder="state name">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="tps">TPS <b>*</b></label>
                            <input type="text" class="form-control" name="tps" id="tps" placeholder="TPS">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="tvq">TVQ <b>*</b></label>
                            <input type="text" class="form-control" name="tvq" id="tvq" placeholder="tvq">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="newBtn btn btn-default">Ajouter</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade photoModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="<?= App::url('state/change') ?>" id="photoForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idPhoto" name="idPhoto">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="photoBtn btn btn-default">MISE A JOUR</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>

