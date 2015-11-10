<div id="main" class="roundall">
	<div class="topbar roundtop">
		<div class="logo"><img src="<?php echo GetSiteLogo();?>"/></div>
		<ul class="logoutbut"><?php //echo showLogoutBut();?></ul>
		
		<div class="latenews">
			
		</div>
	</div>
	<div class="side1">
		
		<div class="navigation">
			<ul>
				<?php echo GetNavBar();?>
				
			</ul>
		</div>
		<?php GetSideBar();?>
	</div>
	<div class="side2">
		<div class="mostript">
			<ul>
				<?php echo GetMoStrip();?>
				<li></li>
			</ul>
		</div>
		<?php
			if(isset($_SESSION['forcelogout'])){
				echo"<div class='msg_info'>You Have Been Logged Out ".$_SESSION['forcelogout']['reason']."</div>";
			}
		?>
		<?php if($context['currentPage']=="home")Req_module("SHOUT","misc_mods");?>
		<?php loadPage();?>
	</div>
	<div class="clear"></div>
</div>
<?php unset($_SESSION['forcelogout']);?>