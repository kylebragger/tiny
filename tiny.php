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
    public static function toTiny($id){
        $set = 'khvrbAfsCXEzIYt30ZdVLBQy5oJeglPHnu9M67qpKxUFj1OS8GawRTcm24DWiN';//'__use the set you generate with tiny.rb (see tiny.rb for more)__';

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
        $set = 'khvrbAfsCXEzIYt30ZdVLBQy5oJeglPHnu9M67qpKxUFj1OS8GawRTcm24DWiN';//$set = '__use the SAME SET as tiny() above__';
        $radix = strlen($set);
        $strlen = strlen($str);
        $N = 0;
        for($i=0;$i<$strlen;$i++){
            $N += strpos($set,$str{$i})*pow($radix,($strlen-$i-1));
        }
        return "{$N}";
    }
}

// Testing
echo Tiny::toTiny(123);
echo Tiny::reverseTiny(Tiny::toTiny(123));