<?php
/**
 * Xorbo Forum Systems
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 3.0
 */

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

define('XFS', 1);

$currentDirectory=(dirname(__FILE__));

include($currentDirectory . "/class.settings.php");
$_settings = new Settings();

include($_settings->getBaseDirectory()."/functions.php");
include($_settings->getFolderLocation("BackCoreDir")."/class.main.php");

$_main = new Main();
$theme = $_main->getTheme();
?>
<!DOCTYPE html>

<html>
<head>
    <title><?php echo $_settings->getForumTitle();?></title>
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
<body>

</body>

</html>