<?php
/**
 * Validator library
 * @package form
 * @version 0.0.1
 * @upgrade true
 */

namespace Form\Library;

class Validator
{
    static function alnumdash($value){
        if(!$value)
            return true;
        
        return !preg_match('![^a-zA-Z0-9-]!', $value);
    }
    
    static function callback($value, $opts){
        if(!$value)
            return true;
        
        $cbs = explode('::', $opts['callback']);
        $cls = $cbs[0];
        $cla = $cbs[1];
        return (bool)$cls::$cla($value);
    }
    
    static function date($value, $opts){
        if(!$value)
            return true;
        
        $time = strtotime($value);
        if(!$time)
            return false;
        
        if($value != date($opts['date'], $time))
            return false;
        return true;
    }
    
    static function email($value){
        if(!$value)
            return true;
        
        return (bool)filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    
    static function length($value, $opts){
        if(!$value)
            return true;
        
        $length = strlen($value);
        
        if(isset($opts['max']) && $opts['max'] != '~' && $length > $opts['max'])
            return false;
        if(isset($opts['min']) && $length < $opts['min'])
            return false;
        return true;
    }
    
    static function numeric($value, $opts){
        if(!$value)
            return true;
        if(!is_numeric($value))
            return false;
        
        if(isset($opts['max']) && $opts['max'] != '~' && $value > $opts['max'])
            return false;
        if(isset($opts['min']) && $value < $opts['min'])
            return false;
        return true;
    }
    
    static function regex($value, $opts){
        if(!$value)
            return true;
        
        return (bool)filter_var($value, FILTER_VALIDATE_REGEXP, [
            'options' => [
                'regexp' => $opts['regex']
            ]
        ]);
    }
    
    static function required($value){
        return (bool)$value;
    }
    
    static function unique($value, $opts){
        if(!$value)
            return true;
        
        $model = $opts['model'];
        $field = $opts['field'];
        
        $ondb = $model::get([$field => $value], false);
        if(!$ondb)
            return true;
        
        if(!isset($opts['self']))
            return false;
        
        $self = $opts['self'];
        
        // self using URL match 
        if(isset($self['uri'])){
            $uri = \Phun::$dispatcher->param->{$self['uri']} ?? null;
            if(!$uri)
                return false;
            
            $ondb_uri = $model::get([$self['field'] => $uri], false);
            if(!$ondb_uri)
                return true;
            return $ondb_uri->id === $ondb->id;
        
        // self using service
        }elseif(isset($self['service'])){
            $serv = $self['service'];
            $serp = $self['field'];
            $comp = $self['comparer'] ?? 'id';
            
            if(\Phun::$dispatcher->$serv->$serp != $ondb->$comp)
                return false;
            return true;
        }else{
            return false;
        }
    }
    
    static function url($value){
        if(!$value)
            return true;
        
        return (bool)filter_var($value, FILTER_VALIDATE_URL);
    }
}