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
					<h3>Add A New Topic</h3>
				</a>
			</div>
			<div class="content">
				<?php if($_SESSION['error']['addtopic']!=''){?><div class="msg_warn"><?php echo$_SESSION['error']['addtopic'];?></div><?php }?>
				<?php if($_SESSION['suc']['addtopic']!=''){?><div class="msg_suc"><?php echo$_SESSION['suc']['addtopic'];?></div><?php }?>
				<form action="" method="post" name="form_wysiwyg" id="form_wysiwyg">
					<input type="hidden" name="addnewtopicmask" value="1">
					<table width="100%" class="topictable">
						<tr>
							<th colspan="2"style="padding:0px 10px;"><h3>Topic Information</h3></th>
						</tr>
						<tr>
							<td style="padding:5px;" width="30%"align="right"><b>Topic Title:</b></td>
							<td style="padding:5px;" align="left"><input type="text" name="topictitle" style="width:250px;" class="blacktextbox"></td>
						</tr>
						<tr>
							<td style="padding:5px;" align="right"><b>Topic Description:</b></td>
							<td style="padding:5px;" align="left"><input type="text" name="topicdesc" style="width:250px;" class="blacktextbox"></td>
						</tr>
						<tr>
							<th colspan="2"style="padding:0px 10px;"><h3>Topic</h3></th>
						</tr>
						<tr>
							<td colspan="2">
								<?php Wysiswyg_cp('full');?>
								<textarea style="display:none;"name="wysiwyg_text" id="wysiwyg_text" ></textarea>
								<iframe name="richTextField" id="richTextField"></iframe>
							</td>
						</tr>
						<tr height="40">
							<td colspan="2" align="center"><input id="inputbut"type="button" onclick="javascript:submit_form();"value="Post New Topic"></td>
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
	unset($_SESSION['error']['addtopic']);
	unset($_SESSION['suc']['addtopic']);
	?>