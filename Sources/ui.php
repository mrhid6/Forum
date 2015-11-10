<?php
/**
 * Xorbo Forum Systems
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 2.0
 */

// User Interfaces!
if (!defined('XFS'))
	die('Hacking attempt...');


function GetSiteLogo(){
	global $forumurl;
	$img=req_setting("siteImage");
	return$forumurl."/Core/Images/".$img;
}

function starrating($score,$small=false){
	global $forumurl,$theme_info,$coreImgs;
	if($small==false){
		if ($score <= 0  ){$rater_stars = $coreImgs."/rating/0star.png";$rater_stars_txt="Not Rated";}
		if ($score >= 0.5){$rater_stars = $coreImgs."/rating/05star.png";$rater_stars_txt="0.5";}
		if ($score >= 1  ){$rater_stars = $coreImgs."/rating/1star.png";$rter_stars_txt="1";}
		if ($score >= 1.5){$rater_stars = $coreImgs."/rating/15star.png";$rater_stars_txt="1.5";}
		if ($score >= 2  ){$rater_stars = $coreImgs."/rating/2star.png";$rater_stars_txt="2";}
		if ($score >= 2.5){$rater_stars = $coreImgs."/rating/25star.png";$rater_stars_txt="2.5";}
		if ($score >= 3  ){$rater_stars = $coreImgs."/rating/3star.png";$rater_stars_txt="3";}
		if ($score >= 3.5){$rater_stars = $coreImgs."/rating/35star.png";$rater_stars_txt="3.5";}
		if ($score >= 4  ){$rater_stars = $coreImgs."/rating/rating/4star.png";$rater_stars_txt="4";}
		if ($score >= 4.5){$rater_stars = $coreImgs."/rating/45star.png";$rater_stars_txt="4.5";}
		if ($score >= 5  ){$rater_stars = $coreImgs."/rating/5star.png";$rater_stars_txt="5";}
	}else{
		if ($score <= 0  ){$rater_stars = $coreImgs."/rating/0star_small.png";$rater_stars_txt="Not Rated";}
		if ($score >= 0.5){$rater_stars = $coreImgs."/rating/05star_small.png";$rater_stars_txt="0.5";}
		if ($score >= 1  ){$rater_stars = $coreImgs."/rating/1star_small.png";$rater_stars_txt="1";}
		if ($score >= 1.5){$rater_stars = $coreImgs."/rating/15star_small.png";$rater_stars_txt="1.5";}
		if ($score >= 2  ){$rater_stars = $coreImgs."/rating/2star_small.png";$rater_stars_txt="2";}
		if ($score >= 2.5){$rater_stars = $coreImgs."/rating/25star_small.png";$rater_stars_txt="2.5";}
		if ($score >= 3  ){$rater_stars = $coreImgs."/rating/3star_small.png";$rater_stars_txt="3";}
		if ($score >= 3.5){$rater_stars = $coreImgs."/rating/35star_small.png";$rater_stars_txt="3.5";}
		if ($score >= 4  ){$rater_stars = $coreImgs."/rating/4star_small.png";$rater_stars_txt="4";}
		if ($score >= 4.5){$rater_stars = $coreImgs."/rating/45star_small.png";$rater_stars_txt="4.5";}
		if ($score >= 5  ){$rater_stars = $coreImgs."/rating/5star_small.png";$rater_stars_txt="5";}
	}
	return"<img src='".$rater_stars."' title='".$rater_stars_txt."'/>";
}

function GetNavBar(){
	global $forumurl, $user_info,$db_prefix,$memsurl, $conn;
	if($user_info['loggedin']==1){
		$where="WHERE access_level>='".$user_info['accesslvl']."'";
	}else{
		$where="WHERE Loggedin='0'";
	}
	$sql=$conn->query("SELECT * FROM ".$db_prefix."navbar $where");
	$ret="";
	while($res=$sql->fetch_assoc()){
		$ret.="<li><a href='".$forumurl.$res['Link']."'>".$res['Linkname']."</a></li>\n";
	}
	return$ret;
}

