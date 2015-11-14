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
	

/*Set Profile Varibles*/
$ismyprofile=($user_info['username']==$context['viewingProfile'] || $context['viewingProfile']=="")?true:false;
$repcolor="";
$reputation_score=0;

if($ismyprofile==false){
	if(checkUserExists($context['viewingProfile'])==true){
		$tmp_uinfo=array();
		$tmp_uinfo=GetotherMember(turnUsernameToId($context['viewingProfile']));
		$reputation_score = $tmp_uinfo['reputation']/$tmp_uinfo['reputation_count'];
	}
}else{
	$reputation_score = $user_info['reputation']/$user_info['reputation_count'];
}

if($reputation_score == 1){
	$repcolor="greenbox";
	$reputation_text="Excellent";
}elseif($reputation_score < 1 && $reputation_score >= 0.5){
	$repcolor="yellowbox";
	$reputation_text="Neutral";
}elseif($reputation_score < 0.5 && $reputation_score >= 0.25){
	$repcolor="orangebox";
	$reputation_text="Bad";
}elseif($reputation_score < 0.25 && $reputation_score >= 0){
	$repcolor="redbox";
	$reputation_text="Awful";
}


/*Include the right file for the profile page*/
if($ismyprofile==true){
	include($srcdir."/Profile/myprofile.php");
}else{
	if(checkUserExists($context['viewingProfile'])==true){
		addprofileView_v2($tmp_uinfo['ID'], $user_info['ID']);
		include($srcdir."/Profile/viewprofile.php");
	}else{
		echo"<div class='msg_warn'>".errorcode(30)."</div>";
	}
}
?>