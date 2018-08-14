<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UpdateManagement;

require_once 'Config.php';
require_once 'Database.php';
require_once 'Input.php';
require_once 'TemplateSystem.php';

/**
 * Description of DefaultModule
 *
 * @author w4ter
 */
trait DefaultModule {
    
    public $tmpl;
    public $db;
    public $input;
    public $conf;
    
    public function initDefaultModule(){
        $this->tmpl = new \UpdateManagement\TemplateSystem();
        $this->db = new \UpdateManagement\Database();
        $this->input = new \UpdateManagement\Input();
        $this->conf = new \UpdateManagement\Config();
    }
}
