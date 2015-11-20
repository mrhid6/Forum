<?php
/**
 * Xorbo Forum Systems
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 2.0
 */


$page_info=array();


function loadPageInfo(){
    global $page_info, $conn, $db_prefix;

    $sql=$conn->query("SELECT * FROM ".$db_prefix."pages ");

    if($sql->num_rows > 0){
        while($res=$sql->fetch_assoc()) {
            $page_info['pages'][$res['ID']] = $res;
        }
    }

    $page_info['currentPage'] = validatePage($_GET['page']);
}

function getHomePage(){
    global $forumurl, $page_info;

    return $forumurl.$page_info['pages']['1']['link'];
}

function checkAccessToPage(){
    if(!canAccessPage()){
        header("location: ".getHomePage());
    }
}

function canAccessPage(){
    global $user_info, $page_info, $context;

    if($user_info['loggedin'] == 0 && getAccessLevel() > 0){
        if($page_info['currentPage'] == "profile" && $context['viewingProfile'] != ""){
            return true;
        }

        return false;
    }else if($user_info['loggedin'] == 1 && getAccessLevel() > $user_info['group']['ID']){
        return false;
    }
    return true;
}

function getAccessLevel(){
    global $page_info;

    $p = getPage($page_info['currentPage']);

    if(!empty($p) && isset($p['accesslvl'])){
        return $p['accesslvl'];
    }
}

function getPage($var){
    global $page_info;
    foreach($page_info['pages'] as $page){
        if($page['pagename'] == $var)
            return $page;
    }

    return array();
}

function validatePage($var){
    global $page_info;

    $var=strtolower($var);
    if($var==''){
        return "home";
    }else{

        $pages = $page_info['pages'];

        foreach($pages as $page){
            if($page['pagename'] == $var){
                return $var;
            }
        }
        return "error";
    }
}

?>