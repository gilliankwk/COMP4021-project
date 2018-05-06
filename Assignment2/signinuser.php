<?php
//get json file
$users=file_get_contents("users.json");
$users=json_decode($users,true);
//get input
$credential = $_POST["username"];
$password = $_POST["password"];
$captcha = $_POST['g-recaptcha-response'];
$remember = false;
if(isset($_POST["remember"])){
    $remember=true;
}
//verify
$secret="6Lf_w1UUAAAAAJFf2URj-g42gHf96eC5UGnBjDD0";
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$captcha}");  
$verify = json_decode($response); 

$found_email=false;
$user=null;

foreach($users as $key){
        if($key["email"]==$credential){
            $found_email=true;
            $user=$key["username"];
            break;
        }
}
$found_name=false;
if(array_key_exists($credential,$users)){
    $found_name=true;
    $user=$credential;
}
if(!($found_email||$found_name)){
    $output["error"]="credential not found";
}elseif($users[$user]["password"]!=$password){
     $output["error"]="wrong password";
}elseif($verify->success==false){
     $output["error"]="reCAPTCHA verification error";
}else{
     session_start();
    $_SESSION["username"] = $user;

    $output["success"] = "";
    if($remember){
        setcookie("username", $user, time() + (86400 * 30), "/");
    }
}
//output
header("content-type: application/json");
print json_encode($output);
?>