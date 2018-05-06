
<?php
//json
session_start();
$json=file_get_contents("users.json");
$users=json_decode($json,true);
    //getting input
$username = trim($_POST["username"]);
$email=trim($_POST["email"]);
$firstname = trim($_POST["firstname"]);
$lastname = trim($_POST["lastname"]);
$opassword=$_POST["opassword"];
$password = $_POST["password"];
$confirm = $_POST["confirm"];
$question = $_POST["question"];
$answer=trim($_POST["answer"]);
$captcha=$_POST['g-recaptcha-response'];  
$secret="6Lf_w1UUAAAAAJFf2URj-g42gHf96eC5UGnBjDD0";
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$captcha}");  
$verify = json_decode($response);  
//checking

// Check all fields

if (empty($username) || empty($firstname) ||empty($lastname) ||empty($opassword)|| empty($password)||empty($question) ||empty($answer)){
    $output["error"] = "Not all data has been submitted!";
}
// Check all fields
elseif ($opassword !=$users[$_SESSION["username"]]["password"]){
    $output["error"] = "please enter correct old password";}
elseif ($password != $confirm){
    $output["error"] = "Passwords do not match!";}
elseif($verify->success==false){
    $output["error"] = "reCAPTCHA verification error";
}
else if (array_key_exists($username, $users)&&!($_SESSION["username"]==$username))
{
    $output["error"] = "Duplicate username exists!";
}
// Add the user
else {
    //move file from temp to not temp
    unset($users[$_SESSION["username"]]);
    if(file_exists("tempprofile_pic/".$username.".png")){
        rename("tempprofile_pic/".$username.".png", "profile_pic/".$username.".png");
        $users[$username]["photo"] = "profile_pic/".$username.".png";
    }else if(file_exists("profile_pic/".$_SESSION['username'].".png")){
        rename("profile_pic/".$_SESSION['username'].".png","profile_pic/".$username.".png");
        $users[$username]["photo"] = "profile_pic/".$username.".png";
    }else{
        $users[$username]["photo"]="";
    }
    
    // Add the user to the JSON object and save it
    $users[$username]["username"]=$username;
    $users[$username]["email"] = $email;
    $users[$username]["firstname"] = $firstname;
    $users[$username]["lastname"] = $lastname;
    $users[$username]["password"] = $password;
    $users[$username]["question"] = $question;
    $users[$username]["answer"] = $answer;

    file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
    $_SESSION['username']=$username;
    $output["success"] = "successfully change your profile";
}
//output
header("content-type: application/json");

print json_encode($output);


?>