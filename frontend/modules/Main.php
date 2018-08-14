<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace UpdateManagement;

require_once '../backend/DefaultModule.php';
require_once './modules/Login.php';
require_once './modules/Dashboard.php';
/**
 * Description of Main
 *
 * @author w4ter
 */
class Main{
    
    use DefaultModule;
    
    public function show() {
        $this->initDefaultModule();
       
        $this->tmpl->load("root.html");
        
        $this->tmpl->addCSS("bootstrap.min.css");
        $this->tmpl->addCSS("amaran.min.css");
        $this->tmpl->addCSS("animate.min.css");
        $this->tmpl->addCSS("font-awesome.min.css");
        $this->tmpl->addCSS("jquery.mCustomScrollbar.css");
        
        
        if(isset($_SESSION["UserID"])){
            //Dashboard laden
            $this->tmpl->addCSS("navbar-fixed-side.css");
            $this->tmpl->addCSS("dashboard.css");  
            $this->tmpl->addCSS("Einstellungen.css");  
            $this->tmpl->addCSS("AddProjekt.css");  
            $this->tmpl->addCSS("EditProjekt.css");  
            $this->tmpl->addCSS("tooltipster.bundle.min.css");  
            
            $dashboard = new \UpdateManagement\Dashboard();
            $this->tmpl->setVar("Body", $dashboard->render());
            $this->tmpl->setVar("Title", "Serverlein Update");
            $this->tmpl->show();
        }else{
            //Login anzeigen
            $this->tmpl->addCSS("login.css");
            
            $login = new \UpdateManagement\Login();
            $this->tmpl->setVar("Body", $login->render());
            $this->tmpl->setVar("Title", "Login - Serverlein Update");
            $this->tmpl->show();
        }
        
    }
}
