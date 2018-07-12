<?php
function truncate($str, $pos = 80)
{
    if(strlen($str)>$pos){
        $substring = substr($str,0,$pos);
        while(substr($substring,-1,1)!=" "){
            $pos--;
            $substring = substr($str,0,$pos);
        }
        return $substring."...";
    }
    else
    {
        return $str;
    }
}