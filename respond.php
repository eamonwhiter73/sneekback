<?php

function getStatusCodeMessage($status)
{
    // these could be stored in a .ini file and loaded
    // via parse_ini_file()... however, this will suffice
    // for an example
    $codes = Array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    );
 
    return (isset($codes[$status])) ? $codes[$status] : '';
}
 
// Helper method to send a HTTP response code/message
function sendResponse($status=null, $body = '', $content_type = 'application/json')
{
    $status_header = 'HTTP/1.1 ' . $status . ' ' . getStatusCodeMessage($status);
    header($status_header);
    header('Content-type: ' . $content_type);
    print $body;
}

//echo "IN SCRIPT";

error_reporting(E_ALL);
    
if(isset($_POST['username']) && isset($_POST['count']) && isset($_POST['challenger'])) {
    $username = $_POST['username'];
    $count = $_POST['count'];
    $challenger = $_POST['challenger'];
}
else {
    echo "Majore prop";
}

if(file_exists('images/'.$username.'/'.$count)) {
    chdir('images/'.$username.'/'.$count);
    //mkdir($count.'/');
}
else {
    /*mkdir('images/'.$username.'/');
    mkdir('images/'.$username.'/'.$count);
    chdir('images/'.$username);*/
    echo "Error responding.";
}

$uploaddir = $username;
$file = basename($_FILES['file']['name']);
$uploadfile = $uploaddir . $file . $count . '.jpg';

if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {

    $photoPath1=$username.$challenger.$count.'.jpg';
    $photoPath2=$username.$count.'.jpg';

    //echo "IN BLOCK";

    $result = exec("/usr/bin/compare -metric RMSE ".$photoPath1." ".$photoPath2." NULL: 2>&1"); ///usr/local/Cellar/imagemagick/6.9.2-6/bin/compare
    if(!$result) {
        error_log("    *********** no result", 3, "/home1/eamondev/public_html/sneekback/error_log");
    }
    else {
        error_log($result, 3, "/home1/eamondev/public_html/sneekback/error_log");
        //error_log("    *********** no result 8888888", 3, "/home1/eamondev/public_html/sneekback/error_log");       
    }

    preg_match('#\((.*?)\)#', $result, $matches);
    $host = $matches[1];
    //print_r($matches);
    error_log("***************new\n", 3, "/home1/eamondev/public_html/sneekback/error_log");
    error_log((float)$host, 3, "/home1/eamondev/public_html/sneekback/error_log");


    
    if((float)$host < 0.300000) {
        sendResponse(200);
    }

    //if($host<0.30) {
        //echo $host;
        //echo "MATCH!";
    //}
    else {
        sendResponse(404);
    }
}
else {
    sendResponse(500);
}

?>