<?php
/**
 * Xorbo Forum Systems
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 2.0
 */

define('XFS', 1);

session_start();

require_once("../../Settings.php");
require_once($coredir . "/Mysql.php");

loadDatabase();

function get_settings(){
    global $db_prefix, $conn;
    $sql=$conn->query("SELECT * FROM ".$db_prefix."settings ");
    while($res=$sql->fetch_assoc()){
        $newres[$res['setting']]=$res['value'];
    }

    return$newres;
}
$context['Forum_settings'] = get_settings();
$sessionid=UnInjection($_SESSION['UserSessionid']);

$conn->query("DELETE FROM ".$db_prefix."member_online WHERE timeonline < '".date("Y-m-d H:i:s",time())."' - INTERVAL ".$context['Forum_settings']['offlinetimeout']." MINUTE");

$sql=$conn->query("SELECT ID,username FROM ".$db_prefix."members");
if($sql->num_rows > 0){
    while($res=$sql->fetch_assoc()){
        if(md5($res['username']."_".$res['ID'])==$_SESSION['loggedUser']){

            $sql=$conn->query("SELECT sessionid FROM ".$db_prefix."member_online WHERE sessionid='".$sessionid."'");
            if($sql->num_rows==1){
                $row=$sql->fetch_assoc();
                die ("1");
            }elseif($_SESSION['UserSessionid'] != ''){
                $_SESSION['forcelogout']['reason']="Due To Inactivity";
                unset($_SESSION['UserSessionid']);
                die("0");
            }
        }
    }
    echo "2";
}else{
    echo "0";
}


killConnection();

?>