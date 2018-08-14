<?php

namespace UpdateManagement;

/**
 * Description of TemplateHelper
 *
 * @author w4ter
 */
class TemplateSystem {
    private $VarDelimiter = array("{..","..}");
    private $TemplateIncludeRegex = '/\{Include="(.+[.]html)"\}/';
    private $RemoveVarRegex = '/{\.\.(.+)\.\.}/';
    private $TemplateFolderPath;
    private $CSSFolderPath;
    private $CSSFiles;
    public $Template = "";
    
    
    public function __construct() {
        $this->setTemplateFolderPath();
        $this->setCSSFolderPath();
        $this->CSSFiles = array();
    }
    
    /**
     * Sets the Template Folder Path with Directory Seperator at the end
     */
    private function setTemplateFolderPath(){
        $this->TemplateFolderPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR;
    }
    
    private function setCSSFolderPath(){
        $this->CSSFolderPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "css" . DIRECTORY_SEPARATOR;
    }
    
    /**
     * Loads templatefile
     * @param type $template Name of templatefile
     */
    public function load($template){
        if(!file_exists($this->TemplateFolderPath . $template)){
            echo("Could not found: " . $this->TemplateFolderPath . $template);
            return false;
        }
        
        $this->Template = file_get_contents($this->TemplateFolderPath . $template);
        $this->parseFunctions();
        return true;
    }
    
    public function addCSS($CSSFileName){
        if(!file_exists($this->CSSFolderPath . $CSSFileName)){
            echo("Could not found: " . $this->CSSFolderPath . $CSSFileName);
            return false;
        }
        array_push($this->CSSFiles, "<link href=\"css/$CSSFileName\" rel=\"stylesheet\">");
    }
    
    /**
     * 
     * @param string $template name of file in template folder
     * @return string template content
     */
    public function getContent($template){
        if(!file_exists($this->TemplateFolderPath . $template)){
            echo("Could not found: " . $this->TemplateFolderPath . $template);
            return false;
        }
        return file_get_contents($this->TemplateFolderPath . $template);
    }
    
    /**
     * Parses includes
     */
    private function parseFunctions(){
        while(preg_match($this->TemplateIncludeRegex, $this->Template)){
            $this->Template = preg_replace_callback($this->TemplateIncludeRegex, function($treffer){
                if(!$this->load($treffer[1])){
                    return "Template not found.";
                }
                return $this->Template;
            }, $this->Template);
        }
    }
    
    /**
     * Sets variable in template.
     * @param type $key Variable name
     * @param type $val Value
     */
    public function setVar($key, $val) {
        $this->Template = str_replace( $this->VarDelimiter[0] . $key . $this->VarDelimiter[1], $val, $this->Template );
        $this->parseFunctions();
    }
    
    /**
     * Displays/echos template.
     */
    public function show(){
        //Add CSS Files
        $cssheaderstr = "";
        foreach ($this->CSSFiles as $File) {
            $cssheaderstr .= $File;
        }
        $this->setVar("CSS", $cssheaderstr);
        $this->removeUnusedVars();
        echo $this->Template;
    }
    
    /**
     * Removes all unset variables in Template
     */
    private function removeUnusedVars(){
        $this->Template = preg_replace($this->RemoveVarRegex,"",$this->Template);
    }
}
