<?php
header("content-type: application/json");
$users=file_get_contents("users.json");
$users=json_decode($users,true);//as associative array
$data="null";
foreach($users as $user){
    if($user["email"]==$_GET["email"]){
       $data=$user["question"];
        break;
    }
}
$output["question"]=$data;
echo json_encode($output);
?>