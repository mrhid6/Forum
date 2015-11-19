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
$sql=$conn->query("SELECT * FROM ".$db_prefix."blogs WHERE Removed='0' ORDER BY ID DESC LIMIT 4");

if($sql->num_rows > 0){
	$heightoftask="50";
	while($row=$sql->fetch_assoc()){
		$rating = ($row['Rating_score']!=0 && $row['Rating_count']!=0)?$row['Rating_score'] / $row['Rating_count']:0;
		$rating = round_to_half($rating);
		$moddata.="<tr height='".$heightoftask."px'><td>";
		
		$moddata.="<table width='100%'height='".$heightoftask."px' border='0'>";
		
		$moddata.="<tr>";
		$moddata.="<td width='98%'><h4><a href='".$forumurl."/blogs/".$row['ID']."'>".ucwords($row['Blogtitle'])."</h4></td>";
		$moddata.="<td width='2%'>".starrating($rating,true)."</td>";
		$moddata.="</tr>";
		
		$moddata.="<tr>";
		$moddata.="<td width='98%'><h6>(".date("d/m/Y",strtotime($row['Dateadded'])).")</h6></td>";
		$moddata.="<td width='2%'>".ucwords(getMemberData($row['Userid'],"username"))."</td>";
		$moddata.="</tr>";
		
		$moddata.="</table>";
		
		$moddata.="</td></tr>";
	}
}else{
	$moddata="<div class='msg_warn'>".errorcode(16)."</div>";
}
?>
<div class="module">
	<div class="mod_title">
		<h3>Recently Added Blogs</h3>
	</div>
	<div class="mod_content" id="RABcontent">
		<table width="100%" height="200">
			<?php
				echo$moddata;
			?>
			<tr><td></td></tr>
		</table>
	</div>
</div>