<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UpdateManagement;

/**
 * Description of Einstellungen
 *
 * @author w4ter
 */
class Einstellungen {
    use DefaultModule;
    public function render(){
        $this->initDefaultModule();
        $this->tmpl->load("Einstellungen.html");
        
        return $this->tmpl->Template;
    }
}
