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
use Projet\Database\Cours;
use Projet\Database\Enseignant;
use Projet\Database\Paiement;
use Projet\Database\Scolarite;
use Projet\Database\users;
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
App::setNavigation("Demandes de retrait");
App::setTitle("Demandes de retrait");
App::addScript('assets/js/transaction.js',true);
App::setBreadcumb('<li class="active">Demandes de retrait</li>');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= "Demandes de retrait <small>(".thousand($nbre->Total).")</small>" ?>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip"class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('withdrawals') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                    <a target="_blank" href="<?= App::url('withdrawals/pdf?etat='.$etat.'&debut='.$debut.'&end='.$end) ?>"
                       data-toggle="tooltip" data-original-title="Generer le fichier PDF des demandes de retrait" ><i class="fa fa-file-pdf-o fa-2x text-primary"></i></a>
                    <a target="_blank" href="<?= App::url('withdrawals/excell?etat='.$etat.'&debut='.$debut.'&end='.$end) ?>"
                       data-toggle="tooltip" data-original-title="Generer le fichier Excel des demandes de retrait" ><i class="fa fa-file-excel-o fa-2x text-info"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('withdrawals') ?>" method="get">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="etat" data-toggle="tooltip" data-original-title="Chercher par etat">
                                        <option value="">Chercher par etat</option>
                                        <option value="2" <?= (isset($_GET['etat']) && $_GET['etat'] == 2) ? 'selected' : ''; ?>>Validé</option>
                                        <option value="1" <?= (isset($_GET['etat']) && $_GET['etat'] == 1) ? 'selected' : ''; ?>>En cours</option>
                                        <option value="3" <?= (isset($_GET['etat']) && $_GET['etat'] == 3) ? 'selected' : ''; ?>>Annulé</option>
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
                                    <th class="">Affilié</th>
                                    <th class="text-right">Montant</th>
                                    <th class="">Etat</th>
                                    <th class="">#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($items)){
                                    foreach ($items as $item) {
                                        $client = users::find($item->user_id);
                                        if($item->status==0){
                                            $act = $des = '';
                                            if(Privilege::canView(Privilege::$eshopDemandeRetraitValid,$user->privilege)){
                                                $act =
                                                    '<a href="javascript:void(0);" class="valid btn-link" data-url="'.App::url('users/withdrawals/valid').'" data-id="'.$item->id.'"
                                                data-toggle="tooltip" data-original-title="Valider la demande de retrait">
                                                    <i class="fa fa-check text-success fa-2x"></i>
                                                </a>
                                                ';
                                            }
                                            if(Privilege::canView(Privilege::$eshopDemandeCancel,$user->privilege)){
                                                $des =
                                                    '<a href="javascript:void(0);" class="cancel btn-link" data-url="'.App::url('users/withdrawals/valid').'" data-id="'.$item->id.'"
                                                data-toggle="tooltip" data-original-title="Annuler la demande de retrait">
                                                    <i class="fa fa-close text-danger fa-2x"></i>
                                                </a>
                                                ';
                                            }

                                            $etat = $act.$des;
                                        }else{
                                            $etat = '<b>...</b>';
                                        }
                                        echo
                                            '
                                            <tr>
                                                <td class="">'.DateParser::DateShort($item->date).'</td>
                                                <td class="">'.$client->username.'</td>
                                                <td class="text-right">$'.float_value($item->amount).'</td>
                                                <td class="">'.StringHelper::$tabEtatWithdraw[$item->status].'</td>
                                                <td>'.$etat.'</td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="5" class="text-danger text-center">Aucune demande trouvée...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($items)){ ?>
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
<div class="row">
    <div class="col-lg-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p><small>$</small> <span class="counter"><?= thousand($in->somme); ?><span></p>
                    <span class="info-box-title">
                        Montant des retraits éffectué (<?= thousand($in->Total); ?>)
                    </span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-check text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p><small>$</small> <span class="counter"><?= thousand($pending->somme); ?><span></p>
                    <span class="info-box-title">
                        Montant des retraits en attente (<?= thousand($pending->Total); ?>)
                    </span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-warning text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>