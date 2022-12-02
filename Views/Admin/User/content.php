<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 21/05/2020
 * Time: 14:50
 */

use Projet\Database\Vues;
use Projet\Database\Worker;
use Projet\Model\App;
use Projet\Model\Paginator;
use Projet\Model\Privilege;


$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);

App::setTitle("Les textes de l'App");
App::setNavigation("Les textes de l'App");
App::setBreadcumb('<li class="active">Textes de l\'App</li>');
App::addStyle('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',true);
App::addScript('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js',true);
App::addScript('assets/js/content.js',true);
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= "Textes de l'App" ?>
                </h5>

                <div class="panel-control">

                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('content') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm  ">
                    <div class= "col-md-offset-1 col-lg-10  ">
                        <?php
                        if(!empty($contents)){
                        foreach ($contents as $content) {
                        echo
                             '<div class="row">
                                  <div class="col-lg-4 col-md-6">
                                    <div class="panel info-box panel-default btn editabout " data-id="'.$content->id.'"  style="background: #e5e5e5; cursor: pointer; padding: 30px 30px; border: 1px solid #ccc; width: 100%">
                                        <div class="panel-body" >
                                           <h5 class="panel-title">
                                                A propos de Nous
                                                <div class="bibio hide">'.$content->about_us.'</div> 
                                            </h5>
                                         </div>
                                        </div>
                                 </div>
                                  <div class="col-lg-4 col-md-6">
                                    <div class="panel info-box panel-default btn editpolicy" data-id="'.$content->id.'" style="background: #e5e5e5; cursor: pointer; padding: 30px 30px; border: 1px solid #ccc; width: 100%">
                                        <div class="panel-body" >
                                           <h5 class="panel-title">
                                               Politique de Confidentialité
                                              <div class="bibioa hide">'.$content->privacy_policy.'</div> 
                                            </h5>
                                         </div>
                                        </div>
                                 </div>
                                  <div class="col-lg-4 col-md-6">
                                    <div class="panel info-box panel-default btn editterm "  data-id="'.$content->id.'" style="background: #e5e5e5; cursor: pointer; padding: 30px 30px; border: 1px solid #ccc; width: 100%">
                                        <div class="panel-body" >
                                           <h5 class="panel-title">     
                                            Conditions Générales
                                        <div class="bibiob hide">'.$content->terms_and_conditions.'</div> 
                                            </h5>
                                         
                                         </div>
                                        </div>
                                 </div>
                                </div>';
                                    }
                        }else{
                                    echo '<h3 class="text-danger text-center">List des contents et vide ...</h3>';
                                }
                        ?>
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
            <form action="<?= App::url('content/about') ?>" id="newForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="action" name="action">
                    <input type="hidden" id="idElement" name="id">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="about_us">A propos de Nous</label>
                            <textarea name="about_us" id="about_us" placeholder="about_us" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="newBtn btn btn-default">Modifier</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade newModala" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleForm">Titre</h2>
            </div>
            <form action="<?= App::url('content/policy') ?>" id="newForma" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="actiona" name="action">
                    <input type="hidden" id="idElementa" name="id">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="privacy_policy">Politique de Confidentialité</b></label>
                            <textarea name="privacy_policy" id="privacy_policy" placeholder="privacy_policy" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="newBtna btn btn-default">Modifier</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade newModalb" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleForm">Titre</h2>
            </div>
            <form action="<?= App::url('content/term') ?>" id="newFormb" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="actionb" name="action">
                    <input type="hidden" id="idElementb" name="id">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="terms_and_conditions">Politique de Confidentialité </label>
                            <textarea name="terms_and_conditions" id="terms_and_conditions" placeholder="terms and conditions" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="newBtnb btn btn-default">Modifier</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>




