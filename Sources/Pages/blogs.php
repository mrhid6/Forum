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
	
if($context['currentBlog']==""){
?>
<div id="collapsebox">
	<div class="titlebox">
		<a href="<?php echo$forumurl;?>/board/<?php echo$row['ID']?>">
			<h3>Blogs</h3>
		</a>
	</div>
	<div class="content">
		<table width="100%" class="topictable">
			<tr>
				<th width='45'></th>
				<th>Blog Title</th>
				<th width='110'>Created By</th>
				<th width='130'>Stats</th>
			</tr>
			<?php 	
				$sql=$conn->query("SELECT * FROM ".$db_prefix."blogs WHERE Removed='0'");
				if($sql->num_rows > 0){
					while($row=$sql->fetch_assoc()){
					$rating = ($row['Rating_score']!=0 && $row['Rating_count']!=0)?$row['Rating_score'] / $row['Rating_count']:0;
					?>
						<tr class="topicrow">
							<td align="center"><img src="<?php echo$coreImgs;?>/normal.png"></td>
							<td>
								<a href="<?php echo$forumurl?>/blogs/<?php echo$row['ID'];?>">
									<?php echo ucwords($row['Blogtitle']);?>
								</a>
							</td>
							<td>
								<a href="<?php echo$forumurl;?>/profile/<?php echo getMemberData($row['Userid'],"username");?>">
									<?php echo ucwords(getMemberData($row['Userid'],"username"));?>
								</a>
							</td>
							<td>
								3 comments<br/>
								<?php echo starrating($rating,true);?>
							</td>
						</tr>
					<?php }?>
				<?php }else{?>
					<tr><td colspan="3"><div class="msg_warn"><?php echo errorcode(16);?></div></td></tr>
				<?php }?>
		</table>
	</div>
</div>
<?php
}else{

$sql=$conn->query("SELECT * FROM ".$db_prefix."blogs WHERE ID='".$context['currentBlog']."'");
	if($sql->num_rows > 0){
?>

<?php }else{?><div class="msg_warn"><?php echo errorcode(17);?></div><?php }?>
<?php }?>