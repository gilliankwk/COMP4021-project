<?php
session_start();
$credential="";
if(isset($_SESSION["username"])){
    $credential=file_get_contents("users.json");
    $credential=json_decode($credential,true);
}else{
     header("Location: signin.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Assignment2-EditProfile</title>
     <meta charset="utf-8">
    <meta name="viewport" 
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
     <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css">
            <!--showing pro pic-->
    <style>
        .profile-header-container{
            margin: 0 auto;
            text-align: center;
        }


        .profile-header-img > img.img-circle {
            width: 120px;
            height: 120px;
            border: 2px solid #51D2B7;
            border-radius: 60px;
        }

        .profile-header {
            margin-top: 43px;
        }

/**
 * Ranking component
 */
        .rank-label-container {
            margin-top: -19px;
    /* z-index: 1000; */
            text-align: center;
        }

        .label.label-default.rank-label {
            background-color: rgb(81, 210, 183);
            padding: 5px 10px 5px 10px;
            border-radius: 27px;
        }
    </style>
<!--image upload handling-->
    <style>
        .upload-area{
            width: 100%;
            height: 200px;
            border: 2px dashed lightgray;
            border-radius: 3px;
            margin: 0 auto;
            margin-top: 1em;
            text-align: center;
            overflow: auto;
        }
        .upload-area.highlight{
            border: 2px dashed gray ;
            border-radius: 3px;
        }

        .upload-area:hover{
            cursor: pointer;
        }

        #areatext{
            text-align: center;
            font-weight: normal;
            font-family: sans-serif;
            line-height: 50px;
            color: lightgray;
        }

        #file{
            display: none;
        }
    </style>
    <script>
         $(document).ready(function() {

    // preventing page from redirecting
            $("html").on("dragover", function(e) {
                e.preventDefault();
                e.stopPropagation();
                $("#areatext").text("Drag here");
            });
             $("html").on("drop", function(e) { 
                 e.preventDefault(); 
                 e.stopPropagation(); 
             });
    // Drag enter
             $('.upload-area').on('dragenter', function (e) {
                e.stopPropagation();
                e.preventDefault();
                 $(".upload-area").addClass("highlight")
                $("#areatext").text("Drop");
            });
    // Drag over
            $('.upload-area').on('dragover', function (e) {
                e.stopPropagation();
                e.preventDefault();
                $(".upload-area").addClass("highlight");
                $("#areatext").text("Drop");
            });
    //Drag leave
             $('.upload-area').on('dragleave', function (e) {
                e.stopPropagation();
                e.preventDefault();
                $(".upload-area").removeClass("highlight");
                $("#areatext").text("Drag here");
            });
    // Drop
            $('.upload-area').on('drop', function (e) {
                e.stopPropagation();
                e.preventDefault();
                $(".upload-area").removeClass("highlight");
                $("#areatext").html("Drag and Drop file here<br/>Or<br/>Click to select file");
                var file = e.originalEvent.dataTransfer.files;
                var fd = new FormData();
                fd.append('file', file[0]);
                uploadData(fd);
            });
    // Open file selector on div click
            $("#uploadfile").click(function(){
                $("#file").click();
            });

    // file selected
            $("#file").change(function(){
                var fd = new FormData();
                var files = $('#file')[0].files[0];
                fd.append('file',files);
                uploadData(fd);
            });
         });

// Sending AJAX request and upload file
        function uploadData(formdata){
            $.ajax({
                url: 'editprofilehandle.php',
                type: 'post',
                data: formdata,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response){
                    changeProPic(response);
                }
            });
        }
        function changeProPic(data){
            var status=data.status;
            var info=data.info;
            var source=data.src;
            $("#pic").attr("src",source+"?timestamp=" + new Date().getTime());
            if(status=="error"){
                $("#propicstatus").removeClass("text-success");
                $("#propicstatus").addClass("text-danger");
                $("#propicstatus").text("Error: "+info);
                $("#propicstatus").show();
            }else{
                $("#propicstatus").addClass("text-success");
                $("#propicstatus").removeClass("text-danger");
                $("#propicstatus").text("Success: profile picture uploaded successfully");
                $("#propicstatus").show();
            }
        }

    </script>
