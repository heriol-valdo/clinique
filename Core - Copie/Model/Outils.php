<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 14/10/2015
 * Time: 16:29
 */

namespace Projet\Model;


use DateInterval;
use DateTime;

class Outils {

    public static function calculImc($poids,$taille){
        $result = 10000*$poids/($taille*$taille);
        return round($result,2);
    }

    public static function calculPI($sexe,$taille){
        if($sexe == 1){
            $result = ($taille - 100 -(($taille - 150)/2.5));
        }else{
            $result = ($taille - 100 -(($taille - 150)/4));
        }
        return round($result,2).' Kg';
    }
    public static function calculImg($sexe,$taille,$age,$poids){
        $result=(1.20 * self::calculImc($poids,$taille) )+(0.23 * $age) - (10.8 * $sexe) - 5.4;
        return round($result,2);
    }

    public static function calculFeconde($dateDebut,$nbreJrs){
        $formatDate = date(MYSQL_DATE_FORMAT,strtotime($dateDebut));
        $formatDate1 = new DateTime($formatDate);
        $dateOvulation = $formatDate1->add(new DateInterval('P14D'))->format(MYSQL_DATE_FORMAT);
        $dateProchain = new DateTime($formatDate);
        $dateProchain->add(new DateInterval('P'.$nbreJrs.'D'));

        return array($dateOvulation, $dateProchain);

    }
    
    public static function getImg($img,$sexe){
        $result="";
        if($sexe == 0){
            if($img <30){
                $result = "<span class='label label-success'> Normal</span>";
                 if($img <25){
                    $result = "<span class='label label-danger'>Trop petit </span>";
                 }
            }else {
                $result = "<span class='label label-danger'>Trop élevé</span>";
            }
        }else{
            if($img <20){
                $result = "<span class='label label-success'> Normale</span>";
                if($img <15) {
                     $result = "<span class='label label-danger'>Trop petit </span>";
                }
            }else {
                $result = "<span class='label label-danger'>Trop élevé</span>";
            }
        }
        return $result;
    }

    public static function getCorpulence($imc){
        if($imc < 16.5){
            $result = "<span class='label label-danger'>Anorexie ou denutrition</span>";
        }elseif($imc < 18.5 && $imc >= 16.5){
            $result = "<span class='label label-warning'>Maigreur</span>";
        }elseif($imc < 25 &&$imc >= 18.5){
            $result = "<span class='label label-success'>Corpulence normale</span>";
        }elseif($imc < 30 &&$imc >= 25){
            $result = "<span class='label label-warning'>Surpoids</span>";
        }elseif($imc < 35 &&$imc >= 35){
            $result = "<span class='label label-warning'>Obésité modérée</span>";
        }elseif($imc < 40 &&$imc >= 35){
            $result = "<span class='label label-danger'>Obésité sévère</span>";
        }else{
            $result = "<span class='label label-danger'>Obésité morbide ou massive</span>";
        }
        return $result;
    }

    public static function getMonthName($numMonth){
        $return = '';
        switch($numMonth){
            case 1:
                $return="Janvier";
                break;
            case 2:
                $return="Fevrier";
                break;
            case 3:
                $return="Mars";
                break;
            case 4:
                $return="Avril";
                break;
            case 5:
                $return="Mai";
                break;
            case 6:
                $return="Juin";
                break;
            case 7:
                $return="Juillet";
                break;
            case 8:
                $return="Août";
                break;
            case 9:
                $return="Septembre";
                break;
            case 10:
                $return="0ctobre";
                break;
            case 11:
                $return="Novembre";
                break;
            case 12:
                $return="Decembre";
                break;
        }
        return $return;
    }

    public static function getShortMonthName($numMonth){
        $return = '';
        switch($numMonth){
            case 1:
                $return="Jan";
                break;
            case 2:
                $return="Fev";
                break;
            case 3:
                $return="Mar";
                break;
            case 4:
                $return="Avr";
                break;
            case 5:
                $return="Mai";
                break;
            case 6:
                $return="Juin";
                break;
            case 7:
                $return="Juil";
                break;
            case 8:
                $return="Août";
                break;
            case 9:
                $return="Sept";
                break;
            case 10:
                $return="0ct";
                break;
            case 11:
                $return="Nov";
                break;
            case 12:
                $return="Dec";
                break;
        }
        return $return;
    }

    public static function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        $theta = floatval($lon1) - floatval($lon2);
        $dist = sin(deg2rad(floatval($lat1))) * sin(deg2rad(floatval($lat2))) +  cos(deg2rad(floatval($lat1))) * cos(deg2rad(floatval($lat2))) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

}