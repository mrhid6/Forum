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
	
?>
<div class="module">
	<div class="mod_title">
		<h3>Calendar</h3>
	</div>
	<div class="mod_content" id="CALcontent">
		 
			
	</div>
</div>
<script>
$(function(){
	$("#CALcontent").load("/modules/CAL.func.php");
});
</script>