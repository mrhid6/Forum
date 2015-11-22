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


$user_info=array();

include($coredir . "/Friend.php");

function loadMember(){
	global $user_info;
	$user_info['sessionid']=getSessionID($_SESSION['UserSessionid']);
	$user_info['loggedin']=(int)checkIfLogged();
	if($user_info['loggedin']==1){
		$user_info=array_merge($user_info,(array)getUserData());
		refreshLastActive();
	}
	return false;
}
function getSessionID($sessionid){
	global $db_prefix,$user_info, $conn;
	$sql=$conn->query("SELECT sessionid FROM ".$db_prefix."member_online WHERE sessionid='".$sessionid."'");
	if($sql->num_rows==1){
		$row=$sql->fetch_assoc();
		return$row['sessionid'];
	}elseif($sessionid!=''){
		logoutUser("Due To Inactivity");
	}
}

function logoutUser($reason="normal"){
	if($reason != "normal"){
		$_SESSION['forcelogout']['reason']=$reason;
	}
	unset($_SESSION['UserSessionid']);
}

function refreshLastActive(){
	global $db_prefix, $user_info, $conn;
	$conn->query("UPDATE ".$db_prefix."members SET last_active=".time()." WHERE ID='".$user_info['ID']."'");
}
function countUserComments($user){
	global $db_prefix, $conn;
	$sql=$conn->query("SELECT * FROM ".$db_prefix."member_profilecoms WHERE to_user='".$user."'");
	return $sql->num_rows;
}


