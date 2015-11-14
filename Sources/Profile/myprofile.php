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

<div id="collapsebox" class="profilebox">
	<div class="titlebox">
		<img style="vertical-align:text-bottom;margin-right:5px;"src="<?php echo$coreImgs."/usericons/".GetUserIcon($user_info['settings']['userIcon'],$user_info['gender']);?>">
		<h3>My Profile</h3>
	</div>
	<div class="content">
		<div id="containerside1">
		</div>
		<div id="containerside2">
			<div class="profileimage">
				<div class="imageboard largeimageboard">
					<img src="<?php echo $memsurl."/".GetMemDp($user_info['ID'],"large");?>">
				</div>
			</div>

			<div class="reputation <?php echo$repcolor;?>">
				<h4>Reputation: <?php echo$reputation_text;?></h4>
			</div>
			<div class="infobox">
				<div class="title">
					<h4>My Information</h4>
				</div>
				<div class="content">
					<div class="inforow">
						<h4>Username: <?php echo$user_info['username'];?></h4>
					</div>
					<div class="inforow">
						<h4>Profile Views: <?php echo$user_info['profile_views'];?></h4>
					</div>
					<div class="inforow">
						<h4>Active Since: <?php echo getRegisteredDate($user_info['registered_date']);?></h4>
					</div>
					<div class="inforow">
						<h4>Last Active: <?php echo getLastActiveDisplay($user_info['last_active']);?></h4>
					</div>
					<div class="inforow">
						<h4>Gender: <?php
							echo ($usett['displaygender']==0)?"Not Telling":"<span id='icon' class='".strtolower($user_info['gender'])."'></span>".$user_info['gender'];
							?></h4>
					</div>
					<div class="inforow">
						<img class="rankimage" title="<?php echo $userdata['group']['desc'];?>"src="<?php echo $coreImgs."/ranks/".$user_info['group']['name'].".png";?>"/>
					</div>
				</div>
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
			<div class="clear"></div>
		</div>
	</div>
</div>