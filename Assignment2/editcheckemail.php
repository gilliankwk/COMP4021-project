<?php
session_start();
header("content-type: application/json");
$users=file_get_contents("users.json");
$users=json_decode($users,true);//as associative array
$contain=false;
foreach($users as $user){
    if($user["email"]==$_GET["email"]){
        $contain=true;
    }
}
if($contain){
    if($users[$_SESSION["username"]]["email"]==$_GET["email"]){
        $output["available"]="yes";
    }else{
        $output["available"]="no";
    }
}else{
    $output["available"]="yes";
}
echo json_encode($output);
?>