function genPagination($total,$currentPage,$baseLink,$nextPrev=true,$limit=10){
	if(!$total OR !$currentPage OR !$baseLink)
	{
		return false;
	}

	$limit = (int)$limit;
	//Total Number of pages
	if($total>$limit){
		$totalPages = round($total/$limit);
	}else{
		$totalPages=1;
	}
	//Text to use after number of pages
	$txtPagesAfter = ($totalPages==1)? " Page": " Pages";
	//return($totalPages);
	//Start off the list.
	$txtPageList = '<span class="roundall maspagenum">'.$totalPages.$txtPagesAfter.' :';

	//Show only 3 pages before current page(so that we don't have too many pages)
	$min = ($currentPage - 1 < $totalPages && $currentPage-1 > 0) ? $currentPage-1 : 1;

	//Show only 3 pages after current page(so that we don't have too many pages)
	$max = ($currentPage + 1 > $totalPages) ? $totalPages : $currentPage+1;

	//Variable for the actual page links
	$pageLinks = "";

	//Loop to generate the page links
	for($i=$min;$i<=$max;$i++)
	{
		if($currentPage==$i)
		{
			//Current Page
			$pageLinks .= '<b class="selectedpage pagenum">'.$i.'</b>';
		}
		else
		{
			$pageLinks .= '<a href="'.$baseLink.$i.'" class="pagenum">'.$i.'</a>';
		}
	}

	if($nextPrev)
	{
		//Next and previous links
		$next = ($currentPage + 1 > $totalPages) ? false : '<a class="pagenum"href="'.$baseLink.($currentPage + 1).'">&raquo;</a>';

		$prev = ($currentPage - 1 <= 0 ) ? false : '<a class="pagenum" href="'.$baseLink.($currentPage - 1).'">&laquo;</a>';
	}
	return $txtPageList.$prev.$pageLinks.$next."</span>";
}

function shortenString($string, $length = 10, $dots = "..."){
	return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}

function timeago($time){
	$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	$lengths = array("60","60","24","7","4.35","12","10");

	$now = time();

	$difference     = $now - $time;
	$tense         = "ago";

	for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		$difference /= $lengths[$j];
	}

	$difference = floor($difference);

	if($difference != 1) {
		$periods[$j].= "s";
	}

	return "$difference $periods[$j] ago ";
}

function GetSideBar(){
	global $context, $modsdir,$forumurl,$db_prefix,$user_info,$memsurl,$coreImgs,$conn;
	foreach($context['sidebar_mods'] as $modkey=>$mod){
		if($mod['shown']==0){
			require_once($modsdir."/".$mod['file']);
			$context['sidebar_mods'][$modkey]['shown']=1;
		}
	}
	return false;
}

function DisplayCountrylist(){
	global $db_prefix, $conn;
	$sql=$conn->query("SELECT * FROM ".$db_prefix."country");
	if($sql->num_rows > 0){
		while($row=$sql->fetch_assoc()){
			$res.="<option value='".$row['iso']."'>".$row['printable_name']."</option>";
		}
		return$res;
	}
}

