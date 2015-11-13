<?php
define('XFS', 1);
require_once("class.settings.php");
require_once($coredir . "/Mysql.php");
require_once($coredir . "/Sessions.php");
require_once($coredir . "/Members.php");
require_once($coredir . "/Modules.php");
require_once($coredir . "/Board.php");
require_once($coredir . "/Load.php");
require_once($coredir . "/Posts.php");
require_once($srcdir . "/ui.php");

if((UnInjection($_GET['id']))!='' && (UnInjection($_GET['code']))!=''){
	
	$id=UnInjection($_GET['id']);
	$code=UnInjection($_GET['code']);
	$user=UnInjection($_POST['act_username']);
	$pass=UnInjection($_POST['act_password']);
	
	if($_POST['act_submit']==1){
		if($user!='' && $pass!=''){
			$encryptpass=md5(SHA1($user.":".$pass));
			$sql=$conn->query("SELECT * FROM ".$db_prefix."members WHERE username='".$user."' AND password='".$encryptpass."'");
			
			if($sql->num_rows > 0){
				$row=$sql->fetch_assoc();
				
				if($row['ID']==$id && $row['AuthCode']==$code){
					$sql2=$conn->query("SELECT * FROM ".$db_prefix."members WHERE ID='".$id."' AND Active='0'");
					if($sql2->num_rows == 1){
					
						$sqlinsert=$conn->query("INSERT INTO ".$db_prefix."member_settings SET displaygender='1'");
						$insertid=$conn->insert_id();
						$sqlupdate=$conn->_query("UPDATE ".$db_prefix."members SET Active='1',setting_id='".$insertid."',groupid='3' WHERE ID='".$id."'");
						
						if($sqlupdate && $sqlinsert){
							$display="<div class='msg_suc'>Activation Success Welcome To The Site!</div>";
						}
					}else{
						$display="<div class='msg_warn'>That Account Has Already Been Activated</div>";
					}
				}else{
					$display="<div class='msg_warn'>Id And Authorization Code Does Not Match Entered User Name And Password</div>";
				}
			}else{
				$display="<div class='msg_warn'>User Was Not Found!</div>";
			}
		}else{
			$display="<div class='msg_warn'>Please Enter All Fields!</div>";
		}
	}
	
}else{
	if(UnInjection($_GET['id'])==''){
		$display="<div class='msg_warn'>There Was No Id Found In Url</div><br/>";
	}
	if(UnInjection($_GET['code'])==''){
		$display.="<div class='msg_warn'>There Was No Code Found In Url</div>";
	}
	
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo req_setting("forumTitle");?> - Activation</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $coreCssFile;?>">
		<link rel="stylesheet" type="text/css" href="<?php echo $coreCss;?>/tabs.css">
		<!--[if lte IE 8]>
		<?php if($theme_info['ieresets']=='Active'){?><link rel="stylesheet" type="text/css" href="<?php echo $theme_info['css_ie'];?>"><?php }?>
		<![endif]-->
		<link rel="stylesheet" type="text/css" href="<?php echo $theme_info['css_file'];?>">
		<style>
			table th{
				padding:0px 5px;
				text-align:left;
			}
			table td{
				padding:5px;
			}
		</style>
	</head>
	<body>
		<img src="<?php echo GetSiteLogo();?>"/>
		<div id="collapsebox" style="width:60%;margin:10px;">
			<div class="titlebox" style="margin:0;">
				<h3>Account Activation</h3>
			</div>
			<div class="content" style="margin:0;">
				<?php if($display!=''){echo$display;}?>
				<form action="" method="post" autocomplete="off">
					<input type="hidden" name="act_submit" value="1"/>
					<table width="100%">
						<tr>
							<th colspan="2" height="30"><h4>Please Fill In Your User Name And Password To Activate Your Account</h4></th>
						</tr>
						<tr>
							<td><label for="act_username">User Name:</label></td>
							<td><input type="text" id="act_username"name="act_username"class="blacktextbox" style="width:200px;"></td>
						</tr>
						<tr>
							<td><label for="act_password">Password:</label></td>
							<td><input type="password" id="act_password"name="act_password"class="blacktextbox" style="width:200px;"></td>
						</tr>
						<tr>
							<th colspan="2" height="30"><input type="submit" value="Activate Account" class="inputbut"></th>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</body>