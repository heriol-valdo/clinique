<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\affiliate_portfolio_project;
use Projet\Database\affiliate_project;
use Projet\Database\council;
use Projet\Database\schedule_meeting;
use Projet\Database\Vues;
use Projet\Database\withdraw_request;
use Projet\Database\Worker;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;
use Projet\Database\wallet;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les Affiliés");
App::setNavigation("Les Affiliés");
App::setBreadcumb('<li class="active">Affiliés</li>');
App::addScript('assets/js/clients.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Affiliés <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" class="panel-collapse" data-toggle="tooltip" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('affilies') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                    <?php if(Privilege::canView(Privilege::$eshopUserAffilieEtat,$user->privilege)){ ?>
                        <a target="_blank" href="<?= App::url('affilies/pdf?search='.$s_search.'&sexe='.$s_sexe.'&etat='.$s_etat.'&debut='.$s_debut.'&end='.$s_end) ?>"
                           data-toggle="tooltip" data-original-title="Generer le fichier PDF des Affiliés" ><i class="fa fa-file-pdf-o fa-2x text-primary"></i></a>
                        <a target="_blank" href="<?= App::url('affilies/excell?search='.$s_search.'&sexe='.$s_sexe.'&etat='.$s_etat.'&debut='.$s_debut.'&end='.$s_end) ?>"
                           data-toggle="tooltip" data-original-title="Generer le fichier Excel des Affiliés" ><i class="fa fa-file-excel-o fa-2x text-info"></i></a>
                    <?php } ?>

                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('affilies') ?>" method="get">
                            <div class="row">
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par nom, prénom, numéro téléphone, ou email" name="search" placeholder="Chercher par nom, prénom, numéro téléphone, ou email">
                                </div>
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="sexe" data-toggle="tooltip" data-original-title="Chercher par sexe">
                                        <option value="">Chercher par sexe</option>
                                        <option value="Male" <?= (isset($_GET['sexe']) && $_GET['sexe'] == 'Male') ? 'selected' : ''; ?>>Masculin</option>
                                        <option value="Female" <?= (isset($_GET['sexe']) && $_GET['sexe'] == 'Female') ? 'selected' : ''; ?>>Feminin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['debut'])&&!empty($_GET['debut']))?'value="'.$_GET['debut'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date ajout min" name="debut" id="debut" placeholder="Chercher par date ajout min">
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['end'])&&!empty($_GET['end']))?'value="'.$_GET['end'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date ajout max" name="end" id="end" placeholder="Chercher par date ajout max">
                                </div>
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="etat" data-toggle="tooltip" data-original-title="Chercher par statut">
                                        <option value="">Chercher par statut</option>
                                        <option value="2" <?= (isset($_GET['etat']) && $_GET['etat'] == 2) ? 'selected' : ''; ?>>Activé</option>
                                        <option value="1" <?= (isset($_GET['etat']) && $_GET['etat'] == 1) ? 'selected' : ''; ?>>Désactivé</option>
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
                                    <th class="">Adresse</th>
                                    <th class="text-right">Gains</th>
                                    <th class="text-right">Solde Wallet</th>
                                    <th class="">Etat</th>
                                    <th class="text-center">#</th>
                                    <th class="">Ajouté le</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($profils)){
                                    foreach ($profils as $profil) {
                                      $wallet = wallet::byUser($profil->userid);
                                        $stat1 = $stat04 = "";
                                        $stat03 = '<li class="divider"></li>';
                                        if(Privilege::canView(Privilege::$eshopUserAffilieActive,$user->privilege)){
                                            if($profil->status==0||$profil->status==2){
                                                $stat1 = '<li>
                                                            <a href="javascript:void(0);" data-url="'.App::url('affilies/activate').'" data-nom="'.$profil->username.'"
                                                            class="activate" data-etat="'.$profil->status.'" data-id="'.$profil->id.'">Activer l\'affilié</a>
                                                        </li>';
                                            }else{
                                                if(Privilege::canView(Privilege::$eshopUserAffilieDesactive,$user->privilege)) {
                                                    $stat1 = '<li>
                                                            <a href="javascript:void(0);" data-url="' . App::url('affilies/activate') . '" data-nom="' . $profil->username . '" 
                                                            class="activate" data-etat="' . $profil->status . '" data-id="' . $profil->id . '">Désactiver l\'affilié</a>
                                                        </li>';
                                                }
                                            }
                                        }
                                        $nbreDemande = withdraw_request::countBySearchType($profil->userid);
                                        $nbreConseil = council::countBySearchType($profil->userid);
                                        $nbrePortofolio = affiliate_portfolio_project::countBySearchType($profil->id);
                                        $nbreProjet = affiliate_project::countBySearchType($profil->id);
                                        $nbreMeeting = schedule_meeting::countBySearchType($profil->id);
                                        if(Privilege::canView(Privilege::$eshopUserAffilieDmdRetraitView,$user->privilege)){
                                            $stat03 .= '<li><a href="'.App::url('affilies/withdrawals?id='.$profil->userid).'">Demandes de retrait ('.thousand($nbreDemande->Total).')</a></li>';
                                        }
                                        if(Privilege::canView(Privilege::$eshopUserAffilieCmdView,$user->privilege)){
                                            $stat03 .= '<li><a href="'.App::url('affilies/councils?id='.$profil->userid).'">Conseils ('.thousand($nbreConseil->Total).')</a></li>
                                                            <li><a href="'.App::url('affilies/meetings?id='.$profil->userid).'">Rendez-vous ('.thousand($nbreMeeting->Total).')</a></li>';
                                        }
                                        if(Privilege::canView(Privilege::$eshopUserAffilieProjectView,$user->privilege)){
                                            $stat03 .= '<li><a href="'.App::url('affilies/projects?id='.$profil->userid).'">Projets ('.thousand($nbreProjet->Total).')</a></li>';
                                        }
                                        if(Privilege::canView(Privilege::$eshopUserAffilieProfolioView,$user->privilege)){
                                            $stat03 .= '<li><a href="'.App::url('affilies/portfolio?id='.$profil->userid).'">Portfolio ('.thousand($nbrePortofolio->Total).')</a></li>';
                                        }
                                        echo
                                            '
                                            <tr>
                                                <td class="text-center"><img src="'.FileHelper::url($profil->profileimg).'" class="img-circle img-sd" alt="Img"></td>
                                                <td class="">'.$profil->username.'</td>
                                                <td class="">'.StringHelper::isEmpty($profil->mobile).'</td>
                                                <td class="">'.StringHelper::isEmpty($profil->email,1).'</td>
                                                <td class="">'.StringHelper::isEmpty($profil->city).'</td>
                                                <td class="text-right"><b>'.float_value($profil->earnings).'</b></td>
                                                <td class="text-right text-primary"><small>$</small> '.float_value($wallet->amount).'</td>
                                                <td class="">'.StringHelper::$tabState[$profil->etat].'</td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Actions <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="javascript:void(0);" class="detail" data-url="'.App::url('users/detail').'" data-id="'.$profil->userid.'">Détail</a>
                                                            </li>
                                                            '.$stat1.$stat03.'
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="">'.DateParser::DateShort($profil->date,1).'</td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="10" class="text-danger text-center">Liste des affiliés vide ...</td></tr>';
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
<div class="modal fade messageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 85%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">DETAIL DE L'AFFILIE</h2>
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