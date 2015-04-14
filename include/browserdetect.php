<?php
function ae_detect_ie()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}

function detect_ff()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false))
        return true;
    else
        return false;
}

function detect_win()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'Windows') !== false))
        return true;
    else
        return false;
}
?>