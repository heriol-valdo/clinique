<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 18/11/2015
 * Time: 14:02
 */

namespace Projet\Model;


class Privilege {


    /**
     * PULMER PRIVILEGE
     */
    public static $eshopDemandeRetraitView = 'RETRAIT_VIEW';
    public static $eshopDemandeRetraitEtat = 'RETRAIT_ETAT';
    public static $eshopDemandeRetraitValid = 'RETRAIT_VALID';
    public static $eshopDemandeCancel= 'RETRAIT_CANCEL';

    public static $eshopMeetingView= 'MEETING_VIEW';
    public static $eshopMeetingEtat= 'MEETING_ETAT';

    public static $eshopCommandView= 'CMD_VIEW';
    public static $eshopCommandEtat= 'CMD_ETAT';
    public static $eshopCommandValid= 'CMD_VALID';

    public static $eshopProductView= 'PRODUCT_VIEW';
    public static $eshopProductEtat= 'PRODUCT_ETAT';
    public static $eshopProductEdit= 'PRODUCT_EDIT';
    public static $eshopProductActivation= 'PRODUCT_ACTIVE';
    public static $eshopProductDesactivation= 'PRODUCT_DESACTIVE';
    public static $eshopProductAdd= 'PRODUCT_ADD';
    public static $eshopProductAddToDeal= 'PRODUCT_DEAL';
    public static $eshopProductAddToStock= 'PRODUCT_STOCKADD';
    public static $eshopProductMoveToStock= 'PRODUCT_STOCKMOVE';
    public static $eshopProductChangeImg= 'PRODUCT_IMGCHANGE';
    public static $eshopProductAddImg= 'PRODUCT_IMGADD';
    public static $eshopProductDeleteImg= 'PRODUCT_IMGDELETE';
    public static $eshopProductNoteView= 'PRODUCT_NOTE';
    public static $eshopProductSaleView= 'PRODUCT_SALE';
    public static $eshopProductSaleEtat= 'PRODUCT_SALEETAT';

    public static $eshopProductDealView= 'PRODUCT_DEALVIEW';
    public static $eshopProductDealActivation= 'PRODUCT_DEALACTIVE';
    public static $eshopProductDealDesactivation= 'PRODUCT_DEALDESACTIVE';

    public static $eshopProductCatView= 'PRODUCT_CATVIEW';
    public static $eshopProductCatAdd= 'PRODUCT_CATADD';
    public static $eshopProductCatEdit= 'PRODUCT_CATEDIT';
    public static $eshopProductCatImg= 'PRODUCT_CATIMG';
    public static $eshopProductCatDelete= 'PRODUCT_CATDELETE';

    public static $eshopProductSubCatView= 'PRODUCT_SUBCATVIEW';
    public static $eshopProductSubCatAdd= 'PRODUCT_SUBCATADD';
    public static $eshopProductSubCatEdit= 'PRODUCT_SUBCATEDIT';
    public static $eshopProductSubCatImg= 'PRODUCT_SUBCATIMG';
    public static $eshopProductSubCatDelete= 'PRODUCT_SUBCATDELETE';


    public static $eshopProjectClientView= 'PROJECT_CLIENTVIEW';
    public static $eshopProjectAffileView= 'PROJECT_AFFILIEVIEW';

    public static $eshopUserClientView= 'USER_CLIENTVIEW';
    public static $eshopUserClientAdd= 'USER_CLIENTADD';
    public static $eshopUserClientReset= 'USER_CLIENTRESET';
    public static $eshopUserClientActive= 'USER_CLIENTACTIVE';
    public static $eshopUserClientDesactive= 'USER_CLIENTDESACTIVE';
    public static $eshopUserClientCmdView= 'USER_CLIENTCMDVIEW';
    public static $eshopUserClientProjectView= 'USER_CLIENTPROJECTVIEW';
    public static $eshopUserClientEtat= 'USER_CLIENTPROJECTETAT';


