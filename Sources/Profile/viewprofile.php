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
	
$usett=$tmp_uinfo['settings'];
?>
<div id="collapsebox">
		<div class="titlebox">
		<img style="vertical-align:text-bottom;margin-right:5px;"src="<?php echo$coreImgs."/usericons/".GetUserIcon($tmp_uinfo['settings']['userIcon'],$tmp_uinfo['gender']);?>">
		<h3><?php echo ucwords($tmp_uinfo['username']);?>'s Profile</h3>
		<span id="icon" class="onlinestatus<?php echo$tmp_uinfo['online'];?>" style="float:right;margin:6px 3px 0px 0px;"></span>
	</div>
	<div class="content">	
		<div id="containerside1">
			<ul id="viewprofiletabs" class="shadetabs">
				<li><a href="#" rel="country1" class="selected">Status Updates</a></li>
				<li><a href="#" rel="country2">My Topics</a></li>
				<li><a href="#" rel="country3">My Blogs</a></li>
				<li><a href="#" rel="country4">About Me</a></li>
			</ul>


			<div id="country1" class="tabcontent">
				<?php Req_module("VPSU","misc_mods");?>
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
				Tab content 4 here<br />Tab content 4 here<br />
				Tab content 4 here<br />Tab content 4 here<br />
			</div>
			<div class="friendsbox roundall">
				<table width="100%">
					<tr>
						<td colspan="6" align="left"><h3>My Friends</h3></td>
					</tr>
					<tr>
					<?php echo DisplayFriends($tmp_uinfo);?>
					</tr>
				</table>
			</div>
		</div>
		<div id="containerside2">
			<div class="imagebord largeimagebord">
				<img src="<?php echo $memsurl."/".GetMemDp($tmp_uinfo['ID'],"large");?>">
			</div>
			<br/>
			<?php if($user_info['loggedin']==1){?>
				<div style="margin:5px 0px;">
				<?php if(in_array($tmp_uinfo['ID'],$user_info['friends'])){?>
					<a title="Remove Friend"class="roundall topic_addfri" onclick="javascript:addfriend('<?php echo$user_info['ID']?>','<?php echo$tmp_uinfo['ID']?>','remove');">
						<span id="icon" class="removeuser"></span>
					</a>
				<?php }else{?>
					<a title="Add Friend"class="roundall topic_addfri" onclick="javascript:addfriend('<?php echo$user_info['ID']?>','<?php echo$tmp_uinfo['ID']?>','add');">
						<span id="icon" class="adduser"></span>
					</a>
				<?php }?>
				</div>
			<?php }?>
			
			<div class="roundtop reputation <?php echo$repcolor;?>">
				Reputation: <?php echo$tmp_uinfo['reputation'];?>
			</div>
			<div class="infobox roundbot shadow1">
				<div class="title">
					<h4>My Information</h4>
				</div>
				<table width="100%" style="text-align:left;">
					<tr>
						<td width="50%"><b>Group Id:</b></td>
						<td><?php echo ucwords($tmp_uinfo['group'])?></td>
					</tr>
					<tr>
						<td width="50%"><b>Profile Views:</b></td>
						<td><?php echo$tmp_uinfo['profile_views'];?></td>
					</tr>
					<tr>
						<td width="50%"><b>Last Active:</b></td>
						<td><?php echo getLastActiveDisplay($tmp_uinfo['last_active']);?></td>
					</tr>
					<tr>
						<td width="50%"><b>Age:</b></td>
						<td><?php echo($usett['displayage']==0)?"Unknown":convertAge(strtotime($tmp_uinfo['dob_day']."-".$tmp_uinfo['dob_month']."-".$tmp_uinfo['dob_year']));?></td>
					</tr>
					<tr>
						<td width="50%"><b>Birthday:</b></td>
						<td>
							<?php
								$mydobtime=strtotime($tmp_uinfo['dob_day']."-".$tmp_uinfo['dob_month']."-".$tmp_uinfo['dob_year']);
								echo ($usett['displaybirthday']==0)?"Unknown":date("M d, Y",$mydobtime);
							?>
						</td>
					</tr>
					<tr>
						<td width="50%"><b>Gender:</b></td>
						<td>
							<?php
								echo ($usett['displaygender']==0)?"Not Telling":"<span id='icon' class='".strtolower($tmp_uinfo['gender'])."'></span>".$tmp_uinfo['gender'];
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
<pre>
<?php print_r($tmp_uinfo);?>
</pre>