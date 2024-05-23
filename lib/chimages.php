<?php
// return the browser request header 
// use built in apache ftn when PHP built as module, 
// or query $_SERVER when cgi 
function getRequestHeaders() 
{ 
    if (function_exists("apache_request_headers")) 
    { 
        if($headers = apache_request_headers()) 
        { 
            return $headers; 
        } 
    } 

    $headers = array(); 
    // Grab the IF_MODIFIED_SINCE header 
    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) 
    { 
        $headers['If-Modified-Since'] = $_SERVER['HTTP_IF_MODIFIED_SINCE']; 
    } 
    return $headers; 
}

// Return the requested graphic file to the browser 
// or a 304 code to use the cached browser copy 
function displayGraphicFile ($graphicFileName, $fileType='jpeg') 
{ 
    $fileModTime = filemtime($graphicFileName); 
    // Getting headers sent by the client. 
    $headers = getRequestHeaders(); 
    // Checking if the client is validating his cache and if it is current. 
    if (isset($headers['If-Modified-Since']) && 
        (strtotime($headers['If-Modified-Since']) == $fileModTime)) 
    { 
        // Client's cache IS current, so we just respond '304 Not Modified'. 
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', $fileModTime).
                ' GMT', true, 304); 
    } 
    else 
    { 
        // Image not cached or cache outdated, we respond '200 OK' and output the image. 
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', $fileModTime).
                ' GMT', true, 200); 
        header('Content-type: image/'.$fileType); 
        header('Content-transfer-encoding: binary'); 
        header('Content-length: '.filesize($graphicFileName)); 
        readfile($graphicFileName); 
    } 
} 
?>