    public static $eshopUserAffilieView= 'USER_AFFILIEVIEW';
    public static $eshopUserAffilieAdd= 'USER_AFFILIEADD';
    public static $eshopUserAffilieReset= 'USER_AFFILIERESET';
    public static $eshopUserAffilieActive= 'USER_AFFILIEACTIVE';
    public static $eshopUserAffilieDesactive= 'USER_AFFILIEDESACTIVE';
    public static $eshopUserAffilieCmdView= 'USER_AFFILIECMDVIEW';
    public static $eshopUserAffilieProjectView= 'USER_AFFILIEPROJECTVIEW';
    public static $eshopUserAffilieDmdRetraitView= 'USER_AFFILIEDMDRETRAITVIEW';
    public static $eshopUserAffilieProfolioView= 'USER_AFFILIEPROFOLIOVIEW';
    public static $eshopUserAffiliePjrojecAns= 'USER_AFFILIEPROJECTANS';
    public static $eshopUserAffilieEtat= 'USER_AFFILIEPROJ0CTETAT';
    public static $eshopUserAffilieImg= 'USER_AFFILIEIMG';
    public static $eshopUserAffilieImgDel= 'USER_AFFILIEIMGDEL';

    public static $eshopConfigCouponView= 'CONFIG_COUPONVIEW';
    public static $eshopConfigCouponAdd= 'CONFIG_COUPONADD';
    public static $eshopConfigCouponEdit= 'CONFIG_COUPONEDIT';
    public static $eshopConfigCouponDelete= 'CONFIG_COUPONDELETE';

    public static $eshopConfigAppTextView= 'CONFIG_APPTEXTVIEW';
    public static $eshopConfigAppTextEdit= 'CONFIG_APPTEXTEDIT';

    public static $eshopConfigTaxeView= 'CONFIG_TAXEVIEW';
    public static $eshopConfigTaxeAdd= 'CONFIG_TAXEADD';
    public static $eshopConfigTaxeEdit= 'CONFIG_TAXEEDIT';
    public static $eshopConfigTaxeDelete= 'CONFIG_TAXEDELETE';

    public static $eshopCouncilView= 'COUNCILS_VIEW';
    public static $eshopCouncilCmdView= 'COUNCILS_CMDVIEW';
    public static $eshopCouncilActive= 'COUNCILS_ACTIVE';
    public static $eshopCouncilDesactive= 'COUNCILS_DESACTIVE';
    public static $eshopCouncilDelete= 'COUNCILS_DELETE';

    public static $eshopAdminView= 'ADMIN_VIEW';
    public static $eshopAdminAdds= 'ADMIN_ADD';
    public static $eshopAdminEdits= 'ADMIN_EDIT';
    public static $eshopAdminActive= 'ADMIN_ACTIVE';
    public static $eshopAdminDesactive= 'ADMIN_DESACTIVE';
    public static $eshopAdminEditImg= 'ADMIN_EDITIMG';
    public static $eshopAdminReset= 'ADMIN_RESET';

    public static $eshopGestionProfils= 'PROFIL_GESTION';

    public static $eshopOtherNewView= 'OTHER_NEWVIEW';
    public static $eshopOtherNewAdd= 'OTHER_NEWADD';
    public static $eshopOtherNewEdit= 'OTHER_NEWEDIT';
    public static $eshopOtherNewDelete= 'OTHER_NEWDELETE';
    public static $eshopOtherNewChangeImg= 'OTHER_NEWCHANGEIMG';

    public static $eshopOtherVisitView= 'OTHER_VISITVIEW';

    public static $eshopOtherSugestionView= 'OTHER_SUGESTIONVIEW';

    public static $eshopDashboardView= 'DASHBOARD_VIEW';
    public static $eshopDashboardAffaire= 'DASHBOARD_AFFAIRE';

