<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 24/10/2015
 * Time: 14:08
 */

namespace Projet\Model;


use DateTime;

class DateParser
{

    public static $lang = ['fr' => [
        'since' => "Il y'a ",
        'environ' => "dans environ",
        'instant' => "A l'instant",
        'mois' => "mois",
        'demi' => " et demi",
        'an' => "an",
        'jr' => "jr",
        'jrs' => "jour",
        'hrs' => "heure",
        'hr' => "hr",
        'min' => "min",
        'mins' => "minute",
        'sec' => "seconde",
        'secs' => "quelques secondes",
        'dans' => "dans",
        'ans' => "an",
        'mer' => "Mercredi",
        'lun' => "Lundi",
        'mar' => "Mardi",
        'jeu' => "Jeudi",
        'ven' => "Vendredi",
        'sam' => "Samedi",
        'dim' => "Dimanche",
        'jan' => "Janvier",
        'fev' => "Février",
        'mars' => "Mars",
        'avr' => "Avril",
        'mai' => "Mai",
        'jui' => "Juin",
        'juil' => "Juillet",
        'aou' => "Août",
        'sep' => "Septembre",
        'oct' => "Octobre",
        'nov' => "Novembre",
        'dec' => "Décembre",
        'inconu' => "Inconnu",
    ], "en" => [
        'since' => "Since",
        'environ' => "In around",
        'instant' => "Just now",
        'mois' => "month",
        'demi' => "half",
        'an' => "year",
        'jr' => "day",
        'jrs' => "day",
        'hrs' => "hour",
        'hr' => "hr",
        'min' => "min",
        'mins' => "minutes",
        'sec' => "second",
        'secs' => "a few seconds",
        'dans' => "in",
        'ans' => "year",
        'mer' => "Wednesday",
        'lun' => "Monday",
        'mar' => "Tuesday",
        'jeu' => "Thursday",
        'ven' => "Friday",
        'sam' => "Saturday",
        'dim' => "Sunday",
        'jan' => "January",
        'fev' => "February",
        'mars' => "March",
        'avr' => "April",
        'mai' => "May",
        'jui' => "June",
        'juil' => "July",
        'aou' => "August",
        'sep' => "September",
        'oct' => "October",
        'nov' => "November",
        'dec' => "December",
        'inconu' => "Unknow",
    ]
    ];

    public static function getLang($key, $default = 'fr')
    {
        $default = (!in_array($default, ["fr", "en"])) ? "fr" : $default;
        return self::$lang[$default][$key];
    }

    public static function relativeTime($date){
        if (!empty($date) && $date != '0000-00-00 00:00:00' && $date != '0000-00-00') {
            $local = "fr";
            // Déduction de la date donnée à la date actuelle
            $time = time() - strtotime($date);

            // Calcule si le temps est passé ou à venir
            if ($time > 0) {
                $when = self::getLang('since', $local);
            } else if ($time < 0) {
                $when = self::getLang('environ', $local);
            } else {
                return self::getLang('instant', $local);
            }
            $time = abs($time);

            // Tableau des unités et de leurs valeurs en secondes
            $times = array(31104000 => self::getLang('an', $local),       // 12 * 30 * 24 * 60 * 60 secondes
                2592000 => self::getLang('mois', $local),        // 30 * 24 * 60 * 60 secondes
                86400 => self::getLang('jr', $local),     // 24 * 60 * 60 secondes
                3600 => self::getLang('hr', $local),    // 60 * 60 secondes
                60 => self::getLang('min', $local),   // 60 secondes
                1 => self::getLang('sec', $local)); // 1 seconde

            foreach ($times as $seconds => $unit) {
                // Calcule le delta entre le temps et l'unité donnée
                $delta = round($time / $seconds);

                // Si le delta est supérieur à 1
                if ($delta >= 1) {
                    // L'unité est au singulier ou au pluriel ?
                    if ($delta == 1) {
                        $unit = str_replace('{s}', '', $unit);
                    } else {
                        $unit = str_replace('{s}', 's', $unit);
                    }
                    // Retourne la chaine adéquate
                    return $when . " " . $delta . " " . $unit;
                }
            }
        } else {
            return '<sapan class="text-danger">Date inconnue</sapan>';
        }
    }

