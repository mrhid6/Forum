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
 
 $adminemail 	= "dominic.richardson1@hotmail.co.uk";
 
 $defaultz		= "Europe/Dublin";

 ########## Database Variables  ########## 
 $db_server		= "localhost";
 $db_user	 	= "forum";
 $db_passwd		= "forum123";
 
 $db_name 	  	= "forum";
 $db_prefix  	= "XFS_";
 
 ########### Folder Structure ############
 
 $basedir 		= 	dirname(__FILE__);
 $coredir 		=	$basedir          . "/Core";
 $srcdir  		=	$basedir          . "/Sources";
 $themedir  	=	$basedir          . "/Themes";
 $modsdir   	=	$basedir          . "/Modules";
 $memsdir   	=	$basedir          . "/Members";
 $pagedir  		=	$srcdir			  . "/Pages";
 $memsurl  		=	$forumurl 		  . "/Members";
 $coreCss		= 	$forumurl 		  . "/Core/Css";
 $coreImgs		= 	$forumurl 		  . "/Core/Images";
 $coreJs		= 	$forumurl 		  . "/Core/Js";
 
 $coreCssFile 	= 	$forumurl . "/Core/Css/main.css";
 
 ?>