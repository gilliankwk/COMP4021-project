<?php
$secret="6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe";
if(isset($_POST['g-recaptcha-response'])){  
    $captcha=$_POST['g-recaptcha-response'];  
}

$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha);  
$response = json_decode($response, true);  
if(!empty($response["success"]))  
{  
    echo 'Thanks for your message!';  
} else {  
    echo 'Error';  
} 
?>