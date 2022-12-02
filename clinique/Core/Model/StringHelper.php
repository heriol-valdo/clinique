<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 18/11/2015
 * Time: 14:02
 */

namespace Projet\Model;


class StringHelper {

    public static $tabs = [
        1 => '<span class="label label-success">OUI</span>',
        2 => '<span class="label label-danger">NON</span>'
    ];

    public static $tabState = [
        1 => '<span class="label label-success">Activé</span>',
        0 => '<span class="label label-warning">Désactivé</span>',
        2 => '<span class="label label-danger">Supprimé</span>'
    ];

    public static $tabStates = [
        1 => 'Activé',
        0 => 'Désactivé',
        2 => 'Supprimé'
    ];

    public static $tabSexe = [
        'Masculin' => '<span class="badge badge-roundless badge-info">H</span>',
        'Feminin' => '<span class="badge badge-roundless badge-primary">F</span>'
    ];

    public static function getCivilite($sexe){
        return $sexe=='Feminin' ? 'Mme' : 'Mr';
    }

    public static $tabStatut = [
        1 => '<span class="label label-danger">Indisponible</span>',
        0 => '<span class="label label-success">Disponible</span>'
    ];

    public static function getIdLastTransaction($val){
        return $val?$val->id+1:1;
    }

    public static function getAmountTransaction($transaction){
        $forfait = empty($transaction->forfait)?'':'<i class="uk-icon-arrow-down uk-text-primary"></i>'.number_format($transaction->forfait);
        $forfaitCoupon = empty($transaction->forfaitCoupon)?'':'<i class="uk-icon-arrow-circle-down uk-text-primary"></i>'.number_format($transaction->forfaitCoupon);
        $amount = number_format($transaction->montant-$transaction->forfait-$transaction->forfaitCoupon-$transaction->commission);
        return "<b>$amount</b> <small>$forfait $forfaitCoupon</small>";
    }

    public static $tabEtat = [
        1 => '<span class="label label-success">Effectif</span>',
        0 => '<span class="label label-info">En cours</span>',
        2 => '<span class="label label-danger">Non effectif</span>'
    ];

    public static $tabCommande = [
        1 => '<span class="label label-primary">Commandé</span>',
        2 => '<span class="label label-info">Payé</span>',
        3 => '<span class="label label-success">Livré</span>'
    ];

    public static $tabCommandeText = [
        1 => 'Non Payé',
        2 => 'Payé',
        3 => 'Payé et Livré'
    ];

    public static $tabCommand = [
        0 => '<span class="label label-warning">En cours</span>',
        2 => '<span class="label label-danger">Annulé</span>',
        1 => '<span class="label label-success">Validé</span>'
    ];

    public static $tabCommandRemboursement = [
        0 => '<span class="label label-info">Aucun</span>',
        2 => '<span class="label label-warning">En attente</span>',
        1 => '<span class="label label-primary">Effectué</span>'
    ];

    public static $tabCommandReceive = [
        0 => '<span class="label label-info">En attente</span>',
        1 => '<span class="label label-success">Réçu</span>'
    ];

    public static $tabCommandeLivraison = [
        0 => '<span class="label label-danger">Non Livré</span>',
        1 => '<span class="label label-warning">En magasin</span>',
        2 => '<span class="label label-info">Sorti</span>',
        3 => '<span class="label label-success">Livré</span>'
    ];

    public static $tabEtatPrimes = [
        0 => '<span class="label label-warning">En cours</span>',
        1 => '<span class="label label-success">Réalisé</span>'
    ];

    public static $tabEtatWithdraw = [
        0 => '<span class="label label-warning">En cours</span>',
        1 => '<span class="label label-success">Validé</span>',
        2 => '<span class="label label-danger">Annulé</span>'
    ];

    public static $tabCommandeState = [
        'succeeded' => '<span class="label label-success">Réussi</span>',
        'Pending' => '<span class="label label-primary">En cours</span>'
    ];

