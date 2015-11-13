<?php
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

$id=Uninjection($_POST['ID']);

$conn->query("DELETE FROM ".$db_prefix."member_online WHERE userid='".$id."'");

?>