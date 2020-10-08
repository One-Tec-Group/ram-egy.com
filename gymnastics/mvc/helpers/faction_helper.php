<?php
function namesorting($string, $len = 14) {
    $return = $string;
    if(isset($string) && $len) {
        if(strlen($string) >  $len) {
            $return = substr($string, 0,$len-2).'..';
        } else {
            $return = $string;
        }
    }

    return $return;
}