<?php
session_start();

// Check for the username session variable
if (!isset($_SESSION["username"])) {
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

// Read the first name of the user
$firstname = $users[$_SESSION["username"]]["firstname"];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assignment2: Main Page</title>
    <meta charset="utf-8">
    <meta name="viewport" 
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css">
    
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	
	
	<script>
    $(document).ready(function(){
        $("#signout").on("click",function(){
            var username = getCookie("username");
            if (username == "") {            
                window.location="signout.php?option=0";
            }else{  
                window.location="remembersignout.php"
            }
        });
        $("#editProfile").on("click",function(){
            window.location="editprofile.php";
            return false;
        });
    });
        
        //get cookie function helper
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    </script>
    <style>
        img.img-circle {
            width: 30px;
            height: 30px;
            border: 1px solid lightgray;
             border-radius: 15px;
        }
    </style>
</head>
<body class="bg-primary">
    <!--navbar-->
    <script>
        $(document).ready(function(){
            $("#Home").hide();
                $("#Add").hide();
                $("#List").show();
                $("#Edit").hide();
            $("#home").on("click",function(){
                $("#Home").show();
                $("#Add").hide();
                $("#List").hide();
                $("#Edit").hide();
            });
            $("#list").on("click",function(){
                $("#Home").hide();
                $("#Add").hide();
                $("#List").show();
                $("#Edit").hide();
            });
            $("#add").on("click",function(){
                $("#Home").hide();
                $("#Add").show();
                $("#List").hide();
                $("#Edit").hide();
            });
            
        });
    </script>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#" id="home"><img src = "images/hkust-logo.svg"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <!--signout function button dun modify start-->
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <?php 
                                        $location="profile_pic/".$_SESSION["username"].".png";
                                        if(file_exists($location)){
                                            echo "<img id='pic' class='img-circle profile-image' src=".$location." />";
                                        }else{
                                            echo "<img id='pic' class='img-circle profile-image' src='profile_pic/untitle.png' />";
                                        }
                                        ?>
                        <!--<img src="http://placehold.it/30x30" class="profile-image img-circle"> -->
                        <?php echo $firstname; ?> <b class="caret"></b></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a id="editProfile" class="dropdown-item" href="#"><i class="fa fa-cog"></i> Account</a>
                                <div class="dropdown-divider"></div>
                                <a id="signout" class="dropdown-item" href="#"><i class="fa fa-sign-out"></i> Sign-out</a>
                            </div>
                </li>
                <!--signout function button dun modify end-->
                <li class="nav-item">
                    <a class="nav-link" href="#" id="list">List </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="add">Add</a>
                </li>
            </ul>      
        </div>
    </nav>
<!--vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv---MODIFY BELOW---vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv-->
    <div id="mainpagecontainer"class="container rounded bg-white" style="width: 90%;margin-top:1vh; margin-left:auto;margin-right:auto">
        <!--home--> <!--carosal when clicked go to attribute of school or all-->
        <div id="Home" class="row">
            <div class="col container" style=":90%">
                <div class="row">
                    <div class="col p-3 text-center">
                        <h4>Welcome to HKUST Faculty Members' Profile</h4>
                    </div>
                </div>
				<div id = "myCarousel" class = "carousel slide" data-ride = "carousel">
					<!-- Indicators -->
					<ol class = "carousel-indicators">
						<li data-target = "#myCarousel" data-slide-to = "0" class = "active"></li>
						<li data-target = "#myCarousel" data-slide-to = "1"</li>
						<li data-target = "#myCarousel" data-slide-to = "2"</li>
					</ol>
					<!-- Wrapper for slides -->
					<div class = "carousel-inner">
						<div class = "carousel-item active">
							<img src = "images/sun.jpg" alt = "First slide">
						</div>
						<div class = "carousel-item">
							<img src = "images/atrium.jpg" alt = "Second slide">
						</div>
						<div class = "carousel-item">
							<img src = "images/sea.jpg" alt = "Third slide">
						</div>
					</div>
					<!-- Left and right controls -->
					<a class = "carousel-control-prev" href = "#myCarousel" role="button" data-slide = "prev">
						<span class = "carousel-control-prev-icon"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class = "carousel-control-next" href = "#myCarousel" role="button" data-slide = "next">
						<span class = "carousel-control-next-icon"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
				<style>
				.carousel-inner img {
					width: 100%;
					height: 100%;
				}
				</style>
            </div>
        </div>
        <!--List--><!--form default all, side bar form, list profile, when click show detail by modal pagination+breadcomb change attribute by breadcomb and form data interchange-->
        <div id="List" class="row" style="display:none">
            <div class="col container bg-light rounded" style="width:90%">
                <div class="row">
                    <div class="col p-3 text-center">
                        <h4>List professor</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 ">
                        <div class="container bg-white rounded m-2 p-1">
                        <div class="row pl-5 pr-5 md-0">
                            <h5>Description:</h5>
                            <p>
                                You can view the detail of each professor on Prof-profile<br>
                                In here you can search by the followings:
                            </p>
                            <ul>
                                <li>School</li>
                                <li>Department</li>
                                <li>Name</li>
                                <li>Research Field</li>
                            </ul>
                            <p>
                                You can view the staff on the list panel <br>
                                or click in the staff for more detail
                            </p>
                        </div>
                        <hr>

                        <div class="row pl-5 pr-5"><!--need ajax to modify the form when select-->
                            <form id=listfilterform>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="school">School:</label>
                                        <select class="form-control" id="school" name="school">
                                            <option id="all">---all---</option>
                                            <option id="sssci">School of Science</option>
                                            <option id="sseng">School of Engineering</option>
                                            <option id="ssbm">School of Business and Management</option>
                                            <option id="shssu">School of Humanities and Social Science</option>
                                            <option id="sipo">Interdisciplinary Programs Office</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="department">Department</label>
                                        <select class="form-control" id="department" name="department"><!--hidden attribute use .attr("hidden",false/true); to toggle no need la fuck, a professor can belong to multiple school and multiple department -->
                                            <option></option>
                                            <optgroup class="ssci" label="School of Science">
                                                <option class="ssci">Division of Life Science</option>
                                                <option class="ssci">Department of Chemistry</option>
                                                <option class="ssci">Department of Physics</option>
                                                <option class="ssci">Department of Mathmatics</option>
                                                <option class="ssci">Department of Ocean Science</option>
                                            </optgroup>
                                            <optgroup class="seng" label="School of Engineering">
                                                <option class="seng">Department of Chemical and Biological Engineering</option>
                                                <option class="seng">Department of Civil and Environmental Engineering</option>
                                                <option class="seng">Department of Computer Science and Engineering</option>
                                                <option class="seng">Department of Electronic and Computer Engineering</option>
                                                <option class="seng">Department of Industrial Engineering and Decision Analysis</option>
                                                <option class="seng">Department of Mechanical and Aerospace Engineering</option>
                                                <option class="seng">Division of Integrative Systems and Design Engineering</option>
                                            </optgroup>
                                            <optgroup class="sbm" label="School of Business and Management">
                                                <option class="sbm">Department of Accounting</option>
                                                <option class="sbm">Department of Economics</option>
                                                <option class="sbm">Department of Finance</option>
                                                <option class="sbm">Department of Information Systems, Business Statistics and Operations Management</option>
                                                <option class="sbm">Department of Management</option>
                                                <option class="sbm">Department of Marketing</option>
                                            </optgroup>
                                            <optgroup class="hssu" label="School of Humanities and Social Science">
                                                <option class="hssu">Division of Humanities</option>
                                                <option class="hssu">Division of Social Science</option>
                                            </optgroup>
                                            <optgroup class="ipo" label="Interdisciplinary Programs Office">
                                                <option class="ipo">Division of Environment and Sustainability</option>
                                                <option class="ipo">Division of Public Policy</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="searchresearch">Search research area:</label>
                                        <input class="form-control" type="text" id="searchresearch" name="searchresearch" placeholder="Research area"/>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="searchname">Search name:</label>
                                        <input class="form-control" type="text" id="searchname" name="searchname" placeholder="Name of prof"/>
                                    </div>
                                </div>   
                            </form>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-6">
                        <div class="container bg-white rounded m-2 p-2">
                            <!--showing simple professor style-->
  <style>
    .prof {
        border: 1px solid lightgray;
        border-radius: 0.5em;
        box-shadow: 1px 1px 4px lightgray;
        margin: 0.25em;
        padding:0.4em;
        overflow: hidden;
    }
    .prof img {
        width: 50%;
        margin-left: 0.5em;
    }
    .prof .info {
        padding: 0.5em;
    }
    .prof .moreinfo {
        color: gray;
    }
    .prof .Name {
        margin-top: 0.5em;
        font-weight: bold;
        font-size: 80%;
    }
</style>
    <!--script for select-->
<script> 
        const listssci=["Division of Life Science","Department of Ocean Science","Department of Mathmatics","Department of Physics","Department of Chemistry"];
        const listseng=["Division of Integrative Systems and Design Engineering","Department of Mechanical and Aerospace Engineering","Department of Industrial Engineering and Decision Analysis","Department of Electronic and Computer Engineering","Department of Computer Science and Engineering","Department of Civil and Environmental Engineering","Department of Chemical and Biological Engineering"];
        const listsbm=["Department of Marketing","Department of Management","Department of Information Systems, Business Statistics and Operations Management","Department of Finance","Department of Economics","Department of Accounting"];
        const listhssu=["Division of Social Science","Division of Humanities"];
        const listipo=["Division of Public Policy","Division of Environment and Sustainability"];
        const listall=[listssci,listseng,listsbm,listhssu,listipo];
    $(document).ready(function(){
        //handle form behaviour
        //submit form+lock department
        $("#school").on("change",function(){
            console.log("changing school");
            if($("#school").val()=="School of Science"){
                $("#department>optgroup.ssci").attr("hidden",false);
                $("#department>optgroup:not(.ssci)").attr("hidden",true);
                $("#school>#sssci").attr("selected",true);
                $("#school>:not(#sssci)").attr("selected",false);
            }else if($("#school").val()=="School of Engineering"){
                $("#department>optgroup.seng").attr("hidden",false);
                $("#department>optgroup:not(.seng)").attr("hidden",true);
                $("#school>#sseng").attr("selected",true);
                $("#school>:not(#sseng)").attr("selected",false);
            }else if($("#school").val()=="School of Business and Management"){
                $("#department>optgroup.sbm").attr("hidden",false);
                $("#department>optgroup:not(.sbm)").attr("hidden",true); 
                $("#school>#ssbm").attr("selected",true);
                $("#school>:not(#ssbm)").attr("selected",false);
            }else if($("#school").val()=="School of Humanities and Social Science"){
                $("#department>optgroup.hssu").attr("hidden",false);
                $("#department>optgroup:not(.hssu)").attr("hidden",true);     
            }else if($("#school").val()=="Interdisciplinary Programs Office"){
                $("#department>optgroup.ipo").attr("hidden",false);
                $("#department>optgroup:not(.ipo)").attr("hidden",true);
                $("#school>#sipo").attr("selected",true);
                $("#school>:not(#sipo)").attr("selected",false);
            }else{
                $("#department>optgroup").attr("hidden",false);
                $("#department").val("");
                $("#school>#all").attr("selected",true);
                $("#school>:not(#all)").attr("selected",false);
            }
            submitList();
        });
        //submit form+select school
        $("#department").on("change",function(){
            console.log("changing");
             console.log(listall);
            console.log($("#department").val());
            var contains=false;
            var count=0;
            while(!contains&&(count<5)){
                for(var i=0;i<listall[count].length;i++){
                    if($("#department").val()==listall[count][i]){
                        contains=true;
                        break;
                    }
                    
                }
                if(!contains){
                    count++;
                }
            }
            console.log("count"+count);
            if($("#department").val()==""){
                
            }else if(count==0){
                $("#school>#sssci").attr("selected",true);
                $("#school>:not(#sssci)").attr("selected",false);
                $("#department>optgroup.ssci").attr("hidden",false);
                $("#department>optgroup:not(.ssci)").attr("hidden",true);
            }else if(count==1){
                $("#school>#sseng").attr("selected",true);
                $("#school>:not(#sseng)").attr("selected",false);
                 $("#department>optgroup.seng").attr("hidden",false);
                $("#department>optgroup:not(.seng)").attr("hidden",true);
            }else if(count==2){
                $("#school>#ssbm").attr("selected",true);
                $("#school>:not(#ssbm)").attr("selected",false);
                $("#department>optgroup.sbm").attr("hidden",false);
                $("#department>optgroup:not(.sbm)").attr("hidden",true);   
            }else if(count==3){
                $("#school>#shssu").attr("selected",true);
                $("#school>:not(#shssu)").attr("selected",false);
                $("#department>optgroup.hssu").attr("hidden",false);
                $("#department>optgroup:not(.hssu)").attr("hidden",true);    
            }else if(count==4){
                $("#school>#sipo").attr("selected",true);
                $("#school>:not(#sipo)").attr("selected",false);
                $("#department>optgroup.ipo").attr("hidden",false);
                $("#department>optgroup:not(.ipo)").attr("hidden",true);  
            }else{
                alert("error")
            }
            $("#school").trigger("change");
        });
        $("#searchname").on("change",function(){
            submitList();
        });
        $("#searchresearch").on("change",function(){
            submitList();
        });
        submitList();
    });
    function submitList(){
        var query=$("#listfilterform").serialize();
        $.get("listProf.php",query,function(data){
            console.log(data);
            /*<div class="col-12 col-md-12 col-lg-4 col-xl-3 page1 listprof">
                                <div class="prof clearfix">
                                    <img id="pic" class="profile-image" src="profile_pic/untitle.png" />
                                    <div class="info">
                                        <div class="Name">Example Prof(例子教授)</div>
                                        <div class="moreinfo">Click to see more info</div>
                                    </div>
                                </div>
                            </div>*/
            //handling listing the thing
            var largehtml="";
            var recordnum=0;
            $(data).find("staff").each(function(i,staff){
                var name1=$(staff).find("name").find("EnglishName").text();
                var name2=$(staff).find("name").find("ChineseName").text();
                var image=$(staff).find("image").text();
                var page = Math.floor(i/9)+1;
                var html='<div class="col-12 col-md-12 col-sm-6 col-lg-4 page'+page;
                html+=' listprof"><div class="prof clearfix"><img id="pic" class="profile-image" src="';
                if(image==""){
                    html+='profile_pic/untitle.png';
                }else{
                    html+=image;
                }
                html+='" /><div class="info"><div class="Name">'+name1;
                if(name2==""){
                }else{
                    html+='('+name2+')';
                }
                html+='</div><div class="moreinfo">Click to see more info</div></div></div></div>';
                largehtml+=html;
                recordnum++;
            });
            $("#listpanel").html(largehtml);
//pagination set up
            /*
            <ul class="pagination">
                <li class="page-item disabled"><a id="pp" class="page-link" href="#">Previous</a></li>
                <li class="page-item" id="pf" style="display:none">...</li>
                <li class="page-item"><a id="pa" class="page-link" href="#">1</a></li>
                <li class="page-item"><a id="pb"class="page-link" href="#">2</a></li>
                <li class="page-item"><a id="pc"class="page-link" href="#">3</a></li>
                <li class="page-item" id="pt">...</li>
                <li class="page-item"><a id="pn" class="page-link" href="#">Next</a></li>
            </ul>
            */
            var numberofpage=Math.floor(recordnum/9)+1;
            var phtml="";
            if(numberofpage<=3){
                phtml+='<li class="page-item disabled"><a id="pp" class="page-link" href="#">Previous</a></li>';
                for(var i=1;i<=numberofpage;i++){
                    var e="a";
                    if(i==2){
                        e="b";
                    }else if(i==3){
                        e="c";     
                    }
                    phtml+='<li class="page-item"><a id="p'+e+'" class="page-link" href="#">'+i+'</a></li>';
                }
                if(numberofpage==1){
                    phtml+='<li class="page-item disabled"><a id="pn" class="page-link" href="#">Next</a></li>';
                }else{
                    phtml+='<li class="page-item"><a id="pn" class="page-link" href="#">Next</a></li>';   
                }
            }else{
                phtml+='<li class="page-item disabled"><a id="pp" class="page-link" href="#">Previous</a></li><li class="page-item disabled" id="ph" style="display:none"><a class="page-link" href="#">...</a></li><li class="page-item"><a id="pa" class="page-link" href="#">1</a></li><li class="page-item"><a id="pb"class="page-link" href="#">2</a></li><li class="page-item"><a id="pc"class="page-link" href="#">3</a></li><li class="page-item disabled" id="pt"><a class="page-link" href="#">...</a></li><li class="page-item"><a id="pn" class="page-link" href="#">Next</a></li>';
            }
            $(".pagination").html(phtml);
            $("#pa").parent().addClass("active");
            if(numberofpage==1){
                $("#pn").parent().addClass("disabled");
            }
             $("#pp").on("click",function(){
                 if(!$("#pp").parent().hasClass("disabled")){
                    paginationclickhandle("#pp",numberofpage);
                 }
            });
            $("#pa").on("click",function(){
                paginationclickhandle("#pa",numberofpage);
            });
            $("#pb").on("click",function(){
                paginationclickhandle("#pb",numberofpage);
            });
            $("#pc").on("click",function(){
                paginationclickhandle("#pc",numberofpage);
            });
            $("#pn").on("click",function(){
                if(!$("#pn").parent().hasClass("disabled")){
                    paginationclickhandle("#pn",numberofpage);
                }
            });
//breadcrumb set up
            var bschool=$(data).find("breadcrumb").find("school").text();
            var bdepartment=$(data).find("breadcrumb").find("department").text();
            var bresearch=$(data).find("breadcrumb").find("research").text();
            var bname=$(data).find("breadcrumb").find("name").text();
            var bhtml='<li class="breadcrumb-item"><a id="b1" href="#">All</a></li>';
            if(bschool!="---all---"){
                bhtml+='<li  class="breadcrumb-item"><a id="b2" href="#">'+bschool+'</a></li>';
            }
            if(bdepartment!=""){
                bhtml+='<li  class="breadcrumb-item"><a id="b3" href="#">'+bdepartment+'</a></li>';
            }
            if(bresearch!=""){
                bhtml+='<li  class="breadcrumb-item"><a id="b4" href="#">research: '+bresearch+'</a></li>';
            }
            if(bname!=""){
                bhtml+='<li  class="breadcrumb-item"><a id="b5" href="#">name: '+bname+'</a></li>';
            }
            $("ol.breadcrumb").html(bhtml);
            $("ol.breadcrumb>li").last().addClass("active");
            $("ol.breadcrumb>li").last().attr("aria-current","page");
            var temp=$("ol.breadcrumb>li").last().find("a").text();
            $("ol.breadcrumb>li").last().find("a").remove();
            $("ol.breadcrumb>li").last().text(temp);
             $("#b1").on("click",function(){
                 breadcrumbclickhandle("#b1");
            });
    $("#b2").on("click",function(){
        breadcrumbclickhandle("#b2");
    });
    $("#b3").on("click",function(){
        breadcrumbclickhandle("#b3");
    });
    $("#b4").on("click",function(){
        breadcrumbclickhandle("#b4");
    });
    $("#b5").on("click",function(){
        breadcrumbclickhandle("#b5");
    });
            //handle the default filter page to only page 1
            $(".listprof").hide();
            $(".listprof.page1").show();

        //handle breadcrumbclick
        //handle pagination(no need ajax, just manipulate existing div)
//handal modal click +ajax
            $(".prof").on("click",function(){
                var proffullname=$(this).find(".info").find(".Name").text();
                var profname="";
                if(proffullname.search(/\(/i)!=-1){
                    profname=proffullname.substring(0,proffullname.search(/\(/i));
                }else{
                    profname=proffullname;
                }
                console.log(profname);
                var request=$.ajax({
                    url: "listProf.php",
                    type: "GET",
                    data: {searchname:profname,searchresearch:"",school:"---all---",department:""},
                    success: function(data){
 //modal configure id=professor english name just use ajax to call the listProf.php
                        /*
                        <div class="modal fade" tabindex="-1" role="dialog" id="detailprof">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Name:<span id="spanengname" style="display:inline-block; margin-left:5%;"></span><span id="spanchinname"style="display:inline-block; margin-left:5%;"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img class="modal-photo" src="profile_pic/untitle.png" alt="sorry no available photo" style="width:256px;height:348px;"/>
                
                <hr>
                <div class="modal-info container rounded bg-light p-4">
                    <div class="row">
                        <div class="col-md-3">
                            Title:
                        </div>
                        <div class="col-md-9">
                            <div id="modalposition" class="container text-center bg-white rounded p-2 m-1">
                                <div class="row ml-2">
                                    <div class="col-1">
                                        -
                                    </div>
                                    <div class="col-11 text-left">
                                        <span class="spantitle">Professor</span>,<span class="spandepartment">Example of Example</span>,<span class="spanschool">School of Example</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            Research Interest:
                        </div>
                        <div class="col-md-9">
                            <div id="modalresearch" class="container text-center bg-white rounded p-2 m-1">
                                <div class="row ml-2">
                                    <span class="spanarea">Example</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            contact:
                        </div>
                        <div class="col-md-9">
                            <div id="modalcontact" class="container text-center bg-white rounded p-2 m-1">
                                <div class="row ml-2">
                                    <div class="col-lg-2">Phone:</div>
                                    <div class="col-lg-10 text-left"><span class="spanphone">12345678</span></div>
                                </div>
                                <div class="row ml-2">
                                    <div class="col-lg-2">E-mail:</div>
                                    <div class="col-lg-10 text-left"><span class="spanphone">Example@example.com</span></div>
                                </div>
                                <div class="row ml-2">
                                    <div class="col-lg-2">Homepage:</div>
                                    <div class="col-lg-10 text-left"><span class="spanphone">Example.com</span></div>                               
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="modal-edit">Edit-Record</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="modal-delete">Delete Record</button>
            </div>
        </div>
    </div>
</div>
                        */
                    //image
                        var node=$(data).find("staff").eq(0);
                        if(node.find("image").text()!=""){
                            $(".modal-body>img").attr("src",$(data).find("image").text());    
                        }else{
                            $(".modal-body>img").attr("src","profile_pic/untitle.png");
                        }
                    //name
                        $("#spanengname").text(node.find("name").find("EnglishName").text());
                        if(node.find("name").find("ChineseName").text()==""){
                            $("#spanchinname").text("");    
                        }else{
                            $("#spanchinname").text("("+node.find("name").find("ChineseName").text()+")");
                        }
                    //title
                        var position=node.find("positions").find("position");
                        var mhtml1="";
                        for(var i =0;i<position.length;i++){
                            var mhtml1t='<div class="row ml-2"><div class="col-1">'+(i+1)+'.</div><div class="col-11 text-left">';
                            if(position.eq(i).find("head")!=""){
                                mhtml1t+=position.eq(i).find("head").text();
                            }
                            if(position.eq(i).find("department")!=""){
                                mhtml1t+=','+position.eq(i).find("department").text();
                            }
                            if(position.eq(i).find("school")!=""){
                                mhtml1t+=','+position.eq(i).find("school").text();
                            }
                            mhtml1t+='</div></div>';
                            mhtml1+=mhtml1t;
                        }
                        $("#modalposition").html(mhtml1);
                    //research
                        var area=node.find("researchAreas").find("area");
                        var mhtml2="";
                        for(var i=0;i<area.length;i++){
                            var mhtml2t='<div class="row ml-2"><span class="spanarea">';
                            mhtml2t+=area.eq(i).text();
                            mhtml2t+='</span></div>';
                            mhtml2+=mhtml2t;
                        }
                        $("#modalresearch").html(mhtml2);
                        $("#detailprof").modal("show");
                    //contact
                        var contact=node.find("contact");
                        var mhtml3="";
                        if(contact.find("telephone").text()!=""){
                            mhtml3+='<div class="row ml-2"><div class="col-lg-2">Phone:</div><div class="col-lg-10 text-left"><span class="spanphone">'+contact.find("telephone").text()+'</span></div></div>';
                        }
                        if(contact.find("email").text()!=""){
                            mhtml3+='<div class="row ml-2"><div class="col-lg-2">E-mail:</div><div class="col-lg-10 text-left"><span class="spanemail">'+contact.find("email").text()+'</span></div></div>';
                        }
                        if(contact.find("homepage").text()!=""){
                            mhtml3+='<div class="row ml-2"><div class="col-lg-2">HomePage:</div><div class="col-lg-10 text-left"><span class="spanhomepage"><a href="'+contact.find("homepage").text()+'">'+contact.find("homepage").text()+'</a></span></div></div>';
                        }
                        $("#modalcontact").html(mhtml3);
                    }
                });
                request.fail(function(){
                    alert("internal Error")
                })
                return false;
            });
        
        });
        return false;
    }
//handling breadcrumb click
    function breadcrumbclickhandle(id){
        var clickedVal=$(id).text();
        var checklist={b1:"",b2:"",b3:"",b4:"",b5:""};
        for(var i=0;i<$(".breadcrumb-item").length;i++){
            console.log("id:"+$(".breadcrumb-item").eq(i).find("a").attr("id")+"text:"+$(".breadcrumb-item").eq(i).find("a").text())
            checklist[$(".breadcrumb-item").eq(i).find("a").attr("id")]=$(".breadcrumb-item").eq(i).find("a").text();
            if($("ol>.breadcrumb-item").eq(i).find("a").text()==clickedVal){
                break;
            }
        }
        $("#department").val("");
        $("#school").val("---all---");
        $("#searchname").val("");
        $("#searchresearch").val("");
        if(checklist.b2!==""){
            $("#school").val(checklist.b2);
            $("#school").trigger("change");
        }
        if(checklist.b3!==""){
            $("#department").val(checklist.b3);
            $("#department").trigger("change");
        }
        if(checklist.b4!==""){
            $("#searchresearch").val(checklist.b4.substring(10,checklist.b4.length));
            $("#searchresearch").trigger("change");
        }
        if(checklist.b5!==""){
            $("#searchname").val(checklist.b5.substring(6,checklist.b5.length));
            $("#searchname").trigger("change");
        }
        if(checklist.b5==""&&checklist.b4==""&&checklist.b3==""&&checklist.b2==""){
            $("#school").trigger("change");
        }
    };
//handle pagination event
    function paginationclickhandle(id,maxpage){
        if(id=="#pp"||id=="#pn"){
            paginationpppnhandle(id,maxpage);           
        }else{
            $(".page-item").removeClass("active");
            $(id).parent().addClass("active");
            var pagenumber=$(id).text();
            $(".listprof").hide();
            $(".listprof.page"+pagenumber).show();
            if(parseInt($(id).text())==1){
                $("#pp").parent().addClass("disabled");
            }else{
                $("#pp").parent().removeClass("disabled");
            } 
            if(parseInt($(id).text())==maxpage){
                $("#pn").parent().addClass("disabled");
            }else{
                $("#pn").parent().removeClass("disabled");
            }
        }
           
    }
    function paginationpppnhandle(id,maxpage){
        var active=$(".page-item.active");
        var checkendcondition={enddiv:"",needdot:false};
        if(maxpage==2){
            checkendcondition.enddiv="#pb";
            checkendcondition.needdot=false;
        }else if(maxpage==3){
            checkendcondition.enddiv="#pc";
            checkendcondition.needdot=false;
        }else{
            checkendcondition.enddiv="#pc";
            checkendcondition.needdot=true;
        }
        if(id=="#pp"){
            if(checkendcondition.enddiv=="#pb"){
                    if(active.find("a").attr("id")=="pb"){//shift active from pb to pa
                        $(".page-item").removeClass("active");
                        $("#pa").parent().addClass("active");
                        if(parseInt($("#pb").text())==2){//if move from pc to pb and pc text=max enable pn
                            $("#pn").parent().removeClass("disabled");
                            $(id).parent().addClass("disabled");
                        }
                    }
            }
            else{
            if(active.find("a").attr("id")!="pa"){
                if(active.find("a").attr("id")=="pc"){//shift active from pc to pb
                    $(".page-item").removeClass("active");
                    $("#pb").parent().addClass("active");
                    if(parseInt($("#pc").text())==maxpage){//if move from pc to pb and pc text=max enable pn
                        $("#pn").parent().removeClass("disabled");
                    }
                }
                if(active.find("a").attr("id")=="pb"){//shift active from pc to pb
                    $(".page-item").removeClass("active");
                    $("#pa").parent().addClass("active");
                    if(parseInt($("#pa").text())==1){//if move from pb to pa and pa text=1 disable pp
                        $(id).parent().addClass("disabled");
                    }
                }
            }else{
                //deal with shifting number pa =active!=1 case
                if(parseInt(active.find("a").text())==2){
                    //shift to 1+disable
                      //need process dot or not
                    $(id).parent().addClass("disabled");
                    $("#pa").text(1);
                    $("#pb").text(2);
                    $("#pc").text(3);
                    if(checkendcondition.needdot){
                        $("#ph").css("display","none");
                    }
                }else{
                    $("#pc").text($("#pb").text());
                    $("#pb").text($("#pa").text());
                    $("#pa").text(parseInt($("#pa").text())-1);
                    if(checkendcondition.needdot){
                        $("#pt").css("display","initial");
                    }
                    //shift
                }
            }
            }
        }else if(id=="#pn"){//pn
            if(checkendcondition.enddiv=="#pb"){
                    if(active.find("a").attr("id")=="pa"){//shift active from pa to pb
                        $(".page-item").removeClass("active");
                        $("#pb").parent().addClass("active");
                        if(parseInt($("#pb").text())==2){//if move from pc to pb and pc text=max enable pn
                            $("#pp").parent().removeClass("disabled");
                            $(id).parent().addClass("disabled");
                        }
                    }
            }else{
                if(active.find("a").attr("id")!="pc"){
                    if(active.find("a").attr("id")=="pa"){//shift active from pa to pb
                        $(".page-item").removeClass("active");
                        $("#pb").parent().addClass("active");
                        if(parseInt($("#pb").text())==2){//if move from pc to pb and pc text=max enable pn
                            $("#pp").parent().removeClass("disabled");
                        }
                    }
                    if(active.find("a").attr("id")=="pb"){//shift active from pb to pc
                        $(".page-item").removeClass("active");
                        $("#pc").parent().addClass("active");
                        if(parseInt($("#pc").text())==maxpage){//if move from pb to pa and pa text=1 disable pp
                            $(id).parent().addClass("disabled");
                        }
                    }
            }else{
                //deal with shifting number pc =active!=maxpage case
                if(parseInt(active.find("a").text())==(maxpage-1)){
                    console.log("pc =active==maxpage-1 case")
                    //shift to 1+disable
                      //need process dot or not
                    $(id).parent().addClass("disabled");
                    $("#pa").text(maxpage-2);
                    $("#pb").text(maxpage-1);
                    $("#pc").text(maxpage);
                    if(checkendcondition.needdot){
                        $("#pt").css("display","none");
                    }
                }else{
                    console.log("pc =active!=maxpage case")
                    console.log($("#pb").text());
                    $("#pa").text($("#pb").text());
                    $("#pb").text($("#pc").text());
                    $("#pc").text(parseInt($("#pc").text())+1);
                    if(checkendcondition.needdot){
                        $("#ph").css("display","initial");
                    }
                    //shift
                }
            }}
             
        }
        var pagenumber=$(".page-item.active").find("a").text();
        $(".listprof").hide();
        $(".listprof.page"+pagenumber).show();
        
    }
</script>
<!--script-->
                        <div class="row p-2 m-2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                </ol>
                            </nav>
                        </div>
                        <div id="listpanel" class="row bg-light ml-2 mr-2 p-2" style="width 100%">

                            
                            <!--filter of professor by department by school by name by research area are done in backend-->
                            
                        </div>
            <div class="row p-2 m-2">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Add--><!--form,no load data, back button to list can follow editprofile.php access by Navbar-->
        <div id="Add"class="row" style="display:none">
            <div class="col container" style=":90%">
                <div class="row">
                    <div class="col p-3 text-center">
                        <h4>Adding a New Faculty Member</h4>
                    </div>
                </div>
				<hr>
				<div class="container rounded bg-light">
					<form id = "addForm" action = "addProf.php" method = "post" enctype="multipart/form-data">
					<div class = "form-group">
						<label for = "EnglishName">English Name</label>
						<input required type = "text" class = "form-control" id = "add-EnglishName" name = "add-EnglishName" placeholder = "e.g. Wong Tai Sin Johnny">
					</div>
					<div class = "form-group">
						<label for = "ChineseName">Chinese Name</label>
						<input type = "text" class = "form-control" id = "add-ChineseName" name = "add-ChineseName" placeholder = "(optional) ">
					</div>
					<div class = "form-group">
						<label for = "head">Title</label>
						<input required type = "text" class = "form-control" id = "add-head" name = "add-head" placeholder = "e.g. Associate Professor">
					</div>
					<div class = "form-group">
						<label for = "school">School</label>
						<select class = "form-control" id = "add-school" name = "add-school">
							<option id="sssci">School of Science</option>
                            <option id="sseng">School of Engineering</option>
                            <option id="ssbm">School of Business and Management</option>
                            <option id="shssu">School of Humanities and Social Science</option>
                            <option id="sipo">Interdisciplinary Programs Office</option>
						</select>
					</div>
					<div class = "form-group">
						<label for = "department">Department</label>
						<select class="form-control" id="add-department" name="add-department"><!--hidden attribute use .attr("hidden",false/true); to toggle no need la fuck, a professor can belong to multiple school and multiple department -->
                            <option></option>
                            <optgroup class="ssci" label="School of Science">
								<option class="ssci">Division of Life Science</option>
								<option class="ssci">Department of Chemistry</option>
								<option class="ssci">Department of Physics</option>
								<option class="ssci">Department of Mathmatics</option>
								<option class="ssci">Department of Ocean Science</option>
							</optgroup>
							<optgroup class="seng" label="School of Engineering">
								<option class="seng">Department of Chemical and Biological Engineering</option>
								<option class="seng">Department of Civil and Environmental Engineering</option>
								<option class="seng">Department of Computer Science and Engineering</option>
								<option class="seng">Department of Electronic and Computer Engineering</option>
								<option class="seng">Department of Industrial Engineering and Decision Analysis</option>
								<option class="seng">Department of Mechanical and Aerospace Engineering</option>
								<option class="seng">Division of Integrative Systems and Design Engineering</option>
							</optgroup>
							<optgroup class="sbm" label="School of Business and Management">
								<option class="sbm">Department of Accounting</option>
								<option class="sbm">Department of Economics</option>
								<option class="sbm">Department of Finance</option>
								<option class="sbm">Department of Information Systems, Business Statistics and Operation Management</option>
								<option class="sbm">Department of Management</option>
								<option class="sbm">Department of Marketing</option>
							</optgroup>
							<optgroup class="hssu" label="School of Humanities and Social Science">
								<option class="hssu">Division of Humanities</option>
								<option class="hssu">Division of Social Science</option>
							</optgroup>
								<optgroup class="ipo" label="Interdisciplinary Programs Office">
								<option class="ipo">Division of Environment and Sustainability</option>
								<option class="ipo">Division of Public Policy</option>
								<option class="ipo">Dual Degree Program in Technology and Management</option>
								<option class="ipo">BSc in Risk Management and Business Intelligence Program</option>
								<option class="ipo">BSc in Environmental Management and Technology Program</option>
								<option class="ipo">BSc in Individualized Interdisciplinary Major Program (IIM)</option>
								<option class="ipo">MPhil/PhD in Environmental Science, Policy and Management Program, MSc / PGD in Environmental Science and Management Program</option>
							</optgroup>
						</select>
					</div>
					<div id = "area-element" class = "form-group">
						<label for = "area">Reasearch Area</label>
						<div class = "multiple-area"><input required type = "text" class = "form-control" id = "add-area1" name = "area[]" placeholder = "e.g. Software Technologies"></div>
					</div>
					<button id = "add-area-btn" class = "btn btn-primary"><i class="fas fa-plus"></i> Add Area</button>
					<script>
						$(document).ready(function() {
							var add_area_fields = 1;
							var wrapper = $("#area-element");
							var add_btn = $("#add-area-btn");
							
							$(add_btn).on("click", function(e) {
								e.preventDefault();
								add_area_fields++;
								var area = "<div class = \"multiple-area\"><input required type = \"text\" class = \"form-control\" id = \"add-area" + add_area_fields + "\" name = \"area[]\" placeholder = \"e.g. Software Technologies\"><a href=\"#\" class=\"remove_field\"><i class=\"fas fa-times\"></i> Remove</a></div>";
								$(wrapper).append(area);
							});
							
							$(wrapper).on("click", ".remove_field", function(e) {
								e.preventDefault(); $(this).parent("div").remove();
								add_area_fields--;
							});
						});
					</script>
					<style>
						#add-area-btn {
							margin-top: 0.5em;
							margin-bottom: 0.5em;
						}
						.remove_field {
							float: right;
						}
						.multiple-area {
							margin-top: 0.5em;
							margin-bottom: 0.5em;
						}
						.remove_field {
							color: red;
						}
						#add-new-person {
							text-align: center;
						}
					</style>
					<div class = "form-group">
						<label for = "telephone">Telephone</label>
						<input required type = "text" class = "form-control" id = "add-telephone" name = "add-telephone" placeholder = "(optional) e.g. (852) 1234 5678">
					</div>
					<div class = "form-group">
						<label for = "email">Email</label>
						<input required type = "text" class = "form-control" id = "add-email" name = "add-email" placeholder = "e.g. johnny@gmail.com">
					</div>
					<div class = "form-group">
						<label for = "homepage">Personal Homepage</label>
						<input required type = "text" class = "form-control" id = "add-homepage" name = "add-homepage" placeholder = "Place your homepage URL here">
					</div>
					<div class = "form-group">
						<label for = "image">Image</label>
						<br>
						<!--<input required type = "file" class = "form-control" id = "add-image" name = "add-image">-->
						<label class="btn btn-info">
							<input required type = "file" class = "form-control" id = "add-image" style = "display:none;">
							<i class="far fa-image"></i> Select Image
						</label>
					</div>
				</form>
				</div>
				<hr>
				<div id = "add-new-person">
					<button type = "submit" class = "btn btn-primary"><i class="fas fa-users"></i> Add Person</button>
				<div>
			</div>
        </div>
        <!--Edit--><!--form,preload data,back button to list can follow editprofile.php access by modal-->
        <div id="Edit"class="row" style="display:none">
            <div class="col container" style=":90%">
                <div class="row">
                    <div class="col p-3 text-center">
                        <h4>Edit record</h4>
                    </div>
                </div>
            </div>
        </div>
  </div>
    <!--modal for detail-->
    <script>
        $(document).ready(function(){
            //modal button handle
            $("#modal-edit").on("click",function(){
                $("#Home").hide();
                $("#Add").hide();
                $("#List").hide();
                $("#Edit").show();
            });
            $("#modal-delete").on("click",function(){
                $("#Home").hide();
                $("#Add").hide();
                $("#List").show();
                $("#Edit").hide();
                $.ajax({
                    url: "main-delete.php",
                    type: "GET",
                    data: {searchname:$("#spanengname").text()},
                    success: function(data){
                        if($(data).find("success").text()!="yes"){
                            alert("internalError");
                        }else{
                            $("#school").val("---all---");
                            $("#school").trigger("change");
                        }
                    }
                });
            });
            
        });
    </script>
    <!--start when the specific professor are clicked-->
<div class="modal fade" tabindex="-1" role="dialog" id="detailprof">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="width:80%;">Name:<span id="spanengname" style="display:inline-block; margin-left:5%;"></span><span id="spanchinname"style="display:inline-block; margin-left:2%;"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img class="modal-photo" src="profile_pic/untitle.png" alt="sorry no available photo" style="width:256px;height:348px;"/>
              
                <hr>
                <div class="modal-info container rounded bg-light p-4">
                    <div class="row">
                        <div class="col-md-3">
                            Title:
                        </div>
                        <div class="col-md-9">
                            <div id="modalposition" class="container text-center bg-white rounded p-2 m-1">
                                <div class="row ml-2">
                                    <div class="col-1">
                                        -
                                    </div>
                                    <div class="col-11 text-left">
                                        <span class="spantitle">Professor</span>,<span class="spandepartment">Example of Example</span>,<span class="spanschool">School of Example</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            Research Interest:
                        </div>
                        <div class="col-md-9">
                            <div id="modalresearch" class="container text-center bg-white rounded p-2 m-1">
                                <div class="row ml-2">
                                    <span class="spanarea">Example</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            contact:
                        </div>
                        <div class="col-md-9">
                            <div id="modalcontact" class="container text-center bg-white rounded p-2 m-1">
                                <div class="row ml-2">
                                    <div class="col-lg-2">Phone:</div>
                                    <div class="col-lg-10 text-left"><span class="spanphone">12345678</span></div>
                                </div>
                                <div class="row ml-2">
                                    <div class="col-lg-2">E-mail:</div>
                                    <div class="col-lg-10 text-left"><span class="spanphone">Example@example.com</span></div>
                                </div>
                                <div class="row ml-2">
                                    <div class="col-lg-2">Homepage:</div>
                                    <div class="col-lg-10 text-left"><span class="spanphone">Example.com</span></div>                               
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="modal-edit">Edit-Record</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="modal-delete">Delete Record</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
