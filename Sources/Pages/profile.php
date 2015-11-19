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

$userdata=array();

if($ismyprofile==false){
	if(checkUserExists($context['viewingProfile'])==true){
		$userdata = getMemberData(turnUsernameToId($context['viewingProfile']));
		addprofileView($userdata['ID'], $user_info['ID']);
	}else{
		echo"<div class='msg_warn'>".errorcode(30)."</div>";
	}
}else{
	$userdata = $user_info;
}

if($userdata['reputation'] > 0 && $userdata['reputation_count'] > 0) {
	$reputation_score = $userdata['reputation'] / $userdata['reputation_count'];
}else{
	$reputation_score = 0;
	echo $userdata['reputation'].":".$userdata['reputation_count'];
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
?>

<div id="collapsebox" class="profilebox">
	<div class="titlebox">
		<img style="vertical-align:text-bottom;margin-right:5px;"src="<?php echo$coreImgs."/usericons/".GetUserIcon($userdata['settings']['userIcon'],$userdata['gender']);?>">
		<?php
			if($ismyprofile==true){
				echo "<h3>My Profile</h3>";
			}else{
				echo "<h3>".ucwords($userdata['username'])."'s Profile</h3>";
			}
		?>

	</div>
	<div class="content">
		<div id="containerside1">
		</div>
		<div id="containerside2">
			<div class="profileimage">
				<div class="imageboard largeimageboard">
					<img src="<?php echo $memsurl."/".GetMemDp($userdata['ID'],"large");?>">
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
						<h4>Username: <?php echo$userdata['username'];?></h4>
					</div>
					<div class="inforow">
						<h4>Profile Views: <?php echo getProfileViews($userdata['ID']);?></h4>
					</div>
					<div class="inforow">
						<h4>Active Since: <?php echo timeago_v1($userdata['registered_date']);?></h4>
					</div>
					<div class="inforow">
						<h4>Last Active: <?php echo timeago($userdata['last_active']);?></h4>
					</div>
					<div class="inforow">
						<h4>Gender: <?php
							echo ($usett['displaygender']==0)?"Not Telling":"<span id='icon' class='".strtolower($userdata['gender'])."'></span>".$userdata['gender'];
							?></h4>
					</div>
					<div class="inforow">
						<img class="rankimage" title="<?php echo $userdata['group']['desc'];?>"src="<?php echo $coreImgs."/ranks/".$userdata['group']['name'].".png";?>"/>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
