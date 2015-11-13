<?php

/**
 * Xorbo Forum Systems
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 3.0
 */
class Database
{

    private $conn, $db_settings, $db_prefix;

    function __construct(){
        global $_settings;

        $this->db_settings = $_settings->getDatabaseSettings();
        $this->db_prefix = $this->db_settings['db_prefix'];

        $this->loadDatabase();
    }

    private function loadDatabase(){

        $this->conn = new mysqli($this->db_settings['db_server'], $this->db_settings['db_user'], $this->db_settings['db_pass']);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // Something's wrong, show an error if its fatal (which we assume it is)
        if (!$this->conn) {
            db_error();
        }

        // Select the database, unless told not to
        if (!$this->conn->select_db($this->db_settings['db_name']))
            $this->db_error();
    }
    public function getConnection(){
        return $this->conn;
    }

    public function getDBPrefix(){
        return $this->db_prefix;
    }

    public function query($sql){
        $res = $this->conn->query($sql) or die("Error:".$this->db_error());
        return $res->fetch_assoc();
    }

    public function closeConnection(){
        global $conn;
        if(!$conn->close())
            $this->db_error();
    }

    private function db_error(){
        die($this->conn->error);
    }
}