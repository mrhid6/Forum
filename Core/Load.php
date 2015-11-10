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

loadDatabase();
loadContext();
resetSessions();
loadTheme();
loadMember();
loadModules("sidebar");
loadModules("misc");
updateSession();

$theme = new Theme();

############# Set Defines ##############

############# Make Functions ##############
function loadContext(){
	global $context,$forumVersion;
	$context["forumVersion"] = $forumVersion;
	$context["currentPage"] = GCP($_GET['page']);
	$context["currentBoard"] = (int)Uninjection($_GET['boardid']);
	$context["currentSubboard"] = (int)Uninjection($_GET['subboardid']);
	$context["currentTopic"] = (int)Uninjection($_GET['topicid']);
	$context["currentBlog"] = (int)Uninjection($_GET['blogid']);
	$context["currentPageNum"] = (int)Uninjection($_GET['pagenum']);
	$context['viewingProfile']=Uninjection($_GET['viewprofile']);
	$context["wysiwyg_pages"]=array("addtopic","addblog","replytopic","profile");
	$context["showsidebar_pages"]=array("addtopic","addblog","replytopic","profile","control","board","topic");
	$context["showsidebar"]=(int)(!in_array($context["currentPage"],$context["showsidebar_pages"]))?1:0;
	
	$context["Forum_settings"]=get_settings();
}
function loadTheme(){

}
function loadPage(){
	global $context,$user_info,$theme_info,$db_prefix, $conn;
	global $srcdir,$pagedir,$coreImgs,$forumurl,$memsdir,$memsurl;
	global $TopicsPerPage,$TopicReplyPerPage;
	if(file_exists($pagedir."/".$context["currentPage"].".php")){
		include_once($pagedir."/".$context["currentPage"].".php");
	}else{
		echo "<div class='msg_warn'>".errorcode(11)."</div>";
	}
}
function listAllThemes(){
	global $themedir, $db_prefix, $theme_info, $forumurl,$context;
	$filters=array("images");
	$res=getDirectoryTree($themedir,$filters);
	
	foreach($res as $reskey=>$resitem){
		if(isset($resitem['config.ini'])){
			$res[$reskey]['config']=parse_ini_file($themedir."/".$reskey."/config.ini");
		}
	}
	
	return $res;
}
function displaySelectThemes($currenttheme,$themelist){
	$res.="<select class='styled' name='themeselect'>";
	$res.="<option value=''>Theme</option>";
	foreach($themelist as $reskey=>$resitem){
		$selected=($reskey==$currenttheme)?"selected":"";
		$res.="<option ".$selected." value='".$reskey."'>".$resitem['config']['themename']."</option>";
	}
	$res.="</select>";
	
	return$res;
}

function getDirectoryTree( $outerDir, $filters = array() ){ 
		$dirs = array_diff( scandir( $outerDir ), array_merge( Array( ".", ".." ), $filters ) ); 
		$dir_array = Array(); 
		foreach( $dirs as $d )
			$dir_array[ $d ] = is_dir($outerDir."/".$d) ? getDirectoryTree( $outerDir."/".$d, $filters ) : $dir_array[ $d ] = $d; 
		return $dir_array; 
	}
