<?php
/**
 * form service
 * @package form
 * @version 0.0.1
 * @upgrade true
 */

namespace Form\Service;
use Core\Library\View;

class Form {

    protected $errors = [];
    protected $fields = [];
    protected $form   = '';
    protected $object = null;
    
    public function __construct(){
        $this->object = new \stdClass();
    }
    
    public function errorExists(){
        return !!$this->errors;
    }
    
    public function field($name, $options=null){
        if(!isset($this->fields[$name]))
            return '';
        
        $_dis = &\Phun::$dispatcher;
        $_req = &$_dis->req;
        
        $is_post = $_req->method === 'POST';
        
        $field = $this->fields[$name];
        $field['value'] = $this->object->$name ?? '';
        $field['error'] = $this->getError($name);
        $field['name']  = $name;
        $field['id']    = 'field-' . $name;
        $field['form']  = $this->form;
        if(!isset($field['desc']))
            $field['desc'] = '';
        
        if($is_post)
            $field['value'] = $_req->getPost($name);
        
        if($options)
            $field['options'] = $options;
        if(!isset($field['options']))
            $field['options'] = [];
        
        if(is_string($field['options'])){
            $opt_source = explode('.', $field['options']);
            $opt_form   = \Phun::$config['form'][$opt_source[0]];
            $field['options'] = $opt_form[$opt_source[1]]['options'];
        }
        
        if(!isset($field['nolabel']))
            $field['nolabel'] = false;
        if(!isset($field['desc']))
            $field['desc'] = '';
            
        // Now, let generate the field HTML
        $view = 'form/' . $field['type'];
        $html = new View($_dis->router->gate['name'], $view, $field);
        return $html->content;
    }
    
    public function getError($field){
        return $this->errors[$field] ?? false;
    }
    
    public function getErrors(){
        return $this->errors;
    }
    
    public function getForm(){
        return $this->form;
    }
    
    public function getObject(){
        return $this->object;
    }
    
    public function setError($field, $message){
        $this->errors[$field] = $message;
    }
    
    public function setForm($form){
        $this->form = $form;
        
        if(!isset(\Phun::$config['form'][$form]))
            throw new \Exception('Form named `' . $form . '` not registered');
        $this->fields = \Phun::$config['form'][$form];
    }
    
    public function setObject($object){
        $this->object = (object)$object;
    }
    
    public function validate($form=null, $object=null){
        if($form)
            $this->setForm($form);
        if($object)
            $this->setObject($object);
        
        $_dis = &\Phun::$dispatcher;
        $_req = &$_dis->req;
        
        if($_req->method !== 'POST')
            return false;
        
        $result = new \stdClass();
        
        $form_vld = \Phun::$config['form_validation'];
        
        foreach($this->fields as $field => $args){
            $rules = $args['rules'];
            foreach($rules as $rule => $val){
                if(!is_array($val))
                    $val = [$rule => $val];
                
                $result->$field = $value = $_req->getPost($field);
                
                $vld        = $form_vld[$rule];
                $vld_opts   = array_replace($vld['options'], $val);
                
                $vld_hanlder= $vld['handler'];
                $vldh_class = $vld_hanlder['class'];
                $vldh_action= $vld_hanlder['action'];
                
                if($vldh_class::$vldh_action($value, $vld_opts) === true)
                    continue;
                
                $vld_msg = $vld['message'];
                $vld_arg = array_merge(['field' => $args['label']], $vld_opts);
                
                foreach($vld_arg as $plc => $plk){
                    if(is_string($plk) || is_int($plk))
                        $vld_msg = str_replace(':'.$plc, $plk, $vld_msg);
                }
                
                $this->setError($field, $vld_msg);
            }
        }
        
        if($this->errorExists())
            return false;
        return $result;
    }
}