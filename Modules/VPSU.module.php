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
	
	$userid=turnUsernameToId($context['viewingProfile']);
	$userdata=GetotherMember($userid);
$moddata="";
$sql=$conn->query("SELECT * FROM ".$db_prefix."member_statups WHERE userid='".$userdata['ID']."' AND removed='0' ORDER BY ID DESC LIMIT 5");
if($sql->num_rows > 0){
	$conn->query("UPDATE ".$db_prefix."member_statups SET removed='1' WHERE date_entered < DATE_SUB(CURDATE(), INTERVAL 3 DAY)");
	$conn->query("DELETE FROM ".$db_prefix."member_statups WHERE date_entered < DATE_SUB(CURDATE(), INTERVAL 2 MONTH)");
	while($row=$sql->fetch_assoc()){
		$userimage=($userdata['profileimage']!='default.png')?$userdata['ID']."/":"";
		$image=$forumurl."/Members/".$userimage.$userdata['profileimage']."' title='".ucwords($userdata['username']);
		
		$substats="";
		$res.="<div class='boxstatus' id='boxstatus_".$row['ID']."'>";
		$res.="<table width='100%'>";
		$res.="<tr>";
		$res.="<td rowspan='2' width='80'><div class='imagebord'><img src='".$image."'></div></td>";
		$res.="<td><h4>".ucwords($username)."</h4> <h5>(".date("d/m/Y H:i:s",strtotime($row['date_entered'])).")</h5></td>";
		$res.="</tr>";
		$res.="<tr>";
		$res.="<td valign='top'>";
		$res.=str_replace("[","<",str_replace("]",">",$row['status']));
		$res.="</td>";
		$res.="</tr>";
		$res.="</table>";
		$res.="</div>";
	}
	$moddata=$res;
}else{
	$moddata="<div class='msg_info'>".errorcode(21)."</div>";
}
?>
<br/>
<?php echo$moddata;
unset($_SESSION['profileupdate']);
?>
<script>fade('fadenow');</script>