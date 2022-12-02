<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 18/05/2020
 * Time: 03:55
 */
use Projet\Database\Vues;
use Projet\Database\Worker;
use Projet\Model\App;
use Projet\Model\Paginator;
use Projet\Model\Privilege;


$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);

App::setTitle("Les Coupons de réduction");
App::setNavigation("Les Coupons de réduction");
App::setBreadcumb('<li class="active">Coupons de réduction</li>');
App::addStyle('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',true);
App::addScript('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js',true);
App::addScript('assets/js/coupons.js',true);
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= "Coupons de réduction <small>(".thousand($nbre->Total).")</small>" ?>
                </h5>
                <div class="panel-control">
                    <?php if(Privilege::canView(Privilege::$eshopArticleAdd,$user->privilege)){ ?>
                        <a href="javascript:void(0);" data-toggle="tooltip" class="new" data-original-title="Nouvel Article">
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
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['coupon_code'])&&!empty($_GET['coupon_code']))?'value="'.$_GET['coupon_code'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par code" name="coupon_code" placeholder="Chercher par le code">
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
                                    <th class="">Code</th>
                                    <th class="">Rémise</th>
                                    <th class="">Description</th>
                                    <th class="">Validité</th>
                                    <th class="text-center">#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($coupons)){
                                    foreach ($coupons as $coupon) {
                                        echo
                                            '<tr>
                                                <td class="">'.$coupon->coupon_code.'</td>
                                                <td class="text-primary">'.$coupon->discount.'%</td>
                                                <td class="">'.$coupon->description.'</td>
                                                <td class="">'.$coupon->end_date.'</td>
                                                <td class="text-center">
                                                 <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Actions <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="javascript:void(0);" data-id="'.$coupon->id.'"data-coupon_code="'.$coupon->coupon_code.'"
                                                                data-discount="'.$coupon->discount.'"
                                                                data-end_date="'.$coupon->end_date.'" data-start_date="'.$coupon->start_date.'"
                                                                class="edit">Modifier</a>
                                                                <div class="bibio hide">'.$coupon->description.'</div>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" class="detail" data-url="'.App::url('coupons/detail').'" data-id="'.$coupon->id.'">Détail</a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" data-url="'.App::url('coupons/delete').'" 
                                                                class="trash delete" data-id="'.$coupon->id.'">Supprimer</a>
                                                            </li>
                                                            
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>';
                                    }
                                }else{
                                    echo '<tr><td colspan="9" class="text-danger text-center">List des coupons et vide ...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($coupons)){ ?>
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
<div class="modal fade newModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleForm">Titre</h2>
            </div>
            <form action="<?= App::url('coupons/save') ?>" id="newForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="action" name="action">
                    <input type="hidden" id="idElement" name="id">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="row ">
                                <div class="col-md-6 ">
                                    <label for="coupon_code">Coupon code <b>*</b></label>
                                    <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Coupon code">
                                </div>
                                <div class="col-md-6 ">
                                    <label for="discount">Rémise <b>*</b></label>
                                    <input type="text" class="form-control" name="discount" id="discount" placeholder="Coupon code">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="row ">
                                <div class="col-md-6 ">
                                    <label for="start_date">Date de début<b>*</b></label>
                                    <input type="text" class="form-control" id="start_date" name="start_date">
                                </div>
                                <div class="col-md-6 ">
                                    <label for="end_date">Date de fin<b>*</b></label>
                                    <input type="text" class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="description">Contenu <b>*</b></label>
                            <textarea name="description" id="description" placeholder="Description" class="form-control"></textarea>
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
<div class="modal fade messageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">DETAIL COUPONS</h2>
            </div>
            <div class="modal-body">
                <div class="contenus hide">

                </div>
            </div>
        </div>
    </div>
</div>