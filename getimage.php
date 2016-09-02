<?php

header("Content-Type: application/json");

$username = $_POST['username'];
$count = $_POST['count'];
$base64string = base64_encode(file_get_contents("images/".$username."/".$count."/".$username.$count.".jpg"));
echo json_encode(array("image" => $base64string));

?>