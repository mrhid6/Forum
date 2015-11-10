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
	
if($context['currentBoard']!='' && $context['currentSubboard']!=''){

$board=GetBoardInfo($context['currentBoard']);
$subboard=GetSubBoardInfo($context['currentSubboard']);

if($board['name']!="Error" && $subboard['name']!="Error"){
?>
<div id="collapsebox">
			<div class="titlebox">
				<a>
					<h3>Add A Reply</h3>
				</a>
			</div>
			<div class="content">
				<?php if($_SESSION['error']['addreply']!=''){?><div class="msg_warn"><?php echo$_SESSION['error']['addreply'];?></div><?php }?>
				<?php if($_SESSION['suc']['addreply']!=''){?><div class="msg_suc"><?php echo$_SESSION['suc']['addreply'];?></div><?php }?>
				<form action="" method="post" name="form_wysiwyg" id="form_wysiwyg">
					<input type="hidden" name="addnewreplymask" value="1">
					<table width="100%" class="topictable">
						<tr>
							<td colspan="2">
								<?php Wysiswyg_cp('basic');?>
								<textarea style="display:none;"name="wysiwyg_text" id="wysiwyg_text" ></textarea>
								<iframe name="richTextField" id="richTextField"></iframe>
							</td>
						</tr>
						<tr height="40">
							<td colspan="2" align="center"><input id="inputbut"type="button" onclick="javascript:submit_form();"value="Post New Reply"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<?php }else{?>
			<div class="msg_warn"><?php echo errorcode(18);?></div>
		<?php }?>
		
	<?php }else{?>
		<div class="msg_warn"><?php echo errorcode(18);?></div>
	<?php }?>
	
	<?php
	unset($_SESSION['error']['addreply']);
	unset($_SESSION['suc']['addreply']);
	?>