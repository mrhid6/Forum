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
function resetSessions(){
	global $db_prefix,$context,$user_info, $conn;
	$sql2=$conn->query("UPDATE ".$db_prefix."member_online SET status='2' WHERE timeonline < '".date("Y-m-d H:i:s",time())."' - INTERVAL ".$context['Forum_settings']['busytimeout']." MINUTE");
	$sql2=$conn->query("DELETE FROM ".$db_prefix."member_online WHERE timeonline < '".date("Y-m-d H:i:s",time())."' - INTERVAL ".$context['Forum_settings']['offlinetimeout']." MINUTE");
}
function updateSession(){
	global $db_prefix,$user_info, $conn;
	$sql=$conn->query("UPDATE ".$db_prefix."member_online SET timeonline='".date("Y-m-d H:i:s",time())."', status='1' WHERE userid='".$user_info['ID']."'");
}
function deleteOnlineuser($userid){
	global $db_prefix,$user_info, $conn;
	$sql=$conn->query("DELETE FROM ".$db_prefix."member_online WHERE userid='".$userid."'");
}
function createSessionID() {
	$password=genpassword(4);
	$password.=genpassword(4);
	$password.=genpassword(4);
	$password.=genpassword(4);

	return sha1($password);
}
function genpassword($length=20, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	$numbers="123456789";
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		$choice=rand(1,3);
		if($choice==1){
			$password.=$consonants[(rand(1,2000000) % strlen($consonants))];
		}elseif($choice==2){
			$password.=$vowels[(rand(1,2000000) % strlen($vowels))];
		}elseif($choice==3){
			$password.=$numbers[(rand(1,2000000) % strlen($numbers))];
		}
	}
	$password=mixpassword($password);
	return $password;
}
function mixpassword($pass){
	return str_shuffle($pass);
}
function startMemSession($userid){
	global $db_prefix,$user_info, $conn;
	$sql1=$conn->query("SELECT * FROM ".$db_prefix."member_online WHERE userid='".$userid."'");
	if($sql1->num_rows > 0){
		$row=$sql1->fetch_assoc();
		$sesid=$row['sessionid'];
	}else{
		$sesid=createSessionID();
		$sql=$conn->query("INSERT INTO ".$db_prefix."member_online SET
		userid='".$userid."',
		timeonline='".date("Y-m-d H:i:s",time())."',
		sessionid='".$sesid."'");
	}
	return$sesid;
}
?>