<!--form upload handling-->
        <script>
            $(document).ready( function(){
			$("#usernameerror").hide();
			$("#emailerror").hide();
        $("#editForm").on("submit",function(){
                //check email error
                if($("#emailerror").css("display")!="none"){
                    alert("please try another email!");
                    $("#email").focus();
                    return false;
                }
                //check username error
                if($("#usernameerror").css("display")!="none"){
                    alert("please try another username");
                    $("#username").focus();
                    return false;
                }
                //check password
                if($("#password").val()!=$("#confirm").val()){
                    alert("password confirmation problem, please double check your password");
                    $("#password").focus();
                    return false;
                }
            //check propic
                if(($("#propicstatus").hasClass("text-danger"))&&($("#propicstatus").css("display")!="none")){
                    console.log(($("#propicstatus").hasClass("text-danger")));
                    console.log(($("#propicstatus").css("display")!="none"));
                    alert("Profile picture error, please change reupload image");
                    return false;
                }
                //submit form
                var query=$("#editForm").serialize();
                $.post("editprofilehandle-1.php",query,function(data){
                    if(data.error){
                        $("#success").removeClass("text-success");
                        $("#success").addClass("text-danger");
                        $("#success").text(data.error);
                        setTimeout(function(){
                            window.location="editprofile.php";
                        },4000);
                    }else{
                        $("#success").addClass("text-success");
                        $("#success").removeClass("text-danger");
                        $("#success").text(data.success);
                        setTimeout(function(){
                            window.location="main.php";
                        },4000);
                    }
                });
                return false;//very important ensure the page won't go to another URL
            });
            //ajax check username
            $("#username").on("change",function(){
                $("#usernameerror").hide();
                if($("#username").val!=""){
                    var query="username="+encodeURIComponent($("#username").val());
                    $.getJSON("editcheckuser.php",query,function(data){
                        if(data.available=="no"){
                            $("#usernameerror").show();
                        }else{
                            $("#usernameerror").hide();
                        }
                    });
                }
            });
            //ajax check email
            $("#email").on("change",function(){
                $("#emaileerror").hide();
                if($("email").val!=""){
                    var query="email="+encodeURIComponent($("#email").val());
                    $.getJSON("editcheckemail.php",query,function(data){
                        if(data.available=="no"){
                            $("#emailerror").show();
                        }else{
                            $("#emailerror").hide();
                        }
                    });
                }
            });
            $("#back").on("click",function(){
                window.location="main.php";
                return false;
            })
        });
        </script>
    </head>
    <body class="bg-primary p-5">
        <div class="container rounded bg-white p-2">
            <div class="row">
                <div class="col p-2 text-center">
                    <h4>Edit Profile</h4>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="container rounded bg-light">
                    <div class="row">
                        <div class="col text-center p-3">
                            <h5>Profile picture</h5>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col">
                                <div class="profile-header-container">   
    		                      <div class="profile-header-img pt-3">
                                        <?php 
                                        $location="profile_pic/".$_SESSION["username"].".png";
                                        if(file_exists($location)){
                                            echo "<img id='pic' class='img-circle' src=".$location." />";
                                        }else{
                                            echo "<img id='pic' class='img-circle' src='profile_pic/untitle.png' />";
                                        }
                                        ?>
                        <!-- badge -->
                                        <div class="rank-label-container">
                                        <span class="label label-default rank-label"><?php
                                                echo $_SESSION["username"];
                                            ?></span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="container" >
                                <input type="file" name="file" id="file">
            
                                <!-- Drag and Drop container-->
                                <div class="upload-area"  id="uploadfile">
                                    <h5 id="areatext">Drag and Drop file here<br/>Or<br/>Click to select file</h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center text-danger p-3" id="propicstatus" style="display:none;" >
                                
                            </div>
                        </div>
                        <hr>
                         <div class="row p-2">                                
 
                            <div class="col text-center">
                                <button id="back" class="btn btn-primary"><i class="fas fa-chevron-circle-left"></i> Back to main page!</button>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col text-center">
                                <button type="submit" form="editForm" id="commit" class="btn btn-primary">  <i class="fas fa-clipboard-check"></i> Commit change   </button>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col text-center p-3" id="success">
                                
                            </div>
                        </div>
                    </div>
                </div>
