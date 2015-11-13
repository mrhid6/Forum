<?php
session_start();
define('XFS', 1);
require_once("../../class.settings.php");
require_once($coredir . "/Mysql.php");
require_once($coredir . "/Sessions.php");
require_once($coredir . "/Members.php");
require_once($coredir . "/Modules.php");
require_once($coredir . "/Board.php");
require_once($coredir . "/Load.php");
require_once($coredir . "/Posts.php");
require_once($srcdir . "/ui.php");

$task=Uninjection($_POST['task']);
$myuserid=Uninjection($_POST['myuserid']);
$friendid=Uninjection($_POST['friendid']);

switch($task){
	case"add":
		echo addfriend($friendid);
	break;
	case"remove":
		echo removefriend($friendid);
	break;
}
?>