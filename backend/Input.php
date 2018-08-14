<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UpdateManagement;

/**
 * Description of Input
 *
 * @author w4ter
 */
class Input {
    public function __construct() {
        
    }
    
    /**
     * Searches for key in all superglobals
     * @param type $key any http-request key
     * @return returns value of key
     */
    public function get($key){
        if(array_key_exists($key, $_GET)){
            return $_GET[$key];
        }else if(array_key_exists($key, $_POST)){
            return $_POST[$key];
        }else if(array_key_exists($key, $_FILES)){
            return $_FILES($key);
        }
        
        return null;
    }
}
