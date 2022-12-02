<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Printer;


use Projet\Database\Absent;
use Projet\Database\Classe;
use Projet\Database\Classe_Eleve;
use Projet\Database\Profil;
use Projet\Database\Note;
use Projet\Model\App;
use Projet\Model\Encrypt;

class CarnetController extends PrintController {

    public function index(){
        $this->render('printer.carnet.index');
    }

    public function sequence(){
        if(isset($_GET['id'])&&!empty($_GET['id'])&&isset($_GET['sequence'])&&!empty($_GET['sequence'])
           &&isset($_GET['classe'])&&!empty($_GET['classe'])&&isset($_GET['conduite'])){
            $id = Encrypt::decrypter($_GET['id']);
            $sequence = Encrypt::decrypter($_GET['sequence']);
            $conduite = $_GET['conduite'];
            $idClasse = Encrypt::decrypter($_GET['classe']);
            $classe = Classe::find($idClasse);
            $eleve = Profil::find($id);
            if($eleve && $classe && in_array($sequence,[1,2,3,4,5,6])){
                $classe_eleve = Classe_Eleve::exist($idClasse,$id);
                if($classe_eleve){
                    $moyennes = Note::lesMoyennes($classe->id,$sequence);
                    $rang = 0;
                    $max = Note::variation($classe->id,$sequence,'DESC');
                    $min = Note::variation($classe->id,$sequence,'ASC');
                    $moy = 0;
                    $j = 0;
                    foreach ($moyennes as $key => $value) {
                        $j++;
                        $moy += $value->moy;
                        if($value->idEleve==$eleve->id){
                            $rang = $key+1;
                            $col = $value;
                        }
                    }
                    $moy = $moy/$j;
                    $absJ = Absent::getAbsences($classe->idAnnee,$eleve->id,$sequence,1);
                    $absNJ = Absent::getAbsences($classe->idAnnee,$eleve->id,$sequence,0);
                    if($absJ->Total>0&&$absNJ->Total>0){
                        $abs = $this->justifie($absJ->Total)." et <b>$absNJ->Total non</b>";
                    }elseif ($absJ->Total>0){
                        $abs = $this->justifie($absJ->Total);
                    }elseif ($absNJ->Total>0){
                        $abs = $this->justifie($absNJ->Total,true);
                    }else{
                        $abs = "aucune";
                    }
                    $notes = Note::searchType(null,null,null,$id,$idClasse);
                    $this->render('printer.carnet.sequence',compact('abs','conduite','moy','col','rang','max','min','eleve','user','classe','notes','sequence','classe_eleve'));
                }else{
                    App::error();
                }
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

    public function trimestre(){
        $tab = [1=>11,2=>12,3=>13];
        if(isset($_GET['id'])&&!empty($_GET['id'])&&isset($_GET['trimestre'])&&!empty($_GET['trimestre'])
            &&isset($_GET['classe'])&&!empty($_GET['classe'])&&isset($_GET['conduite'])){
            $id = Encrypt::decrypter($_GET['id']);
            $conduite = $_GET['conduite'];
            $trimestre = Encrypt::decrypter($_GET['trimestre']);
            $idClasse = Encrypt::decrypter($_GET['classe']);
            $classe = Classe::find($idClasse);
            $eleve = Profil::find($id);
            if($eleve && $classe && in_array($trimestre,[1,2,3])){
                $classe_eleve = Classe_Eleve::exist($idClasse,$id);
                if($classe_eleve){
                    $moyennes = Note::lesMoyennes($classe->id,$tab[$trimestre]);
                    $rang = 0;
                    $max = Note::variation($classe->id,$tab[$trimestre],'DESC');
                    $min = Note::variation($classe->id,$tab[$trimestre],'ASC');
                    $moy = 0;
                    $j = 0;
                    foreach ($moyennes as $key => $value) {
                        $j++;
                        $moy += $value->moy;
                        if($value->idEleve==$eleve->id){
                            $rang = $key+1;
                            $col = $value;
                        }
                    }
                    $moy = $moy/$j;
                    $notes = Note::searchType(null,null,null,$id,$idClasse);
                    if($trimestre==1){
                        $i = 1;
                        $j = 2;
                    }elseif ($trimestre==2){
                        $i = 3;
                        $j = 4;
                    }else{
                        $i = 5;
                        $j = 6;
                    }
                    $absJ1 = Absent::getAbsences($classe->idAnnee,$eleve->id,$i,1);
                    $absJ2 = Absent::getAbsences($classe->idAnnee,$eleve->id,$j,1);
                    $absNJ1 = Absent::getAbsences($classe->idAnnee,$eleve->id,$i,0);
                    $absNJ2 = Absent::getAbsences($classe->idAnnee,$eleve->id,$j,0);
                    $absJ = $absJ1->Total+$absJ2->Total;
                    $absNJ = $absNJ1->Total+$absNJ2->Total;
                    if($absJ>0&&$absNJ>0){
                        $abs = $this->justifie($absJ)." et <b>$absNJ non</b>";
                    }elseif ($absJ>0){
                        $abs = $this->justifie($absJ);
                    }elseif ($absNJ>0){
                        $abs = $this->justifie($absNJ,true);
                    }else{
                        $abs = "aucune";
                    }
                    $this->render('printer.carnet.trimestre',compact('abs','conduite','moy','col','rang','max','min','eleve','user','classe','notes','trimestre','classe_eleve'));
                }else{
                    App::error();
                }
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

    function justifie($nbre, $is=false){
        $i = $is?' non':'';
        return $nbre>1?"<b>$nbre</b>$i justifiées":"<b>$nbre</b> justifiée";
    }

}