    public static function getLesPrivileges(){
        $tab = [self::$eshopDashboardView,
        self::$eshopOtherVisitView, self::$eshopOtherSugestionView,
        self::$eshopOtherNewView,self::$eshopOtherNewAdd,self::$eshopOtherNewEdit,self::$eshopOtherNewDelete,
        self::$eshopAdminView,self::$eshopAdminAdds,self::$eshopAdminEdits,self::$eshopAdminActive,
        self::$eshopAdminDesactive,self::$eshopAdminEditImg,self::$eshopGestionProfils,
        self::$eshopCouncilView,self::$eshopCouncilCmdView,self::$eshopCouncilActive,self::$eshopCouncilDesactive,
        self::$eshopConfigCouponView,self::$eshopConfigCouponAdd,self::$eshopConfigCouponEdit,
        self::$eshopConfigCouponDelete,self::$eshopConfigAppTextView,self::$eshopConfigAppTextEdit,
        self::$eshopConfigTaxeView,self::$eshopConfigTaxeAdd,self::$eshopConfigTaxeEdit,self::$eshopConfigTaxeDelete,
        self::$eshopUserClientView,self::$eshopUserClientAdd,self::$eshopUserClientReset,self::$eshopUserClientActive,
        self::$eshopUserClientDesactive,self::$eshopUserClientCmdView,self::$eshopUserClientProjectView,
        self::$eshopUserAffilieView,self::$eshopUserAffilieAdd,self::$eshopUserAffilieReset,self::$eshopUserAffilieActive,
        self::$eshopUserAffilieDesactive,self::$eshopUserAffilieCmdView,self::$eshopUserAffilieProjectView,
        self::$eshopUserAffilieDmdRetraitView,self::$eshopUserAffilieProfolioView,
        self::$eshopProjectClientView,self::$eshopProjectAffileView,self::$eshopUserAffiliePjrojecAns,
        self::$eshopProductSubCatView,self::$eshopProductSubCatEdit,self::$eshopProductSubCatImg,self::$eshopProductSubCatDelete,
        self::$eshopProductCatView,self::$eshopProductCatEdit,self::$eshopProductCatImg,self::$eshopProductCatDelete,
        self::$eshopProductDealView,self::$eshopProductDealActivation,self::$eshopCouncilDelete,
        self::$eshopProductView,self::$eshopProductEtat,self::$eshopProductEdit,self::$eshopProductActivation,self::$eshopProductDesactivation,
        self::$eshopProductAdd,self::$eshopProductAddToDeal,self::$eshopProductAddToStock,self::$eshopProductMoveToStock,
        self::$eshopProductChangeImg,self::$eshopProductAddImg,self::$eshopProductNoteView,self::$eshopProductSaleView,
        self::$eshopCommandView,self::$eshopCommandEtat,self::$eshopCommandValid,
        self::$eshopDemandeRetraitView,self::$eshopDemandeRetraitEtat,self::$eshopDemandeRetraitValid,self::$eshopDemandeCancel,
        self::$eshopMeetingView,self::$eshopMeetingEtat,self::$eshopOtherNewChangeImg,
        self::$eshopProductDealDesactivation,self::$eshopAdminReset,self::$eshopProductDeleteImg,
        self::$eshopUserClientEtat, self::$eshopUserAffilieEtat,self::$eshopProductSaleEtat,self::$eshopProductSubCatAdd,
        self::$eshopProductCatAdd,self::$eshopUserAffilieImg,self::$eshopUserAffilieImgDel,self::$eshopDashboardAffaire];
        return $tab;
    }

