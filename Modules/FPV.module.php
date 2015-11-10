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
	
$user=new users;
$sql=$conn->query("SELECT * FROM ".$db_prefix."featuredpics ORDER BY RAND() LIMIT 5");
if($sql->num_rows > 0){
	while($row=$sql->fetch_assoc()){
		$data.="<img src='".forbasefold."/images/featuredpics/".$row['ID'].$row['extention']."' title='".ucwords($row['name'])." By ".ucwords($user->ConStatUD($row['userid'],"username"))."'>";
	}
}
?>
<div id="photoviewer">
	<div class="title">
		<h3>Featured Photos</h3>
	</div>
	<div class="content">
		<?php echo$data;?>
	</div>
</div>