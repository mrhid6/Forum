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

function discover_boardPageType(){
	global $context;
	if($context['currentBoard'] == 0 && $context['currentSubboard'] == 0){
		return "board_all";
	}elseif($context['currentBoard'] > 0 && $context['currentSubboard'] == 0){
		return "board_selected";
	}elseif($context['currentBoard'] > 0 && $context['currentSubboard'] > 0){
		return "subboard_selected";
	}
}

function getAllBoards()
{
	global $db_prefix, $conn, $user_info;
	$where = ($user_info['loggedin'] == 0) ? "WHERE memonly='0'" : "";
	$sql = $conn->query("SELECT * FROM " . $db_prefix . "board $where");

	if($sql->num_rows > 0){
		$id=0;
		while($row=$sql->fetch_assoc()) {
			$res[$id]['ID'] = $row['ID'];
			$res[$id]['name'] = $row['name'];


			$sid=0;
			$sql2=$conn->query("SELECT * FROM ".$db_prefix."board_sub WHERE mainboard='".$res[$id]['ID']."'");
			if($sql2->num_rows > 0){
				while($row2=$sql2->fetch_assoc()) {
					$res[$id]['subboards'][$sid]['ID']=$row2['ID'];
					$res[$id]['subboards'][$sid]['name']=$row2['name'];
					$res[$id]['subboards'][$sid]['description']=$row2['description'];
					$sid++;
				}
			}
			$id++;
		}
	}

	return $res;
}

$board_info=getAllBoards();

include("Board/".discover_boardPageType().".php");
?>