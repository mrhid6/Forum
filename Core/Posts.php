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
	
if($_POST['loginRegCode']==1){
	if($_POST['loginRegsec']=="other"){
		$_SESSION['error']['login']=loginfun($_POST['userLogOther'],$_POST['passLogOther']);
	}elseif($_POST['loginRegsec']=="module"){
		$_SESSION['error']['login']=loginfun($_POST['userLogMod'],$_POST['passLogMod']);
	}
}
if($_POST['addnewtopicmask']==1){
	$post=addTopic($_POST['topictitle'],$_POST['topicdesc'],$_POST['wysiwyg_text'],$context['currentBoard'],$context['currentSubboard'],$user_info['ID']);
	
	$_SESSION['error']['addtopic']=($post['result']=="error")?$post['return']:"";
	$_SESSION['suc']['addtopic']=($post['result']=="suc")?$post['return']:"";
}
if($_POST['control_settings']==1){
	$values=array($_POST['busytimeout'],$_POST['offlinetimout'],$_POST['TopPerBoard'],$_POST['RepPerTopic'],$_POST['themeselect']);
	update_control("settings",$values);
	header("location: .");
}
if($_POST['addnewsubboardmask']==1){
	$post=addSubboard($_POST['subtitle'],$_POST['subdesc'],$context['currentBoard']);
	
	$_SESSION['error']['addsubboard']=($post['result']=="error")?$post['return']:"";
	$_SESSION['suc']['addsubboard']=($post['result']=="suc")?$post['return']:"";
}

if($_POST['addnewboardmask']==1){
	$post=addBoard($_POST['title']);
	
	$_SESSION['error']['addboard']=($post['result']=="error")?$post['return']:"";
	$_SESSION['suc']['addboard']=($post['result']=="suc")?$post['return']:"";
}

if($_POST['addnewreplymask']==1){
	$post=addTopicReply($_POST['wysiwyg_text'],$context['currentTopic'],$user_info['ID']);
	
	$_SESSION['error']['addreply']=($post['result']=="error")?$post['return']:"";
	$_SESSION['suc']['addreply']=($post['result']=="suc")?$post['return']:"";
}
if($_POST['shoutSend']==1){
	$user=($user_info['loggedin'])?$user_info['ID']:0;
	$text=$conn->real_escape_string(strip_tags($_POST['shoutoutbox']));
	
	if($text!='' && $text!='Shout Out Now!' && strtolower($text)!='shout out now!'){
		$sql=$conn->query("INSERT INTO ".$db_prefix."shouts SET User='".$user."', Shout='".$text."', dateadded='".date("Y-m-d H:i:s",time())."'");
		if($sql){
			$_SESSION['suc']['shout']="Success The Shout Has Been Added";
		}else{
			$_SESSION['error']['shout']=errorcode(23);
		}
	}else{
		$_SESSION['error']['shout']=errorcode(22);
	}
}
if($_POST['registerpost_ent']==1){
	$post=registeruser($_POST['reg_username'],$_POST['reg_password'],$_POST['reg_passwordconfirm'],$_POST['reg_email'],$_POST['reg_emailconfirm']
	,$_POST['reg_title'],$_POST['reg_firstname'],$_POST['reg_lastname'],$_POST['reg_middlename'],$_POST['reg_gender'],$_POST['reg_dobday']
	,$_POST['reg_dobmonth'],$_POST['reg_dobyear'],$_POST['reg_country'],$_POST['reg_sectextent']);
	
	$_SESSION['inputs']['register']=($post['result']=="error")?$post['inputs']:"";
	$_SESSION['error']['register']=($post['result']=="error")?$post['return']:"";
	$_SESSION['suc']['register']=($post['result']=="suc")?$post['return']:"";
}
if($_POST['profileupdate']!=''){
	switch($_POST['profileupdate']){
		case"mystatus":
			$_SESSION['profileupdate']=statusupdate($_POST['profileupdate_id'],$_POST['statusupdate']);
		break;
	}
}
if($_POST['profilesettings']!=''){
	$post=PostProfileSettings($_POST['usericon'],$_POST['displayage'],$_POST['displaydbay'],$_POST['displaygender'],$_POST['displayloc'],$_POST['displayemail'],$_POST['wysiwyg_text']);
	loadMember();
}
if($context['currentPage']=="logout"){
	deleteOnlineuser($user_info['ID']);
	session_destroy();
	$user_info=null;
}
function flush_headers(){
	unset($_POST,$_GET,$_REQUEST);
}
?>