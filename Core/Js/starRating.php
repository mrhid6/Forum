<?php
define('XFS', 1);
require_once("../../Settings.php");
require_once($coredir . "/Mysql.php");
require_once($coredir . "/Sessions.php");
require_once($coredir . "/Members.php");
require_once($coredir . "/Modules.php");
require_once($coredir . "/Board.php");
require_once($coredir . "/Theme.php");
require_once($coredir . "/Load.php");
require_once($coredir . "/Posts.php");
require_once($srcdir . "/ui.php");

$task=Uninjection($_POST['task']);
$id=Uninjection($_POST['ID']);
$value=Uninjection($_POST['value']);

switch($task){
	case"topic":
		$sql=$conn->query("UPDATE ".$db_prefix."board_topics SET Rating_score= Rating_score+".$value.", Rating_count= Rating_count+1 WHERE ID='".$id."'");
		
		if($sql){
			echo"Success";
		}else{
			echo"error";
		}
	break;
}
?>