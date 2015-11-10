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
	
	function addBoard($title){
		global $db_prefix, $conn;
		$title=UnInjection($title,"basic");
		$desc=UnInjection($desc,"basic");
		
		if($title!=''){
			$sql=$conn->query("SELECT * FROM ".$db_prefix."board WHERE name='".$title."'");
			if($sql->num_rows == 0){
				$sql=$conn->query("INSERT INTO ".$db_prefix."board SET name='".$title."'");
				if($sql){
					$res["result"]="suc";
					$res["return"]="Board Has Been Added!";
				}
			}else{
				$res["result"]="error";
				$res["return"]=errorcode(36);
			}
		}else{
			$res["result"]="error";
			$res["return"]=errorcode(35);
		}
		return $res;
	}
	function addSubboard($title,$desc="",$board){
		global $db_prefix, $conn;
		$title=UnInjection($title,"basic");
		$desc=UnInjection($desc,"basic");
		
		if($title!='' && $board!=''){
			$sql=$conn->query("SELECT * FROM ".$db_prefix."board_sub WHERE name='".$title."' AND mainboard='".$board."'");
			if($sql->num_rows == 0){
				$sql=$conn->query("INSERT INTO ".$db_prefix."board_sub SET
				name='".$title."',
				mainboard='".$board."'");
				if($sql){
					$res["result"]="suc";
					$res["return"]="Sub Board Has Been Added!";
				}
			}else{
				$res["result"]="error";
				$res["return"]=errorcode(27);
			}
		}else{
			$res["result"]="error";
			$res["return"]=errorcode(26);
		}
		return$res;
	}
	function addTopic($title,$desc="",$text,$board,$subboard,$user){
		global $db_prefix, $conn;
		$title=UnInjection($title);
		$desc=UnInjection($desc);
		$text=$conn->real_escape_string(StripScripts($text));
		
		if($title!='' && $text!='' && $board!='' && $subboard!='' && $user!=''){
			$sql=$conn->query("SELECT * FROM ".$db_prefix."board_topics WHERE name='".$title."'");
			if($sql->num_rows == 0){
				$sql=$conn->query("INSERT INTO ".$db_prefix."board_topics SET
				name='".$title."',
				mainboard='".$board."',
				subboard='".$subboard."',
				type='1',
				datestarted='".date("Y-m-d H:i:s",time())."',
				startedby='".$user."'");
				if($sql){
					$insertid=$conn->insert_id;
					$sql1=$conn->query("INSERT INTO ".$db_prefix."board_topicreply SET
					topicid='".$insertid."',
					userid='".$user."',
					text='".$text."',
					dateadded='".date("Y-m-d H:i:s",time())."'");
					if($sql1){
						$res["result"]="suc";
						$res["return"]="Topic Has Been Added!";
					}
				}
			}else{
				$res["result"]="error";
				$res["return"]=errorcode(20);
			}
		}else{
			$res["result"]="error";
			$res["return"]=errorcode(19);
		}
		return$res;
	}
	function addTopicReply($reply,$topic,$user){
		global $db_prefix, $conn;
		$reply=$conn->real_escape_string(StripScripts($reply));
		if($reply!=""){
			$sql1=$conn->query("INSERT INTO ".$db_prefix."board_topicreply SET
				topicid='".$topic."',
				userid='".$user."',
				text='".$reply."',
				dateadded='".date("Y-m-d H:i:s",time())."'");
			if($sql1){
				$res["result"]="suc";
				$res["return"]="Reply Has Been Added!";
			}
		}else{
			$res["result"]="error";
			$res["return"]=errorcode(34);
		}
		return$res;
	}
	function GetBoardInfo($board){
		global $db_prefix, $conn;
		$sql=$conn->query("SELECT * FROM ".$db_prefix."board WHERE ID='".(int)$board."'");
		if($sql->num_rows == 1){
			$res=$sql->fetch_assoc();
			return$res;
		}else{
			$res['name']="Error";
			return$res;
		}
	}

	function isMemberOnlyBoard($boardid){
		global $conn, $db_prefix;
		$sql=$conn->query("SELECT memonly FROM ".$db_prefix."board WHERE ID='".(int)$boardid."'");
		if($sql->num_rows == 1){
			$res=$sql->fetch_assoc();
			return (boolean)$res['memonly'];
		}else{
			$res['name']="Error";
			return$res;
		}
	}

	function canUserAccessBoard($boardid){
		global $user_info;

		return (isMemberOnlyBoard($boardid) <= $user_info['loggedin']);
	}

	function GetSubBoardInfo($subboard){
		global $db_prefix, $conn;
		$sql=$conn->query("SELECT * FROM ".$db_prefix."board_sub WHERE ID='".(int)$subboard."'");
		if($sql->num_rows == 1){
			$res=$sql->fetch_assoc();
			return$res;
		}else{
			$res['name']="Error";
			return$res;
		}
	}
	function GetTopicInfo($topicid){
		global $db_prefix, $conn;
		$sql=$conn->query("SELECT * FROM ".$db_prefix."board_topics WHERE ID='".(int)$topicid."'");
		if($sql->num_rows == 1){
			$res=$sql->fetch_assoc();
			return$res;
		}else{
			$res['name']="Error";
			return$res;
		}
	}
	function GetTopicTypeImg($type){
		global $coreImgs;
		
		switch($type){
			case"1":$ret=$coreImgs."/normal.png";break;
			case"2":$ret=$coreImgs."/poll.png";break;
			case"3":$ret=$coreImgs."/hot.png";break;
		}
		return$ret;
	}
	function countReplys($topicid){
		global $db_prefix, $conn;

		$sql=$conn->query("SELECT * FROM ".$db_prefix."board_topicreply WHERE topicid='".$topicid."'");
		$count=($sql->num_rows)-1;

		return ($count<0)?0:$count;
	}
	function countTopics($subboardid="",$user=""){
		global $db_prefix, $conn;
		$where="";
		if($subboardid!="" && $user==""){
			$where="WHERE subboard='".$subboardid."'";
		}else{
			$where="WHERE startedby='".$user."'";
		}
		$sql=$conn->query("SELECT * FROM ".$db_prefix."board_topics $where");
		$count=$sql->num_rows;
		return $count;
	}
	function CRFSB($subboardid){
		global $db_prefix, $conn;
		$sql=$conn->query("SELECT * FROM ".$db_prefix."board_topics WHERE subboard='".$subboardid."'");
		if($sql->num_rows > 0){
			$count=0;
			while($res=$sql->fetch_assoc()){
				$newsql=$conn->query("SELECT * FROM ".$db_prefix."board_topicreply WHERE topicid='".$res['ID']."'");
				$count=($newsql->num_rows == 0)? $count : $count+($newsql->num_rows)-1;
			}
		}
		return $count;
	}
	function UpdateTopicView($topicid){
		global $db_prefix, $conn;
		$conn->query("UPDATE ".$db_prefix."board_topics SET views= views+1 WHERE ID='".$topicid."'");
		return false;
	}
	function GetLastReplyInfo($id){
		global $db_prefix, $memsurl, $forumurl, $conn;
		$sql=$conn->query("SELECT * FROM ".$db_prefix."board_topicreply WHERE topicid='".$id."' ORDER BY ID DESC LIMIT 1");
		$ret="";
		if($sql->num_rows > 0){

			$res=$sql->fetch_assoc();

			$topic=GetTopicInfo($res['topicid']);

			$time=strtotime($res['dateadded']);

			$ret="<img src=\"".$memsurl."/".GetMemDp($res['userid'],"small")."\">";
			$ret.="<a href='".$forumurl."/topic/".$topic['ID']."'>".shortenString($topic['name'])."</a><br/>";
			$ret.="By <a href='".$forumurl."/profile/".GetotherMember($res['userid'],"username")."'>".ucwords(GetotherMember($res['userid'],"username"))."</a>, ".timeago($time);
		}
		return$ret;
	}
?>