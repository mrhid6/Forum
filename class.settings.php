<?php

/**
 * Xorbo Forum Systems
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 3.0
 */

class Settings
{

    private $offline, $forumURL, $forumVersion, $forumTitle;
    private $db_server, $db_user, $db_pass, $db_name, $db_prefix;
    private $basedir, $folderStructure;
    private $clientIpAddress;

    function __construct(){

        $this->offline          = false;

        $this->forumURL         = "http://".$_SERVER['HTTP_HOST'];
        $this->forumVersion     = "3.0.0";
        $this->forumTitle       = "Xorbo Forums";

        $this->db_server        = "localhost";
        $this->db_user          = "forum";
        $this->db_pass          = "forum123";

        $this->db_name          = "forum";
        $this->db_prefix        = "XFS_";

        $this->setFolderStructure();
        $this->setClientIpAddress();
    }

    public function isOffline(){
        return $this->offline;
    }

    public function getForumURL(){
        return $this->forumURL;
    }

    public function getForumVersion(){
        return $this->forumVersion;
    }

    public function getForumTitle(){
        return $this->forumTitle;
    }

    public function getDatabaseSettings(){
        return array(
            "db_server"     => $this->db_server,
            "db_user"       => $this->db_user,
            "db_pass"       => $this->db_pass,
            "db_name"       => $this->db_name,
            "db_prefix"    => $this->db_prefix
        );
    }

    public function getFolderLocation($folder){
        if(isset($this->folderStructure[$folder])){
            return $this->folderStructure[$folder];
        }
        return null;
    }

    public function getClientIpAddress(){
        return $this->clientIpAddress;
    }

    private function setFolderStructure(){
        $this->basedir = 	dirname(__FILE__);

        $this->folderStructure = array(
            "BackCoreDir"       => $this->basedir."/Backend/Core",
            "FrontCoreDir"      => $this->basedir."/Frontend/Core",
            "SRCDir"            => $this->basedir."/Sources",
            "ThemeDir"          => $this->basedir."/Themes",
            "ModDir"            => $this->basedir."/Modules",
            "MemDir"            => $this->basedir."/Members",
            "PageDir"           => $this->basedir."/Backend/Pages",
            "MemURL"            => $this->getForumURL()."/Frontend/Members",
            "FrontCoreCSSURL"   => $this->getForumURL()."/Fronend/Core/Css",
            "FrontCoreIMGURL"   => $this->getForumURL()."/Frontend/Core/Images",
            "FrontCoreJSURL"    => $this->getForumURL()."/Frontend/Core/JS"
        );
    }

    public function getFolderStructure(){
        return $this->folderStructure;
    }

    public function getBaseDirectory(){
        return $this->basedir;
    }

    private function setClientIpAddress(){
        $this->clientIpAddress = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $exploded = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $this->clientIpAddress = array_pop($exploded);
        }
    }
}