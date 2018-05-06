<?php
session_start();
if(isset($_COOKIE["username"])){
    $_SESSION["username"]=$_COOKIE["username"];
}
if(isset($_SESSION["username"])){
    header("Location: main.php");
    exit;
}
?>
<!DOCTYPE HTML>
<html>
    <head>
    <title>Assignment2-Sign-in Form</title>
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
           $("#signinform").on("submit",function(){
                var query=$("#signinform").serialize();
               $.post("signinuser.php",query,function(data){
                   if(data.error){
                       $("#error").text(data.error)
                       $("#error").show()
                   }else{
                       window.location="main.php";
                   }
               });  
               return false;
           });
            $("#register").on("click",function(){
                window.location="register.html";
            })
        });
    </script>
    </head>
    <body class="bg-primary p-5">
        <div class="container rounded bg-white p-2">
            <div class="row">
                <div class="col pt-3 text-center">
                    <h4>Sign in</h4>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                <form id="signinform" class="p-2">
                    <div class="form-row">
                        <div class="col-sm-6 form-group">
                            <label for="username">Username/Email</label>
                            <div class="input-group"> 
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user"></i>
                                </div>
                                    </div>
                                <input type="text" required class="form-control" id="username" name="username" placeholder="Username/E-mail">
                            </div>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="username">Password</label>
                            <div class="input-group"> 
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-key"></i></div>
                                    </div>
                                <input type="password" required class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <div class="checkbox">
                                <label><input type="checkbox" name="remember"> Remember me</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form_group" style="margin-left:auto;margin-right:auto">
                            <div class="g-recaptcha" data-sitekey="6Lf_w1UUAAAAAIf-yuqgDXXEGyDYEY1jmQ1BV9kO" data-size="compact" >
                                </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="col-lg-1 form_group p-2 ml-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-clipboard-list mr-2"></i>Sign-in</button>
                        </div>
                        <div class="col-md-4 form_group p-2 ml-3 mt-2">
                            <a href="forgot.html">Forgot username or password?</a>
                        </div>
                        <div class="col-md-6 form-text text-danger" id="error" style="display:none">
                        </div>
                    </div>
                    <hr>
                   
                        <div class="form-text ml-3">
                            Don't have an account?
                        </div>
                         <div class="form_group p-2">
                            <button id="register"class="btn btn-info"><i class="fas fa-clipboard-list mr-2"></i>Register</button>
                        </div>
                    
                </form>
                </div>
            </div>
        </div>
    </body>
</html>