<?php

header("Content-Type: application/json");

$username = $_POST['username'];
$count = $_POST['count'];
error_log("\n*****   idbyuserpost    ******"." ".$_POST['idbyuser']."\n", 3, "/home1/eamondev/public_html/sneekback/error_log");
if(isset($_POST['idbyuser'])) {
	$groupcount = $_POST['idbyuser'];
	$base64string = base64_encode(file_get_contents("images/".$username."/".$count."/".$groupcount.'/'.$username.$count.".jpg"));
}
else {
	$base64string = base64_encode(file_get_contents("images/".$username."/".$count."/".$username.$count.".jpg"));
}

echo json_encode(array("image" => $base64string));

?>