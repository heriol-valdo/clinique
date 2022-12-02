<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 12/09/2015
 * Time: 17:25
 */

namespace Projet\Model;


class MapDistance{

    private static $meanRadiusEarth = 6372.795477598;

    private static function rad($x){
        return $x * pi() / 100;
    }

    public static function getDistance($lat1,$lon1,$lat2,$lon2){
        $dLat = self::rad($lat2-$lat1);
        $dLon = self::rad($lon2-$lon1);
        $a = (sin($dLat / 2) * sin($dLat / 2)) + (cos(self::rad($lat1)) * cos(self::rad($lat2)) * sin($dLon / 2) * sin($dLon / 2));
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = self::$meanRadiusEarth * $c;
        return $d;
    }
    public static function distance($lat1, $lon1, $lat2, $lon2, $unit='N')
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
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