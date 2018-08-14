<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UpdateManagement;

/**
 * Description of AddProjekt
 *
 * @author w4ter
 */
class AddProjekt {
    use DefaultModule;
    
    public function render(){
        $this->initDefaultModule();
        
        $this->tmpl->load("Projekte.AddProjekt.html");
        return $this->tmpl->Template;
    }
}
