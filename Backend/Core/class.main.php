<?php

/**
 * Xorbo Forum Systems
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 3.0
 */

include($_settings->getFolderLocation("BackCoreDir")."/class.database.php");
include($_settings->getFolderLocation("BackCoreDir")."/class.theme.php");

class Main
{

    private $db_conn, $thememgr;

    public function __construct(){
        $this->db_conn      = new Database();
        $this->theme     = new Theme($this->db_conn);
    }

    public function getTheme(){
        return $this->theme;
    }
}