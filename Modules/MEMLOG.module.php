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

?>
<div class="module" id="memlog">
	<div class="mod_title">
		<h3><?php echo($user_info['loggedin']!=1)?"Member Login":"Member Area";?></h3>
	</div>
	<div class="mod_content">
		<?php if($user_info['loggedin']!=1){?>
			<form action="" method="post" autocomplete="off">
				<input type="hidden" name="loginRegCode" value="1">
				<input type="hidden" name="loginRegsec" value="module"/>
				<table width="100%" height="160" cellpadding="2">
					<?php if($_SESSION['error']['login']!=''){?>
						<tr>
							<td colspan="2"><div class="roundall message msg_warn"><?php echo$_SESSION['error']['login'];?></div></td>
						</tr>
						<?php unset($_SESSION['error']['login']);}?>
					<tr>
						<td><b>User Name</b></td>
						<td><input placeholder="Username" type="text" class="blacktextbox"name="userLogMod"/></td>
					</tr>
					<tr>
						<td><b>Password</b></td>
						<td><input placeholder="Password" type="password" class="blacktextbox"name="passLogMod"/></td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" id="Loginbut" class="inputbut"name="submitLogMod" Value="Login"/>
							<input type="button" onclick="window.location='<?php echo$forumurl?>/register/';"id="Registbut" class="inputbut"name="regLogMod" Value="Register"/>
						</td>
					</tr>
				</table>
			</form>
		<?php }else{?>
			<div class="profile">
				<div class="imageboard"><img src="<?php echo $memsurl."/".GetMemDp($user_info['ID'],"small");?>"></div>

				<a id="profilebutton"class="link" title="Go To Profile" href="<?php echo$forumurl;?>/profile" style="text-decoration:none;">
					<img style="vertical-align:text-bottom;margin-right:5px;"src="<?php echo$coreImgs."/usericons/".GetUserIcon($user_info['settings']['userIcon'],$user_info['gender']);?>">
					<h3><?php echo ucwords($user_info['username']);?></h3>
				</a>

				<a id="logout" class="link" title="Logout" href="<?php echo$forumurl;?>/logout" style="text-decoration:none;">
					<span id="icon" class="lock"></span>
					<h3>Logout</h3>
				</a>
			</div>
			<ul>
				<li>Last Active : <?php echo getLastActiveDisplay($user_info["last_active"]);?></li>
				<li>Friends : <?php echo count($user_info['friends']);?></li>
				<li>Total Topics : <?php echo countTopics("",$user_info['ID']);?></li>
				<li>Total Comments : <?php echo countUserComments($user_info['ID']);?></li>
			</ul>
		<?php }?>
	</div>
</div>