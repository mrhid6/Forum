<?php
/**
 * Xorbo Forum Systems
 *
 * @author Xorb http://www.xorbo.com
 * @copyright 2011 Xorbo Forums
 *
 * @version 3.0
 */


function checkTheFile($location){
    if(!file_exists($location)){
        return false;
    }else{
        return true;
    }
}

?>