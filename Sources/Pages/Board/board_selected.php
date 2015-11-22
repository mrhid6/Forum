<?php
/**
 * Created by PhpStorm.
 * User: Dominic
 * Date: 07/11/2015
 * Time: 22:12
 */

foreach($board_info as $b){
    if($context['currentBoard'] == $b['ID']){
        $board_info=$b;
        break;
    }
}
?>
<div class="topofboard">
    <?php if($user_info['loggedin']==1){?>
				<a data-form-link="addsubboard" data-form-data="<?php echo $context['currentBoard']?>" class="whitebut"/>
                    <span id="icon" class="bluedocument"></span>
                    Start New Sub Board!
				</a>
			<?php }else{?>
				<a class="whitebut disabledbut"><span id="icon" class="bluedocument"></span>Login to start a topic.</a>
			<?php }?>
</div>
<?php
if(canUserAccessBoard($context['currentBoard'])){
    if(! empty($board_info)){
        $board=$board_info;
        ?>
        <div id="collapsebox" class="boardbox">
            <div class="titlebox">
                <a href="<?php echo$forumurl."/board/".$board['ID']?>">
                    <h3><?php echo ucwords($board['name']);?></h3>
                </a>
            </div>
            <div class="content">
                <?php
                if(! empty($board['subboards'])){
                    foreach($board['subboards'] as $subboard){
                        ?>
                        <div class="subboard_row">
                            <div class="rowicon"><img src="<?php echo $coreImgs."/subboard.png"?>"></div>
                            <div class="rowname">
                                <a href="<?php echo$forumurl."/board/".$board['ID']."/".$subboard['ID'];?>">
                                    <h3><?php echo ucwords($subboard['name']);?></h3>
                                </a>
                            </div>
                            <div class="rowdesc">
                                <h5><?php echo $subboard['description']?></h5>
                            </div>
                            <div class="rowstats">
                                <?php echo number_format(countTopics($subboard['ID']));?> Topics<br/>
                                <?php echo number_format(CRFSB($subboard['ID']));?> Replies
                            </div>
                            <div class="rowlastedit">
                                <?php echo GetLastReplyInfo_SubBoard($subboard['ID']);?>
                            </div>
                        </div>
                    <?php }}else {
                    echo "<div class=\"msg_warn\">".errorcode(13)."</div>";
                }?>
            </div>
        </div>
        <?php
    }else {
        echo "<div class=\"msg_warn\">".errorcode(12)."</div>";
    }
}else{
    echo "<div class=\"msg_warn\">".errorcode(25)."</div>";
}