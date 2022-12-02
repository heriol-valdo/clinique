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
App::setTitle("Les produits");
App::setNavigation("Les produits");
App::setBreadcumb('<li class="active">Produits</li>');
App::addStyle('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',true);
App::addScript('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js',true);
App::addScript('https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js',true);
App::addScript('https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.js',true);
App::addStyle('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',true);
App::addScript('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',true);
App::addScript('assets/js/articles.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Produits <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <?php if(Privilege::canView(Privilege::$eshopProductAdd,$user->privilege)){ ?>
                        <a href="javascript:void(0);" data-toggle="tooltip" class="new" data-original-title="Nouveau produit">
                            <i class="icon-plus text-success fa-2x"></i>
                        </a>
                    <?php } ?>
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('produits') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                    <?php if(Privilege::canView(Privilege::$eshopProductEtat,$user->privilege)){ ?>
                        <a target="_blank" href="<?= App::url('produits/pdf?search='.$s_search.'&cat='.$s_cat.'&categorie='.$s_categorie.'&etat='.$s_etat.'&type='.$s_type.'&stock='.$s_stock) ?>"
                           data-toggle="tooltip" data-original-title="Generer le fichier PDF des produits" ><i class="fa fa-file-pdf-o fa-2x text-primary"></i></a>
                        <a target="_blank" href="<?= App::url('produits/excell?search='.$s_search.'&cat='.$s_cat.'&categorie='.$s_categorie.'&etat='.$s_etat.'&type='.$s_type.'&stock='.$s_stock) ?>"
                           data-toggle="tooltip" data-original-title="Generer le fichier Excel des produits" ><i class="fa fa-file-excel-o fa-2x text-info"></i></a>
                    <?php } ?>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('produits') ?>" method="get">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par nom, sku ou supplier code" name="search" placeholder="Chercher par nom, sku ou supplier code">
                                </div>
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="cat" id="catId" data-toggle="tooltip" data-original-title="Chercher par la catégorie">
                                        <option value="">Chercher par la catégorie</option>
                                        <?php
                                        foreach ($categories as $categorie){
                                            $is = isset($_GET['cat'])&&$_GET['cat']==$categorie->id?' selected':'';
                                            echo '<option value="'.$categorie->id.'"'.$is.'>'.$categorie->category_name.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="categorie" id="sousId" data-toggle="tooltip" data-original-title="Chercher par la sous catégorie">
                                        <option value="">Chercher par la sous catégorie</option>
                                        <?php
                                        foreach ($sousCat as $sou){
                                            $is = isset($_GET['categorie'])&&$_GET['categorie']==$sou->id?' selected':'';
                                            echo '<option value="'.$sou->id.'"'.$is.'>'.$sou->subcategory_name.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="type" data-toggle="tooltip" data-original-title="Chercher par type">
                                        <option value="">Chercher par type</option>
                                        <option value="1" <?= (isset($_GET['type']) && $_GET['type'] == 'Courier Pack') ? 'selected' : ''; ?>>Courier Pack</option>
                                        <option value="2" <?= (isset($_GET['type']) && $_GET['type'] == 'Envelope') ? 'selected' : ''; ?>>Envelope</option>
                                        <option value="2" <?= (isset($_GET['type']) && $_GET['type'] == 'Package') ? 'selected' : ''; ?>>Package</option>
                                        <option value="2" <?= (isset($_GET['type']) && $_GET['type'] == 'Pallet') ? 'selected' : ''; ?>>Pallet</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="stock" data-toggle="tooltip" data-original-title="Chercher par disponibilité du stock">
                                        <option value="">Chercher par disponibilité du stock</option>
                                        <option value="1" <?= (isset($_GET['stock']) && $_GET['stock'] == 1) ? 'selected' : ''; ?>>Stock disponible</option>
                                        <option value="2" <?= (isset($_GET['stock']) && $_GET['stock'] == 2) ? 'selected' : ''; ?>>Stock épuisé</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="etat" data-toggle="tooltip" data-original-title="Chercher par etat">
                                        <option value="">Chercher par etat</option>
                                        <option value="2" <?= (isset($_GET['etat']) && $_GET['etat'] == 2) ? 'selected' : ''; ?>>Actif</option>
                                        <option value="1" <?= (isset($_GET['etat']) && $_GET['etat'] == 1) ? 'selected' : ''; ?>>Inactif</option>
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
                                    <th class="text-center" style="width: 15%">Image</th>
                                    <th class="">Produit</th>
                                    <th class="">Type</th>
                                    <th class="">Catégorie / Sous</th>
                                    <th class="text-center">Prix</th>
                                    <th class="text-center">Réduction</th>
                                    <th class="text-center">Etat</th>
                                    <th class="text-center">#</th>
                                    <th class="text-right">En Stock</th>
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
                                    echo '<tr><td colspan="9" class="text-danger text-center">Liste des produits vide ...</td></tr>';
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
    <div class="modal-dialog" style="width: 85%">
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
                            <label for="cat">Catégorie <b>*</b></label>
                            <select name="cat" id="cat" class="form-control" required>
                                <option value="">............</option>
                                <?php
                                foreach ($categories as $cat){
                                    echo '<option value="'.$cat->id.'">'.$cat->category_name.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="sous">Sous catégorie <b>*</b></label>
                            <select name="sous" id="sous" class="form-control" required>
                                <option value="">............</option>
                                <?php
                                foreach ($sousCat as $sou){
                                    echo '<option value="'.$sou->id.'">'.$sou->subcategory_name.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="sku">SKU <b>*</b></label>
                            <input type="text" class="form-control" id="sku" name="sku" placeholder="SKU" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="nom">Nom <b>*</b></label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="slug">Slug <b>*</b></label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="type">Type <b>*</b></label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">............</option>
                                <option value="Courier Pack">Courier Pack</option>
                                <option value="Envelope">Envelope</option>
                                <option value="Package">Package</option>
                                <option value="Pallet">Pallet</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="prix">Prix <b>*</b></label>
                            <input type="text" class="form-control" id="prix" name="prix" placeholder="Prix" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="offre">Prix offert <b>*</b></label>
                            <input type="text" class="form-control" id="offre" name="offre" placeholder="Prix offert" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="reduction">Réduction (en %) <b>*</b></label>
                            <input type="text" class="form-control" id="reduction" name="reduction" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="hot">Hot Products <b>*</b></label>
                            <select name="hot" id="hot" class="form-control" required>
                                <option value="">............</option>
                                <option value="1">OUI</option>
                                <option value="2">NON</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="trending">Trending Deals <b>*</b></label>
                            <select name="trending" id="hot" class="form-control" required>
                                <option value="">............</option>
                                <option value="1">OUI</option>
                                <option value="2">NON</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="deal">Deal Recommended For You <b>*</b></label>
                            <select name="deal" id="deal" class="form-control" required>
                                <option value="">............</option>
                                <option value="1">OUI</option>
                                <option value="2">NON</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="supplier">Supplier</label>
                            <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Supplier code">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="nmfc">Nmfc code</label>
                            <input type="text" class="form-control" id="nmfc" name="nmfc" placeholder="Nmfc code">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="freight">Freight class</label>
                            <input type="text" class="form-control" id="freight" name="freight" placeholder="Freight class">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="lenght">Lenght</label>
                            <input type="text" class="form-control" id="lenght" name="lenght" placeholder="Lenght">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="width">Width</label>
                            <input type="text" class="form-control" id="width" name="width" placeholder="Width">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="height">Height</label>
                            <input type="text" class="form-control" id="height" name="height" placeholder="Height">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="weight">Weight</label>
                            <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="weightoz">Weight Oz</label>
                            <input type="number" class="form-control" id="weightoz" name="weightoz" placeholder="Weight Oz">
                        </div>
                        <div class="col-md-9 form-group">
                            <label for="mots">Mots clés</label>
                            <input type="text" class="form-control" id="mots" name="mots" placeholder="Mot clés">
                        </div>
                    </div>
                    <div id="pictureContent">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="principale">Image Principale <b>*</b></label>
                                <input type="file" class="form-control" id="principale" accept="image/*" name="image">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="autres">Autres images</label>
                                <input type="file" class="form-control" multiple id="autres" accept="image/*" name="file[]">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="details">Description</label>
                            <textarea class="form-control" id="details" name="details" placeholder="Description" rows="3"></textarea>
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
