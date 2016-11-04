<?php
    require_once 'vendor/autoload.php';

    function getStatusCodeMessage($status) {
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

    $username = $_POST['username'];
    $count = $_POST['count'];

    if(file_exists('images/'.$username)) {
        chdir('images/'.$username);
        if(file_exists($count.'/')) {
            //
        }
        else {
            mkdir($count.'/');
        }
    }
    else {
        mkdir('images/'.$username.'/');
        mkdir('images/'.$username.'/'.$count);
        chdir('images/'.$username);
    }

    $uploaddir = $username;
    $file = basename($_FILES['file']['name']);
    $uploadfile = $uploaddir . $file;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
        rename($username.'file.jpg', $count.'/'.$username.$count.'.jpg');

        // These code snippets use an open-source library. http://unirest.io/php
        $response = Unirest\Request::get("https://netspark-nude-detect-v1.p.mashape.com/url/http%3A%2F%2Fwww.eamondev.com%2Fsneekback%2Fimages%2F".$username."%2F".$count."%2F".$username.$count.".jpg",
          array(
            "X-Mashape-Key" => "SqtDOLU9HrmshiKEbfkyZ17x2iv2p1CMgxyjsnYqjidXtRjHck",
            "Accept" => "application/json"
          )
        );

        //error_log("\n*****RESPONSE******\n", 3, "/home1/eamondev/public_html/sneekback/error_log");
        //error_log($response->code, 3, "/home1/eamondev/public_html/sneekback/error_log");

        error_log("\n*****WHYDECODE******\n", 3, "/home1/eamondev/public_html/sneekback/error_log");
        error_log("test\n" . json_encode($response, JSON_PRETTY_PRINT), 3, "/home1/eamondev/public_html/sneekback/error_log");//$whydecode, 3, "/home1/eamondev/public_html/sneekback/error_log");
        error_log("test2\n" . floatval($response->body->{"is nude"}->confidence) / 100, 3, "/home1/eamondev/public_html/sneekback/error_log");
        if(floatval($response->body->{"is nude"}->confidence) / 100 < 0.99) {
            error_log("\nPOSITITVE******\n", 3, "/home1/eamondev/public_html/sneekback/error_log");
            sendResponse(200);
        }
        else {
            sendResponse(404);
        }
    }
    else {
        //error_log("********errerereoor*******", 3, "/home1/eamondev/public_html/sneekback/error_log");
        sendResponse(404, json_encode(array("not smashing")));
    }
?>