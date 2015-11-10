<?php
/**
 * Xorbo Forum Systems
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 2.0
 */



function getPageinationInfo(){
    global $conn, $db_prefix, $context, $forumurl;
    $res=array();

    $res['perpage'] = $context['Forum_settings']['topicpagelim'];
    $res['startlimit'] = 0;
    $res['page'] = 1;

    $pageid = $context['currentPageNum'];
    if (isset($pageid) && $pageid != 0) {
        $res['page'] = $pageid;
        $res['startlimit'] = $res['topicsperpage'] * ($res['page'] - 1);
    }


    $res['baselink'] = $forumurl . "/board/" . $context['currentBoard'] . "/" . $context['currentSubboard'] . "/";
    $count_sql = $conn->query("SELECT * FROM " . $db_prefix . "board_topics WHERE subboard='" . $context['currentSubboard'] . "' AND mainboard='" . $context['currentBoard'] . "'");
    $res['count'] = $count_sql->num_rows;

    return $res;
}

function getSubboardItems($startlim, $perpage)
{
    global $conn, $db_prefix, $context;

    $res=array();

    $sql = $conn->query("SELECT * FROM " . $db_prefix . "board_sub WHERE ID='" . $context['currentSubboard'] . "'");
    if ($sql->num_rows > 0) {
        $row=$sql->fetch_assoc();
        if(canUserAccessBoard($context['currentBoard'])){
            $res=$row;
            $res['topics']=getPinnedTopicsFromSubboard($startlim,$perpage);
            foreach(getTopicsFromSubboard($startlim,$perpage) as $topic)
                array_push( $res['topics'],$topic);
        }
    }

    return $res;
}
function getPinnedTopicsFromSubboard($startlimit, $endlimit){
    global $conn, $db_prefix, $context;

    $res=array();

    $sql=$conn->query("
          SELECT * FROM ".$db_prefix."board_topics
          WHERE subboard='".$context['currentSubboard']."'
          AND mainboard='".$context['currentBoard']."'
          AND pinned='1'
          LIMIT ".$startlimit.", ".$endlimit
    );
    if($sql->num_rows > 0){
        while($row=$sql->fetch_assoc()) {
            $res[]=$row;
        }
    }

    return $res;
}
function getTopicsFromSubboard($startlimit, $endlimit){
    global $conn, $db_prefix, $context;

    $res=array();

    $sql=$conn->query("
          SELECT * FROM ".$db_prefix."board_topics
          WHERE subboard='".$context['currentSubboard']."'
          AND mainboard='".$context['currentBoard']."'
          AND pinned='0'
          LIMIT ".$startlimit.", ".$endlimit
    );
    if($sql->num_rows > 0){
        while($row=$sql->fetch_assoc()) {
            $res[]=$row;
        }
    }

    return $res;
}

$pagination_info = getPageinationInfo();
$subboard_info=getSubboardItems($pagination_info['startlimit'], $pagination_info['perpage']);
?>

<div class="topofboard">
    <?php if($user_info['loggedin']==1){?>
				<a href="<?php echo$forumurl;?>/addtopic/<?php echo$context['currentBoard']."/".$context['currentSubboard'];?>"class="whitebut"/><span id="icon" class="bluedocument"></span>Start New Topic</a>
			<?php }else{?>
				<a class="whitebut disabledbut"><span id="icon" class="bluedocument"></span>Login to start a topic.</a>
			<?php }?>
    <?php echo genPagination($pagination_info['count'],$pagination_info['page'],$pagination_info['baselink'],true,$pagination_info['perpage'])?>
</div>

<?php if(canUserAccessBoard($context['currentBoard'])){?>
    <div id="collapsebox" class="subboardbox">
        <div class="titlebox">
            <a href="<?php echo $pagination_info['baselink']?>">
                <h3><?php echo ucwords($subboard_info['name']);?></h3>
            </a>
        </div>
        <div class="content">
            <?php
            if(! empty($subboard_info['topics'])){
                foreach($subboard_info['topics'] as $topic){
                    ?>
                    <div class="topic_row">
                        <div class="rowicon"><img src="<?php echo GetTopicTypeImg($topic['type']);?>"></div>
                        <div class="rowname">
                            <a href="<?php echo$forumurl;?>/topic/<?php echo$topic['ID'];?>">
                                <h3><?php echo ucwords($topic['name']);?></h3>
                            </a>
                        </div>
                        <div class="rowstats">
                            <?php echo number_format(countReplys($topic['ID']));?> Replies<br/>
                            <?php echo number_format($topic['views']);?> Views
                        </div>
                        <div class="rowlastedit">
                            <?php echo GetLastReplyInfo($topic['ID']);?>
                        </div>
                    </div>
                <?php }}else {
                echo "<div class=\"msg_warn\">".errorcode(13)."</div>";
            }?>
        </div>
    </div>
<?php }else{?>
    <div class="msg_warn"><?php echo errorcode(25);?></div>
<?php }?>