function GetMoStrip(){
	global $context,$forumurl,$theme,$user_info,$db_prefix;

	$mostrip="<li><a href='$forumurl/home/'><img src='".$forumurl."/Themes/".$theme->getName()."/images/home.png' alt='Home'/></a></li>";

	switch($context['currentPage']){
		case"error":
			$mostrip.="<li><a>Error: Page Could Not Be Displayed</a></li>";
			break;
		case"home":
			$mostrip.="<li><a>Home Page</a></li>";
			break;
		case"logout":
			$mostrip.="<li><a>Logout Page</a></li>";
			break;
		case"register":
			$mostrip.="<li><a>Register Page</a></li>";
			break;
		case"addsubboard":
			if((int)$context['currentBoard']!=""){
				$board=GetBoardInfo($context['currentBoard']);
				$mostrip.="<li><a href='$forumurl/board/".$context['currentBoard']."'>".ucwords($board['name'])."</a></li>";
				$mostrip.="<li><a>Add A New Sub Board</a></li>";
			}else{
				$mostrip.="<li><a>Error Viewing Page</a></li>";
			}
			break;
		case"addtopic":
			if((int)$context['currentBoard']!="" && (int)$context['currentSubboard']!=""){
				$board=GetBoardInfo($context['currentBoard']);
				$subboard=GetSubBoardInfo($context['currentSubboard']);
				$mostrip.="<li><a href='$forumurl/board/".$context['currentBoard']."'>".ucwords($board['name'])."</a></li>";
				$mostrip.="<li><a href='$forumurl/board/".$context['currentBoard']."/".$context['currentSubboard']."'>".ucwords($subboard['name'])."</a></li>";
				$mostrip.="<li><a>Add A New Topic</a></li>";
			}else{
				$mostrip.="<li><a>Error Viewing Page</a></li>";
			}
			break;
		case"blogs":
			if((int)$context['currentBlog']==""){
				$mostrip.="<li><a>Viewing All Blogs</a></li>";
			}else{
				$sql=$conn->query("SELECT * FROM ".$db_prefix."blogs WHERE ID='".$context['currentBlog']."'");
				if($sql->num_rows > 0){
					$res=$sql->fetch_assoc();
					$mostrip.="<li><a>".$res['Blogtitle']."</a></li>";
				}else{
					$mostrip.="<li><a>Blog Was Not Found</a></li>";
				}
			}
			break;
		case"profile":
			if(checkUserExists($context['viewingProfile'])==true || $context['viewingProfile']==''){
				$text=($context['viewingProfile']=="")?"":$context['viewingProfile']."'s";
				$mostrip.="<li><a>Viewing ".ucwords($text)." Profile</a></li>";
			}else{
				$text="Error User Does Not Exist";
				$mostrip.="<li><a>".ucwords($text)."</a></li>";
			}

			break;
		case"control":
			$mostrip.="<li><a>Viewing Control Panel</a></li>";
			break;
		case"board":
			$mostrip.="<li><a href='$forumurl/board/'>All Boards</a></li>";
			if((int)$context['currentBoard']=="" && (int)$context['currentSubboard']==""){
			}else{
				$board=GetBoardInfo($context['currentBoard']);
				if($board['memonly']<=$user_info['loggedin']){
					$mostrip.="<li><a href='$forumurl/board/".$context['currentBoard']."'>".ucwords($board['name'])."</a></li>";
					if((int)$context['currentSubboard']!=""){
						$subboard=GetSubBoardInfo($context['currentSubboard']);
						$mostrip.="<li><a href='$forumurl/board/".$context['currentBoard']."/".$context['currentSubboard']."'>".ucwords($subboard['name'])."</a></li>";
					}
				}else{
					$mostrip.="<li><a>This Board Is For Members Only!</a></li>";
				}
			}
			break;
		case"topic":
			if($context['currentTopic']!=""){
				$topic=GetTopicInfo($context['currentTopic']);
				$mainboard=GetBoardInfo($topic['mainboard']);
				$subboard=GetSubBoardInfo($topic['subboard']);

				$context['currentBoard']	= $mainboard['ID'];
				$context['currentSubboard']	= $subboard['ID'];
				if($mainboard['memonly']<=$user_info['loggedin']){
					$mostrip.="<li><a href='$forumurl/board/'>All Boards</a></li>";
					$mostrip.="<li><a href='$forumurl/board/".$context['currentBoard']."'>".ucwords($mainboard['name'])."</a></li>";
					$mostrip.="<li><a href='$forumurl/board/".$context['currentBoard']."/".$context['currentSubboard']."'>".ucwords($subboard['name'])."</a></li>";
					$mostrip.="<li><a href='$forumurl/topic/".$context['currentTopic']."'>".ucwords($topic['name'])."</a></li>";
				}else{
					$mostrip.="<li><a>This Topic Is For Members Only!</a></li>";
				}
			}else{
				$mostrip.="<li><a>No Topic Has Been Defined!</a></li>";
			}
			break;
		case"replytopic":
			if($context['currentTopic']!=""){
				$topic=GetTopicInfo($context['currentTopic']);
				$mainboard=GetBoardInfo($topic['mainboard']);
				$subboard=GetSubBoardInfo($topic['subboard']);

				$context['currentBoard']	= $mainboard['ID'];
				$context['currentSubboard']	= $subboard['ID'];

				$mostrip.="<li><a href='$forumurl/board/".$context['currentBoard']."'>".ucwords($mainboard['name'])."</a></li>";
				$mostrip.="<li><a href='$forumurl/board/".$context['currentBoard']."/".$context['currentSubboard']."'>".ucwords($subboard['name'])."</a></li>";
				$mostrip.="<li><a href='$forumurl/topic/".$context['currentTopic']."'>".ucwords($topic['name'])."</a></li>";
				$mostrip.="<li><a>Add Reply</a></li>";
			}else{
				$mostrip.="<li><a>No Topic Has Been Defined!</a></li>";
			}
			break;
	}

	return$mostrip;
}
?>