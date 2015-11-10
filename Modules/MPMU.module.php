<?php
if(count($user_info['friends'])>0){
	foreach($user_info['friends'] as $fri){
		$fridata=GetotherMember($fri);
		$usericon=GetUserIcon($fridata['settings']['userIcon'],$fridata['gender']);
		$data.="<tr>";
			$data.="<td align='center'><img src='".$coreImgs."/usericons/".$usericon."'></td>";
			$data.="<td><a href='".$forumurl."/profile/".$fridata['username']."'>".ucwords($fridata['username'])."</td>";
			$data.="<td></td>";
		$data.="</tr>";
	}
}else{
	$data="";
}
?>
<div style="position:relative; top:5px;margin-bottom:8px;">
	<table width="100%" class='lmemt roundall'>
		<tr style="height:30px!important;">
			<th width='35'></th>
			<th>User Name</th>
			<th>Date Started</th>
		</tr>
		<?php echo$data;?>
	</table>
</div>