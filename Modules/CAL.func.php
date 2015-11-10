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
	
$moddata="";
if((int)$_GET['month'] && (int)$_GET['year']){
	switch($_GET['month']){
		case"1":$mon="January";break;
		case"2":$mon="Febuary";break;
		case"3":$mon="March";break;
		case"4":$mon="April";break;
		case"5":$mon="May";break;
		case"6":$mon="June";break;
		case"7":$mon="July";break;
		case"8":$mon="August";break;
		case"9":$mon="September";break;
		case"10":$mon="October";break;
		case"11":$mon="November";break;
		case"12":$mon="December";break;
	}
	$date=strtotime($mon." ".$_GET['year']);
}else{
	$date=time();
}

$day =date("d",$date);
$month =date("m",$date);
$year =date("Y",$date);

$first_day=mktime(0,0,0,$month,1,$year);

$title=date('F',$first_day);

$day_of_week=date('D',$first_day);

switch($day_of_week){
	case"Sun":$blank=0;break;
	case"Mon":$blank=1;break;
	case"Tue":$blank=2;break;
	case"Wed":$blank=3;break;
	case"Thu":$blank=4;break;
	case"Fri":$blank=5;break;
	case"Sat":$blank=6;break;
}

$days_in_month=cal_days_in_month(0,$month,$year);

$moddata.="<table width='100%'height='95%' border='0' class='CAL roundall'>";

$moddata.="<tr>";
$moddata.="<td>Prev</td>";
$moddata.="<th colspan='5'>".$title."</th>";
$moddata.="<td>Next</td>";
$moddata.="</tr>";

$moddata.="<tr class='weekdays'>";
$moddata.="<td>S</td>";
$moddata.="<td>M</td>";
$moddata.="<td>T</td>";
$moddata.="<td>W</td>";
$moddata.="<td>T</td>";
$moddata.="<td>F</td>";
$moddata.="<td>S</td>";
$moddata.="</tr>";

$day_count=1;
$moddata.="<tr>";
while($blank>0){
	$moddata.="<td></td>";
	$blank--;
	$day_count++;
}

$day_num=1;

while($day_num<=$days_in_month){
	
	$moddata.=($day_num==$day)?"<td class='current'><b>".$day_num."</b></td>":"<td>".$day_num."</td>";
	$day_num++;
	$day_count++;
	
	if($day_count>7){
		$moddata.="</tr><tr>";
		$day_count=1;
	}
	
}
while($day_count >1 && $day_count<=7){
$moddata.="<td></td>";
$day_count++;
}
$moddata.="</tr>";
$moddata.="</table>";

echo$moddata;
?>