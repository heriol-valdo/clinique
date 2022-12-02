<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Admin;


use DateTime;
use Exception;
use Projet\Database\category;
use Projet\Database\checkout_orders;
use Projet\Database\dealoftheday;
use Projet\Database\product_review;
use Projet\Database\products;
use Projet\Database\productsimage;
use Projet\Database\subcategory;
use Projet\Model\App;
use Projet\Model\DataHelper;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

class ArticleController extends AdminController{

    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopProductView,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 10;
        $categories = category::searchType();
        $sousCat = subcategory::searchType();
        $s_search = (isset($_GET['search'])&&!empty($_GET['search'])) ? $_GET['search'] : null;
        $s_cat = (isset($_GET['cat'])&&!empty($_GET['cat'])) ? $_GET['cat'] : null;
        $s_categorie = (isset($_GET['categorie'])&&!empty($_GET['categorie'])) ? $_GET['categorie'] : null;
        $s_etat = (isset($_GET['etat'])&&is_numeric($_GET['etat'])) ? $_GET['etat']-1 : null;
        $s_stock = (isset($_GET['stock'])&&!empty($_GET['stock'])) ? $_GET['stock'] : null;
        $s_type = (isset($_GET['type'])&&!empty($_GET['type'])) ? $_GET['type'] : null;
        $nbre = products::countBySearchType($s_search,$s_cat,$s_categorie,$s_type,$s_stock,$s_etat);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $articles = products::searchType($nbreParPage,$pageCourante,$s_search,$s_cat,$s_categorie,$s_type,$s_stock,$s_etat);
        $this->render('admin.article.index',compact('s_stock','s_search','s_etat','s_type','s_cat','s_categorie','sousCat','articles','user','nbre','nbrePages','categories'));
    }

    public function detail(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $article = products::find($id);
            if($article){
                $images = productsimage::searchType(null,null,$id);
                $tr = '<div class="grid"><div class="grid-sizer"></div>';
                if(!empty($article->image)){
                    $tr .= '<div class="grid-item">
                                <img src="'.FileHelper::url($article->image).'">
                                <p class="text-center">
                                <a href="javascript:void(0);">...</a>
                                </p>
                                </div>';
                }
                if(!empty($images)){
                    foreach ($images as $image) {
                        $tr .= '<div class="grid-item">
                                <img src="'.FileHelper::url($image->image).'">
                                <p class="text-center m-t-xxs m-b-xxs">
                                <a href="javascript:void(0);" data-id="'.$image->id.'" data-url="'.App::url('produits/images/delete').'" class="deleteImage btn btn-sm btn-danger">
                                    Supprimer       
                                </a>
                                </p>
                                </div>';
                    }
                }
                $tr .= '</div>';
                $cat = category::find($article->category_id);
                $sub = subcategory::find($article->sub_category);
                $rate = product_review::countBySearchType(null,$id);
                $content = '<table class="table table-striped table-bordered m-t-sm">
                                <tbody>
                                <tr><td class="col-md-2">SKU</td><td>'.$article->sku.'</td></tr>
                                <tr><td class="col-md-2">Nom</td><td>'.ucfirst($article->productname).'</td></tr>
                                <tr><td class="col-md-2">Slug</td><td>'.ucfirst($article->slug).'</td></tr>
                                <tr><td class="col-md-2">Type</td><td>'.$article->package_type.'</td></tr>
                                <tr><td class="col-md-2">Supplier code</td><td>'.$article->supplier_code.'</td></tr>
                                <tr><td class="col-md-2">Catégorie</td><td>'.$cat->category_name.'</td></tr>
                                <tr><td class="col-md-2">Sous catégorie</td><td>'.$sub->subcategory_name.'</td></tr>
                                <tr><td class="col-md-2">Prix offert</td><td>$ '.float_value($article->offer_price).'</td></tr>
                                <tr><td class="col-md-2">Prix</td><td>$ '.float_value($article->price).'</td></tr>
                                <tr><td class="col-md-2">Réduction</td><td>'.$article->discount.' %</td></tr>
                                <tr><td class="col-md-2">Longueur</td><td>'.$article->length.'</td></tr>
                                <tr><td class="col-md-2">Largeur</td><td>'.$article->width.'</td></tr>
                                <tr><td class="col-md-2">Poids</td><td>'.$article->weight.'</td></tr>
                                <tr><td class="col-md-2">Poids Oz</td><td>'.$article->weightOz.'</td></tr>
                                <tr><td class="col-md-2">Classe de fret</td><td>'.$article->freightClass.'</td></tr>
                                <tr><td class="col-md-2">Nmfc Code</td><td>'.$article->nmfcCode.'</td></tr>
                                <tr><td class="col-md-2">Trending Deals</td><td>'.StringHelper::$tabs[$article->trending].'</td></tr>
                                <tr><td class="col-md-2">Hot Products</td><td>'.StringHelper::$tabs[$article->hot].'</td></tr>
                                <tr><td class="col-md-2">Deal Recommended For You</td><td>'.StringHelper::$tabs[$article->deal].'</td></tr>
                                <tr><td class="col-md-2">Mots clés</td><td>'.StringHelper::isEmpty($article->tags,1).'</td></tr>
                                <tr><td class="col-md-2">Note</td><td>'.$rate->moyenne.' ('.$rate->Total.' fois)</td></tr>
                                <tr><td class="col-md-2">Stock disponible</td><td>'.thousand($article->qty).'</td></tr>
                                <tr><td class="col-md-2">Description</td><td>'.$article->description.'</td></tr>
                                <tr><td class="col-md-2">Etat</td><td>'.StringHelper::$tabArticleState[$article->status].'</td></tr>
                                <tr><td class="col-md-2">Date ajout</td><td>'.DateParser::DateConviviale($article->created_on,1).'</td></tr>
                                </tbody>
                            </table>'.$tr.'';

                $return = array("statuts" => 0, "contenu" => $content);
            }else{
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function save(){
        header('content-type: application/json');
        $return = [];
        $tab = ["add", "edit"];
        $tabs = [1, 2];
        if (isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prix']) && $_POST['prix']>0 && isset($_POST['offre']) && $_POST['offre']>0
            &&isset($_POST['type']) && !empty($_POST['type']) &&isset($_POST['sku'])&&!empty($_POST['sku'])&&$_POST['prix']>$_POST['offre']
            &&isset($_POST['sous']) && !empty($_POST['sous'])&&isset($_POST['slug']) && !empty($_POST['slug']) &&isset($_POST['weight'])
            &&isset($_POST['supplier']) &&isset($_POST['nmfc']) &&isset($_POST['mots'])&& in_array($_POST['type'],['Envelope','Courier Pack','Package','Pallet'])
            &&isset($_POST['freight']) &&isset($_POST['details']) &&isset($_POST['lenght']) &&isset($_POST['width']) &&isset($_POST['height'])
            && isset($_POST['action']) && !empty($_POST['action']) && isset($_POST['id']) && in_array($_POST["action"], $tab)&&isset($_POST['weightoz'])
            && isset($_POST['trending']) && in_array($_POST["trending"], $tabs)&& isset($_POST['deal']) && in_array($_POST["deal"], $tabs)&& isset($_POST['hot']) && in_array($_POST["hot"], $tabs)) {
            $nom = ucfirst(trim($_POST['nom']));
            $prix = (float)$_POST['prix'];
            $offre = (float)$_POST['offre'];
            $type = $_POST['type'];
            $sku = trim($_POST['sku']);
            $slug = trim($_POST['slug']);
            $weight = trim($_POST['weight']);
            $supplier = trim($_POST['supplier']);
            $nmfc = trim($_POST['nmfc']);
            $freight = trim($_POST['freight']);
            $details = trim($_POST['details']);
            $lenght = trim($_POST['lenght']);
            $width = trim($_POST['width']);
            $height = trim($_POST['height']);
            $weightoz = trim($_POST['weightoz']);
            $mots = trim($_POST['mots']);
            $sous = trim($_POST['sous']);
            $action = $_POST['action'];
            $trending = $_POST['trending'];
            $hot = $_POST['hot'];
            $deal = $_POST['deal'];
            $id = $_POST['id'];
            $sousCategorie = subcategory::find($sous);
            if($sousCategorie){
                $reduction = ((($prix-$offre)*100)/$prix);
                $reduction = number_format($reduction,2);
                if($action == "edit") {
                    Privilege::hasPrivilege(Privilege::$eshopProductEdit,$this->user->privilege);
                    if (!empty($id)){
                        $article = products::find($id);
                        if ($article) {
                            $bool = $bool1 = true;
                            if($sku!=$article->sku&&products::bySku($sku)){
                                $bool = false;
                            }
                            if($nom!=$article->productname&&products::byNom($nom)){
                                $bool1 = false;
                            }
                            if($bool){
                                if($bool1){
                                    $pdo = App::getDb()->getPDO();
                                    try{
                                        $pdo->beginTransaction();
                                        products::save($nom,$sousCategorie->category_id,$slug,$details,$prix,$offre,$sousCategorie->id,$sku,
                                            $supplier,$reduction,$mots,$type,$lenght,$width,$height,$weight,$weightoz,$freight,$nmfc,$trending,$deal,$hot,$id);
                                        $message = "Le produit a été mis à jour avec succès";
                                        $this->session->write('success',$message);
                                        $pdo->commit();
                                        $return = array("statuts" => 0, "mes" => $message);
                                    }catch (Exception $e){
                                        $pdo->rollBack();
                                        $message = $e->getMessage();
                                        $return = array("statuts" => 1, "mes" => $message);
                                    }
                                }else{
                                    $message = "Le nom de ce produit existe déjà";
                                    $return = array("statuts" => 1, "mes" => $message);
                                }
                            }else{
                                $message = "Le SKU de ce produit existe déjà";
                                $return = array("statuts" => 1, "mes" => $message);
                            }
                        } else {
                            $message = $this->error;
                            $return = array("statuts" => 1, "mes" => $message);
                        }
                    } else {
                        $message = $this->error;
                        $return = array("statuts" => 1, "mes" => $message);
                    }
                } else {
                    Privilege::hasPrivilege(Privilege::$eshopProductAdd,$this->user->privilege);
                    if(!products::bySku($sku)){
                        if(!products::byNom($nom)){
                            $pdo = App::getDb()->getPDO();
                            try{
                                $pdo->beginTransaction();
                                products::save($nom,$sousCategorie->category_id,$slug,$details,$prix,$offre,$sousCategorie->id,$sku,
                                    $supplier,$reduction,$mots,$type,$lenght,$width,$height,$weight,$weightoz,$freight,$nmfc,$trending,$deal,$hot);
                                $lastId = products::lastId();
                                $errorFile = "";
                                if(isset($_FILES['image']['name'])){
                                    $extensions_valides = array('jpg','jpeg','png','JPG','JPEG','PNG');
                                    $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
                                    if(in_array($extension_upload,$extensions_valides) && in_array($extension_upload,$extensions_valides) ){
                                        if($_FILES['image']['size']<=500000){
                                            $image_info = getimagesize($_FILES["image"]["tmp_name"]);
                                            $image_width = $image_info[0];
                                            $image_height = $image_info[1];
                                            $root = FileHelper::moveImageArticle($sku,$_FILES['image']['tmp_name'],"articles","jpg","",true);
                                            if($root){
                                                products::setImage($root,$lastId);
                                            }
                                        }else{
                                            $errorFile = "L'image principale doit avoir une taille inférieure ou égal à 500 Ko";
                                        }
                                    }else{
                                        $errorFile = "L'image principale doit être au format jpg ou png";
                                    }
                                }else{
                                    $errorFile = "L'image principale du produit est requise";
                                }
                                if(count($_FILES['file'])>0){
                                    $extensions_valides = array('jpg','jpeg','png','JPG','JPEG','PNG');
                                    for($i=0;$i<count($_FILES['file']['name']);$i++){
                                        if($_FILES['file']['error'][$i] == 0){
                                            $extension_upload = strtolower(  substr(  strrchr($_FILES['file']['name'][$i], '.')  ,1)  );
                                            if(in_array($extension_upload,$extensions_valides)){
                                                if($_FILES['file']['size'][$i]<=500000){
                                                    $image_info = getimagesize($_FILES["file"]["tmp_name"][$i]);
                                                    $image_width = $image_info[0];
                                                    $image_height = $image_info[1];
                                                    /*if($image_width==230&&$image_height==210){

                                                    }*/
                                                    $root = FileHelper::moveImageArticle($sku,$_FILES['file']['tmp_name'][$i],"articles","jpg","",true);
                                                    if($root){
                                                        productsimage::save($lastId,$root);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                if(empty($errorFile)){
                                    $message = "Le produit a été ajouté avec succès";
                                    $this->session->write('success',$message);
                                    $pdo->commit();
                                    $return = array("statuts" => 0, "mes" => $message);
                                }else{
                                    $return = array("statuts" => 1, "mes" => $errorFile);
                                }
                            }catch (Exception $e){
                                $pdo->rollBack();
                                $message = $this->error;
                                $return = array("statuts" => 1, "mes" => $message);
                            }
                        }else{
                            $message = "Le nom de ce produit existe déjà";
                            $return = array("statuts" => 1, "mes" => $message);
                        }
                    }else{
                        $message = "Le SKU de ce produit existe déjà";
                        $return = array("statuts" => 1, "mes" => $message);
                    }
                }
            }else{
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        } else {
            $message = "Veiullez renseigner tous les champs requis";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function setStock(){
        Privilege::hasPrivilege(Privilege::$eshopProductAddToStock,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])&&isset($_POST['nbre']) && !empty($_POST['nbre']) && $_POST['nbre']>0){
            $id = $_POST['id'];
            $nbre = $_POST['nbre'];
            $article = products::find($id);
            if($article){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    products::setStock($article->qty+$nbre,$id);
                    /*Historique::save($article->id,$article->stock,$article->stock+$nbre,$nbre,1);
                    $idLast = Historique::lastId();
                    Historique::setRaison("Approvisionnement",$idLast);
                    Historique::setAdmin($this->user->id,$this->user->nom.' '.$this->user->prenom,$idLast);
                    Article::update(DATE_COURANTE,$id);*/
                    $message = "Le stock a été augmenté avec succès";
                    $this->session->write('success',$message);
                    $pdo->commit();
                    $return = array("statuts" => 0, "mes" => $message);
                }catch (Exception $e){
                    $pdo->rollBack();
                    $message = $this->error;
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->empty;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function delStock(){
        Privilege::hasPrivilege(Privilege::$eshopProductMoveToStock,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])&&isset($_POST['raison'])
            &&isset($_POST['nbre']) && !empty($_POST['nbre']) && $_POST['nbre']>0){
            $id = $_POST['id'];
            $nbre = $_POST['nbre'];
            $raison = $_POST['raison'];
            $article = products::find($id);
            if($article){
                if($article->qty>=$nbre){
                    $pdo = App::getDb()->getPDO();
                    try{
                        $pdo->beginTransaction();
                        products::setStock($article->qty-$nbre,$id);
                        /*Historique::save($article->id,$article->stock,$article->stock-$nbre,$nbre,2);
                        $idLast = Historique::lastId();
                        Historique::setRaison($raison,$idLast);
                        Historique::setAdmin($this->user->id,$this->user->nom.' '.$this->user->prenom,$idLast);*/
                        $message = "Le stock a été diminué avec succès";
                        $this->session->write('success',$message);
                        $pdo->commit();
                        $return = array("statuts" => 0, "mes" => $message);
                    }catch (Exception $e){
                        $pdo->rollBack();
                        $message = $this->error;
                        $return = array("statuts" => 1, "mes" => $message);
                    }
                }else{
                    $message = "Il ne reste que $article->qty en stock";
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->empty;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function setEtat(){
        Privilege::hasPrivilege(Privilege::$eshopProductActivation,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])&&isset($_POST['etat'])  && in_array($_POST['etat'],[1,0])){
            $id = $_POST['id'];
            $etat = $_POST['etat'];
            $article = products::find($id);
            if($article){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    products::setEtat($etat,$id);
                    $message = "L'opération s'est effectuée avec succès";
                    $this->session->write('success',$message);
                    $pdo->commit();
                    $return = array("statuts" => 0, "mes" => $message);
                }catch (Exception $e){
                    $pdo->rollBack();
                    $message = $this->error;
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->empty;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function setImage(){
        Privilege::hasPrivilege(Privilege::$eshopProductChangeImg,$this->user->privilege);
        header('content-type: application/json');
        if(isset($_FILES['file']['name'])){
            $id = DataHelper::post('idPhoto');
            $product = products::find($id);
            if($product){
                if(count($_FILES['file'])>0){
                    $extensions_valides = array('jpg','jpeg','png','JPG','JPEG','PNG');
                    $pdo = App::getDb()->getPDO();
                    try{
                        $pdo->beginTransaction();
                        $j = 0;
                        for($i=0;$i<count($_FILES['file']['name']);$i++){
                            if($_FILES['file']['error'][$i] == 0){
                                $extension_upload = strtolower(  substr(  strrchr($_FILES['file']['name'][$i], '.')  ,1)  );
                                if(in_array($extension_upload,$extensions_valides)){
                                    if($_FILES['file']['size'][$i]<=500000){
                                        $image_info = getimagesize($_FILES["file"]["tmp_name"][$i]);
                                        $image_width = $image_info[0];
                                        $image_height = $image_info[1];
                                        if($image_width==230&&$image_height==210){

                                        }
                                        $root = FileHelper::moveImageArticle($product->sku,$_FILES['file']['tmp_name'][$i],"articles",$extension_upload,"",true);
                                        if($root){
                                            productsimage::save($id,$root);
                                            $j++;
                                        }
                                    }
                                }
                            }
                        }
                        if($j>0){
                            $return = "Les images ont été ajoutées avec succès";
                            $this->session->write('success',$return);
                            $pdo->commit();
                            $return = array("statuts"=>0, "mes"=>$return);
                        }else{
                            $pdo->rollBack();
                            $message = "Vous devez joindre au moins une image jpg ou png de 230 pixels de large sur 210 pixels de haut et de moins de 500 Ko au produit";
                            $return = array("statuts" => 1, "mes" => $message);
                        }
                    }catch (Exception $e){
                        $pdo->rollBack();
                        $message = $this->error;
                        $return = array("statuts" => 1, "mes" => $message);
                    }
                }else{
                    $message = "Vous devez joindre au moins une image au produit";
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = "Une erreur est survenue";
                $return = array("statuts"=>1, "mes"=>$message);
            }
        }else{
            $message = $this->empty;
            $return = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($return);
    }

    public function setPhoto(){
        Privilege::hasPrivilege(Privilege::$eshopProductChangeImg,$this->user->privilege);
        header('content-type: application/json');
        if(isset($_FILES['image']['name'])){
            $id = DataHelper::post('idImage');
            if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])&& !is_null($id) ){
                if ($_FILES['image']['error'] == 0){
                    $extensions_valides = array('jpg','jpeg','png','JPG','JPEG','PNG');
                    $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
                    if(in_array($extension_upload,$extensions_valides)){
                        if($_FILES['image']['size']<=500000){
                            $image_info = getimagesize($_FILES["image"]["tmp_name"]);
                            $image_width = $image_info[0];
                            $image_height = $image_info[1];
                            /*if($image_width==230&&$image_height==210){

                            }else{
                                $erreur = "L'image principale doit avoir 230 pixels de large sur 210 pixels de haut";
                                $result = array("statuts"=>1, "mes"=>$erreur);
                            }*/
                            $product = products::find($id);
                            if($product){
                                $pdo = App::getDb()->getPDO();
                                try{
                                    $pdo->beginTransaction();
                                    FileHelper::deleteImage($product->image);
                                    $root = FileHelper::moveImageArticle($product->sku,$_FILES['image']['tmp_name'],"articles",$extension_upload,"",true);
                                    if($root){
                                        products::setImage($root,$id);
                                        $success = "L'image principale a été mise à jour avec succès";
                                        $this->session->write('success',$success);
                                        $pdo->commit();
                                        $result = array("statuts"=>0, "mes"=>$success);
                                    }else{
                                        $erreur = $this->error;
                                        $result = array("statuts"=>1, "mes"=>$erreur);
                                    }
                                } catch(Exception $e){
                                    $pdo->rollBack();
                                    $erreur = $this->error;
                                    $result = array("statuts"=>1, "mes"=>$erreur);
                                }
                            } else{
                                $erreur =  'Une erreur est survenue, recharger et réessayer';
                                $result = array("statuts"=>1, "mes"=>$erreur);
                            }
                        }else{
                            $erreur =  'Le fichier doit avoir une taille inférieure ou égale à 500 Ko';
                            $result = array("statuts"=>1, "mes"=>$erreur);
                        }
                    }else{
                        $message = "Le fichier doit être une image d'extension jpg ou png";
                        $result = array("statuts"=>1, "mes"=>$message);
                    }
                }else{
                    $message = $this->error;
                    $result = array("statuts"=>1, "mes"=>$message);
                }
            }else{
                $message = "Vous devez uploader un fichier";
                $result = array("statuts"=>1, "mes"=>$message);
            }
        }else{
            $message = $this->empty;
            $result = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($result);
    }

    public function deleteImage(){
        Privilege::hasPrivilege(Privilege::$eshopProductDeleteImg,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $item = productsimage::find($id);
            if($item){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    FileHelper::deleteImage($item->image);
                    productsimage::delete($id);
                    $message = "Image supprimée avec succès";
                    $return = array("statuts" => 0, "mes" => $message);
                    $pdo->commit();
                } catch(Exception $e){
                    $pdo->rollBack();
                    $erreur = $this->error;
                    $return = array("statuts"=>1, "mes"=>$erreur);
                }
            }else{
                $message = "Une erreur est apparue, recharger";
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = "Une erreur est apparue, recharger";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function setDeal(){
        Privilege::hasPrivilege(Privilege::$eshopProductDealActivation,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        $tab = ["add", "edit"];
        if (isset($_POST['d_date']) && !empty($_POST['d_date']) && isset($_POST['d_prix']) && $_POST['d_prix']>0
            &&isset($_POST['d_fin']) && !empty($_POST['d_fin']) &&isset($_POST['d_titre'])&&!empty($_POST['d_titre'])
            &&isset($_POST['d_details'])&&isset($_POST['idDeal']) && !empty($_POST['idDeal'])) {
            $nom = ucfirst(trim($_POST['d_titre']));
            $prix = (float)$_POST['prix'];
            $details = trim($_POST['d_details']);
            $debut = $_POST['d_date'];
            $fin = $_POST['d_fin'];
            $id = $_POST['idDeal'];
            $product = products::find($id);
            if($product){
                if($product->price>$prix){
                    if(date(MYSQL_DATETIME_FORMAT,strtotime($debut))<date(MYSQL_DATETIME_FORMAT,strtotime($fin))){
                        $pdo = App::getDb()->getPDO();
                        try{
                            $pdo->beginTransaction();
                            $debut = new DateTime($debut);
                            $fin = new DateTime($fin);
                            dealoftheday::save($nom,$debut->format(MYSQL_DATETIME_FORMAT),$fin->format(MYSQL_DATETIME_FORMAT),$id,$prix,$details);
                            $lastId = dealoftheday::lastId();
                            $errorFile = "";
                            if(isset($_FILES['image']['name'])){
                                $extensions_valides = array('jpg','jpeg','png','JPG','JPEG','PNG');
                                $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
                                if(in_array($extension_upload,$extensions_valides) && in_array($extension_upload,$extensions_valides) ){
                                    if($_FILES['image']['size']<=500000){
                                        $image_info = getimagesize($_FILES["image"]["tmp_name"]);
                                        $image_width = $image_info[0];
                                        $image_height = $image_info[1];
                                        $root = FileHelper::moveImage($_FILES['image']['tmp_name'],"articles","jpg","",true);
                                        if($root){
                                            dealoftheday::setImage($root,$lastId);
                                        }
                                    }else{
                                        $errorFile = "L'image doit avoir une taille inférieure ou égal à 500 Ko";
                                    }
                                }else{
                                    $errorFile = "L'image doit être au format jpg ou png";
                                }
                            }else{
                                $errorFile = "La banniere est requise";
                            }
                            if(empty($errorFile)){
                                $message = "Le produit a été associé avec succès au deal du jour";
                                $this->session->write('success',$message);
                                $pdo->commit();
                                $return = array("statuts" => 0, "mes" => $message);
                            }else{
                                $return = array("statuts" => 1, "mes" => $errorFile);
                            }
                        }catch (Exception $e){
                            $pdo->rollBack();
                            $message = $this->error;
                            $return = array("statuts" => 1, "mes" => $message);
                        }
                    }else{
                        $message = "La date de début ne doit pas être inférieure à la date de fin";
                        $return = array("statuts"=>1, "mes"=>$message);
                    }
                }else{
                    $message = "Le prix du deal ne peut pas être supérieur au prix";
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        } else {
            $message = "Veiullez renseigner tous les champs requis";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function commandes(){
        Privilege::hasPrivilege(Privilege::$eshopCommandView,$this->user->privilege);
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $article = products::find($id);
            if($article){
                $user = $this->user;
                $nbreParPage = 20;
                $etat = (isset($_GET['etat'])&&!empty($_GET['etat'])) ? $_GET['etat'] : null;
                $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
                $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
                $nbre = checkout_orders::countBySearchType($id,null,$etat,$debut,$end);
                $nbrePages = ceil($nbre->Total / $nbreParPage);
                if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                    $pageCourante = $_GET['page'];
                } else {
                    $pageCourante = 1;
                    $params['page'] = $pageCourante;
                }
                $lignes = checkout_orders::searchType($nbreParPage,$pageCourante,$id,null,$etat,$debut,$end);
                $this->render('admin.article.lignes',compact('debut','end','etat','article','lignes','user','nbre','nbrePages'));
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

    public function reviews(){
        Privilege::hasPrivilege(Privilege::$eshopCommandView,$this->user->privilege);
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $article = products::find($id);
            if($article){
                $user = $this->user;
                $nbreParPage = 20;
                $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
                $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
                $nbre = product_review::countBySearchType(null,$id,$debut,$end);
                $nbrePages = ceil($nbre->Total / $nbreParPage);
                if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                    $pageCourante = $_GET['page'];
                } else {
                    $pageCourante = 1;
                    $params['page'] = $pageCourante;
                }
                $items = product_review::searchType($nbreParPage,$pageCourante,null,$id,$debut,$end);
                $this->render('admin.article.reviews',compact('article','items','user','nbre','nbrePages'));
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

}