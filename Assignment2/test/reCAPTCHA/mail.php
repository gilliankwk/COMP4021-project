<?php

$name=$_POST["name"];

$email=$_POST["email"];

$message=$_POST["message"];

$secret="6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe";
$response=$_POST["g-recaptcha-response"];
$verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
$captcha_success=json_decode($verify);
if ($captcha_success->success==false) {

  //This user was not verified by recaptcha.

 $output['status']="fail";

}

else if ($captcha_success->success==true) {

  //This user is verified by recaptcha

 $output['status']="success";

}
header("content-type: application/json");
echo json_encode($output);
