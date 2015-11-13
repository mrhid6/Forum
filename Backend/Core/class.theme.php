<?php

/**
 * Created by PhpStorm.
 * User: Dominic
 * Date: 06/11/2015
 * Time: 20:59
 */
class Theme
{
    private $db_conn;
    private $name, $folder, $html_folder, $config_file, $config, $index_file, $valid;

    function __construct($conn){
        $this->db_conn = $conn;

        $this->initTheme();
        //$this->validate();
    }

    function initTheme()
    {

        $res = $this->db_conn->query("SELECT value FROM " . $this->db_conn->getDBPrefix() . "settings WHERE setting='currentTheme'");

        $this->name = $res['value'];
        $this->folder = $this->getFolder();
        $this->config = $this->getConfigJSON();
        $this->index_file = $this->getIndexFile();
        $this->html_folder = $this->getHtmlFolder();
    }

    function getName(){
        return $this->name;
    }

    function getFolder(){
        global $_settings;
        return $_settings->getFolderLocation('ThemeDir')."/".$this->getName();
    }

    function getConfigJSON()
    {
        $this->config_file = $this->getFolder() . "/config.json";
        if (checkTheFile($this->config_file)) {
            $json_data = file_get_contents($this->getFolder() . "/config.json");
            $obj = json_decode($json_data, true);

            $__js = $obj['JavaScript'];
            $__ss = $obj['Stylesheet'];
            foreach($__js as $key=>$arr){
                foreach($arr as $jskey=>$val){
                    $obj['JavaScript'][$jskey] = $val;
                }
                $obj['JavaScript'][$key]=null;
            }

            foreach($__ss as $key=>$arr){
                foreach($arr as $sskey=>$val){
                    $obj['Stylesheet'][$sskey] = $val;
                }
                $obj['Stylesheet'][$key]=null;
            }

            $obj['JavaScript']=array_filter($obj['JavaScript']);
            $obj['Stylesheet']=array_filter($obj['Stylesheet']);

            return $obj;
        }

        return array();
    }
    function getHtmlFolder(){
        global $forumurl;
        return $forumurl."/Themes/".$this->name;
    }

    function _remove_empty_internal($value) {
        return !empty($value) || $value === 0;
    }

    function getIndexFile(){
        return $this->getFolder()."/index.php";
    }

    function buildArray(){
        $res = array();
        $res['name'] = $this->name;
        $res['folder'] = $this->folder;
        $res['config_file'] = $this->config_file;
        $res['index_file'] = $this->index_file;
        $res['config'] = $this->config;
        $res['valid'] = $this->valid;
        return $res;
    }

    function generateHeadCSS(){
        $res="";
        foreach($this->config['Stylesheet'] as $css){
            $res.="<link rel=\"stylesheet\" type=\"text/css\" href=\"$this->html_folder/$css\">\n";
        }
        return $res;
    }

    function generateHeadJS(){
        $res="";
        foreach($this->config['JavaScript'] as $css){
            $res.="<script type=\"text/javascript\" src=\"$this->html_folder/$css\"> </script>\n";
        }
        return $res;
    }

    function isValid(){
        return $this->valid;
    }

    function validate(){
        $this->valid = true;

        if(!checkTheFile($this->index_file) || !checkTheFile($this->config_file) || $this->config['Version'] == "")
            $this->valid = false;
    }
}