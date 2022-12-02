<?php
/**
 * Created by IntelliJ IDEA.
 * User: Fabrice
 * Date: 05/06/2017
 * Time: 12:37
 */

namespace Projet\Controller\Admin;


use Exception;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Projet\Database\affiliate_portfolio_profile;
use Projet\Database\affiliate_user;
use Projet\Database\category;
use Projet\Database\checkout_orders;
use Projet\Database\orders;
use Projet\Database\products;
use Projet\Database\Profil;
use Projet\Database\Salle;
use Projet\Database\schedule_item;
use Projet\Database\subcategory;
use Projet\Database\users;
use Projet\Database\wallet;
use Projet\Database\withdraw_request;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

class StatsController extends AdminController {

  
    public function salles(){
        Privilege::hasPrivilege(Privilege::$eshopMeetingEtat,$this->user->privilege);
        $search = (isset($_GET['search'])&&!empty($_GET['search'])) ? $_GET['search'] : null;
        $items = Salle::searchType(null,null,$search);
        try{
            $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4-L','margin_left' => 5,'margin_right' => 5,'margin_top' => 15,'margin_bottom' => 20,'margin_header' => 15,'margin_footer' => 10]);
            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle('Liste des Salle');
            $mpdf->SetAuthor("Dikla lucien");
            $mpdf->SetWatermarkText('Salle | CLINIQUE');
            $mpdf->showWatermarkText = true;
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->useAdobeCJK = true;
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            ob_start();
            $transac = ['items '=>$items ];
            $header = '';

            if(!is_null($search)){
                $header .= '<tr><th style="border: 0;text-align: right">Nom/Prix:</th><td style="border: 0;" class="meta-head">'.$search.'</td></tr>';
            }
            
            $head = ['headerTab'=>$header];
            $variables = array_merge($transac,$head);
            extract($variables);
            require 'Views/Prints/salles.php';
            $html = ob_get_contents();
            ob_end_clean();
            $mpdf->WriteHTML($html);
            $mpdf->Output('Pdf_Liste_Des_Salles'.date('Y-m-d_i:s').'_'.time().'.pdf', 'I'); 
        }catch (MpdfException $e){}

    }

    public function sallesExcell(){
        Privilege::hasPrivilege(Privilege::$eshopMeetingEtat,$this->user->privilege);
        require 'Excel_XML.php';
        $search = (isset($_GET['search'])&&!empty($_GET['search'])) ? $_GET['search'] : null;
        $items = Salle::searchType(null,null,$search);
        $datas = [];
        $i = 0;
        try{
            $datas[0] = array('nom','prix','Créer le');
            foreach ($items as $item) {
                $datas[]=array($item->nom,$item->prix,$item->created_at);

            }
            $name = 'Excel_Liste_Des_Salles_'.date('Y-m-d_i:s').'_'.time();
            $xls = new \Excel_XML();
            $xls->addWorksheet('Salles ', $datas);
            $xls->sendWorkbook($name.'.xls');
        }catch (Exception $e){}
    }

    function collerleNom($nom){
        return str_replace(' ','_',$nom);
    }

}