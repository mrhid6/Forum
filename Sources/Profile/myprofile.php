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
	
$usett=$user_info['settings'];
?>

<div id="collapsebox">
	<div class="titlebox">
		<img style="vertical-align:text-bottom;margin-right:5px;"src="<?php echo$coreImgs."/usericons/".GetUserIcon($user_info['settings']['userIcon'],$user_info['gender']);?>">
		<h3>My Profile</h3>
	</div>
	<div class="content">
		<div id="containerside1">
			<ul id="myprofiletabs" class="shadetabs">
				<li><a href="#" rel="country1" class="selected">Status Update</a></li>
				<li><a href="#" rel="country2">My Topics</a></li>
				<li><a href="#" rel="country3">My Blogs</a></li>
				<li><a href="#" rel="country4">Manage Friends</a></li>
				<li><a href="#" rel="country5"><span id="icon" class="gear"></span>Settings</a></li>
			</ul>


			<div id="country1" class="tabcontent">
				<?php Req_module("MPSU","misc_mods");?>
			</div>

			<div id="country2" class="tabcontent">
				<?php
					Req_module("LMEMT","misc_mods");
				?>
			</div>

			<div id="country3" class="tabcontent">
				Tab content 3 here<br />Tab content 3 here<br />
			</div>

			<div id="country4" class="tabcontent">
				<?php Req_module("MPMU","misc_mods");?>
			</div>
			<div id="country5" class="tabcontent">
				<div class="settingsbox roundall">
					<form name="form_wysiwyg" id="form_wysiwyg" action="" method="post" >
					<input type="hidden" name="profilesettings" value="1"/>
					<table width="100%" border="0" style="float:left;text-align:left;">
						<tr>
							<td height="30"colspan="3"><h3>My Settings</h3></td>
						</tr>
						<tr>
							<td width="150"><label for="displayage"><b>Display Age</b></label></td>
							<td width="40"><input name="displayage" id="displayage" <?php echo($usett['displayage']==1)?"checked":"";?> type="checkbox" value="1"class="styled"></td>
							<td rowspan="6" valign="top">
								<table width="100%" border="0" class="usericons roundall">
									<tr>
										<td height="30"colspan="6"><h4>My User Icon</h4></td>
									</tr>
									<tr>
										<td>Default</td>
										<td width="20"><img style="float:left;display:inline-block;"src="<?php echo$coreImgs."/usericons/".GetUserIcon(1,$user_info['gender']);?>"></td>
										<td width="30"><input type="radio" <?php echo($usett['userIcon']==1)?"checked":"";?> class="styled" name="usericon" value="1"/></td>
										<td>White</td>
										<td width="20"><img style="float:left;display:inline-block;"src="<?php echo$coreImgs."/usericons/".GetUserIcon(6,$user_info['gender']);?>"></td>
										<td width="30"><input type="radio" <?php echo($usett['userIcon']==6)?"checked":"";?> class="styled" name="usericon" value="6"/></td>
									</tr>
									<tr>
										<td>Black</td>
										<td><img style="float:left;display:inline-block;"src="<?php echo$coreImgs."/usericons/".GetUserIcon(2,$user_info['gender']);?>"></td>
										<td><input type="radio" class="styled" <?php echo($usett['userIcon']==2)?"checked":"";?> name="usericon" value="2"/></td>
										<td>Yellow</td>
										<td><img style="float:left;display:inline-block;"src="<?php echo$coreImgs."/usericons/".GetUserIcon(7,$user_info['gender']);?>"></td>
										<td><input type="radio" class="styled" <?php echo($usett['userIcon']==7)?"checked":"";?> name="usericon" value="7"/></td>
									</tr>
									<tr>
										<td>Grey</td>
										<td><img style="float:left;display:inline-block;"src="<?php echo$coreImgs."/usericons/".GetUserIcon(3,$user_info['gender']);?>"></td>
										<td><input type="radio" class="styled" <?php echo($usett['userIcon']==3)?"checked":"";?> name="usericon" value="3"/></td>
										<td>Medical</td>
										<td><img style="float:left;display:inline-block;"src="<?php echo$coreImgs."/usericons/".GetUserIcon(8,$user_info['gender']);?>"></td>
										<td><input type="radio" class="styled" <?php echo($usett['userIcon']==8)?"checked":"";?> name="usericon" value="8"/></td>
									</tr>
									<tr>
										<td>Green</td>
										<td><img style="float:left;display:inline-block;"src="<?php echo$coreImgs."/usericons/".GetUserIcon(4,$user_info['gender']);?>"></td>
										<td><input type="radio" class="styled" <?php echo($usett['userIcon']==4)?"checked":"";?> name="usericon" value="4"/></td>
										<td>Robber</td>
										<td><img style="float:left;display:inline-block;"src="<?php echo$coreImgs."/usericons/".GetUserIcon(9,$user_info['gender']);?>"></td>
										<td><input type="radio" class="styled" <?php echo($usett['userIcon']==9)?"checked":"";?> name="usericon" value="9"/></td>
									</tr>
									<tr>
										<td>Red</td>
										<td><img style="float:left;display:inline-block;"src="<?php echo$coreImgs."/usericons/".GetUserIcon(5,$user_info['gender']);?>"></td>
										<td><input type="radio" class="styled" <?php echo($usett['userIcon']==5)?"checked":"";?> name="usericon" value="5"/></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td><label for="displaydbay"><b>Display Birthday</b></label></td>
							<td><input name="displaydbay" id="displaydbay" <?php echo($usett['displaybirthday']==1)?"checked":"";?> type="checkbox" value="1"class="styled"></td>
						</tr>
						<tr>
							<td><label for="displaygender"><b>Display Gender</b></label></td>
							<td><input name="displaygender" id="displaygender" <?php echo($usett['displaygender']==1)?"checked":"";?> type="checkbox" value="1"class="styled"></td>
						</tr>
						<tr>
							<td><label for="displayloc"><b>Display Location</b></label></td>
							<td><input name="displayloc" id="displayloc" <?php echo($usett['displaylocation']==1)?"checked":"";?> type="checkbox" value="1"class="styled"></td>
						</tr>
						<tr>
							<td><label for="displayemail"><b>Display Email</b></label></td>
							<td><input name="displayemail" id="displayemail" <?php echo($usett['displayemail']==1)?"checked":"";?> type="checkbox" value="1"class="styled"></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="2">Signature</td>
							<td colspan="2">
								<?php Wysiswyg_cp('basic');?>
								<textarea style="display:none;"name="wysiwyg_text" id="wysiwyg_text" ></textarea>
								<iframe name="richTextField" id="richTextField" class="roundbot shadow1"></iframe>
							</td>
						</tr>
						<tr>
							<td colspan="4"><input id="inputbut"type="button" onclick="javascript:submit_form();" value="Save Settings"></td>
						</tr>
					</table>
					</form>
					<div class="clear"></div>
				</div>
				<script src="<?php echo$forumurl;?>/Core/Js/main.js"></script>
			</div>
			<div class="friendsbox roundall">
				<table width="100%">
					<tr>
						<td colspan="6" align="left"><h3>My Friends</h3></td>
					</tr>
					<tr>
					<?php echo DisplayFriends($user_info);?>
					</tr>
				</table>
			</div>
		</div>
		<div id="containerside2">
			<div class="imagebord largeimagebord">
				<img src="<?php echo $memsurl."/".GetMemDp($user_info['ID'],"large");?>">
			</div>
			
			<div class="roundtop reputation <?php echo$repcolor;?>">
				Reputation: <?php echo$user_info['reputation'];?>
			</div>
			<div class="infobox roundbot shadow1">
				<div class="title">
					<h4>My Information</h4>
				</div>
				<table width="100%" style="text-align:left;">
					<tr>
						<td width="50%"><b>Group Id:</b></td>
						<td><?php echo ucwords($user_info['group'])?></td>
					</tr>
					<tr>
						<td width="50%"><b>Profile Views:</b></td>
						<td><?php echo$user_info['profile_views'];?></td>
					</tr>
					<tr>
						<td width="50%"><b>Last Active:</b></td>
						<td><?php echo getLastActiveDisplay($user_info['last_active']);?></td>
					</tr>
					<tr>
						<td width="50%"><b>Age:</b></td>
						<td><?php echo($usett['displayage']==0)?"Unknown":convertAge(strtotime($user_info['dob_day']."-".$user_info['dob_month']."-".$user_info['dob_year']));?></td>
					</tr>
					<tr>
						<td width="50%"><b>Birthday:</b></td>
						<td>
							<?php
								$mydobtime=strtotime($user_info['dob_day']."-".$user_info['dob_month']."-".$user_info['dob_year']);
								echo ($usett['displaybirthday']==0)?"Unknown":date("M d, Y",$mydobtime);
							?>
						</td>
					</tr>
					<tr>
						<td width="50%"><b>Gender:</b></td>
						<td>
							<?php
								echo ($usett['displaygender']==0)?"Not Telling":"<span id='icon' class='".strtolower($user_info['gender'])."'></span>".$user_info['gender'];
							?>
							
						</td>
					</tr>
				</table>
			</div>
			
			<div class="infobox roundall">
				<div class="title">
					<h4>My Contact Details</h4>
				</div>
				<table width="100%" style="text-align:left;">
					<tr>
						<td width="50%"><b>Email:</b></td>
						<td>1</td>
					</tr>
					<tr>
						<td width="50%"><b>Msn:</b></td>
						<td>1</td>
					</tr>
					<tr>
						<td width="50%"><b>Website Url:</b></td>
						<td>Today</td>
					</tr>
					<tr>
						<td width="50%"><b>Yahoo:</b></td>
						<td>1</td>
					</tr>
					<tr>
						<td width="50%"><b>Facebook:</b></td>
						<td>today</td>
					</tr>
					<tr>
						<td width="50%"><b>Skype:</b></td>
						<td>Male</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
document.getElementById('richTextField').contentDocument.body.innerHTML='<?php echo$user_info['signature'];?>';
</script>