<?php
namespace Steel;

class ArrayMethods{
    public static function lastKey($array){
        end($array);
        return key($array);
    }
    
    public static function lastValue($array){
        
        return end($array);
    }
}