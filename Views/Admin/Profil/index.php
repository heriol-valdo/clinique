<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\customer_project;
use Projet\Database\orders;
use Projet\Database\Vues;
use Projet\Database\wallet;
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
App::setTitle("Les clients");
App::setNavigation("Les clients");
App::setBreadcumb('<li class="active">Clients</li>');
App::addScript('assets/js/clients.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Clients <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" class="panel-collapse" data-toggle="tooltip" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('users') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                    <?php if(Privilege::canView(Privilege::$eshopUserClientEtat,$user->privilege)){ ?>
                        <a target="_blank" href="<?= App::url('clients/pdf?search='.$s_search.'&sexe='.$s_sexe.'&etat='.$s_etat.'&role='.$s_role.'&debut='.$s_debut.'&end='.$s_end) ?>"
                           data-toggle="tooltip" data-original-title="Generer le fichier PDF des clients" ><i class="fa fa-file-pdf-o fa-2x text-primary"></i></a>
                        <a target="_blank" href="<?= App::url('clients/excell?search='.$s_search.'&sexe='.$s_sexe.'&etat='.$s_etat.'&role='.$s_role.'&debut='.$s_debut.'&end='.$s_end) ?>"
                           data-toggle="tooltip" data-original-title="Generer le fichier Excel des clients" ><i class="fa fa-file-excel-o fa-2x text-info"></i></a>
                    <?php } ?>

                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('users') ?>" method="get">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par nom, prénom, numéro téléphone, ou email" name="search" placeholder="Chercher par nom, prénom, numéro téléphone, ou email">
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['debut'])&&!empty($_GET['debut']))?'value="'.$_GET['debut'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date ajout min" name="debut" id="debut" placeholder="Chercher par date ajout min">
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['end'])&&!empty($_GET['end']))?'value="'.$_GET['end'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date ajout max" name="end" id="end" placeholder="Chercher par date ajout max">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="sexe" data-toggle="tooltip" data-original-title="Chercher par sexe">
                                        <option value="">Chercher par sexe</option>
                                        <option value="Male" <?= (isset($_GET['sexe']) && $_GET['sexe'] == 'Male') ? 'selected' : ''; ?>>Masculin</option>
                                        <option value="Female" <?= (isset($_GET['sexe']) && $_GET['sexe'] == 'Female') ? 'selected' : ''; ?>>Feminin</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="etat" data-toggle="tooltip" data-original-title="Chercher par statut">
                                        <option value="">Chercher par statut</option>
                                        <option value="2" <?= (isset($_GET['etat']) && $_GET['etat'] == 2) ? 'selected' : ''; ?>>Activé</option>
                                        <option value="1" <?= (isset($_GET['etat']) && $_GET['etat'] == 1) ? 'selected' : ''; ?>>Désactivé</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="role" data-toggle="tooltip" data-original-title="Chercher par role">
                                        <option value="">Chercher par role</option>
                                        <option value="Affiliate" <?= (isset($_GET['role']) && $_GET['etat'] == 'Affiliate') ? 'selected' : ''; ?>>Affilié</option>
                                        <option value="Customer" <?= (isset($_GET['role']) && $_GET['etat'] == 'Customer') ? 'selected' : ''; ?>>Client</option>
                                    </select>
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
                                    <th class="text-center">Photo</th>
                                    <th class="">Noms</th>
                                    <th class="">Téléphone</th>
                                    <th class="">Email</th>
                                    <th class="">Role</th>
                                    <th class="">Etat</th>
                                    <th class="text-center">#</th>
                                    <th class="">Ajouté le</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($profils)){
                                    foreach ($profils as $profil) {
                                        $stat1 = $stat04 = "";
                                        $stat03 = '<li class="divider"></li>';
                                        if(Privilege::canView(Privilege::$eshopUserClientActive,$user->privilege)){
                                            if($profil->status==0||$profil->status==2){
                                                $stat1 = '<li>
                                                            <a href="javascript:void(0);" data-url="'.App::url('users/activate').'" data-nom="'.$profil->username.'"
                                                            class="activate" data-etat="'.$profil->status.'" data-id="'.$profil->userid.'">Activer le client</a>
                                                        </li>';
                                            }else{
                                                if(Privilege::canView(Privilege::$eshopUserClientDesactive,$user->privilege)){
                                                $stat1 = '<li>
                                                            <a href="javascript:void(0);" data-url="'.App::url('users/activate').'" data-nom="'.$profil->username.'" 
                                                            class="activate" data-etat="'.$profil->status.'" data-id="'.$profil->userid.'">Désactiver le client</a>
                                                        </li>';
                                                }
                                            }
                                        }
                                        $nbreCommande = orders::countBySearchType($profil->userid);
                                        $nbreProjet = customer_project::countBySearchType($profil->userid);
                                        if(Privilege::canView(Privilege::$eshopUserClientCmdView,$user->privilege)){
                                            $stat03 .= '<li><a href="'.App::url('users/commandes?id='.$profil->userid).'">Commandes ('.thousand($nbreCommande->Total).')</a></li>';
                                        }
                                        if(Privilege::canView(Privilege::$eshopUserClientProjectView,$user->privilege)){
                                            $stat03 .= '<li><a href="'.App::url('users/projects?id='.$profil->userid).'">Projets ('.thousand($nbreProjet->Total).')</a></li>';
                                        }
                                        if(Privilege::canView(Privilege::$eshopUserClientReset,$user->privilege)){
                                            $stat04 .= '<li>
                                                            <a href="javascript:void(0);" data-url="'.App::url('users/reset').'" 
                                                            class="reset" data-nom="'.$profil->username.'" data-id="'.$profil->userid.'">Réinitialiser mon mot de passe</a>
                                                        </li>';
                                        }
                                        if(Privilege::canView(Privilege::$eshopConfigCouponAdd,$user->privilege)){
                                            $stat04 .= '<li class="none">
                                                            <a href="javascript:void(0);" data-nom="'.$profil->username.'" 
                                                            class="coupon" data-id="'.$profil->userid.'">Donner un coupon de réduction</a>
                                                        </li>';
                                        }
                                        echo
                                            '
                                            <tr>
                                                <td class="text-center"><img src="'.FileHelper::url($profil->profileimg).'" class="img-circle img-sd" alt="Img"></td>
                                                <td class="">'.$profil->username.'</td>
                                                <td class="">'.StringHelper::isEmpty($profil->mobile).'</td>
                                                <td class="">'.StringHelper::isEmpty($profil->email,1).'</td>
                                                <td class="">'.StringHelper::$tabUserState[$profil->role].'</td>
                                                <td class="">'.StringHelper::$tabState[$profil->status].'</td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Actions <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="javascript:void(0);" class="detail" data-url="'.App::url('users/detail').'" data-id="'.$profil->userid.'">Détail</a>
                                                            </li>
                                                            '.$stat04.$stat1.$stat03.'
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="">'.DateParser::DateShort($profil->created_on,1).'</td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="8" class="text-danger text-center">Liste des clients vide ...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($profils)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="9">
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
<?php if(Privilege::getPrivilege(Privilege::$eshopConfigCouponAdd,$user->privilege)){ ?>
    <div class="modal fade couponModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h2 class="modal-title titleCoForm"></h2>
                </div>
                <form action="<?= App::url('users/coupons/add') ?>" id="couponForm" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="idCoupon" name="idCoupon">
                        <input type="hidden" id="idMarchandCoupon" name="idMarchandCoupon">
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
                                <label for="titre">Titre du coupon</label>
                                <input type="text" id="titre" name="titre" class="form-control">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="dFin">Date d'expiration du coupon <b>*</b></label>
                                <input type="text" id="dFin" name="fin" class="form-control">
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
                        <button type="submit" class="sendCoBtn btn btn-default">VALIDER</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
<div class="modal fade messageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 85%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">DETAIL DU CLIENT</h2>
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