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

$mainboard=GetBoardInfo($context['currentBoard']);
if($mainboard['memonly']<=$user_info['loggedin']){
	$row=GetTopicInfo($context['currentTopic']);
	UpdateTopicView($context['currentTopic']);

	$currentrate=($row['Rating_score']!=0 && $row['Rating_count']!=0)?$row['Rating_score'] / $row['Rating_count']:0;
	$currentrate=round_to_half($currentrate);
	$currentpercent=0;
	for($i=0;$i<$currentrate;$i=$i+0.5){
		$currentpercent=$currentpercent+10;
	}

	$topicsperpage=req_setting('topicreplypagelim');
	$pageid=$context['currentPageNum'];
	if(isset($pageid) && $pageid!=0) {
		$page = $pageid;
		$startlim=$topicsperpage*($page-1);
	} else {
		$page = 1;
		$startlim=0;
	}
	$baselink=$forumurl."/topic/".$row['ID']."/";
	$count_sql=$conn->query("SELECT * FROM ".$db_prefix."board_topicreply WHERE topicid='".$row['ID']."'");
	$count=$count_sql->num_rows;
	?>
	<div class="topofboard">
		<?php if($user_info['loggedin']==1){?>
			<a href="<?php echo$forumurl;?>/replytopic/<?php echo$row['ID'];?>" class="whitebut"><span id="icon" class="reply"></span>Add Reply</a>
		<?php }else{?>
			<a class="whitebut disabledbut"><span id="icon" class="bluedocument"></span>Login to reply</a>
		<?php }?>
		<?php echo genPagination($count,$page,$baselink,true,$topicsperpage)?>
	</div>
	<div id="collapsebox">
		<div class="titlebox">
			<a><h3><?php echo ucwords($row['name']);?></h3></a>
				<span class="inline-rating">
					<ul class="star-rating small-star">
						<li class="current-rating" style="width:<?php echo$currentpercent."%";?>;">Currently 1.5/5 Stars.</li>
						<li><a onclick="javascript:starRating(<?php echo$row['ID']?>,'topic',1);"title="1 star out of 5" class="one-star">1</a></li>
						<li><a onclick="javascript:starRating(<?php echo$row['ID']?>,'topic',2);"title="2 stars out of 5" class="two-stars">2</a></li>
						<li><a onclick="javascript:starRating(<?php echo$row['ID']?>,'topic',3);"title="3 stars out of 5" class="three-stars">3</a></li>
						<li><a onclick="javascript:starRating(<?php echo$row['ID']?>,'topic',4);"title="4 stars out of 5" class="four-stars">4</a></li>
						<li><a onclick="javascript:starRating(<?php echo$row['ID']?>,'topic',5);"title="5 stars out of 5" class="five-stars">5</a></li>
					</ul>
				</span>
		</div>
		<div class="content">
			<?php
			$sql2=$conn->query("SELECT * FROM ".$db_prefix."board_topicreply WHERE topicid='".$row['ID']."'LIMIT " . (  $startlim) .", " . $topicsperpage);
			if($sql2->num_rows > 0){
				while($row=$sql2->fetch_assoc()){
					$userdata=getMemberData($row['userid']);
					$userimg=GetMemDp($row['userid']);
					$icon=GetUserIcon($userdata['settings']['userIcon'],"male");

					//echo "<pre>";print_r($userdata); echo "</pre>";
					?>
					<div class="subboard_topic">
						<table width="100%" border="0" style="position:relative;" cellspacing="5">
							<tr height="30">
								<th colspan="2" align="left">
									<img src='<?php echo$coreImgs."/usericons/".$icon;?>'>
									<h3 style="padding:0px 5px;"><?php echo ucwords($userdata['username']);?></h3>
								</th>
							</tr>
							<tr valign="top">
								<td width="20%" align="center">
									<div class="imageboard medimageboard">
										<a href="<?php echo$forumurl?>/profile/<?php echo$userdata['username']?>">
											<img src="<?php echo$memsurl."/".$userimg;?>">
										</a>
									</div>
								</td>
								<td rowspan="3" style="position:relative;">
									<div style="height:24px;padding:3px 0px;line-height:24px;">
										Posted <b><?php echo date("d M Y - h:i A",strtotime($row['dateadded']));?></b>
									</div>
									<?php echo$row['text'];?>
									<div style="border-top:1px dashed rgb(40,40,40); position:absolute;bottom:0px; display:block;height:70px; width:98%;">
										<?php echo$userdata['signature'];?>
									</div>
								</td>
							</tr>
							<tr>
								<td align="center" height="25"><img title="<?php echo $userdata['group']['desc'];?>"src="<?php echo $coreImgs."/ranks/".$userdata['group']['name'].".png";?>"/></td>
							</tr>
							<tr>
								<?php if($row['userid']!=$user_info['ID'] && $user_info['loggedin']==1){?>
									<td align="center" height="35">
										<?php if(in_array($row['userid'],$user_info['friends'])){?>
											<a title="Remove Friend"class="roundall topic_addfri" onclick="javascript:addfriend('<?php echo$user_info['ID']?>','<?php echo$row['userid']?>','remove');">
												<span id="icon" class="removeuser"></span>
											</a>
										<?php }else{?>
											<a title="Add Friend"class="roundall topic_addfri" onclick="javascript:addfriend('<?php echo$user_info['ID']?>','<?php echo$row['userid']?>','add');">
												<span id="icon" class="adduser"></span>
											</a>
										<?php }?>
									</td>
								<?php }?>
							</tr>
						</table>
					</div>
				<?php }
			}else{?>
				<div class="msg_warn"><?php echo errorcode(15);?></div>
			<?php }
			?>
		</div>
	</div>
	<?php
}else{?>
	<div class="msg_warn"><?php echo errorcode(25);?></div>
<?php }?>