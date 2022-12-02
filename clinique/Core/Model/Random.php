<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 16/07/2015
 * Time: 16:16
 */

namespace Projet\Model;


class Random {

    public static function generateMatricule($lenght){
        $year = date('y');
        $list = $lenght==1?'ABCDEFGHJKLMN':'PQRSTUVWXYZ';
        $char = self::randString(1,$list);
        $day = date('d');
        $month = date('m');
        return $year.$char.$day.$month.self::number(1);
    }

    public static function generateNumeroCarte($codePays,$codeCarte){
        $char = self::randString(4,'012345678901234567890120034560007890123456789');
        $idPays = self::randString(1,'12345678901234567891234567890123456789');
        $idRegion = self::randString(2,'12345678901234567891234567890123456789');
        $codeMerchant = self::randString(2,'12345678901234567000891234500067890123456789');
        return $idPays.$codePays.$idRegion.$codeCarte.$codeMerchant.$char;
    }

    public static function number($length){
        $numbers = "123456789123456789123456789";
        return substr(str_shuffle(str_repeat($numbers, $length)),0,$length);
    }

    public static function getCodeCoupon($nbre){
        $year = date('y');
        return $year.self::randString(1,"FGHJKL").$nbre;
    }

    public static function string($length){
        $year = date('y');
        $char = self::randString(2,"ABCDEFGHJKLMNPQRSTUVWXYZ");
        $number = self::randString(5,"111222333444555666777888999");
        //$letters = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return $year.$char.$number;
    }

    public static function token(){
        $time = time();
        $char = self::randString(5,"ABCDEFGHJKLMNPQRSTUVWXYZ");
        $number = self::randString(5,"11122233344455566677788899900000");
        return $char.$time.$number;
    }

    public static function reference(){
        $day = date('d');
        $second = date('s');
        $heure = date('H');
        $char = self::randString(2,"ACEHRPATEFRMNTE");
        $number = self::randString(4,"111222333444555666777888999");
        return $day.$char.$day.$number.$heure.$second;
    }

    public static function randString($length,$table){
        return substr(str_shuffle(str_repeat($table, $length)),0,$length);
    }
}