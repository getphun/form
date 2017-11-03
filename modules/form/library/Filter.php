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
    
    static function tinymce($str, $opts=[]){
        if(!module_exists('lib-kses'))
            return $str;
        
        $kses = new \kses5();
        $tags = $opts['kses'] ?? [];
        
        foreach($tags as $tag => $attr)
            $kses->AddHTML($tag, $attr);
        
        return $kses->Parse($str);
    }
}