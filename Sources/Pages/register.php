<div id="collapsebox">
	<div class="titlebox">
		<h3>Create A New Account</h3>
	</div>
	<div class="content nopadding">
		<?php if($_SESSION['error']['register']!=''){?><div class="msg_warn"><?php echo$_SESSION['error']['register'];?></div><?php }?>
		<?php if($_SESSION['suc']['register']!=''){?><div class="msg_suc"><?php echo$_SESSION['suc']['register'];?></div><?php }?>
		<form action="" method="post" autocomplete="off">
			<input type="hidden" name="registerpost_ent" value="1"/>
			<table width="100%"class="register">
				<tr>
					<td colspan="3" class="disclamer">
						<h4 style="font-size:110%;">Welcome to <?php echo req_setting("forumTitle");?></h4><br/>
						<h5 class="redtext">Please Fill In All The Required Feilds Marked With <span class="astrix">*</span></h5>
					</td>
				</tr>
				<tr>
					<td colspan="3"><b><u>Account Details</u></b></td>
				</tr>
				<tr>
					<td width="170"><label for="reg_username">User Name <span class="astrix">*</span></label></td>
					<td width="300"><input type="text" style="width:200px;" id="reg_username"name="reg_username" class="blacktextbox" value="<?php echo$_POST['reg_username'];?>"></td>
					<td><?php echo($_SESSION['inputs']['register']['username'])?"<div class='msg_warn'>User Name</div>":"";?></td>
				</tr>
				<tr>
					<td ><label for="reg_password">Password <span class="astrix">*</span></label></td>
					<td><input type="password" style="width:200px;" id="reg_password"name="reg_password" class="blacktextbox"></td>
					<td><?php echo($_SESSION['inputs']['register']['password'])?"<div class='msg_warn'>Password</div>":"";?></td>
				</tr>
				<tr>
					<td ><label for="reg_passwordconfirm">Password Confirm <span class="astrix">*</span></label></td>
					<td><input type="password" style="width:200px;" id="reg_passwordconfirm"name="reg_passwordconfirm" class="blacktextbox"></td>
					<td><?php echo($_SESSION['inputs']['register']['password2'])?"<div class='msg_warn'>Password Confirm</div>":"";?></td>
				</tr>
				<tr>
					<td ><label for="reg_email">Email Address <span class="astrix">*</span></label></td>
					<td><input type="text" style="width:200px;" id="reg_email"name="reg_email" class="blacktextbox"value="<?php echo$_POST['reg_email'];?>"></td>
					<td><?php echo($_SESSION['inputs']['register']['email'])?"<div class='msg_warn'>Email Address</div>":"";?></td>
				</tr>
				<tr>
					<td ><label for="reg_emailconfirm">Email Address Confirm <span class="astrix">*</span></label></td>
					<td><input type="text" style="width:200px;" id="reg_emailconfirm"name="reg_emailconfirm" class="blacktextbox"></td>
					<td><?php echo($_SESSION['inputs']['register']['email2'])?"<div class='msg_warn'>Email Address Confirm</div>":"";?></td>
				</tr>
				<tr>
					<td colspan="3"><b><u>Personal Details</u></b></td>
				</tr>
				<tr>
					<td ><label>Title <span class="astrix">*</span></label></td>
					<td>
						<select name="reg_title">
							<option value="">Select Title</option>
							<option value="mr">Mr</option>
							<option value="mrs">Mrs</option>
							<option value="ms">Ms</option>
							<option value="miss">Miss</option>
							<option value="dr">Dr</option>
						</select>
					</td>
					<td><?php echo($_SESSION['inputs']['register']['title'])?"<div class='msg_warn'>Title</div>":"";?></td>
				</tr>
				<tr>
					<td ><label for="reg_firstname">First Name <span class="astrix">*</span></label></td>
					<td><input type="text" style="width:200px;" id="reg_firstname" name="reg_firstname" class="blacktextbox" value="<?php echo$_POST['reg_firstname'];?>"></td>
					<td><?php echo($_SESSION['inputs']['register']['fname'])?"<div class='msg_warn'>First Name</div>":"";?></td>
				</tr>
				<tr>
					<td ><label for="reg_lastname">Last Name <span class="astrix">*</span></label></td>
					<td><input type="text" style="width:200px;" id="reg_lastname" name="reg_lastname" class="blacktextbox" value="<?php echo$_POST['reg_lastname'];?>"></td>
					<td><?php echo($_SESSION['inputs']['register']['lname'])?"<div class='msg_warn'>Last Name</div>":"";?></td>
				</tr>
				<tr>
					<td ><label for="reg_middlename">Middle Name (optional)</label></td>
					<td><input type="text" style="width:200px;" id="reg_middlename" name="reg_middlename" class="blacktextbox" value="<?php echo$_POST['reg_middlename'];?>"></td>
					<td></td>
				</tr>
				<tr>
					<td ><label>Gender <span class="astrix">*</span></label></td>
					<td>
						<label for="reg_malesel"><span id="icon" class="male"></span></label>
						<input type="radio" id="reg_malesel" name="reg_gender" value="Male"/>
						<label for="reg_femalesel"><span id="icon" class="female"></span></label>
						<input type="radio" id="reg_femalesel" name="reg_gender" value="Female"/>
					</td>
					<td><?php echo($_SESSION['inputs']['register']['gender'])?"<div class='msg_warn'>Gender</div>":"";?></td>
				</tr>
				<tr>
					<td ><label>Date Of Birth <span class="astrix">*</span></label></td>
					<td>
						<select name="reg_dobday">
							<option value="">Select Day</option>
							<?php
							$currentday=1;
							$endday=31;
							while($currentday<$endday){
								echo"<option value='".$currentday."'>".$currentday."</option>";
								$currentday++;
							}
							?>
						</select>
						<select name="reg_dobmonth">
							<option value="">Select Month</option>
							<option value="1">January
							<option value="2">February
							<option value="3">March
							<option value="4">April
							<option value="5">May
							<option value="6">June
							<option value="7">July
							<option value="8">August
							<option value="9">September
							<option value="10">October
							<option value="11">November
							<option value="12">December
						</select>
						<select name="reg_dobyear">
							<option value="">Select Year</option>
							<?php
							$currentyear=date("Y",time())-5;
							$endyear=$currentyear-80;
							while($currentyear>$endyear){
								$currentyear--;
								echo"<option value='".$currentyear."'>".$currentyear."</option>";
							}
							?>
						</select>
					</td>
					<td><?php echo($_SESSION['inputs']['register']['dob'])?"<div class='msg_warn'>Date Of Birth</div>":"";?></td>
				</tr>
				<tr>
					<td ><label>Country <span class="astrix">*</span></label></td>
					<td>
						<select name="reg_country">
							<option value="">Select Country</option>
							<?php
								echo DisplayCountrylist();
							?>
						</select>
					</td>
					<td><?php echo($_SESSION['inputs']['register']['country'])?"<div class='msg_warn'>Country</div>":"";?></td>
				</tr>
				<tr>
					<td ><label>Country <span class="astrix">*</span></label></td>
					<td>
						<img class="roundall"src="<?php echo$forumurl;?>/Sources/secimage.php?width=200&height=40&characters=10"/><br/>
						<input type="text" style="width:200px;"class="blacktextbox" name="reg_sectextent"/>
					</td>
					<td><?php echo($_SESSION['inputs']['register']['secimage'])?"<div class='msg_warn'>Security Image</div>":"";?></td>
				</tr>
				<tr>
					<td colspan="3"><input type="submit" value="Register Now!" class="inputbut"></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php unset($_SESSION['inputs']['register']);?>
<?php unset($_SESSION['error']['register']);?>
<?php unset($_SESSION['suc']['register']);?>