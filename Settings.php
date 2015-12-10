<?php
/**
 * Xorbo Forum Systems
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 2.0
 */

############# Offline Mode ##############
$offline = 0;



########### Forum Variables  ############

$forumurl 		= "http://".$_SERVER['HTTP_HOST'];


$forumVersion 	= "2.0.0";

$adminemail 	= "admin@forum.hostxtra.co.uk";

$defaultz		= "Europe/Dublin";

########## Database Variables  ##########
$db_server		= "localhost";
$db_user	 	= "admin_forum";
$db_passwd		= "iTNLK7QTX6";

$db_name 	  	= "admin_forum";
$db_prefix  	= "XFS_";

########### Folder Structure ############

$basedir 		= 	dirname(__FILE__);
$coredir 		=	dirname(__FILE__) . "/Core";
$srcdir  		=	dirname(__FILE__) . "/Sources";
$themedir  	    =	dirname(__FILE__) . "/Themes";
$modsdir   	    =	dirname(__FILE__) . "/Modules";
$memsdir   	    =	dirname(__FILE__) . "/Members";
$pagedir  		=	$srcdir			  . "/Pages";
$memsurl  		=	$forumurl 		  . "/Members";
$coreCss		= 	$forumurl 		  . "/Core/Css";
$coreImgs		= 	$forumurl 		  . "/Core/Images";
$coreJs		    = 	$forumurl 		  . "/Core/Js";

$coreCssFile 	= 	$forumurl . "/Core/Css/main.css";

date_default_timezone_set($defaultz);

$ipAddress = $_SERVER['REMOTE_ADDR'];
if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
    $exploded = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $ipAddress = array_pop($exploded);
}

?>