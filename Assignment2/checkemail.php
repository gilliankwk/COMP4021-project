<?php
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
    $output["available"]="no";
}else{
    $output["available"]="yes";
}
echo json_encode($output);
?>