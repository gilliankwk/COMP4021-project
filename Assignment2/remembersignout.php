<?php
session_start();

// Check for the username session variable
if (!isset($_SESSION["username"])) {
    header("Location: signin.php");
    exit;
}
if (!isset($_COOKIE["username"])) {
    header("Location: signin.php");
    exit;
}

// Read the JSON file
$users = file_get_contents("users.json");
$users = json_decode($users, true);

// Validate the user
if (!array_key_exists($_SESSION["username"], $users)) {
    header("Location: signin.php");
    exit;
}
?>
<!DOCTYPE HTML>
<html>
    <head>
    <title>Assignment2-Special sign-out Form</title>
     <meta charset="utf-8">
    <meta name="viewport" 
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
     <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css">
    <script>
        $(document).ready(function(){
           $("#signoutform").on("submit",function(){
                if($("select").val()==1){
                    var query=$("#signoutform").serialize();
                    $.get("signout.php",query,function(data){
                       if(data.status!="error"){
                           $("#signoutform").hide();
                           $("#alert").show();
                       } 
                    });
                    return false;
                }else{
                    window.location="signout.php?option=2";
                    return false;
                }
           });
        });
    </script>
    </head>
    <body class="bg-primary p-5">
        <div class="container rounded bg-white p-2">
            <div class="row">
                <div class="col pt-3 text-center">
                    <h4>Sign Out</h4>
                </div>
            </div>
            <hr>
            <div class="row" id="form">
                <div class="col">
                <form id="signoutform" class="p-2">
                    <div class="form-row">
                        <div class="form-group col">
                            <div class="form-group">
                                <label for="signoutoption">Sign Out option:</label>
                                    <select class="form-control" name=option id="signoutoption">
                                        <option value="1">keep remember me</option>
                                        <option value="2">not remember me anymore</option>
                                    </select>
                                </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="col-lg-1 form_group p-2 ml-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-clipboard-list mr-2"></i>Sign-out</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <div class="row" id="alert" style="display:none">
                <div class="col m-5 text-center p-5 text-success">
                    <small><i class="far fa-smile"></i>successfully sign out</small>
                </div>
            </div>
        </div>
    </body>
</html>