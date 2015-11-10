<?php
/**
 * Xorbo Forum Systems 
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 2.0
 */

// Start Forum!
if (!defined('XFS'))
	die('Hacking attempt...');
	

function loadModules($task){
	global $context,$db_prefix, $conn;
	switch($task){
		case"sidebar":
			$sql=$conn->query("SELECT `filename`,`code` FROM ".$db_prefix."modules WHERE enabled='1' AND task='0' ORDER BY `order` ASC");
			if($sql->num_rows > 0){
				while($res=$sql->fetch_assoc()){
					$context["sidebar_mods"][$res['code']]=array();
					$context["sidebar_mods"][$res['code']]['file']=$res['filename'];
					$context["sidebar_mods"][$res['code']]['shown']=0;
				}
			}
		break;
		case"misc":
			$sql=$conn->query("SELECT `filename`,`code` FROM ".$db_prefix."modules WHERE enabled='1' AND task='1' ORDER BY `order` ASC");
			if($sql->num_rows > 0){
				while($res=$sql->fetch_assoc()){
					$context["misc_mods"][$res['code']]=array();
					$context["misc_mods"][$res['code']]['file']=$res['filename'];
					$context["misc_mods"][$res['code']]['shown']=0;
				}
			}
		break;
		default:
			$sql=$conn->query("SELECT `filename`,`code` FROM ".$db_prefix."modules WHERE enabled='1' ORDER BY `order` ASC");
			if($sql->num_rows > 0){
				while($res=$sql->fetch_assoc()){
					$context["all_mods"][$res['code']]=$res['filename'];
				}
			}
		break;
	}
	return false;
}
function Req_module($code,$section){
	global $context, $modsdir, $db_prefix, $user_info, $coreImgs,$forumurl,$memsurl,$tmp_uinfo, $conn;
	if($context[$section][$code]['shown']==0){
		include($modsdir."/".$context[$section][$code]['file']);
		$context[$section][$code]['shown']=1;
	}
}

function Wysiswyg_cp($style){
	$style=strtolower($style);
	global $modsdir,$context;
	require_once($modsdir."/wysiwyg/cp_".$style.".php");
}

function Wysiwyg_Js(){
	global $context,$coreJs;
	if(in_array($context['currentPage'],$context['wysiwyg_pages'])){
		return'<script type="text/javascript" src="'.$coreJs.'/wysiwyg.js">'."</script>\n";
	}else{
		return"";
	}
}

?>