<?php
/**
 * Xorbo Forum Systems 
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 2.0
 */

session_start();
$forum_version = 'XFS 2.0';

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

define('XFS', 1);
// Set Headers
ob_start();
$context = array();
// Load core files

require_once(dirname(__FILE__) . "/class.settings.php");

date_default_timezone_set($defaultz);

$ipAddress = $_SERVER['REMOTE_ADDR'];
if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
	$exploded = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
	$ipAddress = array_pop($exploded);
}

require_once($coredir . "/Mysql.php");
require_once($coredir . "/Sessions.php");
require_once($coredir . "/Members.php");
require_once($coredir . "/Modules.php");
require_once($coredir . "/Board.php");
require_once($coredir . "/Theme.php");
require_once($coredir . "/Load.php");
require_once($coredir . "/Posts.php");
require_once($srcdir . "/ui.php");

MemOnlyPages($context['currentPage']);
?>
<!DOCTYPE html>

<html>
	<head>
		<title><?php echo req_setting("forumTitle");?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $coreCssFile;?>">
		<link rel="stylesheet" type="text/css" href="<?php echo $coreCss;?>/tabs.css">
		<?php echo $theme->generateHeadCSS();?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo$coreJs;?>/tabsmin.js"></script>
		<script type="text/javascript" src="<?php echo$coreJs;?>/main.js"></script>
		<?php echo $theme->generateHeadJS();?>

		<meta http-equiv="cache-control" content="max-age=0" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="0" />
		<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
		<meta http-equiv="pragma" content="no-cache" />
	</head>
	<body class="">
		<?php 
			if($theme_info['index_file']!="Failed" && $theme_info['status']!="Failed"){
				include_once($theme->getIndexFile());
			}else{echo"<div class='msg_warn'>Failed To Load Theme</div>";};?>
		<div id="coverpage"></div>
		<div id="alertbox">
			<div class="titlebox">
				Alert Box
			</div>
			<div class="content">
				<b>Sample text</b>
				<div class="okbutton">Ok</div>
			</div>

		</div>
		<pre><?php print_r($context);?></pre>
		<pre><?php print_r($user_info);?></pre>
		<pre><?php print_r($theme->buildArray());?></pre>
	</body>
</html>
<?php

killConnection();
flush_forum();

?>