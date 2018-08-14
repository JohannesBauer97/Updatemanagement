<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UpdateManagement;

/**
 * Description of Projekte
 *
 * @author w4ter
 */
class Projekte {
    use DefaultModule;
    
    public function render(){
        $this->initDefaultModule();
        
        $this->tmpl->load("Projekte.html");
        
        return $this->tmpl->Template;
    }
}
