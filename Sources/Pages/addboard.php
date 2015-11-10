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
<div id="collapsebox">
			<div class="titlebox">
				<a>
					<h3>Add A Sub Board</h3>
				</a>
			</div>
			<div class="content">
				<?php if($_SESSION['error']['addboard']!=''){?><div class="msg_warn"><?php echo$_SESSION['error']['addboard'];?></div><?php }?>
				<?php if($_SESSION['suc']['addboard']!=''){?><div class="msg_suc"><?php echo$_SESSION['suc']['addboard'];?></div><?php }?>
				<form action="" method="post" name="form_wysiwyg" id="form_wysiwyg">
					<input type="hidden" name="addnewboardmask" value="1">
					<table width="100%" class="topictable">
						<tr>
							<th colspan="2"style="padding:0px 10px;"><h3>Board Information</h3></th>
						</tr>
						<tr>
							<td style="padding:5px;" width="30%"align="right"><b>Board Title:</b></td>
							<td style="padding:5px;" align="left"><input type="text" name="title" style="width:250px;" class="blacktextbox"></td>
						</tr>
						<tr height="40">
							<td colspan="2" align="center"><input id="inputbut"type="submit" value="Add New Board"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	
<?php
	unset($_SESSION['error']['addsubboard']);
	unset($_SESSION['suc']['addsubboard']);
?>