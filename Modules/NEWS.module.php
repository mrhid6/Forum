<?php
/**
 * Created by PhpStorm.
 * User: Dominic
 * Date: 06/11/2015
 * Time: 23:33
 */



$sql=$conn->query("SELECT news FROM ".$db_prefix."latenews ORDER BY ID DESC LIMIT 1");
if($sql->num_rows > 0){
    $row=$sql->fetch_assoc();
    $news=$row['news'];
}else{
    $news="No News";
}

?>

<div id="newsStrip">
    <marquee class="innerNews">
        <?php echo $news;?>
    </marquee>
</div>
