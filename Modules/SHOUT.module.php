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
	
$moddata="";
$sql=$conn->query("SELECT * FROM ".$db_prefix."shouts ORDER BY ID DESC");

if($sql->num_rows > 0){
	$heightoftask="25";
	while($row=$sql->fetch_assoc()){
		$userdata=getMemberData($row['User']);

		$usersets=(isset($userdata['settings']))?$userdata['settings']:array();

		$username=($row['User']==0)?"Anonymous":$userdata['username'];
		$profilelink=($row['User']==0)?"":"href='".$forumurl."/profile/".$username."'";
		$moddata.="<tr height='".$heightoftask."px' style='border-bottom:1px dashed #555;'><td>";
		
		$moddata.="<table width='100%'height='".($heightoftask-5)."px' border='0'>";
		
		$moddata.="<tr>";
		if($username=="Anonymous"){
			$icon="user-silhouette-question.png";
		}else{
			if($usersets['userIcon']==0){
				$icon="user-silhouette.png";
			}else{
				$icon=GetUserIcon($usersets['userIcon'],$userdata['gender']);
			}
		}
		$moddata.="<td align='center'width='25px'><img src='".$coreImgs."/usericons/".$icon."'></td>";
		$moddata.="<td><h4><a ".$profilelink.">".ucwords($username)."</h4></a> - ".$row['Shout']."</td>";
		$moddata.="<td width='90px'><h5>(".timeago(strtotime($row['dateadded'])).")</h5></td>";
		$moddata.="</tr>";
		
		$moddata.="</table>";
		
		$moddata.="</td></tr>";
	}
}else{
	$moddata="<div class='msg_warn'>".errorcode(24)."</div>";
}
?>
<div class="module">
	<div class="mod_title">
		<h3>Shout Box</h3>
	</div>
	<div class="mod_content" id="SHOUTcontent" style="height:175px;">
		<div style="padding:5px;hieght:25px;">
			<form action="" method="post" style="width:auto;display:inline;">
				<input type="hidden" name="shoutSend" value="1">
				<input type="text" class="blacktextbox" placeholder="Shout Out Now!" style="min-width:300px;max-width:1000px;width:50%;" name="shoutoutbox">
				<input id="inputbut"type="submit" name="shoutoutbut" value="Shout Out">
			</form>
			<?php if($_SESSION['error']['shout']){?>
				<div class="msg_warn" id="shoutstatus" style="margin:0px 5px;float:right;"><?php echo$_SESSION['error']['shout'];?></div>
			<?php }elseif($_SESSION['suc']['shout']){?>
				<div class="msg_suc" id="shoutstatus" style="margin:0px 5px;float:right;"><?php echo$_SESSION['suc']['shout'];?></div>
			<?php }?>
			<script>fade('shoutstatus');</script>
		</div>
		<div style="overflow:auto;height:140px;clear:both;">
			<table width="100%" border="0">
				<?php
					echo$moddata;
				?>
			</table>
		</div>
	</div>
</div>
<?php
unset($_SESSION['error']['shout']);
unset($_SESSION['suc']['shout']);
?>