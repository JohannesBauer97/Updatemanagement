<?php

namespace UpdateManagement;
require_once 'Config.php';
/**
 * Description of Connection
 *
 * @author w4ter
 */
class Database {
    
    private $link;
    
    /**
     * Setup new MySQLi connection
     */
    public function __construct() {
        $this->link = new \mysqli(Config::MYSQL_IP, Config::MYSQL_DB, Config::MYSQL_PASSWORD, Config::MYSQL_USER) or die;
        $this->link->set_charset("utf8");
    }
    
    /**
     * 
     * @param type $sql SQL Command
     * @return Array with rows
     */
    public function Query($sql){
        $data = mysqli_query($this->link, $sql);
        
        if(is_bool($data)) return $data;
        
        $out = array();
        $i = 0;
        while($row= mysqli_fetch_object($data)){        
            foreach($row as $key => $value){
                $out[$i][$key] = $value;
            }
            $i++;
        }
        if($i == 0)
            return null;
        return $out;
    }
    
    public function getLink(){
        return $this->link;
    }
    
    public function LastInsertedID(){
        return mysqli_insert_id($this->link);
    }
}
