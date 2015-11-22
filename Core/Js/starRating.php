<?php
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

define('XFS', 1);
include("../../Settings.php");
include($coredir."/Mysql.php");

function round_to_half($num)
{
	if($num >= ($half = ($ceil = ceil($num))- 0.5) + 0.25) return $ceil;
	else if($num < $half - 0.25) return floor($num);
	else return $half;
}

loadDatabase();

$data = explode(",",$_POST['starData']);
$task = UnInjection($data['0']);

switch($task){

	case "topic":
			$id = UnInjection($data['1']);
			$rating = UnInjection($data['2']);
			if($rating > 5 || $rating <=0 ){
				die("Error");
			}
			$sql = $conn->query("SELECT ID,Rating_score,Rating_count FROM ".$db_prefix."board_topics WHERE ID='".$id."'");
			if($sql->num_rows == 1){

				$row = $sql->fetch_assoc();
				$conn->query("UPDATE ".$db_prefix."board_topics SET
				Rating_Score = Rating_score + ".$rating.",
				Rating_count = Rating_count + 1
				WHERE ID='".$id."'");

				$currentrate=($row['Rating_score']+$rating) / ($row['Rating_count']+1);
				$currentrate=round_to_half($currentrate);
				$currentpercent=0;
				for($i=0;$i<$currentrate;$i=$i+0.5){
					$currentpercent=$currentpercent+10;
				}
				echo $currentpercent;
			}
		break;

}

?>