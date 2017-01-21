<?php
/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:53
 */

// Function to escape all quotes
// ENT_QUOTES escapes all single and double quotes
function escape($string){
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}