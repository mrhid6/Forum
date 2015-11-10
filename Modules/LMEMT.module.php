<?php

if($context['viewingProfile']!=''){
	$userid=turnUsernameToId($context['viewingProfile']);
}else{
	$userid=$user_info['ID'];
}

$sql=$conn->query("SELECT * FROM ".$db_prefix."board_topics WHERE startedby='".$userid."'");

if($sql->num_rows > 0){
	while($row=$sql->fetch_assoc()){
		$data.="<tr>";
			$data.="<td align='center'>";
			$data.="<img src='".GetTopicTypeImg($row['type'])."'/>";
			$data.="</td>";	
			$data.="<td><a href='".$forumurl."/topic/".$row['ID']."/'>".ucwords($row['name'])."</a></td>";
			$data.="<td>".date("d/m/Y H:i:s", strtotime($row['datestarted']))."</td>";
		$data.="</tr>";
	}
}
?>
<div style="position:relative; top:5px;margin-bottom:8px;">
	<table width="100%" class='roundall lmemt'>
		<tr style="height:30px!important;">
			<th width='35'></th>
			<th>Name</th>
			<th>Date Started</th>
		</tr>
		<?php echo$data;?>
	</table>
</div>echo$data;?>
	</table>
</div>