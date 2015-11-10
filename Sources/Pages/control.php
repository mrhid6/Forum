<?php
$Newestversion= file_get_contents("http://xorbo.com/forumapi/forumversion.ini",null,null,7,5);

$compare=decodeForumVersions(compareForumVersions($context["forumVersion"],$Newestversion,true));
$themelist=listAllThemes();
?>
<div class="control">
	<div class="side1">
		<div class="profile">
			<table width="100%" height="120">
				<tr>
					<td align="center"width="80"rowspan="2"><div class="imagebord"><img src="<?php echo $memsurl."/".GetMemDp($user_info['ID'],"small");?>"></div></td>
					<td valign="bottom"><h5>Logged In As</h5></td>
				</tr>
				<tr>
					<td valign="top"><a class="profilelink"><h3><?php echo ucwords($user_info['username']);?></h3></a></td>
				</tr>
			</table>
		</div>
		<ul>
			<li>Forum Version : <?php echo $context["forumVersion"];?></li>
			<li>Theme Version : <?php echo $theme_info["config_file"]['version'];?></li>
			<li>Total Topics : <?php echo countTopics();?></li>
			<li>Total Members : <?php echo countMembers();?></li>
		</ul>
	</div>
	<div class="sidebar2">
		<ul id="cptabs" class="shadetabs">
			<li><a href="#" rel="country1" class="selected">Dashboard</a></li>
			<li><a href="#" rel="country2">Boards</a></li>
			<li><a href="#" rel="country3">Blogs</a></li>
			<li><a href="#" rel="country4">Manage Users</a></li>
			<li><a href="#" rel="country5"><span id="icon" class="gear"></span>Settings</a></li>
		</ul>
		<div id="country1" class="tabcontent">
			<div class="title">
				<h4>Dashboard</h4>
			</div>
			<div class="content">
				<?php echo $compare;?>
			</div>
		</div>
		<div id="country2" class="tabcontent">
			<div class="title">
				<h4>Boards</h4>
			</div>
			<div class="content nopadding">
				<table width="100%">
					<tr>
						<th style='text-align:center;' width="40">ID</th>
						<th width="250">Board Name</th>
						<th width="100">Members Only</th>
						<th>Options</th>
					</tr>
					<?php echo control_displayboards();?>
				</table>
			</div>
			<div class="title">
				<h4>Sub Boards</h4>
			</div>
			<div class="content nopadding">
				<table width="100%">
					<tr>
						<th style='text-align:center;' width="40">ID</th>
						<th width="250">Board Name</th>
						<th width="100">Members Only</th>
						<th>Options</th>
					</tr>
					<?php echo control_displayboards();?>
				</table>
			</div>
			<div class="title">
				<h4>Topics</h4>
			</div>
			<div class="content nopadding">
				
			</div>
		</div>
		<div id="country3" class="tabcontent">
			Blogs
		</div>
		<div id="country4" class="tabcontent">
			<div class="title">
				<h4>Users</h4>
			</div>
			<div class="content nopadding">
				<table width="100%">
					<tr>
						<th width="30"></th>
						<th style='text-align:center;' width="40">ID</th>
						<th width="150">Username</th>
						<th width="90">Access Level</th>
						<th width="45">Online</th>
						<th>Options</th>
					</tr>
					<?php echo control_displaymembers();?>
				</table>
			</div>
		</div>
		<div id="country5" class="tabcontent">
			<div class="title">
				<h4>Settings</h4>
			</div>
			<div class="content">
				<form action="" method="post">
				<input type="hidden" name="control_settings" value="1">
				<table width="100%" cellspacing="5">
					<tr>
						<td width="120" height="30">Busy Timeout</td>
						<td>
							<select class="styled" name="busytimeout">
								<option value="">Select Timeout</option>
								<option <?php echo($context['Forum_settings']['busytimeout']=="1")?"Selected":"";?> value="1">1 Minute</option>
								<option <?php echo($context['Forum_settings']['busytimeout']=="2")?"Selected":"";?> value="2">2 Minutes</option>
								<option <?php echo($context['Forum_settings']['busytimeout']=="3")?"Selected":"";?> value="3">3 Minutes</option>
								<option <?php echo($context['Forum_settings']['busytimeout']=="4")?"Selected":"";?> value="4">4 Minutes</option>
								<option <?php echo($context['Forum_settings']['busytimeout']=="5")?"Selected":"";?> value="5">5 Minutes</option>
								<option <?php echo($context['Forum_settings']['busytimeout']=="10")?"Selected":"";?> value="10">10 Minutes</option>
								<option <?php echo($context['Forum_settings']['busytimeout']=="15")?"Selected":"";?> value="15">15 Minutes</option>
								<option <?php echo($context['Forum_settings']['busytimeout']=="20")?"Selected":"";?> value="20">20 Minutes</option>
								<option <?php echo($context['Forum_settings']['busytimeout']=="25")?"Selected":"";?> value="25">25 Minutes</option>
							</select>
						</td>
					</tr>
					<tr>
						<td height="30">Offline Timeout</td>
						<td>
							<select class="styled" name="offlinetimout">
								<option value="">Select Timeout</option>
								<option <?php echo($context['Forum_settings']['offlinetimeout']=="5")?"Selected":"";?> value="5">5 Minutes</option>
								<option <?php echo($context['Forum_settings']['offlinetimeout']=="10")?"Selected":"";?> value="10">10 Minutes</option>
								<option <?php echo($context['Forum_settings']['offlinetimeout']=="15")?"Selected":"";?> value="15">15 Minutes</option>
								<option <?php echo($context['Forum_settings']['offlinetimeout']=="20")?"Selected":"";?> value="20">20 Minutes</option>
								<option <?php echo($context['Forum_settings']['offlinetimeout']=="25")?"Selected":"";?> value="25">25 Minutes</option>
							</select>
						</td>
					</tr>	
					<tr>
					<tr>
						<td height="10"><hr/></td>
						<td><hr/></td>
					</tr>
						
					<tr>
						<td height="30">Topics Per Page</td>
						<td>
							<select class="styled" name="TopPerBoard">
								<option value="">Select</option>
								<option <?php echo($context['Forum_settings']['topicpagelim']=="5")?"Selected":"";?> value="5">5</option>
								<option <?php echo($context['Forum_settings']['topicpagelim']=="10")?"Selected":"";?> value="10">10</option>
								<option <?php echo($context['Forum_settings']['topicpagelim']=="15")?"Selected":"";?> value="15">15</option>
								<option <?php echo($context['Forum_settings']['topicpagelim']=="20")?"Selected":"";?> value="20">20</option>
								<option <?php echo($context['Forum_settings']['topicpagelim']=="25")?"Selected":"";?> value="25">25</option>
								<option <?php echo($context['Forum_settings']['topicpagelim']=="30")?"Selected":"";?> value="30">30</option>
								<option <?php echo($context['Forum_settings']['topicpagelim']=="35")?"Selected":"";?> value="35">35</option>
								<option <?php echo($context['Forum_settings']['topicpagelim']=="40")?"Selected":"";?> value="40">40</option>
							</select>
						</td>
					</tr>
					<tr>
						<td height="30">Replies Per Page</td>
						<td>
							<select class="styled" name="RepPerTopic">
								<option value="">Select</option>
								<option <?php echo($context['Forum_settings']['topicreplypagelim']=="5")?"Selected":"";?> value="5">5</option>
								<option <?php echo($context['Forum_settings']['topicreplypagelim']=="10")?"Selected":"";?> value="10">10</option>
								<option <?php echo($context['Forum_settings']['topicreplypagelim']=="15")?"Selected":"";?> value="15">15</option>
								<option <?php echo($context['Forum_settings']['topicreplypagelim']=="20")?"Selected":"";?> value="20">20</option>
								<option <?php echo($context['Forum_settings']['topicreplypagelim']=="25")?"Selected":"";?> value="25">25</option>
								<option <?php echo($context['Forum_settings']['topicreplypagelim']=="30")?"Selected":"";?> value="30">30</option>
								<option <?php echo($context['Forum_settings']['topicreplypagelim']=="35")?"Selected":"";?> value="35">35</option>
								<option <?php echo($context['Forum_settings']['topicreplypagelim']=="40")?"Selected":"";?> value="40">40</option>
							</select>
						</td>
					</tr>
					<tr>
						<td height="10"><hr/></td>
						<td><hr/></td>
					</tr>
					<tr>
						<td height="30">Select Theme</td>
						<td><?php echo displaySelectThemes($theme_info['name'],$themelist);?></td>
					</tr>
					<tr>
						<td height="30" colspan="2"><input type="submit" name="control_sub_setts" value="Save Settings" class="inputbut"></td>
					</tr>
					
				</table>
				</form>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javascript">
var countries=new ddtabcontent("cptabs")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()
</script>
<script src="<?php echo$forumurl;?>/Core/Js/main.js"></script>