    public static function getIndexTabOfPrivileges(){
        $tab = [


            self::$eshopDemandeRetraitView=>' Voir les demandes de retrait',
            self::$eshopDemandeRetraitEtat=>'Génerer les états de demande de retrait',
            self::$eshopDemandeRetraitValid=>'Valider une demande de retrait',
            self::$eshopDemandeCancel=>'Annuler une demande de retrait',

            self::$eshopMeetingView=>' Voir les rendez-vous',
            self::$eshopMeetingEtat=>' Génerer les états des rendez-vous',

            self::$eshopCommandView=>' Voir les commandes',
            self::$eshopCommandEtat=>' Génerer les états des commandes',
            self::$eshopCommandValid=>' Valider une commande',

            self::$eshopProductView =>'Voir les Produits',
            self::$eshopProductEtat =>'Génerer les états des Produits ',
            self::$eshopProductEdit =>'Modifier un Produit ',
            self::$eshopProductActivation =>'Activer un Produit',
            self::$eshopProductDesactivation=>'Désactiver un Produit',
            self::$eshopProductAdd =>'Ajouter un Produit',
            self::$eshopProductAddToDeal =>'Ajouter un Produit comme deal du jour',
            self::$eshopProductAddToStock =>'Agumenter le Stock ',
            self::$eshopProductMoveToStock =>'Diminuer le Stock',
            self::$eshopProductChangeImg =>'Changer l\'image principal',
            self::$eshopProductAddImg =>' Ajouter uneImages',
            self::$eshopProductDeleteImg =>'Supprimer une Images',
            self::$eshopProductNoteView =>'Voir les Notes',
            self::$eshopProductSaleView =>'Voir les Ventes',
            self::$eshopProductSaleEtat =>'G2nerer les etets des Ventes',

            self::$eshopProductDealView =>'Voir les Deal du jour',
            self::$eshopProductDealActivation =>'Activer les Deal du jour',
            self::$eshopProductDealDesactivation=> 'Désactiver les Deal du jour',

            self::$eshopProductCatView =>'Voir Les Catégories des produits',
            self::$eshopProductCatAdd =>'Ajouter Les Catégories des produits',
            self::$eshopProductCatEdit =>'Modifier Les Catégories',
            self::$eshopProductCatImg =>'Modifier les Images des Catégories',
            self::$eshopProductCatDelete =>'Supprimer les Catégories',

            self::$eshopProductSubCatView =>'Voir Les Sous Catégories des produits',
            self::$eshopProductSubCatAdd =>'Ajouter Les Sous Catégories des produits',
            self::$eshopProductSubCatEdit =>'Modifier  Les Sous Catégories des produits',
            self::$eshopProductSubCatImg =>'Modifier les Images des Sous Catégories des produits',
            self::$eshopProductSubCatDelete =>'Supprimer les Sous Catégories des produits',

            self::$eshopProjectClientView =>'Voir Les Projets des Clients',
            self::$eshopProjectAffileView =>'Voir Les Projets des Affiliés',

            self::$eshopUserClientView =>'Voir les Clients',
            self::$eshopUserClientAdd =>'Ajouter un Client',
            self::$eshopUserClientReset =>'Reinitialiser le mot de passe ',
            self::$eshopUserClientActive =>'Activer le Client',
            self::$eshopUserClientDesactive =>'Désactiver le Client',
            self::$eshopUserClientCmdView =>'Voir les Commandes du client',
            self::$eshopUserClientProjectView =>'Voir les Projets du client',
            self::$eshopUserClientEtat =>'Génerer les états des clients',

            self::$eshopUserAffilieView =>'Voir les Affiliés',
            self::$eshopUserAffilieAdd =>'Ajouter un Affilié',
            self::$eshopUserAffilieReset =>'Reinitialiser le mot de passe de l\'affilié',
            self::$eshopUserAffilieActive =>'Activer le affilié',
            self::$eshopUserAffilieDesactive =>'Désactiver l\'affilié',
            self::$eshopUserAffilieCmdView =>'Voir les Conseils de l\'affilié' ,
            self::$eshopUserAffilieProjectView =>'Voir les Projets de l\'affilié',
            self::$eshopUserAffilieDmdRetraitView =>'Voir les Demandes l\'affilié',
            self::$eshopUserAffilieProfolioView =>'Voir le Profolio de l\'affilié',
            self::$eshopUserAffiliePjrojecAns =>'Répondre ou projet',
            self::$eshopUserAffilieEtat =>'Génerer les états de l\'Affilié',
            self::$eshopUserAffilieImg =>'Ajouter l\'image de l\'Affilié',
            self::$eshopUserAffilieImgDel =>'Supprimer l\'image de l\'Affilié',


            self::$eshopConfigCouponView=>'Voir le Coupons Réduction',
            self::$eshopConfigCouponAdd=>'Ajouter un Coupon Réduction',
            self::$eshopConfigCouponEdit=>'Modifier un Coupon Réduction',
            self::$eshopConfigCouponDelete=>'Supprimer un Coupon Réduction',
            self::$eshopConfigAppTextView=>'Voir les Textes d\'Application',
            self::$eshopConfigAppTextEdit=>'Modifier les Textes d\'Application',
            self::$eshopConfigTaxeView=>'Voir les Taxes',
            self::$eshopConfigTaxeAdd=>'Ajouter une Taxe',
            self::$eshopConfigTaxeEdit=>'Modifier une Taxe',
            self::$eshopConfigTaxeDelete=>'Supprimer une Taxe',

            self::$eshopCouncilView=> 'Voir les Conseils',
            self::$eshopCouncilCmdView=> 'Voir les Commentaires du Conseil',
            self::$eshopCouncilActive=> 'Activer un Conseil',
            self::$eshopCouncilDesactive=> 'Désactiver un Conseil',
            self::$eshopCouncilDelete => 'Supprimer un Conseil',

            self::$eshopAdminView=>'Voir les Administrateurs',
            self::$eshopAdminAdds=>'Ajouter un Administrateur',
            self::$eshopAdminEdits=>'Modifier un Administrateur',
            self::$eshopAdminActive=>'Activer un Administrateur',
            self::$eshopAdminDesactive=>'Désactiver un Administrateur',
            self::$eshopAdminEditImg=>'Modifier l\'image d\'un Administrateur',
            self::$eshopAdminReset=>'Reinitialiser le mot de passe de Administrateur',

            self::$eshopGestionProfils=>'Gestion des profils',

            self::$eshopOtherNewView=> 'Voir les News',
            self::$eshopOtherNewAdd=> 'Ajouter une News',
            self::$eshopOtherNewEdit=> 'Modifier une News',
            self::$eshopOtherNewDelete=> 'Supprimer une News',
            self::$eshopOtherNewChangeImg=>'Modifier l\'image de la News ',

            self::$eshopOtherVisitView=> 'Voir les Visites ',
            self::$eshopOtherSugestionView=> 'Voir Les Suggestions',

            self::$eshopDashboardView=> 'Voir Le Tableau De Bord',
            self::$eshopDashboardAffaire=> 'Calculer Le Chiffre d\'Affaire',

            ];
        return $tab;
    }

