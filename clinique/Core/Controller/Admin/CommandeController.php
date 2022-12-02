<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Admin;


use Exception;
use Mpdf\Mpdf;
use DateTime;
use Mpdf\MpdfException;
use Projet\Database\Article;
use Projet\Database\checkout_orders;
use Projet\Database\Commande;
use Projet\Database\Coupon;
use Projet\Database\Historique_Compte;
use Projet\Database\Historique_Point;
use Projet\Database\Ligne;
use Projet\Database\Marchand;
use Projet\Database\orders;
use Projet\Database\Point_Marchand;
use Projet\Database\Profil;
use Projet\Database\Tranche;
use Projet\Model\App;
use Projet\Model\EmailShipped;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;
use Projet\Model\Sms;
use Projet\Model\StringHelper;

class CommandeController extends AdminController{

    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopCommandView,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 50;
        $s_etat = (isset($_GET['etat'])&&!empty($_GET['etat'])) ? $_GET['etat'] : null;
        $s_ref = (isset($_GET['ref'])&&!empty($_GET['ref'])) ? $_GET['ref'] : null;
        $s_debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
        $s_end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
        $nbre = orders::countBySearchType(null,$s_ref,$s_etat,$s_debut,$s_end);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $commandes = orders::searchType($nbreParPage,$pageCourante,null,$s_ref,$s_etat,$s_debut,$s_end);
        $this->render('admin.commande.index',compact('s_etat','s_ref','s_debut','s_end','commandes','user','nbre','nbrePages'));
    }

    public function detail(){
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $commande = orders::find($id);
            if($commande){
                $user = $this->user;
                $nbreParPage = 100;
                $nbre = checkout_orders::countBySearchType(null,null,null,null,null,$commande->order_id);
                $nbrePages = ceil($nbre->Total / $nbreParPage);
                if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                    $pageCourante = $_GET['page'];
                } else {
                    $pageCourante = 1;
                    $params['page'] = $pageCourante;
                }
                $lignes = checkout_orders::searchType($nbreParPage,$pageCourante,null,null,null,null,null,$commande->order_id);
                $this->render('admin.commande.lignes',compact('commande','lignes','user','nbre','nbrePages'));
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

    public function buildCart($lignes){
        $content = "";
        if(!empty($lignes)){
            $nbre = $total = 0;
            foreach ($lignes as $ligne) {
                $article = Article::find($ligne->idArticle);
                $nbre += $ligne->nbre;
                $total += $ligne->prixTotal;
                $content .=
                    '
                    <div style="background-color:transparent;">
                        <div class="block-grid four-up no-stack" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:650px"><tr class="layout-full-width" style="background-color:#FFFFFF"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 162px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 0px;padding-left: 0px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="center"><![endif]--><img align="center" alt="Image" border="0" class="center fixedwidth" src="'.FileHelper::url($article->image).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 130px; display: block;" title="Image" width="130"/>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:30px; padding-bottom:35px;"><![endif]-->
                                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:30px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 10px; padding-bottom: 5px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:\'Lato\', Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:5px;padding-left:0px;">
                                                <div style="font-size: 12px; line-height: 1.2; font-family: \'Lato\', Tahoma, Verdana, Segoe, sans-serif; color: #555555; mso-line-height-alt: 14px;">
                                                    <p style="font-size: 16px; line-height: 1.2; text-align: left; mso-line-height-alt: 19px; margin: 0;"><span style="font-size: 16px; color: #2190e3;"><strong></strong></span></p>
                                                </div>
                                            </div>
                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:\'Lato\', Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:0px;">
                                                <div style="font-size: 12px; line-height: 1.2; font-family: \'Lato\', Tahoma, Verdana, Segoe, sans-serif; color: #555555; mso-line-height-alt: 14px;">
                                                    <p style="font-size: 14px; line-height: 1.2; text-align: left; mso-line-height-alt: 17px; margin: 0;"><b>'.ucfirst($article->intitule).'</b></p>
                                                </div>
                                            </div>
                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 1px dotted #E8E8E8;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:55px; padding-bottom:5px;"><![endif]-->
                                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 161px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:1px dotted #E8E8E8; padding-top:55px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:\'Lato\', Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                                <div style="font-size: 12px; line-height: 1.2; font-family: \'Lato\', Tahoma, Verdana, Segoe, sans-serif; color: #555555; mso-line-height-alt: 14px;">
                                                    <p style="font-size: 20px; line-height: 1.2; text-align: center; mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 20px;"><strong>'.thousand($ligne->nbre).'</strong></span></p>
                                                </div>
                                            </div>
                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
                                                <tbody>
                                                <tr style="vertical-align: top;" valign="top">
                                                    <td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;" valign="top">
                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="30" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid transparent; height: 30px; width: 100%;" valign="top" width="100%">
                                                            <tbody>
                                                            <tr style="vertical-align: top;" valign="top">
                                                                <td height="30" style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td><td align="center" width="162" style="background-color:#FFFFFF;width:162px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:55px; padding-bottom:5px;"><![endif]-->
                                <div class="col num3" style="max-width: 320px; min-width: 162px; display: table-cell; vertical-align: top; width: 162px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:55px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 15px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:\'Lato\', Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:0px;padding-right:15px;padding-bottom:0px;padding-left:0px;">
                                                <div style="line-height: 1.2; font-size: 12px; font-family: \'Lato\', Tahoma, Verdana, Segoe, sans-serif; color: #555555; mso-line-height-alt: 14px;">
                                                    <p style="line-height: 1.2; text-align: center; font-size: 20px; mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 20px;"><span style="font-size: 20px;"><strong><small>XOF</small> '.thousand($ligne->prixTotal).'</strong></span></span></p>
                                                </div>
                                            </div>
                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    ';
            }
        }
        return $content;
    }

    public function setEtat(){
        Privilege::hasPrivilege(Privilege::$eshopCommandValid,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            $commande = Commande::find($id);
            if($commande){
                $user = Profil::find($commande->idUser);
                if($user&&$commande->etat==1&&$commande->etats==1){
                    $pdo = App::getDb()->getPDO();
                    try{
                        $pdo->beginTransaction();
                        Commande::setEtat(3,$id);
                        Commande::setLivraison(3,$id);
                        Commande::setDatePaiement(DATE_COURANTE,$id);
                        Commande::setDateLivraison(DATE_COURANTE,$id);

                        $tabMarchand = $tabsMarchand = [];
                        $isForfait = $commande->forfait > 0;
                        $lignes = Ligne::searchType(null,null,$id);
                        $pointsCoupon = 0;
                        $boolAFRIKFID = false;
                        $idMarchandCoupon = 0;
                        if(!empty($commande->codeCoupon)){
                            $coupon = Coupon::byCode($commande->codeCoupon);
                            if($coupon->idMarchand==0){
                                $bool = $user->points>$coupon->points?true:false;
                                $boolAFRIKFID = $bool;
                                if($bool){
                                    $pointsCoupon = $coupon->points;
                                }
                            }
                        }
                        $totalAmount = 0;
                        $leMarchand = null;
                        foreach ($lignes as $ligne) {
                            $article = Article::find($ligne->idArticle);
                            Article::setReserved($article->reserved-$ligne->nbre,$article->id);
                            $nbrePoint = $ligne->prixTotal/VALUE_OF_POINT;
                            if(array_key_exists($article->idMarchand,$tabsMarchand)){
                                $tabsMarchand [$article->idMarchand] += $nbrePoint;
                            }else{
                                $tabsMarchand [$article->idMarchand] = $nbrePoint;
                            }
                            if($isForfait){
                                if(array_key_exists($article->idMarchand,$tabsMarchand)){
                                    $tabMarchand[$article->idMarchand] += $nbrePoint;
                                }else{
                                    $tabMarchand[$article->idMarchand] = $nbrePoint;
                                }
                            }
                            if(!empty($commande->codeCoupon)){
                                if($article->idMarchand==$coupon->idMarchand){
                                    $leMarchand = Point_Marchand::gets($coupon->idMarchand,$user->id);
                                    $totalAmount += $ligne->prixUnitaire;
                                }
                                if(!is_null($leMarchand)){
                                    $bool = $leMarchand->points>$coupon->points?true:false;
                                    if($bool){
                                        $pointsCoupon = $coupon->points;
                                        $idMarchandCoupon = $leMarchand->id;
                                    }
                                }
                            }
                        }

                        $pointsTotal = 0;
                        if($isForfait){
                            foreach ($tabsMarchand as $k => $v) {
                                $pointMarchand = Point_Marchand::gets($k,$commande->idUser);
                                if($pointMarchand){
                                    Point_Marchand::setPoints($pointMarchand->points+$v,$pointMarchand->id);
                                    Historique_Point::save($pointMarchand->id,$commande->idUser,$k,$pointMarchand->points,$pointMarchand->points+$v,$v,1,"Approvisionnement par commande");
                                }else{
                                    Point_Marchand::save($commande->idUser,$k,$v);
                                    $idLast = Point_Marchand::lastId();
                                    Historique_Point::save($idLast,$commande->idUser,$k,0,$v,$v,1,"Approvisionnement par commande");
                                }
                                $pointsTotal += $v;
                            }
                        }
                        if($boolAFRIKFID){
                            $pointsTotal -= $pointsCoupon;
                        }
                        if(!empty($idMarchandCoupon)){
                            $pointsTotal -= $pointsCoupon;
                            Historique_Point::save($idMarchandCoupon,$commande->idUser,$leMarchand->idMarchand,$leMarchand->points,$leMarchand->points+$pointsCoupon,$pointsCoupon,2,"Achat chez $leMarchand->nom");
                            Point_Marchand::setPoints($leMarchand->points-$pointsCoupon,$idMarchandCoupon);
                        }
                        if(!empty($pointsTotal)){
                            Profil::setPoints($user->points+$pointsTotal,$user->id);
                        }

                        $commision = 0;
                        $commisionCarte = $commande->comissionCarte;
                        $soldeAfrikFid = Marchand::find(0)->solde;
                        foreach ($tabsMarchand as $k=>$v) {
                            $marchand = Marchand::find($k);
                            $tranche = Tranche::get($v);
                            $amount = $v-$tranche->cout;
                            Historique_Compte::saveMarchand($marchand->id,$marchand->solde,$marchand->solde+$amount,$amount,1,"Recettes",0);
                            if($k!=0)
                                Marchand::setSolde($marchand->solde+$amount,$marchand->id);
                            $soldeAfrikFid = $k==0 ? $soldeAfrikFid + $amount : $soldeAfrikFid;
                            $commision += $tranche->cout;
                        }
                        if(!empty($commision)){
                            Commande::setComission($commision,$commande->id);
                            Historique_Compte::saveMarchand(0,$soldeAfrikFid,$soldeAfrikFid+$commision,$commision,1,"Commissions",0);
                        }
                        if(!empty($commisionCarte))
                            Historique_Compte::saveMarchand(0,$soldeAfrikFid+$commision,$soldeAfrikFid+$commision+$commisionCarte,$commisionCarte,1,"Commission Carte de fidélité",0);
                        Marchand::setSolde($soldeAfrikFid+$commision+$commisionCarte,0);
                        if(!empty($user->email)){
                            $content = $this->buildCart($lignes);
                            $emailer1 = new EmailShipped($user->email,"Livraison de la commande $commande->ref effectuée avec succès",
                                "$user->nom $user->prenom",$commande,$user,$content,"Afrikfid Account");
                            $emailer1->send();
                        }
                        $message = "La commande a été payée et livrée avec succès";
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
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);

    }

    public function setPayer(){
        Privilege::hasPrivilege(Privilege::$eshopCommandValid,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            $commande = Commande::find($id);
            if($commande){
                $user = Profil::find($commande->idUser);
                if($user&&$commande->etat==1&&!empty($commande->idTransaction)){
                    $pdo = App::getDb()->getPDO();
                    try{
                        $pdo->beginTransaction();
                        Commande::setEtat(2,$id);
                        Commande::setDatePaiement(DATE_COURANTE,$id);
                        $commision = 0;
                        $commisionCarte = $commande->comissionCarte;
                        $soldeAfrikFid = Marchand::find(0)->solde;

                        $tabMarchand = $tabsMarchand = [];
                        $isForfait = $commande->forfait > 0;
                        $lignes = Ligne::searchType(null,null,$id);
                        $pointsCoupon = 0;
                        $boolAFRIKFID = false;
                        $idMarchandCoupon = 0;
                        if(!empty($commande->codeCoupon)){
                            $coupon = Coupon::byCode($commande->codeCoupon);
                            if($coupon->idMarchand==0){
                                $bool = $user->points>$coupon->points?true:false;
                                $boolAFRIKFID = $bool;
                                if($bool){
                                    $pointsCoupon = $coupon->points;
                                }
                            }
                        }
                        $totalAmount = 0;
                        $leMarchand = null;
                        foreach ($lignes as $ligne) {
                            $article = Article::find($ligne->idArticle);
                            $nbrePoint = $ligne->prixTotal/VALUE_OF_POINT;
                            if(array_key_exists($article->idMarchand,$tabsMarchand)){
                                $tabsMarchand [$article->idMarchand] += $nbrePoint;
                            }else{
                                $tabsMarchand [$article->idMarchand] = $nbrePoint;
                            }
                            if($isForfait){
                                if(array_key_exists($article->idMarchand,$tabMarchand)){
                                    $tabMarchand[$article->idMarchand] += $nbrePoint;
                                }else{
                                    $tabMarchand[$article->idMarchand] = $nbrePoint;
                                }
                            }
                            if(!empty($commande->codeCoupon)){
                                if($article->idMarchand==$coupon->idMarchand){
                                    $leMarchand = Point_Marchand::gets($coupon->idMarchand,$user->id);
                                    $totalAmount += $ligne->prixUnitaire;
                                }
                                if(!is_null($leMarchand)){
                                    $bool = $leMarchand->points>$coupon->points?true:false;
                                    if($bool){
                                        $pointsCoupon = $coupon->points;
                                        $idMarchandCoupon = $leMarchand->id;
                                    }
                                }
                            }
                        }

                        $pointsTotal = 0;
                        if($isForfait){
                            foreach ($tabsMarchand as $k => $v) {
                                $pointMarchand = Point_Marchand::gets($k,$commande->idUser);
                                if($pointMarchand){
                                    Point_Marchand::setPoints($pointMarchand->points+$v,$pointMarchand->id);
                                    Historique_Point::save($pointMarchand->id,$commande->idUser,$k,$pointMarchand->points,$pointMarchand->points+$v,$v,1,"Approvisionnement par commande");
                                }else{
                                    Point_Marchand::save($commande->idUser,$k,$v);
                                    $idLast = Point_Marchand::lastId();
                                    Historique_Point::save($idLast,$commande->idUser,$k,0,$v,$v,1,"Approvisionnement par commande");
                                }
                                $pointsTotal += $v;
                            }
                        }
                        if($boolAFRIKFID){
                            $pointsTotal -= $pointsCoupon;
                        }
                        if(!empty($idMarchandCoupon)){
                            $pointsTotal -= $pointsCoupon;
                            Historique_Point::save($idMarchandCoupon,$commande->idUser,$leMarchand->idMarchand,$leMarchand->points,$leMarchand->points+$pointsCoupon,$pointsCoupon,2,"Achat chez $leMarchand->nom");
                            Point_Marchand::setPoints($leMarchand->points-$pointsCoupon,$idMarchandCoupon);
                        }
                        if(!empty($pointsTotal)){
                            Profil::setPoints($user->points+$pointsTotal,$user->id);
                        }
                        foreach ($tabsMarchand as $k=>$v) {
                            $marchand = Marchand::find($k);
                            $tranche = Tranche::get($v);
                            $amount = $v-$tranche->cout;
                            Historique_Compte::saveMarchand($marchand->id,$marchand->solde,$marchand->solde+$amount,$amount,1,"Recettes",0);
                            if($k!=0)
                                Marchand::setSolde($marchand->solde+$amount,$marchand->id);
                            $soldeAfrikFid = $k==0 ? $soldeAfrikFid + $amount : $soldeAfrikFid;
                            $commision += $tranche->cout;
                        }
                        if(!empty($commision)){
                            Commande::setComission($commision,$commande->id);
                            Historique_Compte::saveMarchand(0,$soldeAfrikFid,$soldeAfrikFid+$commision,$commision,1,"Commission Marchand",0);
                        }
                        if(!empty($commisionCarte))
                            Historique_Compte::saveMarchand(0,$soldeAfrikFid+$commision,$soldeAfrikFid+$commision+$commisionCarte,$commisionCarte,1,"Commission Carte de fidélité",0);
                        Marchand::setSolde($soldeAfrikFid+$commision+$commisionCarte,0);
                        $message = "La commande a été payée avec succès";
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
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function setEtats(){
        Privilege::hasPrivilege(Privilege::$eshopCommandValid,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])&&isset($_POST['etat']) && in_array($_POST['etat'],[1,2])){
            $id = $_POST['id'];
            $etat = $_POST['etat'];
            $commande = Commande::find($id);
            if($commande){
                if((($etat==1&&$commande->etats==0)||($etat==2&&($commande->etats==1||$commande->etats==0)))&&$commande->etat!=3){
                    $pdo = App::getDb()->getPDO();
                    try{
                        $pdo->beginTransaction();
                        Commande::setEtats($etat,$id);
                        $lignes = Ligne::searchType(null,null,$id);
                        foreach ($lignes as $ligne) {
                            $article = Article::find($ligne->idArticle);
                            if($etat==1){
                                Article::setStock($article->stock-$ligne->nbre,$article->id);
                                Article::setReserved($article->reserved+$ligne->nbre,$article->id);
                            }else{
                                Article::setStock($article->stock+$ligne->nbre,$article->id);
                                Article::setReserved($article->reserved-$ligne->nbre,$article->id);
                            }
                        }
                        $message = "L'opération s'est passée avec succès";
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
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function setState(){
        Privilege::hasPrivilege(Privilege::$eshopCommandValid,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            $commande = Commande::find($id);
            if($commande&&$commande->etats==1&&$commande->etat!=3){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    $lignes = Ligne::searchType(null,null,$id);
                    foreach ($lignes as $ligne) {
                        $article = Article::find($ligne->idArticle);
                        Article::setStock($article->stock+$ligne->nbre,$article->id);
                        Article::setReserved($article->reserved-$ligne->nbre,$article->id);
                    }
                    Commande::setEtats(2,$id);
                    $message = "La commande a été annulée et le stock a été retabli avec succès";
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
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function setLivraison(){
        Privilege::hasPrivilege(Privilege::$eshopCommandValid,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            $commande = Commande::find($id);
            if($commande->etat==2&&$commande->etats==1){
                $profil = Profil::find($commande->idUser);
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    Commande::setEtat(3,$id);
                    Commande::setDateLivraison(DATE_COURANTE,$id);
                    $lignes = Ligne::searchType(null,null,$id);
                    foreach ($lignes as $ligne) {
                        $article = Article::find($ligne->idArticle);
                        Article::setReserved($article->reserved-$ligne->nbre,$article->id);
                    }

                    if(!empty($profil->email)){
                        $content = $this->buildCart($lignes);
                        $emailer1 = new EmailShipped($profil->email,"Livraison de la commande $commande->ref effectuée avec succès",
                            "$profil->nom $profil->prenom",$commande,$profil,$content,"Afrikfid Account");
                        $emailer1->send();
                    }
                    $message = "La commande a été livrée avec succès";
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
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function livraison() {
        header('content-type: application/json');
        if (isset($_FILES['image']['name'])) {
            if (isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name']) && isset($_POST['id'])
            &&!empty($_POST['id'])&&isset($_POST['type'])&&in_array($_POST['type'],[1,2])) {
                $id = $_POST['id'];
                $type = $_POST['type'];
                if ($_FILES['image']['error'] == 0) {
                    $extensions_valides = array('jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG', 'pdf');
                    $extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
                    if (in_array($extension_upload, $extensions_valides)) {
                        if ($_FILES['image']['size'] <= 500000) {
                            $commande = Commande::find($id);
                            if ($commande&&$commande->etats==1) {
                                $user = Profil::find($commande->idUser);
                                if($user){
                                    $bool = true;
                                    if($type==2){
                                        if($commande->etat!=2)
                                            $bool = false;
                                    }
                                    if($bool){
                                        $pdo = App::getDb()->getPDO();
                                        try {
                                            $pdo->beginTransaction();
                                            $root = FileHelper::moveImage($_FILES['image']['tmp_name'], "bons", $extension_upload, "", true);
                                            FileHelper::deleteImage('Public/' . $commande->bonLivraison);
                                            if ($root) {
                                                $lignes = Ligne::searchType(null,null,$id);
                                                if($type==1){
                                                    Commande::setDatePaiement(DATE_COURANTE,$id);
                                                    $tabMarchand = $tabsMarchand = [];
                                                    $isForfait = $commande->forfait > 0;
                                                    $pointsCoupon = 0;
                                                    $boolAFRIKFID = false;
                                                    $idMarchandCoupon = 0;
                                                    if(!empty($commande->codeCoupon)){
                                                        $coupon = Coupon::byCode($commande->codeCoupon);
                                                        if($coupon->idMarchand==0){
                                                            $bool = $user->points>$coupon->points?true:false;
                                                            $boolAFRIKFID = $bool;
                                                            if($bool){
                                                                $pointsCoupon = $coupon->points;
                                                            }
                                                        }
                                                    }
                                                    $totalAmount = 0;
                                                    $leMarchand = null;
                                                    foreach ($lignes as $ligne) {
                                                        $article = Article::find($ligne->idArticle);
                                                        Article::setReserved($article->reserved-$ligne->nbre,$article->id);
                                                        $nbrePoint = $ligne->prixTotal/VALUE_OF_POINT;
                                                        if(array_key_exists($article->idMarchand,$tabsMarchand)){
                                                            $tabsMarchand [$article->idMarchand] += $nbrePoint;
                                                        }else{
                                                            $tabsMarchand [$article->idMarchand] = $nbrePoint;
                                                        }
                                                        if($isForfait){
                                                            if(array_key_exists($article->idMarchand,$tabMarchand)){
                                                                $tabMarchand[$article->idMarchand] += $nbrePoint;
                                                            }else{
                                                                $tabMarchand[$article->idMarchand] = $nbrePoint;
                                                            }
                                                        }
                                                        if(!empty($commande->codeCoupon)){
                                                            if($article->idMarchand==$coupon->idMarchand){
                                                                $leMarchand = Point_Marchand::gets($coupon->idMarchand,$user->id);
                                                                $totalAmount += $ligne->prixUnitaire;
                                                            }
                                                            if(!is_null($leMarchand)){
                                                                $bool = $leMarchand->points>$coupon->points?true:false;
                                                                if($bool){
                                                                    $pointsCoupon = $coupon->points;
                                                                    $idMarchandCoupon = $leMarchand->id;
                                                                }
                                                            }
                                                        }
                                                    }

                                                    $pointsTotal = 0;
                                                    if($isForfait){
                                                        foreach ($tabsMarchand as $k => $v) {
                                                            $pointMarchand = Point_Marchand::gets($k,$commande->idUser);
                                                            if($pointMarchand){
                                                                Point_Marchand::setPoints($pointMarchand->points+$v,$pointMarchand->id);
                                                                Historique_Point::save($pointMarchand->id,$commande->idUser,$k,$pointMarchand->points,$pointMarchand->points+$v,$v,1,"Approvisionnement par commande");
                                                            }else{
                                                                Point_Marchand::save($commande->idUser,$k,$v);
                                                                $idLast = Point_Marchand::lastId();
                                                                Historique_Point::save($idLast,$commande->idUser,$k,0,$v,$v,1,"Approvisionnement par commande");
                                                            }
                                                            $pointsTotal += $v;
                                                        }
                                                    }
                                                    if($boolAFRIKFID){
                                                        $pointsTotal -= $pointsCoupon;
                                                    }
                                                    if(!empty($idMarchandCoupon)){
                                                        $pointsTotal -= $pointsCoupon;
                                                        Historique_Point::save($idMarchandCoupon,$commande->idUser,$leMarchand->idMarchand,$leMarchand->points,$leMarchand->points+$pointsCoupon,$pointsCoupon,2,"Achat chez $leMarchand->nom");
                                                        Point_Marchand::setPoints($leMarchand->points-$pointsCoupon,$idMarchandCoupon);
                                                    }
                                                    if(!empty($pointsTotal)){
                                                        Profil::setPoints($user->points+$pointsTotal,$user->id);
                                                    }
                                                    $commision = 0;
                                                    $commisionCarte = $commande->comissionCarte;
                                                    $soldeAfrikFid = Marchand::find(0)->solde;
                                                    foreach ($tabsMarchand as $k=>$v) {
                                                        $marchand = Marchand::find($k);
                                                        $tranche = Tranche::get($v);
                                                        $amount = $v-$tranche->cout;
                                                        Historique_Compte::saveMarchand($marchand->id,$marchand->solde,$marchand->solde+$amount,$amount,1,"Recettes",0);
                                                        if($k!=0)
                                                            Marchand::setSolde($marchand->solde+$amount,$marchand->id);
                                                        $soldeAfrikFid = $k==0 ? $soldeAfrikFid + $amount : $soldeAfrikFid;
                                                        $commision += $tranche->cout;
                                                    }
                                                    if(!empty($commision)){
                                                        Commande::setComission($commision,$commande->id);
                                                        Historique_Compte::saveMarchand(0,$soldeAfrikFid,$soldeAfrikFid+$commision,$commision,1,"Commissions",0);
                                                    }
                                                    if(!empty($commisionCarte))
                                                        Historique_Compte::saveMarchand(0,$soldeAfrikFid+$commision,$soldeAfrikFid+$commision+$commisionCarte,$commisionCarte,1,"Commission Carte de fidélité",0);
                                                    Marchand::setSolde($soldeAfrikFid+$commision+$commisionCarte,0);
                                                    $message = "La commande a été payée et livrée avec succès";
                                                }else{
                                                    foreach ($lignes as $ligne) {
                                                        $article = Article::find($ligne->idArticle);
                                                        Article::setReserved($article->reserved-$ligne->nbre,$article->id);
                                                    }
                                                    $message = "La commande a été livrée avec succès";
                                                }
                                                if(!empty($user->email)){
                                                    $content = $this->buildCart($lignes);
                                                    $emailer1 = new EmailShipped($user->email,"Livraison de votre commande $commande->reference effectuée avec succès",
                                                        "$user->nom $user->prenom",$commande,$user,$content,"Afrikfid Account");
                                                    $emailer1->send();
                                                }
                                                Commande::setLivreur($this->user->id, $this->user->nom, $root, DATE_COURANTE, $id);
                                                $this->session->write('success', $message);
                                                $pdo->commit();
                                                $result = array("statuts" => 0, "mes" => $message);
                                            } else {
                                                $erreur = $this->error;
                                                $result = array("statuts" => 1, "mes" => $erreur);
                                            }
                                        } catch (Exception $e) {
                                            $pdo->rollBack();
                                            $erreur = $this->error;
                                            $result = array("statuts" => 1, "mes" => $erreur);
                                        }
                                    }else{
                                        $message = "Vous devez valider le paiement de la commande avant de la livrer";
                                        $result = array("statuts" => 1, "mes" => $message);
                                    }
                                }else{
                                    $message = $this->error;
                                    $result = array("statuts" => 1, "mes" => $message);
                                }
                            } else {
                                $erreur = 'Une erreur est survenue, recharger et réessayer';
                                $result = array("statuts" => 1, "mes" => $erreur);
                            }
                        } else {
                            $erreur = 'Le fichier doit avoir une taille inférieur à 500K';
                            $result = array("statuts" => 1, "mes" => $erreur);
                        }
                    } else {
                        $message = "Le fichier doit être une image ou un pdf";
                        $result = array("statuts" => 1, "mes" => $message);
                    }
                } else {
                    $message = $this->error;
                    $result = array("statuts" => 1, "mes" => $message);
                }
            } else {
                $message = $this->empty;
                $result = array("statuts" => 1, "mes" => $message);
            }
        } else {
            $message = $this->error;
            $result = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($result);
    }

    public function disponible() {
        header('content-type: application/json');
        if (isset($_POST['id'])&&!empty($_POST['id'])) {
            $id = $_POST['id'];
            $commande = Commande::find($id);
            if ($commande&&$commande->etats==1&&$commande->disponible==0) {
                $user = Profil::find($commande->idUser);
                if($user){
                    $pdo = App::getDb()->getPDO();
                    try {
                        $pdo->beginTransaction();
                        Commande::setDisponible(1,$id);
                        Sms::sendSms($user->codePays.$user->numero,"Les articles de votre commande $commande->reference sont disponible. Vous avez 3 jours pour les recupérer","Afrikfid");
                        $message = 'Le client est informé de la disponibilité de ses produits dans le point de livraison';
                        $this->session->write('success', $message);
                        $pdo->commit();
                        $result = array("statuts" => 0, "mes" => $message);
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        $erreur = $this->error;
                        $result = array("statuts" => 1, "mes" => $erreur);
                    }
                }else{
                    $message = $this->error;
                    $result = array("statuts" => 1, "mes" => $message);
                }
            } else {
                $result = array("statuts" => 1, "mes" => $this->error);
            }
        } else {
            $message = $this->empty;
            $result = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($result);
    }

    public function details(){
        Privilege::hasPrivilege(Privilege::$eshopValider,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $commande = Commande::find($id);
            if($commande){
                $contenu = '<table class="table table-striped table-hover"><thead>
                                <tr>
                                    <th class="text-center"><input type="checkbox" id="selectAll" class="selectAll"/></th>
                                    <th class="">Article</th>
                                    <th class="text-right">Prix unitaire <small>(XOF)</small></th>
                                    <th class="text-right">Quantité</th>
                                    <th class="text-right">Prix total <small>(XOF)</small></th>
                                </tr>
                            </thead><tbody>';
                $lignes = Ligne::searchType(null,null,$id);
                foreach ($lignes as $ligne) {
                    $article = Article::find($ligne->idArticle);
                    $contenu .= '
                            <tr>
                                <td class="text-center"><input type="checkbox" name="selected" class="selected" value="'.$ligne->id.'"/></td>
                                <td class="">'.$article->intitule.'</td>
                                <td class="text-right">'.thousand($ligne->prix).'</td>
                                <td class="text-right"><span class="label label-primary">'.thousand($ligne->nbre).'</span> <b><small>('.$article->stock.' en stock)</small></b></td>
                                <td class="text-right">'.thousand($ligne->prixTotal).'</td>
                            </tr>
                        ';
                }
                $contenu .= "</tbody><tfoot>
                                <tr><td colspan='5' class='text-right'>
                                <button data-id='".$id."' data-url='".App::url('commandes/lignes/valid')."' class='validBtn btn btn-success'>Executer la validation</button>
                                </td></tr></tfoot></table>";
                $return = array("statuts" => 0, "contenu" => $contenu);
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

    public function valid(){
        Privilege::hasPrivilege(Privilege::$eshopCommandValid,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])&&isset($_POST['datas'])){
            $id = $_POST['id'];
            $datas = explode(',',$_POST['datas']);
            $commande = Commande::find($id);
            if($commande&&$commande->etats==0){
                $lignes = Ligne::searchType(null,null,$id);
                $total = 0;
                foreach ($lignes as $ligne) {
                    if(in_array($ligne->id,$datas)){
                        $etat = 1;
                        $article = Article::find($ligne->idArticle);
                        Article::setStock($article->stock-$ligne->nbre,$article->id);
                        Article::setReserved($article->reserved+$ligne->nbre,$article->id);
                        $total += $ligne->prixTotal;
                    }else{
                        $etat = 2;
                    }
                    Ligne::setEtat($etat,$ligne->id);
                }
                Commande::setCoutReel($total,$id);
                $etats = empty($_POST['datas'])?2:1;
                Commande::setEtats($etats,$id);
                $return = array("statuts" => 0, "mes" => "La validation de la commande s'est bien déroulé et elle a été transmise au point de retrait");
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

    public function facture(){
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $commande = Commande::find($id);
            if($commande){
                $lignes = Ligne::searchType(null,null,$id);
                $pdf_c = '';
                $ib_w_font = 'dejavusanscondensed';
                try{
                    ini_set('memory_limit','256M');
                    $mpdf = new Mpdf(['mode' => 'utf-8','margin_left' => 20,'margin_right' => 20,'margin_top' => 10,'margin_bottom' => 30,'margin_header' => 5,'margin_footer' => 5]);
                    $mpdf->SetProtection(array('print'));
                    $titre = $commande->etat==1?'Proforma':'Facture';
                    $mpdf->SetTitle("$titre #$commande->reference");
                    $mpdf->SetAuthor("Ndjeunou Steve");
                    $mpdf->SetWatermarkText(StringHelper::$tabCommandeText[$commande->etat]);
                    $mpdf->showWatermarkText = true;
                    $mpdf->watermark_font = $ib_w_font;
                    $mpdf->watermarkTextAlpha = 0.1;
                    $mpdf->SetDisplayMode('fullpage');

                    $mpdf->useAdobeCJK = true;
                    $mpdf->autoScriptToLang = true;
                    $mpdf->autoLangToFont = true;
                    ob_start();
                    $transac = ['commande'=>$commande];
                    $ligns = ['lignes'=>$lignes];
                    $variables = array_merge($transac,$ligns);
                    extract($variables);
                    require 'Views/Prints/facture.php';
                    $html = ob_get_contents();

                    ob_end_clean();
                    $mpdf->WriteHTML($html);

                    $mpdf->Output($titre.'_'.$commande->reference.'_'.date('Y-m-d_H:i:s'). '.pdf', 'I'); # D
                }catch (MpdfException $e){}
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

    public function bon(){
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $commande = Commande::find($id);
            if($commande){
                $lignes = Ligne::searchType(null,null,$id);
                $pdf_c = '';
                $ib_w_font = 'dejavusanscondensed';
                try{
                    ini_set('memory_limit','256M');
                    $mpdf = new Mpdf(['mode' => 'utf-8','margin_left' => 20,'margin_right' => 20,'margin_top' => 10,'margin_bottom' => 30,'margin_header' => 5,'margin_footer' => 5]);
                    $mpdf->SetProtection(array('print'));
                    $mpdf->SetTitle('Bon de livraison #'.$commande->reference);
                    $mpdf->SetAuthor("Ndjeunou Steve");
                    $mpdf->SetWatermarkText(StringHelper::$tabCommandeText[$commande->etat]);
                    $mpdf->showWatermarkText = true;
                    $mpdf->watermark_font = $ib_w_font;
                    $mpdf->watermarkTextAlpha = 0.1;
                    $mpdf->SetDisplayMode('fullpage');

                    $mpdf->useAdobeCJK = true;
                    $mpdf->autoScriptToLang = true;
                    $mpdf->autoLangToFont = true;
                    ob_start();
                    $transac = ['commande'=>$commande];
                    $ligns = ['lignes'=>$lignes];
                    $variables = array_merge($transac,$ligns);
                    extract($variables);
                    require 'Views/Prints/bon.php';
                    $html = ob_get_contents();
                    ob_end_clean();
                    $mpdf->WriteHTML($html);

                    $mpdf->Output('Bon_'.$commande->reference.'_'.date('Y-m-d_H:i:s'). '.pdf', 'I'); # D
                }catch (MpdfException $e){}
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

    public function change(){
        Privilege::hasPrivilege(Privilege::$eshopCommandValid,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])&&isset($_POST['etat']) && in_array($_POST['etat'],[1,2,3])){
            $id = $_POST['id'];
            $etat= $_POST['etat'];
              if($etat==3)  {
                  $transit_status='Order is Delivered';
              } elseif ($etat==1) {
                  $transit_status='Order is in Production';
              } elseif ($etat==2){
                  $transit_status='Order in Delivery';
              }
            $order = orders::find($id);
            if($order){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    orders::setStatus($transit_status,$id);
                    if ($transit_status=='Order is Delivered'){
                        orders::setDeliveryDate(DATE_COURANTE ,$id);
                    }
                    $message = "L'opération s'est passée avec succès";
                    $this->session->write('success',$message);
                    $pdo->commit();
                    $return = array("statuts" => 0, "mes" => $message);
                }catch (Exception $e){
                    $pdo->rollBack();
                    $message = $e->getMessage();
                    $return = array("statuts" => 1, "mes" => $message);
                }
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

    public function dateDelivery(){
        Privilege::hasPrivilege(Privilege::$eshopConfigCouponAdd,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        $tab = ["edit"];
        if (isset($_POST['date_delivery']) && !empty($_POST['date_delivery']) && isset($_POST['action']) && !empty($_POST['action'])
            && isset($_POST['id']) && in_array($_POST["action"], $tab)) {
            $date_delivery = $_POST['date_delivery'];
            $action = $_POST['action'];
            $id = (int)$_POST['id'];
                    if($action == "edit") {
                        if (!empty($id)){
                            $order = orders::find($id);
                            if ($order) {
                                $pdo = App::getDb()->getPDO();
                                try{
                                    $pdo->beginTransaction();
                                    $date_delivery = new DateTime($date_delivery);
                                    orders:: setDateDelivery( $date_delivery->format(MYSQL_DATE_FORMAT),$id);
                                    $message = "La date de livraison a été mise à jour avec succès";
                                    $this->session->write('success',$message);
                                    $pdo->commit();
                                    $return = array("statuts" => 0, "mes" => $message);
                                }catch (Exception $e){
                                    $pdo->rollBack();
                                    $message = $this->error;
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
                    }
        } else {
            $message = "Veiullez renseigner tous les champs requis";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

}