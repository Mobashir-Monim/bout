<?php

namespace App\Helpers;

class Helper
{
    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        
        return substr($haystack, 0, $length ) === $needle;
    }
   
    function endsWith($haystack, $needle)
    {
       $length = strlen($needle);
       
       if(!$length) {
           return true;
       }

       return substr($haystack, -$length) === $needle;
    }

    function success($message)
    {
        flash($message)->success();
    }

    function error($message)
    {
        flash($message)->error();
    }
    
    function warning($message)
    {
        flash($message)->warning();
    }
}