    public static function DateConviviale($date,$withTime=null){
        //$local = isset($_SESSION['lang']) ? $_SESSION['lang'] : "fr";
        $local = "fr";
        if (!empty($date) && $date != '0000-00-00 00:00:00' && $date != '0000-00-00') {
            $now = date(MYSQL_DATE_FORMAT);
            $NomJour = date("D", strtotime($date));
            $Jour = date("j", strtotime($date));
            $NomMois = date("M", strtotime($date));
            $Annee = date("Y", strtotime($date));
            switch ($NomJour) {
                case "Mon":
                    $NomJour = self::getLang('lun', $local);
                    break;
                case "Tue":
                    $NomJour = self::getLang('mar', $local);
                    break;
                case "Wed":
                    $NomJour = self::getLang('mer', $local);
                    break;
                case "Thu":
                    $NomJour = self::getLang('jeu', $local);
                    break;
                case "Fri":
                    $NomJour = self::getLang('ven', $local);
                    break;
                case "Sat":
                    $NomJour = self::getLang('sam', $local);
                    break;
                case "Sun":
                    $NomJour = self::getLang('dim', $local);
                    break;
            }
            switch ($NomMois) {
                case "Jan":
                    $NomMois = self::getLang('jan', $local);
                    break;
                case "Feb":
                    $NomMois = self::getLang('fev', $local);
                    break;
                case "Mar":
                    $NomMois = self::getLang('mars', $local);
                    break;
                case "Apr":
                    $NomMois = self::getLang('avr', $local);
                    break;
                case "May":
                    $NomMois = self::getLang('mai', $local);
                    break;
                case "Jun":
                    $NomMois = self::getLang('jui', $local);
                    break;
                case "Jul":
                    $NomMois = self::getLang('juil', $local);
                    break;
                case "Aug":
                    $NomMois = self::getLang('aou', $local);
                    break;
                case "Sep":
                    $NomMois = self::getLang('sep', $local);
                    break;
                case "Oct":
                    $NomMois = self::getLang('oct', $local);
                    break;
                case "Nov":
                    $NomMois = self::getLang('nov', $local);
                    break;
                case "Dec":
                    $NomMois = self::getLang('dim', $local);
                    break;
            }
            $time = isset($withTime)?" à ".date("H:i",strtotime($date)):"";
            $val = "";
            if(date(MYSQL_DATE_FORMAT,strtotime($date))==$now){
                $val = "Aujourd'hui";
            }elseif(date(MYSQL_DATE_FORMAT,strtotime($date))==date(MYSQL_DATE_FORMAT, strtotime($now . ' +1 day'))){
                $val = "Demain";
            }elseif(date(MYSQL_DATE_FORMAT,strtotime($date))==date(MYSQL_DATE_FORMAT, strtotime($now . ' +2 day'))){
                $val = "Après demain";
            }elseif(date(MYSQL_DATE_FORMAT,strtotime($date))==date(MYSQL_DATE_FORMAT, strtotime($now . ' -1 day'))){
                $val = "Hier";
            }elseif(date(MYSQL_DATE_FORMAT,strtotime($date))==date(MYSQL_DATE_FORMAT, strtotime($now . ' -2 day'))){
                $val = "Avant hier";
            }else{
                $val = $NomJour . " " . $Jour . " " . $NomMois . " " . $Annee;
            }
            return $val.$time;
        } else {
            return '<span class="text-danger">Date inconnue</span>';
        }
    }

    public static function DateShort($date,$withTime=null){
        //$local = isset($_SESSION['lang']) ? $_SESSION['lang'] : "fr";
        $local = "en";
        if (!empty($date) && $date != '0000-00-00 00:00:00' && $date != '0000-00-00') {
            $format = isset($withTime)?"d-m-Y H:i":"d-m-Y";
            return date($format,strtotime($date));
        } else {
            return '<span class="text-danger">Date inconnue</span>';
        }
    }

    public static function DateShorts($date,$withTime=null){
        //$local = isset($_SESSION['lang']) ? $_SESSION['lang'] : "fr";
        $local = "en";
        if (!empty($date) && $date != '0000-00-00 00:00:00' && $date != '0000-00-00') {
            $format = isset($withTime)?"d-m-Y H:i":"d-m-Y";
            return date($format,strtotime($date));
        } else {
            return 'Date inconnue';
        }
    }

    public static function getRelativeDate($date){
        $local = isset($_SESSION['lang']) ? $_SESSION['lang'] : "fr";
        $local = isset($_SESSION['lang']) ? $_SESSION['lang'] : "fr";
        $date_a_comparer = new DateTime($date);
        $date_actuelle = new DateTime("now");

        $intervalle = $date_a_comparer->diff($date_actuelle);

        if ($date_a_comparer > $date_actuelle) {
            $prefixe = self::getLang('dans', $local);
        } else {
            $prefixe = self::getLang('since', $local);
        }
        $ans = $intervalle->format('%y');
        $mois = $intervalle->format('%m');
        $jours = $intervalle->format('%d');
        $heures = $intervalle->format('%h');
        $minutes = $intervalle->format('%i');
        $secondes = $intervalle->format('%s');

        if ($ans != 0) {
            $relative_date = $prefixe . $ans . ' ' . self::getLang('ans', $local) . (($ans > 1) ? 's' : '');
            if ($mois >= 6) $relative_date .= ' ' . self::getLang('demi', $local);
        } elseif ($mois != 0) {
            $relative_date = $prefixe . $mois . ' ' . self::getLang('mois', $local);
            if ($jours >= 15) $relative_date .= ' ' . self::getLang('demi', $local);
        } elseif ($jours != 0) {
            $relative_date = $prefixe . $jours . ' ' . self::getLang('jrs', $local) . (($jours > 1) ? 's' : '');
        } elseif ($heures != 0) {
            $relative_date = $prefixe . $heures . ' ' . self::getLang('hrs', $local) . (($heures > 1) ? 's' : '');
        } elseif ($minutes != 0) {
            $relative_date = $prefixe . $minutes . ' ' . self::getLang('mins', $local) . (($minutes > 1) ? 's' : '');
        } else {
            $relative_date = $prefixe . ' ' . self::getLang('secs', $local);
        }

        return $relative_date;
    }

    public static function calculAge($date_naissance)
    {
        $local = isset($_SESSION['lang']) ? $_SESSION['lang'] : "fr";
        $local = "fr";
        $date_actuelle = new DateTime();
        $dateNaissance = new DateTime($date_naissance);
        $intervalle = $date_actuelle->diff($dateNaissance);
        $ans = $intervalle->format('%y');
        $result = ($ans > 1) ? $ans . ' ' . self::getLang('an', $local) . 's' : $ans . ' ' . self::getLang('an', $local);
        return $result;
    }

}