function round_to_half($num)
{
  if($num >= ($half = ($ceil = ceil($num))- 0.5) + 0.25) return $ceil;
  else if($num < $half - 0.25) return floor($num);
  else return $half;
}
function checkTheFile($location){
	if(!file_exists($location)){
		return false;
	}else{
		return true;
	}
}
function req_setting($var){
	global $db_prefix, $conn;
	$sql=$conn->query("SELECT value FROM ".$db_prefix."settings WHERE setting='".$var."'");
	$res=$sql->fetch_assoc();
	
	return$res['value'];
}
function get_settings(){
	global $db_prefix, $conn;
	$sql=$conn->query("SELECT * FROM ".$db_prefix."settings ");
	while($res=$sql->fetch_assoc()){
		$newres[$res['setting']]=$res['value'];
	}
	
	return$newres;
}
function flush_forum(){ 
    ob_end_flush();
    ob_flush(); 
    flush();
	flush_headers();
} 
function GCP($var){
	global $user_info,$basedir;
	$var=strtolower($var);
	if($var==''){
		return"home";
	}else{
		$pagesalowed=array(
		"home","logout","register",
		"board","topic","addtopic","addsubboard","addboard","replytopic",
		"profile","control",
		"blogs","register");
		
		if(in_array($var,$pagesalowed)){
			return $var;
		}else{
			return "error";
		}
	}
}
function compareForumVersions($forumversion,$exturnalversion,$returncode=false){

	$XorbVersion=explode(".",$exturnalversion);
	$myversion=explode(".",$forumversion);
	$versions=array("thisforum"=>array(),"xorbforum"=>array());
	
	$versions['thisforum']['major']=	$myversion[0];
	$versions['thisforum']['build']=	$myversion[1];
	$versions['thisforum']['minor']=	$myversion[2];
	
	$versions['xorbforum']['major']=	$XorbVersion[0];
	$versions['xorbforum']['build']=	$XorbVersion[1];
	$versions['xorbforum']['minor']=	$XorbVersion[2];
	
	$minor=0;
	$build=0;
	$major=0;
	
	if($versions['thisforum']['minor']== $versions['xorbforum']['minor']){
		$minor=true;
	}
	if($versions['thisforum']['build']== $versions['xorbforum']['build']){
		$build=true;
	}
	if($versions['thisforum']['major']== $versions['xorbforum']['major']){
		$major=true;
	}
	if($returncode==true){return$major."-".$build."-".$minor;}else{return$XorbVersion_orl;}
}
function decodeForumVersions($code){
	$explode=explode("-",$code);
	
if($explode[0]==0){
		return"<div class='msg_warn'>".errorcode(33)."</div>";
	}
	if($explode[1]==0){
		return"<div class='msg_warn'>".errorcode(32)."</div>";
	}
	if($explode[2]==0){
		return"<div class='msg_warn'>".errorcode(31)."</div>";
	}
	return"<div class='msg_suc'>Up To Date</div>";
}

function update_control($task,$values){
	global $db_prefix, $conn;
	switch($task){
		case"settings":
			$conn->query("UPDATE ".$db_prefix."settings SET value='".$values[0]."' WHERE setting='busytimeout'");
			$conn->query("UPDATE ".$db_prefix."settings SET value='".$values[1]."' WHERE setting='offlinetimeout'");
			$conn->query("UPDATE ".$db_prefix."settings SET value='".$values[2]."' WHERE setting='topicpagelim'");
			$conn->query("UPDATE ".$db_prefix."settings SET value='".$values[3]."' WHERE setting='topicreplypagelim'");
			$conn->query("UPDATE ".$db_prefix."settings SET value='".$values[4]."' WHERE setting='currentTheme'");
		break;
	}
}
function control_displaymembers(){
	global $db_prefix,$coreImgs, $conn;
	$sql=$conn->query("SELECT * FROM ".$db_prefix."members");
	if($sql->num_rows>0){
		while($row=$sql->fetch_assoc()){
			$userdata=GetotherMember($row['ID']);
			if($userdata['accesslvl']==1){$acclvltitle="Admin";}
			if($userdata['accesslvl']==2){$acclvltitle="Moderator";}
			if($userdata['accesslvl']==3){$acclvltitle="Member";}
			$res.="<tr height='25'>";
			$res.="<td style='text-align:center;'><img style='vertical-align:text-bottom;margin-right:5px;'src='".$coreImgs."/usericons/".GetUserIcon($userdata['settings']['userIcon'],$userdata['gender'])."'></td>";
			$res.="<td style='text-align:center;'>".$userdata['ID']."</td>";
			$res.="<td style='text-align:left;font-weight:bold;'>".ucwords($userdata['username'])."</td>";
			$res.="<td style='text-align:center;'><span id='icon' title='".$acclvltitle."' class='crown".$userdata['accesslvl']."'></span></td>";
			$res.="<td style='text-align:center;'><span id='icon' class='onlinestatus".$userdata['online']."'></span></td>";
			
			$res.="<td style='text-align:left;'>";
			$res.="<span title='Flag User' id='icon' class='flag_black'></span>";
			$res.="<a onclick='logoutuser(".$userdata['ID'].")'><span title='Logout User' id='icon' class='keyminus'></span>";
			$res.="</td>";
			
			$res.="</tr>";
		}
		return$res;
	}
}
function control_displayboards(){
	global $db_prefix,$coreImgs, $conn;
	$sql=$conn->query("SELECT * FROM ".$db_prefix."board");
	if($sql->num_rows>0){
		while($row=$sql->fetch_assoc()){
			$memonly=($row['memonly']==1)?"tick":"cross";
			$res.="<tr height='25'>";
			
			$res.="<td style='text-align:center;'>".$row['ID']."</td>";
			$res.="<td style='text-align:left;font-weight:bold;'>".ucwords($row['name'])."</td>";
			$res.="<td style='text-align:center;'><span id='icon' title='".$acclvltitle."' class='".$memonly."'></span></td>";
			$res.="<td style='text-align:center;'></td>";
			
			$res.="</tr>";
		}
		return$res;
	}
}

?>