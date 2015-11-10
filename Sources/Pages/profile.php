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
$rep=0;

if($ismyprofile==false){
	if(checkUserExists($context['viewingProfile'])==true){
		$tmp_uinfo=array();
		$tmp_uinfo=GetotherMember(turnUsernameToId($context['viewingProfile']));
		$rep=$tmp_uinfo['reputation'];
	}
}else{
	$rep=$user_info['reputation'];
}

if($rep>0){
	if($rep>0 && $rep<5){
		$repcolor="yellowbox";
	}else{
		$repcolor="greenbox";
	}
}else{
	if($rep<0 && $rep>-5){
		$repcolor="orangebox";
	}else{
		$repcolor="redbox";
	}
}


/*Include the right file for the profile page*/
if($ismyprofile==true){
	include($srcdir."/Profile/myprofile.php");
}else{
	if(checkUserExists($context['viewingProfile'])==true){
		AddprofileView($tmp_uinfo['ID']);
		include($srcdir."/Profile/viewprofile.php");
	}else{
		echo"<div class='msg_warn'>".errorcode(30)."</div>";
	}
}
?>

<script type="text/javascript">
<?php if($ismyprofile==true){?>

var countries=new ddtabcontent("myprofiletabs")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()

<?php }else{?>

var countries=new ddtabcontent("viewprofiletabs")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()

<?php }?>
</script>