    public static function getOptionsSelect(){
        $default = '<option value="">Ajouter un privilège</option>';

        $group8 = '
            <optgroup label="Tableau de bord">
                <option value="'.self::$eshopDashboardView.'">Voir Le Tableau De Bord</option>
                <option value="'.self::$eshopDashboardAffaire.'">Calculer Le Chiffre d\'Affaire</option>
            </optgroup>
        ';$group9 = '
            <optgroup label="Gestion des demandes de retrait">
                <option value="'.self::$eshopDemandeRetraitView.'">Voir les demandes de retrait</option>
                <option value="'.self::$eshopDemandeRetraitEtat.'">Génerer les états de demande de retrait</option>
                <option value="'.self::$eshopDemandeRetraitValid.'">Valider une demande de retrait</option>
                <option value="'.self::$eshopDemandeCancel.'">Annuler une demande de retrait</option>
            </optgroup>
        ';
        $group10 = '
            <optgroup label="Gestion des Rendez-vous">
                <option value="'.self::$eshopMeetingView.'">Voir les demandes de retrait</option>
                <option value="'.self::$eshopMeetingEtat.'">Génerer les états des rendez-vous</option>
            </optgroup>
        ';
        $group11 = '
            <optgroup label="Gestion des Commandes">
                <option value="'.self::$eshopCommandView.'">Voir les commandes</option>
                <option value="'.self::$eshopCommandEtat.'">Génerer les etat des commandes</option>
                <option value="'.self::$eshopCommandValid.'">Validerr une commande</option>
            </optgroup>
        ';
        $group12 = '
            <optgroup label="Gestion des Produits">
                <option value="'.self::$eshopProductView.'">Voir les Produits</option>
                <option value="'.self::$eshopProductEtat.'">Génerer les états des Produits</option>
                <option value="'.self::$eshopProductEdit.'">Modifier un Produit</option>
                <option value="'.self::$eshopProductActivation.'">Activer un Produit</option>
                <option value="'.self::$eshopProductDesactivation.'">Désactiver un Produit</option>
                <option value="'.self::$eshopProductAdd.'">Ajouter un Produit</option>
                <option value="'.self::$eshopProductAddToDeal.'">Ajouter un Produit comme deal du jour</option>  
                <option value="'.self::$eshopProductAddToStock.'">Agumenter le Stock</option>
                <option value="'.self::$eshopProductMoveToStock.'">Diminuer le Stock</option>
                <option value="'.self::$eshopProductChangeImg.'">Changer l\'image principal</option>
                <option value="'.self::$eshopProductAddImg.'">Ajouter des Images</option>
                <option value="'.self::$eshopProductDeleteImg.'">Supprimer une Images</option>
                <option value="'.self::$eshopProductNoteView.'">Ajouter des Images</option>
                <option value="'.self::$eshopProductSaleView.'">Voir les Ventes</option> 
                <option value="'.self::$eshopProductSaleEtat.'">Génerer les et des Ventes</option> 
                <option value="'.self::$eshopProductDealView.'">Voir les Deal du jour</option>
                <option value="'.self::$eshopProductDealActivation.'">Activer  les Deal du jour</option> 
                <option value="'.self::$eshopProductDealDesactivation.'">Désactiver les Deal du jour</option> 
                <option value="'.self::$eshopProductCatView.'">Voir Les Catégories des produits</option>
                <option value="'.self::$eshopProductCatAdd.'">Ajouter Les Catégories des produits</option>
                <option value="'.self::$eshopProductCatEdit.'">Modifier Les Catégories des produits</option> 
                <option value="'.self::$eshopProductCatImg.'">Modifier les Images des Catégories des produits</option> 
                <option value="'.self::$eshopProductCatDelete.'">Supprimer les Catégories des produits</option> 
                <option value="'.self::$eshopProductSubCatView.'">Voir Les Sous Catégories des produits</option>
                <option value="'.self::$eshopProductSubCatAdd.'">Ajouter Les Sous Catégories des produits</option>
                <option value="'.self::$eshopProductSubCatEdit.'">Modifier Les Sous Catégories des produits</option> 
                <option value="'.self::$eshopProductSubCatImg.'">Modifier les Sous Images des Catégories des produits</option> 
                <option value="'.self::$eshopProductSubCatDelete.'">Supprimer les Sous Catégories des produits</option> 
            </optgroup>
        ';
        $group13 = '
            <optgroup label="Gestion des Projets"> 
                <option value="'.self::$eshopProjectClientView.'">Voir Les Projets des Clients</option> 
                <option value="'.self::$eshopProjectAffileView.'">Voir Les Projets des Affiliés</option> 
            </optgroup>
        ';
        $group14 = '
            <optgroup label="Gestion des Utilisateurs"> 
                <option value="'.self::$eshopUserClientView.'">Voir les Clients</option> 
                <option value="'.self::$eshopUserClientAdd.'">Ajouter un Client</option> 
                <option value="'.self::$eshopUserClientReset.'">Reinitialiser le mot de passe</option> 
                <option value="'.self::$eshopUserClientActive.'">Activer le Client</option> 
                <option value="'.self::$eshopUserClientDesactive.'">Désactiver le Client</option> 
                <option value="'.self::$eshopUserClientCmdView.'">Voir les Commandes du client</option> 
                <option value="'.self::$eshopUserClientEtat.'">Génerer les états du client</option> 
                <option value="'.self::$eshopUserClientProjectView.'">Voir les Projets du client</option> 
                <option value="'.self::$eshopUserAffilieView.'">Voir les Affiliés</option> 
                <option value="'.self::$eshopUserAffilieAdd.'">Ajouter un Affilié</option> 
                <option value="'.self::$eshopUserAffilieReset.'">Reinitialiser le mot de passe de l\'affilié</option> 
                <option value="'.self::$eshopUserAffilieActive .'">Activer le affilié</option> 
                <option value="'.self::$eshopUserAffilieDesactive.'">Désactiver l\'affilié</option> 
                <option value="'.self::$eshopUserAffilieCmdView.'">Voir les Commandes de l\'affilié</option> 
                <option value="'.self::$eshopUserAffilieProjectView.'">Voir les Projets de l\'affilié</option> 
                <option value="'.self::$eshopUserAffilieDmdRetraitView .'">Voir les Demandes l\'affilié</option> 
                <option value="'.self::$eshopUserAffilieProfolioView.'">Voir le Profolio de l\'affilié</option> 
                <option value="'.self::$eshopUserAffiliePjrojecAns.'">Répondre ou projet</option> 
                <option value="'.self::$eshopUserAffilieEtat.'">Génerer les états de l\'Affilié</option> 
                <option value="'.self::$eshopUserAffilieImg.'">Ajouter l\'image de l\'Affilié</option> 
                <option value="'.self::$eshopUserAffilieImgDel.'">Supprimer l\'image de l\'Affilié</option> 
            </optgroup>
        ';
        $group15 = '
            <optgroup label="Configurations"> 
                <option value="'.self::$eshopConfigCouponView.'">Voir le Coupons Réduction</option> 
                <option value="'.self::$eshopConfigCouponAdd.'">Ajouter un Coupon Réduction</option> 
                <option value="'.self::$eshopConfigCouponEdit.'">Modifier un Coupon Réduction</option> 
                <option value="'.self::$eshopConfigCouponDelete.'">Supprimer un Coupon Réduction</option> 
                <option value="'.self::$eshopConfigAppTextView.'">Voir les Textes d\'Application\</option> 
                <option value="'.self::$eshopConfigAppTextEdit.'">\'Modifier les Textes d\'Application </option> 
                <option value="'.self::$eshopConfigTaxeView.'">Voir les Taxes</option> 
                <option value="'.self::$eshopConfigTaxeAdd.'">Ajouter une Taxe</option> 
                <option value="'.self::$eshopConfigTaxeEdit.'">Modifier une Taxe</option> 
                <option value="'.self::$eshopConfigTaxeDelete.'">Supprimer une Taxe</option> 
            </optgroup>
        ';
        $group16 = '
            <optgroup label="Gestion des Conseils"> 
                <option value="'.self::$eshopCouncilView.'">Voir les Conseils</option>  
                <option value="'.self::$eshopCouncilCmdView.'">Voir les Commentaires du Conseil</option>  
                <option value="'.self::$eshopCouncilActive.'">Activer un Conseil</option>  
                <option value="'.self::$eshopCouncilDesactive.'">Désactiver un Conseil</option>
                <option value="'.self::$eshopCouncilDelete.'">Supprimer un Conseil</option>  
            </optgroup>
        ';
        $group17 = '
            <optgroup label="Administration"> 
                <option value="'.self::$eshopAdminView.'">Voir les Administrateurs</option>  
                <option value="'.self::$eshopAdminAdds.'">Ajouter un Administrateur</option>  
                <option value="'.self::$eshopAdminEdits.'">Modifier un Administrateur</option>
                <option value="'.self::$eshopAdminReset.'">Reinitialiser le mot de passe de Administrateur</option>  
                <option value="'.self::$eshopAdminActive.'">Activer un Administrateur</option>  
                <option value="'.self::$eshopAdminDesactive.'">Désactiver un Administrateur</option>  
                <option value="'.self::$eshopAdminEditImg.'">Modifier l\'image d\'un Administrateur</option>  
                <option value="'.self::$eshopGestionProfils.'">Gestion des profils</option>  
            </optgroup>
            
        ';
        $group18 = '
            <optgroup label="Autres"> 
                <option value="'.self::$eshopOtherNewView.'">Voir les News</option>  
                <option value="'.self::$eshopOtherNewAdd.'">Ajouter une News</option>  
                <option value="'.self::$eshopOtherNewEdit.'">Modifier une News</option>  
                <option value="'.self::$eshopOtherNewDelete.'">Supprimer une News</option>
                <option value="'.self::$eshopOtherNewChangeImg.'">Modifier l\'image de la News </option>
                <option value="'.self::$eshopOtherVisitView.'">Voir les Visites</option>  
                <option value="'.self::$eshopOtherSugestionView.'">Voir Les Suggestions</option>  
            </optgroup>
        ';

        return $default.$group8.$group9.$group10.$group11.$group12.$group13.$group14.$group15.$group16.$group17.$group18;
    }

    public static function hasPrivilege($privilege,$myPrivileges){
        $answer = in_array($privilege,explode(',',$myPrivileges));
        if(!$answer){
            if(is_ajax()){
                header('content-type: application/json');
                $return['statuts']=1;
                $return['mes']="Vous n'avez pas les permissions d'acceder à cette ressource";
                echo json_encode($return);
                exit();
            }else{
                App::unauthorize();
            }
        }
    }

    public static function canView($privilege,$myPrivileges){
        return in_array($privilege,explode(',',$myPrivileges));
    }

    public static function getPrivilege($privilege,$myPrivileges){
        return in_array($privilege,explode(',',$myPrivileges));
    }

    public static function isPrivilege($privilege){
        return in_array($privilege,self::getLesPrivileges());
    }

    public static function showPrivilege($myPrivileges){
        $tab = self::getIndexTabOfPrivileges();
        $explodes = explode(',',$myPrivileges);
        $tags = "<p>";
        $i=0;
        foreach ($explodes as $explode) {
            $tags .= $i==0?$tab[$explode]:", $tab[$explode]";
            $i++;
        }
        return $tags.'</p>';
    }

}