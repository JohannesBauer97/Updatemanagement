<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UpdateManagement;

/**
 * Description of EditProjekt
 *
 * @author w4ter
 */
class EditProjekt {
    
    use DefaultModule;
    
    private $ID;
    private $Name;
    private $Beschreibung;
    private $Angelegt;
    private $Version;
    
    public function render(){
        $this->initDefaultModule();
        $this->getProjektInfos($this->input->get("pid"));
        $this->tmpl->load("Projekte.EditProjekt.html");
        
        //Allgemeine Projektinfos anpassen
        $this->allgemeineProjektInfosRender();
        $this->versionHistoryTBodyRender();
        
        return $this->tmpl->Template;
    }
    
    public function getProjektInfos($pid){
        if(!intval($pid) || $pid < 0){
            exit;
        }
        $projekt = $this->db->Query("SELECT 
    p.*, v.version
FROM
    `projekte` AS p
        LEFT JOIN
    version AS v ON p.projektID = v.projektID
WHERE p.ProjektID = $pid and p.active = 1
ORDER BY v.version DESC
LIMIT 1");
        $this->ID = $projekt[0]["ProjektID"];
        $this->Name = $projekt[0]["Projektname"];
        $this->Beschreibung = $projekt[0]["Projektbeschreibung"];
        $this->Angelegt = $projekt[0]["Angelegt"];
        $this->Version = $projekt[0]["version"];
    }
    
    public function allgemeineProjektInfosRender(){
        $this->tmpl->setVar("ProjektName",$this->Name);
        $this->tmpl->setVar("ProjektDesc",$this->Beschreibung);
        $this->tmpl->setVar("ProjektErstellt", date("d.m.Y - H:i",strtotime($this->Angelegt)));
        $this->tmpl->setVar("ProjektID", $this->ID);
        $this->tmpl->setVar("ProjektLink", "https://updates.serverlein.de/download/index.php?pid=" . $this->ID);
        $this->tmpl->setVar("VersionsLink", "https://updates.serverlein.de/download/index.php?pid=" . $this->ID . "&version");
        $this->tmpl->setVar("ProjektVersion",$this->Version);
    }
    
    public function versionHistoryTBodyRender(){
        $result = $this->db->Query("SELECT 
    d.*, v.version, v.versionID
FROM
    `dateien` AS d
        LEFT JOIN
    version AS v ON v.projektID = d.ProjektID
        AND d.DateiID = v.DateiID
WHERE d.ProjektID = {$this->ID} AND d.active = 1
ORDER BY v.Angelegt DESC");
        $str = null;
        
        if(count($result) <= 0){
            $this->tmpl->setVar("VersionTbody", "<tr><td colspan=\"5\" style=\"text-align:center;\">Noch keine Dateien hochgeladen...</td></tr>");
            return;
        }
        
        foreach ($result as $key => $file) {
            $fname = $file["Name"];
            $fsize = $this->formatBytes($file["Size"]);
            $fdate = date("d.m.Y - H:i", strtotime($file["Hochgeladen"]));
            $fid = $file["DateiID"];
            $btncolor = "primary";
            $onclickfunction = "setAsProjektFile($fid);";
            $title = "Veröffentlichen";
            $version = $file["version"];
            $versionID = $file["versionID"];
            
            if($file["ProjektDatei"]){
                $btncolor = "success";
                $onclickfunction = "removeAsProjektFile($fid);";
                $title = "Verbergen";
            }
            
            $setAsProjektDownload = "<button type=\"button\" class=\"btn btn-$btncolor tooltipster\" onclick=\"$onclickfunction\" title=\"$title\"><i class=\"fa fa-cloud-upload\" aria-hidden=\"true\"></i></button>";
            $deleteFile = "<button type=\"button\" class=\"btn btn-danger tooltipster\" onclick=\"removeFile($fid);\" title=\"Löschen\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button>";
            
            $str .= "<tr>";
            $str .= "<td>$fname</td>";
            $str .= "<td><button type=\"button\" class=\"btn btn-link\" onclick=\"openVersionModal($versionID);\">$version</button></td>";
            $str .= "<td>$fsize</td>";
            $str .= "<td>$fdate</td>";
            $str .= "<td>$setAsProjektDownload $deleteFile</td>";
            $str .= "</tr>";
        }
        $this->tmpl->setVar("VersionTbody", $str);
    }
    
    public static function formatBytes($bytes, $precision = 2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 

        // Uncomment one of the following alternatives
         $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow]; 
    } 
}
