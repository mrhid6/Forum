<div id="main">
	<div class="topbar">
		<div class="logo"><img src="<?php echo GetSiteLogo();?>"/></div>
	</div>
	<div class="navbar">
		<ul>
			<?php echo GetNavBar();?>
		</ul>
	</div>
	<?php Req_module("NEWSSTRIP","misc_mods");?>
	<?php if($context["showsidebar"]==1){?>
		<div class="side1">
			<?php GetSideBar();?>
		</div>
	<?php }?>
	<div class="side2 <?php echo($context["showsidebar"]==1)?"":"sidefull";?>">
		<div class="mostript">
			<ul>
				<?php echo GetMoStrip();?>
				<li></li>
			</ul>
		</div>
		<?php if($context['currentPage']=="home")Req_module("SHOUT","misc_mods");?>
		<?php loadPage();?>
	</div>
	<div class="clear"></div>
	<?php Req_module("FOOT","misc_mods");?>
</div>