<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\category;
use Projet\Database\checkout_orders;
use Projet\Database\product_review;
use Projet\Database\subcategory;
use Projet\Model\App;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les Medicaments");
App::setNavigation("Les Medicaments");

App::addStyle('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',true);
App::addScript('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js',true);
App::addScript('https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js',true);
App::addScript('https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.js',true);
App::addStyle('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',true);
App::addScript('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',true);
App::addScript('assets/js/medecament.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                Medicaments <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <?php if(Privilege::canView(Privilege::$eshopProductAdd,$user->privilege)){ ?>
                        <a href="javascript:void(0);" data-toggle="tooltip" class="new" data-original-title="Nouveau medicament">
                            <i class="icon-plus text-success fa-2x"></i>
                        </a>
                    <?php } ?>
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('medocs') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>

                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('medocs') ?>" method="get">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par nom le medicament" name="search" placeholder="Chercher par nom"    style="width:200px">
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

                                    <th class="text-center" style="width: 15%">nom </th>
                                    <th class="text-center"></th>
                                    <th class="">Prix</th>
                                    <th class="text-center"></th>
                                    <th class="">Type</th>
                                    <th class="text-center"></th>
                                    <th class="">Quantite</th>
                                    <th class=""></th>
                                    <th class="text-center">Drescryption</th>
                                    <th class=""></th>


                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($articles)){
                                    foreach ($articles as $article) {
                                        $stat1 = $stat2 = $stat3 = $stat01 = $stat02 = $stat03 = $stat04 = $stat05 = $stat06 = $stat07 = $stat08 = $stat09 = $stat19 = "";
                                        if($article->status == 0&&Privilege::canView(Privilege::$eshopProductActivation,$user->privilege)){
                                            $stat09 = '<li>
                                                            <a href="javascript:void(0);" data-url="'.App::url('produits/setEtat').'" 
                                                            class="activate" data-nom="'.$article->productname.'" data-etat="'.$article->status.'" data-id="'.$article->productid.'">Activer le produit</a>
                                                        </li>';
                                        }
                                        if($article->status != 0&&Privilege::canView(Privilege::$eshopProductDesactivation,$user->privilege)){
                                            $stat09 = '<li>
                                                            <a href="javascript:void(0);" data-url="'.App::url('produits/setEtat').'" 
                                                            class="activate" data-nom="'.$article->productname.'" data-etat="'.$article->status.'" data-id="'.$article->productid.'">Désactiver le produit</a>
                                                        </li>';
                                        }
                                        if(Privilege::canView(Privilege::$eshopProductChangeImg,$user->privilege)){
                                            $stat05 = '
                                                            <li>
                                                                <a href="javascript:void(0);" class="editPhoto" 
                                                                data-id="'.$article->productid.'" data-nom="'.$article->productname.'">Ajouter des images</a>
                                                            </li>';
                                            $stat3 = '<li class="divider"></li>
                                                            <li>
                                                                <a href="javascript:void(0);" class="editImage" 
                                                                data-id="'.$article->productid.'" data-nom="'.$article->productname.'">Changer l\'image principale</a>
                                                            </li>';
                                        }
                                        if(Privilege::canView(Privilege::$eshopProductEdit,$user->privilege)){
                                            $stat01 = '<li>
                                                            <a href="javascript:void(0);" data-id="'.$article->productid.'" data-length="'.$article->length.'"
                                                             data-nom="'.$article->productname.'" data-cat="'.$article->category_id.'" data-prix="'.$article->price.'"
                                                             data-offre="'.$article->offer_price.'" data-sous="'.$article->sub_category.'"
                                                             data-sku="'.$article->sku.'" data-supplier="'.$article->supplier_code.'"
                                                             data-type="'.$article->package_type.'" data-mots="'.$article->tags.'" data-width="'.$article->width.'"
                                                             data-height="'.$article->height.'" data-weight="'.$article->weight.'"
                                                             data-weightoz="'.$article->weightOz.'" data-freight="'.$article->freightClass.'"
                                                             data-nmfc="'.$article->nmfcCode.'" data-slug="'.$article->slug.'"
                                                             data-deal="'.$article->deal.'" data-trending="'.$article->trending.'" data-hot="'.$article->hot.'"
                                                            class="edit">Modifier</a>
                                                            <div class="bibio hide">'.$article->description.'</div>
                                                        </li>';
                                        }
                                        if(Privilege::canView(Privilege::$eshopProductAddToDeal,$user->privilege)){
                                            $stat02 = '<li class="divider"></li><li>
                                                            <a href="javascript:void(0);" class="deal" data-prix="'.$article->price.'"
                                                            data-id="'.$article->productid.'" data-nom="'.$article->productname.'">Ajouter comme Deal du jour</a>
                                                        </li>';
                                        }
                                        if(Privilege::canView(Privilege::$eshopProductAddToStock,$user->privilege)){
                                            $stat02 .= '<li>
                                                                <a href="javascript:void(0);" class="editStock" 
                                                                data-id="'.$article->productid.'" data-nom="'.$article->productname.'">Augmenter le stock</a>
                                                            </li>';
                                        }
                                        if(Privilege::canView(Privilege::$eshopProductMoveToStock,$user->privilege)){
                                            $stat02 .= '<li>
                                                            <a href="javascript:void(0);" class="delStock" 
                                                                data-id="'.$article->productid.'" data-nom="'.$article->productname.'">Diminuer le stock</a>
                                                            </li>';
                                        }
                                        $nbreLigne = checkout_orders::countBySearchType($article->productid);
                                        $nbreNote = product_review::countBySearchType(null,$article->productid);
                                        if(Privilege::canView(Privilege::$eshopProductSaleView,$user->privilege)){
                                            $stat07 = '<li class="divider"></li>
                                                            <li><a href="'.App::url('produits/commandes?id='.$article->productid).'">Ventes ('.thousand($nbreLigne->Total).')</a></li>';
                                        }
                                        if(Privilege::canView(Privilege::$eshopProductNoteView,$user->privilege)){
                                            $stat07 = '<li class="divider"></li>
                                                            <li><a href="'.App::url('produits/reviews?id='.$article->productid).'">Notes ('.thousand($nbreNote->Total).')</a></li>';
                                        }
                                        $cat = category::find($article->category_id);
                                        $sub = subcategory::find($article->sub_category);
                                        echo
                                            '
                                            <tr>
                                                <td class="text-center"><img src="'.FileHelper::url($article->image).'" class="img-ld" alt="Img"></td>
                                                <td class="">
                                                    <b>'.ucfirst($article->productname).'</b> <br> 
                                                    <small class="text-primary"><i class="icon-login"></i> '.$article->sku.'</small> <br> 
                                                    <small class="text-info"><i class="icon-control-forward"></i> '.$article->supplier_code.'</small>
                                                </td>
                                                <td class="">'.$article->package_type.'</td>
                                                <td class="">'.$cat->category_name.'<br><i class="glyphicon glyphicon-arrow-down"></i><br>'.$sub->subcategory_name.'</td>
                                                <td class="text-center">
                                                    <div class="style-1">
                                                      <del>
                                                        <span class="amount">$'.float_value($article->price).'</span>
                                                      </del>
                                                      <ins>
                                                        <span class="amount">$'.float_value($article->offer_price).'</span>
                                                      </ins>
                                                    </div>
                                                </td>
                                                <td class="text-center">'.$article->discount.'%</td>
                                                <td class="text-center">'.StringHelper::$tabArticleState[$article->status].'</td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Actions <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="javascript:void(0);" class="detail" data-url="'.App::url('produits/detail').'" data-id="'.$article->productid.'">Détail</a>
                                                            </li>
                                                            '.$stat01.$stat09.$stat02.$stat04.$stat3.$stat05.$stat06.$stat07.$stat08.'
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="text-right color-primary"><b>'.thousand($article->qty).'</b></td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="9" class="text-danger text-center">Liste des medicaments vide ...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($articles)){ ?>
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
<div class="modal fade newModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleForm">Titre</h2>
            </div>
            <form action="<?= App::url('produits/save') ?>" id="newForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="action" name="action">
                    <input type="hidden" id="idElement" name="id">
                    <input type="hidden" id="idMarchand" name="idMarchand">
                    <p class="mainColor text-right">* Champs obligatoires</p>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="nom">Nom <b>*</b></label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required   style="width:200px">
                        </div>
                        <div class="col-md-2 form-group">

                        </div>


                        <div class="col-md-4 form-group">
                            <label for="slug">Prix <b>*</b></label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="prix" required>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-4 form-group">
                            <label for="type">Type <b>*</b></label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">............</option>
                                <option value="Courier Pack">générique</option>
                                <option value="Envelope">biosimilaire</option>
                                <option value="Package">orphelin</option>
                                <option value="Pallet">biologique</option>
                                <option value="Pallet"> a base de plantes</option>
                                <option value="Pallet">essentiel</option>
                            </select>
                        </div>

                        <div  class="col-md-2 form-group">

                        </div>
                        <div class="col-md-4 form-group">
                            <label for="slug">Quantite <b>*</b></label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="quantite" required>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="details">Description  <b>*</b></label>
                            <textarea class="form-control" name="details" placeholder="Description" rows="3"  required></textarea>
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
    <div class="modal-dialog" style="width: 85%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">DETAIL ARTICLE</h2>
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
<div class="modal fade stockModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleAddStock">AUGMENTER LE STOCK</h2>
            </div>
            <form action="<?= App::url('produits/setStock') ?>" id="stockForm" method="post">
                <div class="modal-body">
                    <input type="hidden" id="idStock" name="idStock">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Nombre à augmenter <b>*</b></label>
                                <input type="number" id="nbre" min="1" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="stockBtn btn btn-default">ENREGISTRER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade stockdelModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleDelStock">DIMINUER LE STOCK</h2>
            </div>
            <form action="<?= App::url('produits/stock/diminuer') ?>" id="stockdelForm" method="post">
                <div class="modal-body">
                    <input type="hidden" id="idStockdel" name="idStockdel">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nombre à diminuer <b>*</b></label>
                                <input type="number" id="nbredel" min="1" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Raison</label>
                                <input type="text" id="raisondel" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="stockdelBtn btn btn-default">ENREGISTRER</button>
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
                <h2 class="modal-title titleImg">AJOUTER DES IMAGES</h2>
            </div>
            <form action="<?= App::url('produits/setImage') ?>" id="photoForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idPhoto" name="idPhoto">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="photoImage">Images <b>*</b></label>
                            <input type="file" class="form-control" multiple id="photoImage" accept="image/*" name="file[]">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="photoBtn btn btn-default">ENREGISTRER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade imageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titlePho">CHANGER L'IMAGE PRINCIPALE</h2>
            </div>
            <form action="<?= App::url('produits/setPhoto') ?>" id="imageForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idImage" name="idImage">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="image">Image principale <b>*</b></label>
                            <input type="file" class="form-control" id="image" accept="image/*" name="image">
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
<div class="modal fade dealModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleDeal">CHANGER L'IMAGE PRINCIPALE</h2>
            </div>
            <form action="<?= App::url('produits/setDeal') ?>" id="dealForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idDeal" name="idDeal">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="d_titre">Titre <b>*</b></label>
                            <input type="text" class="form-control" name="d_titre" placeholder="Titre" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="d_prix">Prix du Deal <b>*</b></label>
                            <input type="text" class="form-control" name="d_prix" placeholder="Prix du Deal" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="d_date">Date de début <b>*</b></label>
                                <input type="text" id="d_date" name="d_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="d_fin">Date de fin <b>*</b></label>
                                <input type="text" id="d_fin" name="d_fin" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="d_image">Image <b>*</b></label>
                            <input type="file" class="form-control" id="d_image" accept="image/*" name="image">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="d_details">Description</label>
                            <textarea class="form-control" name="d_details" placeholder="Description" rows="2"></textarea>
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
