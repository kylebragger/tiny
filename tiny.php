<?php

/**
 * Tiny
 *
 * A reversible base62 ID obfuscater
 *
 * Authors:
 *  Jacob DeHart (original PHP version) and Kyle Bragger (Ruby port)
 *
 * Usage:
 *  $obfuscated_id = toTiny(123)
 *  $original_id = reverseTiny($obfuscated_id)
 *
 * Configuration:
 *  * You must run Tiny::generate_set() from console (using tiny.rb) to generate your $set
 *    Do *not* change this once you start using Tiny, as you won't be able to reverseTiny()
 *    any values toTiny()'ed with another set.
 *
 */

class Tiny {
    public static $set = '__PUT SET HERE__';

    public static function toTiny($id){
        $set = self::$set;

        $HexN="";
        $id = floor(abs(intval($id)));
        $radix = strlen($set);
        while (true) {
            $R=$id%$radix;
            $HexN = $set{$R}.$HexN;
            $id=($id-$R)/$radix;
            if ($id==0) break;
        }
        return $HexN;
    }

    public static function reverseTiny($str){
        $set = self::$set;
        $radix = strlen($set);
        $strlen = strlen($str);
        $N = 0;
        for($i=0;$i<$strlen;$i++){
            $N += strpos($set,$str{$i})*pow($radix,($strlen-$i-1));
        }
        return "{$N}";
    }

    public static function generate_set(){
        $arr = array();
        for ($i = 65; $i <= 122; $i++)
        {
            if ($i < 91 || $i > 96) $arr[] = chr($i);
        }
        $arr = array_merge($arr, range(0, 9));
        shuffle($arr);
        return join('', $arr);
    }
	 
}

// Testing
echo Tiny::generate_set() . "<br />";
echo Tiny::toTiny(123) . "<br />";
echo Tiny::reverseTiny(Tiny::toTiny(123));
