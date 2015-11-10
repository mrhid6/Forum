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
$sql=$conn->query("SELECT * FROM ".$db_prefix."board_topics ORDER BY ID DESC LIMIT 4");

if($sql->num_rows > 0){
	$heightoftask="50";
	while($row=$sql->fetch_assoc()){
		$mainboard=GetBoardInfo($row['mainboard']);
		if($mainboard['memonly']<=$user_info['loggedin']){
			$rating = ($row['Rating_score']!=0 && $row['Rating_count']!=0)?$row['Rating_score'] / $row['Rating_count']:0;
			$rating = round_to_half($rating);
			$moddata.="<tr height='".$heightoftask."px'><td>";
			
			$moddata.="<table width='100%'height='".($heightoftask-5)."px' border='0'>";
			
			$moddata.="<tr>";
			$moddata.="<td width='98%'><a href='".$forumurl."/topic/".$row['ID']."'><h4>".ucwords($row['name'])."</h4></td>";
			$moddata.="<td width='2%'><h5>(".date("d/m/Y",strtotime($row['datestarted'])).")</h5></td>";
			$moddata.="</tr>";
			$moddata.="<tr>";		
			$moddata.="<td colspan='2'>".starrating($rating,true)."</td>";
			$moddata.="</tr>";
			
			$moddata.="</table>";
			
			$moddata.="</td></tr>";
		}
	}
}else{
	$moddata="<div class='msg_warn'>".errorcode(14)."</div>";
}
?>
<div class="module">
	<div class="mod_title">
		<h3><icon:default class="topic"></icon:default>Recently Added Topics<icon:default class="minus"id="option" taborder="200"alt="RATcontent"></icon:default></h3>
	</div>
	<div class="mod_content" id="RATcontent">
		<table width="100%" height="200">
			<?php
				echo$moddata;
			?>
		</table>
	</div>
</div>