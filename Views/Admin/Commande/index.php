<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\users;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\Paginator;
use Projet\Model\Privilege;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les commandes");
App::setNavigation("Les commandes");
App::setBreadcumb('<li class="active">Commandes</li>');
App::addScript('assets/js/commande.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Commandes <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('commandes') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                    <a target="_blank" href="<?= App::url('commandes/pdf?etat='.$s_etat.'&ref ='.$s_ref .'&debut='.$s_debut.'&end='.$s_end) ?>"
                       data-toggle="tooltip" data-original-title="Generer le fichier PDF des commandes" ><i class="fa fa-file-pdf-o fa-2x text-primary"></i></a>
                    <a target="_blank" href="<?= App::url('commandes/excell?etat='.$s_etat.'&ref ='.$s_ref .'&debut='.$s_debut.'&end='.$s_end) ?>"
                       data-toggle="tooltip" data-original-title="Generer le fichier Excel des commandes" ><i class="fa fa-file-excel-o fa-2x text-info"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('commandes') ?>" method="get">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['ref'])&&!empty($_GET['ref']))?'value="'.$_GET['ref'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par N° commande" name="ref" placeholder="Chercher par N° commande">
                                </div>
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="etat" data-toggle="tooltip" data-original-title="Chercher par etat">
                                        <option value="">Chercher par etat</option>
                                        <option value="Order Placed" <?= (isset($_GET['etat']) && $_GET['etat'] == 'Order Placed') ? 'selected' : ''; ?>>Order Placed</option>
                                        <option value="Order is in Production" <?= (isset($_GET['etat']) && $_GET['etat'] == 'Order is in Production') ? 'selected' : ''; ?>>Order is in Production</option>
                                        <option value="Order in Delivery" <?= (isset($_GET['etat']) && $_GET['etat'] == 'Order in Delivery') ? 'selected' : ''; ?>>Order in Delivery</option>
                                        <option value="Order is Delivered" <?= (isset($_GET['etat']) && $_GET['etat'] == 'Order in Delivered') ? 'selected' : ''; ?>>Order in Delivered</option>
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['debut'])&&!empty($_GET['debut']))?'value="'.$_GET['debut'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date min" name="debut" id="debut" placeholder="Chercher par date min">
                                </div>
                                <div class="col-md-2 form-group">
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
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="">Date</th>
                                <th class="">Client</th>
                                <th class="">Reférence</th>
                                <th class="text-right">Prix</th>
                                <th class="">Etat</th>
                                <th class="text-center">#</th>
                                <th class="">Livrée le</th>
                                <th class="">Date livraison</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(!empty($commandes)){
                                foreach ($commandes as $commande) {
                                    $stat1 = $stat2 = $stat4 = $stat5 = $stat6 = $stat0 = $stat3 = $stat7 = $stat8 = $stat9 =$stat10="";

                                    if(Privilege::canView(Privilege::$eshopCommandValid,$user->privilege)){
                                        $stat8 = '<li class="none">
                                                            <a href="javascript:void(0);" data-url="'.App::url('commandes/disponible').'" 
                                                            class="disponible" data-ref="'.$commande->order_id.'" data-id="'.$commande->id.'">Valider la disponibilité des produits</a>
                                                        </li>';
                                    }
                                    if(Privilege::canView(Privilege::$eshopCommandValid,$user->privilege)){
                                        $stat7 = '<li class="none">
                                                        <a target="_blank" href="'.App::url('commandes/bon?id='.$commande->id).'" 
                                                        >Generer le bon livraison</a>
                                                        </li>';
                                    }
                                    if(Privilege::canView(Privilege::$eshopCommandValid,$user->privilege)){
                                        $stat5 = '<li class="none">
                                                            <a href="javascript:void(0);" data-url="'.App::url('commandes/setLivraison').'" 
                                                            class="livrer livrer2" data-id="'.$commande->id.'">Livrer la commande</a>
                                                        </li>';
                                    }
                                    if(Privilege::canView(Privilege::$eshopCommandValid,$user->privilege)){
                                        $stat3 = '<li class="none">
                                                                <a href="javascript:void(0);" data-url="'.App::url('commandes/setState').'" 
                                                                class="retablir" data-id="'.$commande->id.'">Annuler et retablir le stock reservé</a>
                                                            </li>';
                                    }
                                    if(Privilege::canView(Privilege::$eshopCommandValid,$user->privilege)){
                                        if($commande->transit_status !=='Order is Delivered'){
                                            $stat9 = '<li>
                                                            <a href="javascript:void(0);" data-url="'.App::url('commandes/etat/change').'" 
                                                            class="etat" data-id="'.$commande->id.'" data-etat="'.$commande->transit_status.'">Changer l\'état</a>
                                                      </li>
                                                      ';
                                        }else{
                                            $stat9 =''   ;
                                        }
                                        if(in_array($commande->transit_status,['Order in Delivery','Order is in Production'])){
                                            $text = empty($commande->date_delivery) ? 'Ajouter' : 'Modifier';
                                            $is= empty($commande->date_delivery) ? 1 : 0;
                                            $stat10 = '<li>
                                                        <a href="javascript:void(0);" data-is="'.$is.'" data-id="'.$commande->id.'" data-date="'.$commande->date_delivery.'"
                                                        class="date_livraison">'.$text.' la date de livraison</a>
                                                     </li>';
                                        }else{
                                            $stat10 =''   ;
                                        }
                                    }
                                    $client = users::find($commande->user_id);
                                    $nom = "";
                                    if($client){
                                        $nom = $client->username;
                                    }
                                    echo
                                        '
                                            <tr>
                                                <td class="text-black">'.DateParser::DateShort($commande->created_date,1).'</td>
                                                <td class="text-info">'.$nom.'</td>
                                                <td class="text-black">'.$commande->order_id.'</td>
                                                <td class="text-right text-primary"><small>$</small> '.thousand($commande->paid_amount).'</td>
                                                <td class="">'.$commande->transit_status.'</td>
                                                 <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Actions <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="'.App::url('commandes/detail?id='.$commande->id).'">Détail</a>
                                                            </li>
                                                            '.$stat7.$stat8.$stat0.$stat1.$stat5.$stat2.$stat4.$stat3.$stat9.$stat10.'
                                                             
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="text-black">'.DateParser::DateShort($commande->delivery_date,1).'</td>
                                                <td class="text-black">'.DateParser::DateShort($commande->date_delivery).'</td>
                                            </tr>
                                             
                                            ';
                                }}else{
                                echo '<tr><td colspan="8" class="text-danger text-center">Liste des commandes vide ...</td></tr>';
                            }
                            ?>
                            </tbody>
                            <?php
                            if(!empty($commandes)){ ?>
                                <tfoot>
                                <tr>
                                    <td colspan="8">
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
<div class="row">
    <div class="col-lg-12">
        <div class="panel info-box panel-dark">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p><small>$</small> <span class="counter"><?= thousand($nbre->somme); ?><span></p>
                    <span class="info-box-title">
                        Montant total des commandes
                    </span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-money"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade photoModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleLivraison">VALIDER LA LIVRAISON</h2>
            </div>
            <form action="<?= App::url('commandes/livraison/made') ?>" id="photoForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idType" name="type">
                    <input type="hidden" id="idPhoto" name="id">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="photoImage">Bon de livraison signé (jpeg,jpg,pnf,pdf) <b>*</b></label>
                            <input type="file" class="form-control" id="photoImage" name="image">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="photoBtn btn btn-default">VALIDER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade newModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleForm">Titre</h2>
            </div>
            <form action="<?= App::url('commandes/dateDelivery') ?>" id="newForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="action" name="action">
                    <input type="hidden" id="idElement" name="id">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-12 ">
                            <label for="date_delivery">Date de livraison<b>*</b></label>
                            <input type="text" class="form-control" id="date_delivery" name="date_delivery">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="newBtn1 btn btn-default">Ajouter</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
