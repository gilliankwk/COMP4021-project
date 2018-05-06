<?php
session_start();
$status="";
$info="";
//get session name
$user = $_SESSION["username"];
if(isset($_SESSION["username"])){
}else{
    $status="error";
    $info="user credential problem";
}
/* Getting file name */
if(isset($_FILES['file']['name'])){
    $filename = $_FILES['file']['name'];
}else{
    $status="error";
    $info="file upload error";
}
/* Getting File size */
if(isset($_FILES['file']['size'])){
    $filesize = $_FILES['file']['size'];
}else{
    $status="error";
    $info="file upload error";
}
/* Location */
$location = "tempprofile_pic/".$filename.".png";

$return_arr = array();

/* Upload file */
if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
    $src = "default.png";
    
    // checking file is image or not
    if(is_array(getimagesize($location))){
        chmod($location, 0755);
        rename($location, "tempprofile_pic/".$user.".png");//rename the file as username
        $src = "tempprofile_pic/".$user.".png";
        $status="success";
        $info="";
    }else{
         $status="error";
        $info="file type error";
    }
    
}
//due with updating the pro pic source
$return_arr = array("status" => $status,"info" => $info, "src"=> $src);
echo json_encode($return_arr);