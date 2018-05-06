<?php
header("content-type: application/json");
$users=file_get_contents("users.json");
$users=json_decode($users,true);//as associative array

//check usernam and make output
if(array_key_exists($_GET["username"],$users)){
    $output["available"]="no";
}else{
    $output["available"]="yes";
}
print json_encode($output);
?>