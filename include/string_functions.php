<?php

function ordinal_suffix($value, $sup = 0){
// Function written by Marcus L. Griswold (vujsa)
// Can be found at http://www.handyphp.com
// Do not remove this header!

    is_numeric($value) or trigger_error("<b>\"$value\"</b> is not a number!, The value must be a number in the function <b>ordinal_suffix()</b>", E_USER_ERROR);
    if(substr($value, -2, 2) == 11 || substr($value, -2, 2) == 12 || substr($value, -2, 2) == 13){
        $suffix = "th";
    }
    else if (substr($value, -1, 1) == 1){
        $suffix = "st";
    }
    else if (substr($value, -1, 1) == 2){
        $suffix = "nd";
    }
    else if (substr($value, -1, 1) == 3){
        $suffix = "rd";
    }
    else {
        $suffix = "th";
    }
    if($sup){
        $suffix = "<sup>" . $suffix . "</sup>";
    }
    return $value . $suffix;
}

?>