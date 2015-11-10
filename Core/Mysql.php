<?php
/**
 * Xorbo Forum Systems 
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 2.0
 */
if (!defined('XFS'))
	die('Hacking attempt...');
	
############ Load Database ############

global $conn;

function loadDatabase(){
	
	global $conn, $db_server, $db_user, $db_passwd, $db_name;

	$conn = new mysqli($db_server, $db_user, $db_passwd);

	if ($conn->connect_error) {
		die("Connection failed: " . $this->conn->connect_error);
	}

	// Something's wrong, show an error if its fatal (which we assume it is)
	if (!$conn)
	{
		db_error();
	}

	// Select the database, unless told not to
	if (!$conn->select_db($db_name))
		db_error();
}

function killConnection(){
	global $conn;
	if(!$conn->close())
		db_error();
}
function UnInjection($data,$task='basic'){
	global $conn;
	$special=array("'",'!','&','?','*','/','^','%','$','£','"','=');
	
	if($task=="basic"){
		$data=str_replace($special,'',$data);
	}else{
		$data=str_replace(' ','',str_replace($special,'',$data));
	}

	$data=$conn->real_escape_string($data);
	$data=strip_tags($data);
	return$data;
}
function StripScripts($data){
	$pattern = "/<script>(.*)</script>/i"; 
	$replacement = ""; 
	$data = preg_replace('/<script\b[^>]*>(.*?)<\/script>/i', "", $data);
	
	return$data;
}
function errorcode($errornum){
	global $conn,$db_prefix;
	if($errornum!=''){
		$sql=$conn->query("SELECT * FROM ".$db_prefix."errorcodes WHERE ID='".UnInjection($errornum)."'");
		if($sql->num_rows > 0){
			$row=$sql->fetch_assoc();
			return("[#".$row['ID']."]"." ".$row['value']);
		}
	}
}
######## Mysql Error Checks ########
function db_error(){
	global $conn;
	die($conn->error);
}
?>