    public static $tabEtatPrime = [
        'Approved' => '<span class="label label-success">Approuvé</span>',
        'Rejected' => '<span class="label label-danger">Rejeté</span>',
        'Pending' => '<span class="label label-primary">En cours</span>'
    ];

    public static $tabRdv = [
        'Chat' => '<span class="badge badge-info">Chat</span>',
        'Audio' => '<span class="badge badge-success">Audio</span>',
        'Video' => '<span class="badge badge-primary">Video</span>'
    ];

    public static $tabCommandesLivraison = [
        0 => 'Non Livré',
        1 => 'En magasin',
        2 => 'Sorti',
        3 => 'Livré'
    ];

    public static $tabAnnonce = [
        1 => '<span class="label label-success">Valide</span>',
        2 => '<span class="label label-danger">Non Valide</span>'
    ];

    public static $tabArticleEtat = [
        1 => '<span class="label label-success">En Stock</span>',
        2 => '<span class="label label-danger">Stock épuisé</span>'
    ];

    public static $tabArticleRec = [
        1 => '<span class="label label-success">Recommandé</span>',
        0 => '<span class="label label-danger">Non Recommandé</span>'
    ];

    public static $tabArticleState = [
        1 => '<span class="label label-success">Activé</span>',
        0 => '<span class="label label-danger">Désactivé</span>'
    ];

    public static $tabUserState = [
        'Customer' => '<span class="label label-success">Client</span>',
        'Affiliate' => '<span class="label label-danger">Affilié</span>'
    ];

    public static $tabDealState = [
        0 => '<span class="label label-danger">Désactivé</span>',
        1 => '<span class="label label-success">Activé</span>',
        2 => '<span class="label label-primary">Expiré</span>'
    ];

    public static $tabEtats = [
        0 => '<span class="label label-primary">En cours</span>',
        1 => '<span class="label label-success">Validé</span>',
        2 => '<span class="label label-danger">Annulé</span>'
    ];

    public static $tabArticleVente = [
        1 => '<span class="label label-success">Meilleur Vente</span>',
        0 => '<span class="label label-danger">Pas meilleur vente</span>'
    ];

    public static $tabArticleType = [
        2 => '<span class="label label-primary">Service</span>',
        1 => '<span class="label label-info">Marchandise</span>'
    ];

    public static $tabArticleSolde = [
        1 => '<span class="label label-info">En Solde</span>',
        2 => '<span class="label label-warning">Pas En Solde</span>'
    ];

    public static $tabArticleDeal = [
        1 => '<span class="badge badge-success">OUI</span>',
        2 => '<span class="badge badge-danger">NON</span>'
    ];

    public static $tab = [
        1 => '<span class="badge badge-success">OUI</span>',
        0 => '<span class="badge badge-danger">NON</span>'
    ];

    public static $tabType = [
        1 => '<span class="label label-success text-uppercase">Entrée</span>',
        2 => '<span class="label label-danger text-uppercase">Sortie</span>'
    ];

    public static function isEmpty($string,$isEmail=null){
        if(!empty($string)){
            return $isEmail?$string:ucfirst($string);
        }
        return '<span class="text-danger">Pas renseigné</span>';
    }

    public static function getShortName($nom,$prenom){
        $expF = explode(' ',$nom);
        $expS = explode(' ',$prenom);
        return $expF[0].' '.$expS[0];
    }

    public static $tabCompteMoyens = [
        0 => 'Système',
        1 => 'Orange Money',
        2 => 'Airtel Money',
        3 => 'Espèces',
        4 => 'Autres moyens',
        5 => 'Dépôt bancaire',
    ];

    public static function showNote($note,$isdec=true){
        $val = '';
        if(is_null($note)){
            $val = '<span class="label label-primary text-uppercase">pas noté</span>';
        }elseif ($note == 0){
            $val = '<span class="text-danger"><b>0</b></span>';
        }elseif ($note >= 2.5){
            $num = $isdec?number_format($note,2):$note;
            $val = '<span class="text-success"><b>'.$num.'</b></span>';
        }else{
            $num = $isdec?number_format($note,2):$note;
            $val = '<span class="text-danger"><b>'.$num.'</b></span>';
        }
        return $val;
    }

