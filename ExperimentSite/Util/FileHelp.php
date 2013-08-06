<?php

    function getFileSizeString($fileSize)
    {
        $sizeString = "" . $fileSize;
        if($fileSize > 1e9)
        {
            $sizeString = number_format($fileSize/ 1e9, 1, '.','') . " GB";
        }
        elseif ($fileSize > 1e6)
        {
            $sizeString = number_format($fileSize/ 1e6, 1, '.','') . " MB";
        }
        elseif ($fileSize > 1e3)
        {
            $sizeString = number_format($fileSize/ 1e3, 1, '.','') . " kB";
        }
        return $sizeString;
    }

