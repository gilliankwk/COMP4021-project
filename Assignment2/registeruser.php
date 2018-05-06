<?php
//json
$json=file_get_contents("users.json");
$users=json_decode($json,true);
    //getting input
$username = trim($_POST["username"]);
$email=trim($_POST["email"]);
$firstname = trim($_POST["firstname"]);
$lastname = trim($_POST["lastname"]);
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
if (array_key_exists($username, $users))
{$output["error"] = "Duplicate username exists!";}
elseif (empty($username) || empty($firstname) ||empty($lastname) || empty($password) ||empty($answer)){
    $output["error"] = "Not all data has been submitted!";
}
// Check all fields
elseif ($password != $confirm){
    $output["error"] = "Passwords do not match!";}
elseif($verify->success==false){
    $output["error"] = "reCAPTCHA verification error";
}

// Add the user
else {
    // Add the user to the JSON object and save it
    $users[$username]["username"]=$username;
    $users[$username]["email"] = $email;
    $users[$username]["firstname"] = $firstname;
    $users[$username]["lastname"] = $lastname;
    $users[$username]["password"] = $password;
    $users[$username]["photo"] = "";
    $users[$username]["question"] = $question;
    $users[$username]["answer"] = $answer;

    file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));

    // Set up the session
    session_start();
    $_SESSION["username"] = $username;

    $output["success"] = "";
}
//output
header("content-type: application/json");

print json_encode($output);


?>