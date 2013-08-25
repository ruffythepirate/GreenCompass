<?php

    function getFileSizeString($fileSize)
    {
        $sizeString = "" . $fileSize;
        if($fileSize > 1024*1024*1024)
        {
            $sizeString = number_format($fileSize/ (1024*1024*1024), 1, '.','') . " GB";
        }
        elseif ($fileSize > (1024*1024))
        {
            $sizeString = number_format($fileSize/ (1024*1024), 1, '.','') . " MB";
        }
        elseif ($fileSize > 1024)
        {
            $sizeString = number_format($fileSize/ 1024, 1, '.','') . " kB";
        }
        else 
        {
            $sizeString = $sizeString . " B";
        }
        return $sizeString;
    }

