<?php
/**
 * Filter library
 * @package form
 * @version 0.0.1
 * @upgrade true
 */

namespace Form\Library;

class Filter
{
    static function lowercase($str){
        return strtolower($str);
    }
    
    static function uppercase($str){
        return strtoupper($str);
    }
    
    static function string($any){
        return (string)$any;
    }
    
    static function number($any){
        return (int)$any;
    }
}