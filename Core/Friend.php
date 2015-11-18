<?php
/**
 * Xorbo Forum Systems
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 3.0
 */

if (!defined('XFS'))
    die('Hacking attempt...');

function addfriend($friendid){
    global $db_prefix, $user_info, $conn;

    if($friendid!=$user_info['ID']){
        $therearray=GetotherMember($friendid);
        if(!in_array($friendid,$user_info['friends']) && !in_array($user_info['ID'],$therearray['friends'])){
            $myarray=$user_info['friends'];
            $myarray[]=$friendid;
            $therearray=$therearray['friends'];
            $therearray[]=$user_info['ID'];

            $mynewfriends="";
            $therenewfriends="";

            foreach($myarray as $fri){
                $mynewfriends.=($mynewfriends=="")?$fri:"+".$fri;
            }
            foreach($therearray as $thfri){
                $therenewfriends.=($therenewfriends=="")?$thfri:"+".$thfri;
            }
            $conn->query("UPDATE ".$db_prefix."members SET friend_array='".$mynewfriends."' WHERE ID='".$user_info['ID']."'");
            $conn->query("UPDATE ".$db_prefix."members SET friend_array='".$therenewfriends."' WHERE ID='".$friendid."'");
            return"Suc";
        }else{
            return"Error1";
        }
    }else{
        return"Error2";
    }
}

function removefriend($friendid){
    global $db_prefix, $user_info, $conn;

    if($friendid!=$user_info['ID']){
        $therearray=GetotherMember($friendid);
        if(in_array($friendid,$user_info['friends']) && in_array($user_info['ID'],$therearray['friends'])){
            $myarray=$user_info['friends'];

            $therearray=$therearray['friends'];

            $fri_arr_mem1="";
            $fri_arr_mem2="";

            foreach($myarray as $fri){
                $fri_arr_mem1.=($fri_arr_mem1=="")?$fri:"+".$fri;
            }
            foreach($therearray as $thfri){
                $fri_arr_mem2.=($fri_arr_mem2=="")?$thfri:"+".$thfri;
            }

            $fri_arr_mem1=str_replace($friendid,"",$fri_arr_mem1);
            $fri_arr_mem2=str_replace($user_info['ID'],"",$fri_arr_mem2);

            $first1=$fri_arr_mem1[0];
            $first2=$fri_arr_mem2[0];

            $last1=$fri_arr_mem1[strlen($fri_arr_mem1)-1];
            $last2=$fri_arr_mem2[strlen($fri_arr_mem2)-1];

            if($first1=="+"){$fri_arr_mem1=substr($fri_arr_mem1,1);}
            if($first2=="+"){$fri_arr_mem2=substr($fri_arr_mem2,1);}

            if($last1=="+"){$fri_arr_mem1=substr($fri_arr_mem1,0,-1);}
            if($last2=="+"){$fri_arr_mem2=substr($fri_arr_mem2,0,-1);}

            $fri_arr_mem1=str_replace("++","+",$fri_arr_mem1);
            $fri_arr_mem2=str_replace("++","+",$fri_arr_mem2);

            $notokin=array("++","+ +"," + +","+ + "," + + ");

            $fri_arr_mem1=str_replace($notokin,'',$fri_arr_mem1);
            $fri_arr_mem2=str_replace($notokin,'',$fri_arr_mem2);

            $conn->query("UPDATE ".$db_prefix."members SET friend_array='".$fri_arr_mem1."' WHERE ID='".$user_info['ID']."'");
            $conn->query("UPDATE ".$db_prefix."members SET friend_array='".$fri_arr_mem2."' WHERE ID='".$friendid."'");
            return"Suc";
        }else{
            return"Error1";
        }
    }else{
        return"Error2";
    }
}
?>