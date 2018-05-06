<?php
//get json file
$users=file_get_contents("users.json");
$users=json_decode($users,true);
//get input
$credential = "kiki";
$password = "1234";


$found_email=false;
$user=null;

foreach($users as $key){
    echo "search credential: ".$credential."<br>";
    echo "search email: ".$key["email"]."<br>";
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
echo "<br>credential: ".$credential."<br>";
echo "user: ".$user."<br>";
echo "find email: ".$found_email."<br>";
echo "find name: ".$found_name."<br>";
?>