    public static function str_without_accents($str, $charset='utf-8'){
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        $str = preg_replace('#&[^;]+;#', '', $str);
        return strtolower($str);
    }

    public static function cutString($string, $start, $length, $endStr = ' [...]'){
        if( strlen( $string ) <= $length ) return $string;
        $str = substr( $string, $start, $length - strlen( $endStr ) + 1);
        return substr( $str, 0, strrpos( $str,' ') ).$endStr;
    }

    public static function getPhone($number){
        if(!empty($number)){
            if(is_numeric($number)){
                $first = substr($number,0,1);
                $code = substr($number,0,3);
                $code1 = substr($number,1,3);
                $code2 = substr($number,2,3);
                $plus = substr($number,0,2);
                $result = "";
                if($first == "6" && strlen($number) == 9){
                    $result = "237".$number;
                }elseif ($first == "+" && $code1 == "237"){
                    $result = substr($number,1);
                }elseif($plus == "00" && $code2 == "237"){
                    $result = substr($number,2);
                }elseif($first == "+"){
                    $result = substr($number,1);
                }else{
                    $result = $number;
                }
                return $result;
            }else{
                return $number;
            }
        }else{
            return '';
        }
    }

    public static function abbreviate($text,$max) {
        if (strlen($text)<=$max)
            return $text;
        return substr($text, 0, $max-3).'...';
    }

    public static function detailArticle($article) {
        $taille = !empty($article->taille)?'<span style="margin: 0">'.$article->taille.'</span><br>':'';
        $couleur = !empty($article->couleur)?'<span style="margin: 0">'.$article->couleur.'</span><br>':'';
        return $taille.$couleur;
    }

    public static function buildSlug($string){
        $val = self::str_without_accents(trim($string));
        $val = str_replace('?','_',str_replace('&','_',str_replace(' ','_',$val)));
        $val = str_replace(',','_',str_replace(')','',str_replace('(','',$val)));
        $val = str_replace('\\','_',str_replace('/','_',str_replace('.','_',$val)));
        $val = str_replace('*','_',str_replace('%','_',str_replace(':','_',$val)));
        $val = str_replace('\'','_',str_replace('--','_',str_replace('---','_',$val)));
        $val = str_replace('"','_',str_replace('  ','_',str_replace('""','_',$val)));
        return $val;
    }

    public static function getPhones($number){
        $code = substr($number,0,3);
        if($code=='227'){
            $result = substr($number,3);
        }else{
            $result = $number;
        }
        return $result;
    }