function convertAge($iTimestamp){
	// See http://php.net/date for what the first arguments mean. 
	$iDiffYear  = date('Y') - date('Y', $iTimestamp);
	$iDiffMonth = date('n') - date('n', $iTimestamp);
	$iDiffDay   = date('j') - date('j', $iTimestamp);

	// If birthday has not happen yet for this year, subtract 1.
	if ($iDiffMonth < 0 || ($iDiffMonth == 0 && $iDiffDay < 0))
	{
		$iDiffYear--;
	}

	return $iDiffYear;
}
function getUserFriends($friends){

	$res=array();

	foreach(explode("+",$friends) as $friend){
		if($friend != '')
			$res[]=$friend;
	}

	return $res;
}
function getUserSettings($setid){
	global $db_prefix, $conn;
	$sql=$conn->query("SELECT * FROM ".$db_prefix."member_settings WHERE ID='".$setid."'");
	if($sql->num_rows==1){
		return $sql->fetch_assoc();
	}else{
		return(array)"Error";
	}
}
function getOnlineMemStatus($userid){
	global $db_prefix, $conn;
	$sql=$conn->query("SELECT * FROM ".$db_prefix."member_online WHERE userid='".$userid."'");
	if($sql->num_rows==1){
		$res=$sql->fetch_assoc();
		return $res['status'];
	}else{
		return 0;
	}
}
function getUserGroup($groupid){
	global $db_prefix, $conn;
	$sql=$conn->query("SELECT * FROM ".$db_prefix."groups WHERE ID='".$groupid."'");
	if($sql->num_rows == 1){
		$row=$sql->fetch_assoc();
		return $row;
	}else{
		return(array)"Error";
	}
}
function PostProfileSettings($usericon,$dage,$dbday,$dgender,$dloc,$demail,$sig){
	global $db_prefix,$user_info, $conn;
	$conn->query("DELETE FROM ".$db_prefix."member_settings WHERE ID='".$user_info['setting_id']."'");
	$conn->query("INSERT INTO ".$db_prefix."member_settings SET
	userIcon='".$usericon."',
	displayage='".$dage."',
	displaybirthday='".$dbday."',
	displaygender='".$dgender."',
	displaylocation='".$dloc."',
	displayemail='".$demail."'
	");
	$newsetid=$conn->insert_id;
	$conn->query("UPDATE ".$db_prefix."members SET setting_id='".$newsetid."', signature='".$sig."' WHERE ID='".$user_info['ID']."'");

}

function checkUserExists($username){
	global $db_prefix, $conn;
	$sql=$conn->query("SELECT * FROM ".$db_prefix."members WHERE username='".$username."'");
	if($sql->num_rows == 1){
		return True;
	}else{
		return false;
	}
}

function addProfileView($profile_id, $user_id){
	global $db_prefix, $conn;
	if(!isset($profile_id) ||$profile_id==0) {
		return;
	}

	if(shouldAddProfileView($profile_id, $user_id)){
		$conn->query("INSERT INTO ".$db_prefix."profile_views SET user_id='".$user_id."', profile_id='".$profile_id."'");
	}
}

function shouldAddProfileView($profile_id, $user_id){
	global $db_prefix, $conn;

	if(!isset($user_id) || $user_id==0) {
		return true;
	}

	$sql = $conn->query("SELECT * FROM ".$db_prefix."profile_views WHERE user_id='".$user_id."' AND profile_id='".$profile_id."' AND date_viewed > NOW() - INTERVAL 10 MINUTE");

	return ($sql->num_rows == 0);
}

function getProfileViews($profile_id){
	global $conn, $db_prefix;
	$sql=$conn->query("SELECT * FROM ".$db_prefix."profile_views WHERE profile_id='".$profile_id."'");

	return $sql->num_rows;
}

function checkIfLogged(){
	global $user_info;
	if(isset($_SESSION['loggedUser'])){
		if($user_info['sessionid']!=''){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
function getUserData(){
	global $db_prefix, $conn;
	$sql=$conn->query("SELECT * FROM ".$db_prefix."members");
	if($sql->num_rows > 0){
		while($res=$sql->fetch_assoc()){
			if(md5($res['username']."_".$res['ID'])==$_SESSION['loggedUser']){
				$res['group']=getUserGroup($res['groupid']);
				$res['settings']=getUsersettings($res['setting_id']);
				$res['friends']=getUserFriends($res['friend_array']);
				unset($res['friend_array'],$res['password'],$res['AuthCode']);
				return$res;
			}
		}
	}else{
		return"Error";
	}
}
function countMembers(){
	global $db_prefix, $conn;
	$sql = $conn->query("SELECT * FROM ".$db_prefix."members");
	return $sql->num_rows;
}
function DisplayFriends($data){
	global $forumurl;
	$fricount=count($data['friends']);
	if($fricount>0){
		$fris=$data['friends'];
		$count=6;
		for($i=0; $i<$count; $i++){
			if(isset($fris[$i]) && $fris[$i]!=''){
				$userimage=GetMemDp($fris[$i],"small");
				$frienddata=getMemberData($fris[$i]);
				$friends.="<td width='16%'><div class='imagebord'><a href='".$forumurl."/profile/".$frienddata['username']."'><img src='".$forumurl."/Members/".$userimage."' title='".ucwords($frienddata['username'])."'></a></div></td>";
			}else{
				$friends.="<td width='16%'></td>";
			}
		}
		return $friends;
	}
}
function getMemberData($id, $data=""){
	global $db_prefix, $conn;
	$sql=$conn->query("SELECT * FROM ".$db_prefix."members WHERE ID='".$id."'");
	if($sql->num_rows == 1){
		$res=$sql->fetch_assoc();
		$res['online']=(int)getOnlineMemStatus($res['ID']);
		$res['group']=getUserGroup($res['groupid']);
		$res['settings']=getUsersettings($res['setting_id']);
		$res['friends']=getUserFriends($res['friend_array']);

		unset($res['friend_array'],$res['password'],$res['AuthCode']);

		if($data!=''){
			return $res[$data];
		}else{
			return $res;
		}
	}else{
		return"Error";
	}
}
function turnUsernameToId($uname){
	global $db_prefix, $conn;
	$uname=UnInjection($uname);
	$sql=$conn->query("SELECT * FROM ".$db_prefix."members WHERE username='".$uname."'");
	if($sql->num_rows == 1){
		$res=$sql->fetch_assoc();
		return$res['ID'];
	}else{
		return"Error";
	}

}
function statusupdate($userid,$status){
	global $user_info, $db_prefix, $conn;
	$res=array();
	$status=Uninjection(strtolower($status));
	$startstring=Uninjection(strtolower("Whats On Your Mind?"));
	if($userid==$user_info['ID'] || $user_info['loggedin']==1){
		if($status!='' && $status!=$startstring){
			$sql=$conn->query("INSERT INTO ".$db_prefix."member_statups SET
			userid='".$userid."',
			date_entered='".date("Y-m-d H:i:s",time())."',
			status='".$status."'
			");
			if($sql){
				$res['suc']="Success The Status Has Been Posted";
			}
		}else{
			$res['error']=errorcode(28);
		}
	}else{
		$res['error']=errorcode(29);
	}
	return$res;
}
function loginfun($username,$password){
	global $db_prefix, $conn, $ipAddress;
	$username=UnInjection($username);
	$password=UnInjection($password);
	if($username!='' && $password!=''){
		$encryptpass=md5(SHA1($username.":".$password));
		$sql=$conn->query("SELECT * FROM ".$db_prefix."members WHERE username='".$username."' AND password='".$encryptpass."'");
		if($sql->num_rows == 1){
			$conn->query("UPDATE ".$db_prefix."members SET lastlogin='".time()."', ipAddy='".$ipAddress."'");
			$row=$sql->fetch_assoc();
			$conn->query("DELETE FROM ".$db_prefix."member_online WHERE userid='".$row['ID']."'");
			if($row['Active']==1){
				$_SESSION['loggedUser']=md5($username."_".$row['ID']);
				$_SESSION['UserSessionid']=startMemSession($row['ID']);
				loadMember();

			}else{
				return errorcode(10);
			}
		}else{
			return errorcode("2");
		}
	}else{
		return errorcode("1");
	}
}

function registeruser($username,$password,$password2,$email,$email2,$title,$fname,$lname,$mname,$gender,$dobday,$dobmon,$dobyear,$country,$secimage){
	global $db_prefix, $adminemail, $forumurl, $conn;

	$username=UnInjection($username);
	$password=UnInjection($password);
	$password2=UnInjection($password2);
	$email=UnInjection($email);
	$email2=UnInjection($email2);
	$fname=UnInjection($fname);
	$lname=UnInjection($lname);
	$mname=UnInjection($mname);

	if($username!='' && $password!='' && $password2!='' && $email!='' && $email2!='' && $title!='' && $fname!='' && $lname!='' && $gender!='' && $dobday!='' && $dobmon!='' && $dobyear!='' && $country!='' && $secimage!=''){
		if($password==$password2){
			if($email==$email2){
				if($secimage == $_SESSION['security_code']){

					$usercheck_res=$conn->query("SELECT username FROM ".$db_prefix."members WHERE username='".$username."'");
					$usercheck=$usercheck_res->num_rows;

					$emailcheck_res=$conn->query("SELECT email FROM ".$db_prefix."members WHERE email='".$email."'");
					$emailcheck=$emailcheck_res->num_rows;

					if($usercheck==0){
						if($emailcheck==0){
							$encryptpass=md5(SHA1($username.":".$password));
							$authcode=rand(0,str_replace(".","",$_SERVER["REMOTE_ADDR"]));
							$sqlinsert=$conn->query("INSERT INTO ".$db_prefix."members
								SET
								username='".$username."',
								password='".$encryptpass."',
								email='".$email."',
								title='".$title."',
								firstname='".$fname."',
								middlename='".$mname."',
								lastname='".$lname."',
								gender='".$gender."',
								dob_day='".$dobday."',
								dob_month='".$dobmon."',
								dob_year='".$dobyear."',
								country='".$country."',
								ipAddy='".$_SERVER["REMOTE_ADDR"]."',
								AuthCode='".md5(time().$authcode)."',
								registered_date='".time()."'
								");
							$insertnum=$conn->insert_id;
							if($sqlinsert){
								// Send Email To New User
								$to=$email;
								$subject="Welcome To ".req_setting("forumTitle");
								$adminemail='"'.req_setting("forumTitle").'"<'.$adminemail.'>';
								$message="Welcome ".$fname." ".$lname.",
Click the link below to activate your account when ready
".$forumurl."/activation/".$insertnum."/".md5($authcode)."/
Once Activated Login Using Your Credentials:
User Name: ".$username."
Password: ".$password;
								if( mail($to, $subject,$message, "From:" . $adminemail)){
									$res['result']="suc";
									$res['return']="Success Your Account Was Registered Please Check Your Email To Activate Your Account";
								}else{
									$res['result']="suc";
									$res['return']="Success Your Account Was Registered But The Email Was Not Send Please Contact An Admin";
								}
							}else{
								$res['result']="error";
								$res['return']=errorcode(9);
							}
						}else{
							$res['result']="error";
							$res['return']=errorcode(8);
						}
					}else{
						$res['result']="error";
						$res['return']=errorcode(7);
					}
				}else{
					$res['result']="error";
					$res['return']=errorcode(6);
				}
			}else{
				$res['result']="error";
				$res['return']=errorcode(5);
			}
		}else{
			$res['result']="error";
			$res['return']=errorcode(4);
		}
	}else{
		$res['return']=errorcode(3);
		if($username==""){
			$res['result']="error";
			$res['inputs']['username']=1;
		}
		if($password==""){
			$res['result']="error";
			$res['inputs']['password']=1;
		}
		if($password2==""){
			$res['result']="error";
			$res['inputs']['password2']=1;
		}
		if($email==""){
			$res['result']="error";
			$res['inputs']['email']=1;
		}
		if($email2==""){
			$res['result']="error";
			$res['inputs']['email2']=1;
		}
		if($title==""){
			$res['result']="error";
			$res['inputs']['title']=1;
		}
		if($fname==""){
			$res['result']="error";
			$res['inputs']['fname']=1;
		}
		if($lname==""){
			$res['result']="error";
			$res['inputs']['lname']=1;
		}
		if($gender==""){
			$res['result']="error";
			$res['inputs']['gender']=1;
		}
		if($dobday=='' || $dobmon=='' || $dobyear!=''){
			$res['result']="error";
			$res['inputs']['dob']=1;
		}
		if($country==""){
			$res['result']="error";
			$res['inputs']['country']=1;
		}
		if($secimage==""){
			$res['result']="error";
			$res['inputs']['secimage']=1;
		}
	}

	return($res);
}
function GetMemDp($memid,$size="org"){
	$userdata=getMemberData($memid);
	if($userdata['profileimage']=="default.png"){
		$userimg="default.png";
	}else{
		switch($size){
			case"large":$userimg=$memid."/thumbs/large/thumb_".$userdata['profileimage'];break;
			case"med":$userimg=$memid."/thumbs/med/thumb_".$userdata['profileimage'];break;
			case"small":$userimg=$memid."/thumbs/small/thumb_".$userdata['profileimage'];break;

			default:$userimg=$memid."/".$userdata['profileimage'];break;
		}
	}

	return$userimg;
}
?>