<!--edit profile-->
                <div class="col-lg-8 col-md-6 " style="border-left: 1px solid lightgrey">
                    <div class="container rounded bg-light">
                        <div class="row">
                            <div class="col text-center p-3">
                                <h5>Edit Profile</h5>
                            </div>
                        </div>
                        <div class="row p-3">
                        <form id="editForm" style="width:100%">                       
                        <div class="form-row"><!--username-->
                            <div class="col-sm-6 form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <?php
                                        echo'<input type="text" required class="form-control" id="username" name="username" placeholder="Username" value="'.$credential[$_SESSION["username"]]["username"].'">';
                                    ?>
                                </div>
                            </div>
                            <div id="usernameerror" class="col-sm-6 form-text text-danger" style="">
                                <small><i class="fas fa-times"></i>Someone has used the username</small>
                            </div>
                        </div>
                        <div class="form-row"><!--email-->
                            <div class="col-sm-6 form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <?php
                                        echo'<input type="email" required class="form-control" id="email" name="email" placeholder="Email Address" value="'.$credential[$_SESSION["username"]]["email"].'">';
                                    ?>
                                </div>
                            </div>
                            <div id="emailerror" class="col col-sm-6 form-text text-danger" style="">
                                <small><i class="fas fa-times"></i>Someone has used the email</small>
                            </div>
                        </div>
                        <div class="form-row"><!--firstname+lastname-->
                            <div class="col-sm form-group">
                                <label for="firstname">First name:</label>
                                <?php
                                     echo'<input type="text" required class="form-control" id="firstname" name="firstname" placeholder="First name" value="'.$credential[$_SESSION["username"]]["firstname"].'">';
                                ?>
                            </div>
                            <div class="col-sm form-group">
                                <label for="lastname">Last name:</label>
                                <?php
                                     echo'<input type="text" required class="form-control" id="lastname" name="lastname" placeholder="Last name" value="'.$credential[$_SESSION["username"]]["lastname"].'">';
                                ?>
                            </div>
                        </div>
                        <div class="form-row"><!--password+confirm-->
                            <div class="col-sm form-group">
                                <label for="opassword">Old Password:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </div>
                                    </div>
                                    <input type="password" required class=form-control id="opassword" name="opassword" placeholder="OldPassword">
                                </div>
                            </div>
                        </div>
                        <div class="form-row"><!--password+confirm-->
                            <div class="col-sm form-group">
                                <label for="password">New Password:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </div>
                                    </div>
                                   <?php
                                     echo'<input type="password" required class="form-control" id="password" name="password" placeholder="New Password" value="'.$credential[$_SESSION["username"]]["password"].'">';
                                ?>
                                </div>
                            </div>
                            <div class="col-sm form-group">
                                <label for="confirm">Confirm Password:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </div>
                                    </div>
                                   <?php
                                     echo'<input type="password" required class="form-control" id="confirm" name="confirm" placeholder="Confirm Password" value="'.$credential[$_SESSION["username"]]["password"].'">';
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-row"><!--question-->
                            <div class="col-sm form-group">
                                <label for="question">Forgot Password Question:</label>
                                <?php
                                    if($credential[$_SESSION["username"]]["question"]=="Who is your favourite professor?"){
                                        echo'<select required class="form-control" id="question" name="question">
                                    <option selected="selected">Who is your favourite professor?</option>
                                    <option>What is your first phone number?</option>
                                    <option>What will you do when you are boring?</option>
                                </select>';
                                    }else if($credential[$_SESSION["username"]]["question"]=="What is your first phone number?"){
                                        echo'<select required class="form-control" id="question" name="question">
                                    <option>Who is your favourite professor?</option>
                                    <option selected="selected">What is your first phone number?</option>
                                    <option>What will you do when you are boring?</option>
                                </select>';
                                    }else if($credential[$_SESSION["username"]]["question"]=="What will you do when you are boring?"){
                                        echo'<select required class="form-control" id="question" name="question">
                                    <option>Who is your favourite professor?</option>
                                    <option>What is your first phone number?</option>
                                    <option selected="selected">What will you do when you are boring?</option>
                                </select>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-row"><!--answer-->
                            <div class="col-sm form-group">
                                <label for="answer">Answer for the question:</label>
                                <?php
                                     echo'<input type="text" required class="form-control" id="answer" name="answer" placeholder="Answer" value="'.$credential[$_SESSION["username"]]["answer"].'">';
                                ?>
                            </div>
                        </div>
                        <div class="form-row"><!--reCAPTCHA-->
                            <div class="form-group" style="margin-left: auto;margin-right: auto">
                                <div class="g-recaptcha" data-sitekey="6Lf_w1UUAAAAAIf-yuqgDXXEGyDYEY1jmQ1BV9kO" data-size="compact" >
                                </div>
                            </div>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>