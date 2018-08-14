<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dashboard
 *
 * @author w4ter
 */

namespace UpdateManagement;

require_once './modules/AddProjekt.php';
require_once './modules/EditProjekt.php';
require_once './modules/Einstellungen.php';

class Dashboard {
    
    use DefaultModule;
    
    public function __construct() {
        $this->initDefaultModule();
    }
    
    public function render(){
        $this->tmpl->load("dashboard.html");
        $this->tmpl->setVar("Projekte", $this->getProjektEntrys());
        $this->tmpl->setVar("Content", $this->ManageContent());
        
        return $this->tmpl->Template;
    }
    
    public function ManageContent(){       
        switch($this->input->get("page")){      
            case "AddProjekt":
                $AddProjekt = new \UpdateManagement\AddProjekt();
                $this->tmpl->setVar("AddProjektClass","active");
                return $AddProjekt->render();
                break;
            
            case "EditProjekt":
                $EditProjekt = new \UpdateManagement\EditProjekt();
                if($this->input->get("pid") === null){
                    goto defaultlabel;
                }
                //$this->tmpl->setVar("PID". $this->input->get("pid") ,"active");
                return $EditProjekt->render();
                break;
            
            case "Einstellungen":
                $einstellungen = new \UpdateManagement\Einstellungen();
                $this->tmpl->setVar("EinstellungenClass","active");
                return $einstellungen->render();
                break;
            
            case "logout":
                session_destroy();
                header('Location: http://updates.serverlein.de');
                exit;
                break;
            
            default:
                defaultlabel:
                $AddProjekt = new \UpdateManagement\AddProjekt();
                $this->tmpl->setVar("AddProjektClass","active");
                return $AddProjekt->render();
                break;
        }
    }
    
    public function getProjektEntrys(){
        $userID = $_SESSION["UserID"];
        $projekte = $this->db->Query("SELECT
                                        pu.`projektID`,
                                        p.Projektname
                                      FROM
                                        `projekte_user` pu
                                      LEFT JOIN projekte p ON p.ProjektID = pu.`projektID`
                                      WHERE
                                        `userID` = $userID AND 
                                        p.`active` = 1");
        $str = "";
        if(count($projekte) <= 0){
            return $str;
        }
        foreach ($projekte as $projekt) {
            $class = "{..PID" . $projekt["projektID"] . "..}";
            $str .= "<li class=\"\"><a href=\"index.php?page=EditProjekt&pid={$projekt["projektID"]}\"><i class=\"fa fa-folder\" aria-hidden=\"true\"></i> {$projekt["Projektname"]}</a></li>";
        }
        
        return $str;
    }
}
