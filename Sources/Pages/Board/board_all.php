<?php
/**
 * Xorbo Forum Systems
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 2.0
 */


if(! empty($board_info)){
    foreach($board_info as $board){
        ?>
        <div id="collapsebox" class="boardbox">
            <div class="titlebox">
                <a href="<?php echo$forumurl."/board/".$board['ID']?>">
                    <h3><?php echo ucwords($board['name']);?></h3>
                </a>
            </div>
            <div class="content">
                <table width="100%" class="topictable">
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
                                    <?php echo GetLastReplyInfo($subboard['ID']);?>
                                </div>
                            </div>
                        <?php }}else {
                        echo "<div class=\"msg_warn\">".errorcode(13)."</div>";
                    }?>

                </table>
            </div>
        </div>
        <?php
    }
}else {
    echo "<div class=\"msg_warn\">".errorcode(12)."</div>";
}
?>