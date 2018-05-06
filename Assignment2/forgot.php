<?php
    
//status?yes:no
//info
//get json file
$users=file_get_contents("users.json");
$users=json_decode($users,true);
//get input
$email =$_POST["email"];
$answer =$_POST["answer"];
$captcha = $_POST['g-recaptcha-response'];

//verify
$secret="6Lf_w1UUAAAAAJFf2URj-g42gHf96eC5UGnBjDD0";
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$captcha}");  
$verify = json_decode($response); 
$user=null;
foreach($users as $key){
        if($key["email"]==$email){
            $found_email=true;
            $user=$key["username"];
            break;
        }
}
if(!($answer==$users[$user]["answer"])){
    $output["status"]="no";
    $output["info"]="Answer is not correct";
}elseif($verify->success==false){
    $output["status"]="no";
    $output["info"]=$verify;
}else{
    $output["status"]="yes";
    $output["info"]="username: {$user}, password: {$users[$user]["password"]}, please remember them";
}

//output
header("content-type: application/json");
print json_encode($output);
?>