    public static $tabLesPays = [
        "Afghanistan",
        "Afrique Centrale",
        "Afrique du sud",
        "Albanie",
        "Algerie",
        "Allemagne",
        "Andorre",
        "Angola",
        "Anguilla",
        "Arabie Saoudite",
        "Argentine",
        "Armenie",
        "Australie",
        "Autriche",
        "Azerbaidjan",

        "Bahamas",
        "Bangladesh",
        "Barbade",
        "Bahrein",
        "Belgique",
        "Belize",
        "Benin",
        "Bermudes",
        "Bielorussie",
        "Bolivie",
        "Botswana",
        "Bhoutan",
        "Boznie Herzegovine",
        "Bresil",
        "Brunei",
        "Bulgarie",
        "Burkina Faso",
        "Burundi",

        "Caiman",
        "Cambodge",
        "Cameroun",
        "Canada",
        "Canaries",
        "Cap vert",
        "Chili",
        "Chine",
        "Chypre",
        "Colombie",
        "Comores",
        "Congo",
        "Congo democratique",
        "Cook",
        "Coree du Nord",
        "Coree du Sud",
        "Costa Rica",
        "Cote d'Ivoire",
        "Croatie",
        "Cuba",

        "Danemark",
        "Djibouti",
        "Dominique",

        "Egypte",
        "Emirats Arabes Unis",
        "Equateur",
        "Erythree",
        "Espagne",
        "Estonie",
        "Etats Unis",
        "Ethiopie",

        "Falkland",
        "Feroe",
        "Fidji",
        "Finlande",
        "France",

        "Gabon",
        "Gambie",
        "Georgie",
        "Ghana",
        "Gibraltar",
        "Grece",
        "Grenade",
        "Groenland",
        "Guadeloupe",
        "Guam",
        "Guatemala",
        "Guernesey",
        "Guinee",
        "Guinee Bissau",
        "Guinee equatoriale",
        "Guyana",
        "Guyane Francaise ",

        "Haiti",
        "Hawaii",
        "Honduras",
        "Hong Kong",
        "Hongrie",

        "Inde",
        "Indonesie",
        "Iran",
        "Iraq",
        "Irlande",
        "Islande",
        "Israel",
        "Italie",

        "Jamaique",
        "Jan Mayen",
        "Japon",
        "Jersey",
        "Jordanie",

        "Kazakhstan",
        "Kenya",
        "Kirghizstan",
        "Kiribati",
        "Koweit",

        "Laos",
        "Lesotho",
        "Lettonie",
        "Liban",
        "Liberia",
        "Liechtenstein",
        "Lituanie",
        "Luxembourg",
        "Lybie",

        "Maroc",
        "Macedoine",
        "Madagascar",
        "Madère",
        "Malaisie",
        "Malawi",
        "Maldives",
        "Mali",
        "Malte",
        "Man",
        "Mariannes du Nord",
        "Maroc",
        "Marshall",
        "Martinique",
        "Maurice",
        "Mauritanie",
        "Mayotte",
        "Mexique",
        "Micronesie",
        "Midway",
        "Moldavie",
        "Monaco",
        "Mongolie",
        "Montserrat",
        "Mozambique",

        "Namibie",
        "Nauru",
        "Nepal",
        "Nicaragua",
        "Niger",
        "Nigeria",
        "Niue",
        "Norfolk",
        "Norvege",
        "Nouvelle Caledonie",
        "Nouvelle Zelande",

        "Oman",
        "Ouganda",
        "Ouzbekistan","Pakistan",
        "Palau",
        "Palestine",
        "Panama",
        "Papouasie Nouvelle Guinee",
        "Paraguay",
        "Pays Bas",
        "Perou",
        "Philippines",
        "Pologne",
        "Polynesie",
        "Porto Rico",
        "Portugal",

        "Qatar",

        "Republique Dominicaine",
        "Republique Tcheque",
        "Reunion",
        "Roumanie",
        "Royaume Uni",
        "Russie",
        "Rwanda",

        "Sahara Occidental",
        "Sainte Lucie",
        "Saint Marin",
        "Salomon",
        "Salvador",
        "Samoa Occidentales",
        "Samoa Americaine",
        "Sao Tome et Principe",
        "Senegal",
        "Seychelles",
        "Sierra Leone",
        "Singapour",
        "Slovaquie",
        "Slovenie",
        "Somalie",
        "Soudan",
        "Sri Lanka",
        "Suede",
        "Suisse",
        "Surinam",
        "Swaziland",
        "Syrie",

        "Tadjikistan",
        "Taiwan",
        "Tonga",
        "Tanzanie",
        "Tchad",
        "Thailande",
        "Tibet",
        "Timor Oriental",
        "Togo",
        "Trinite et Tobago",
        "Tristan da cunha",
        "Tunisie",
        "Turkmenistan",
        "Turquie",

        "Ukraine",
        "Uruguay",

        "Vanuatu",
        "Vatican",
        "Venezuela",
        "Vierges Americaines",
        "Vierges Britanniques",
        "Vietnam",

        "Wake",
        "Wallis et Futuma",

        "Yemen",
        "Yougoslavie",

        "Zambie",
        "Zimbabwe"
    ];

}