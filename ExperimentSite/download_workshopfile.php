<?php
    $parentid = $_GET['parentid'];
    $type = $_GET['type'];
    $filename = $_GET['filename'];
    
    if(strpos($parentid,'/') !== false
        || strpos($type,'/') !== false
        || strpos($filename,'/') !== false)
    {
        header("HTTP/1.0 400 Bad Request");
        exit();    
    }
    
    require_once "Includes/session.php";
    if(!is_admin())
    {
        require_role('teacher');
        //Is authorized for filename?
    } 
    
    if($type == 'batch')
    {
        $filepath = "FileUploads/batch/$parentid/$filename";
    }
    else if($type == 'workshop')
    {
        $filepath = "FileUploads/workshop/$parentid/$filename";
    }
    
    if(is_file($filepath)){
    set_time_limit(0);
    $file = @fopen($filepath,"rb");
    
    if($file)
    {
    
    $filesize = filesize($filepath);
    $start = 0;
    $end = $filesize - 1;
    
    if (isset($_SERVER['HTTP_RANGE'])) 
    {
        $range = $_SERVER['HTTP_RANGE'];
    
        $matches = array();
        preg_match('/bytes=([0-9]+)\-/', $range, $matches);
        if(count($matches) == 1)
        {
            $start = (int) $matches[0];
        } else if (count($matches) > 1)
        {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            exit;
        }
    
        preg_match('/bytes=[0-9]*\-([0-9]+)/', $range, $matches);
        if(count($matches) == 1)
        {
            $end = (int) $matches[0];
        } else if (count($matches) > 1)
        {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            exit;
        }
    
        //We must verify that the range is valid.
        header('HTTP/1.1 206 Partial Content');
        header("Content-Range: bytes $start-$end/$filesize");
    }
    
    $content_length = $end - $start + 1;
    header("Content-Length: $content_length");
    header("Accept-Ranges: bytes");
    
    $path_parts = pathinfo($filepath);
    $file_extension = $path_parts['extension'];

    header("Expires: -1");
	header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
	header("Content-Disposition: attachment; filename=\"$filename\"");
    

     $content_types =array(
     "pdf" => "application/pdf",
     "txt" => "text/plain",
     "html" => "text/html",
     "htm" => "text/html",
     "exe" => "application/octet-stream",
     "zip" => "application/zip",
     "doc" => "application/msword",
     "xls" => "application/vnd.ms-excel",
     "ppt" => "application/vnd.ms-powerpoint",
     "gif" => "image/gif",
     "png" => "image/png",
     "jpeg"=> "image/jpg",
     "jpg" =>  "image/jpg",
     "mp3" => "audio/mpeg",
     "mpg" => "video/mpeg",
     "avi" => "video/x-msvideo",
      ); 
    $content_type = isset($content_types[$file_extension]) ? $content_types[$file_extension] : "application/octet-stream";
    header("Content-Type: " . $content_type);
    
    fseek($file, $start);
    
    while(!feof($file))
    {
        print(@fread($file, 1024*8));
        ob_flush();
        flush();
                if (connection_status()!=0) 
            {
                @fclose($file);
                exit;
            }	
     }
    @fclose($file);
    } else 
    {
        header("HTTP/1.0 500 Internal Server Error");
        exit;
    }
    }
    else {
        header("HTTP/1.0 404 Not Found");
        exit;
    }
