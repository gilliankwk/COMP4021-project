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
    <title>Faculty Members at HKUST</title>
    <meta charset="utf-8">
    <meta name="viewport" 
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css">
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
		
		$(window).on('hashchange', function() {
            // Get the fragment identifier from the URL
            var page = window.location.hash;
            if (page == "") page = "#list";

            // You need to change this so that the corresponding page is shown
            // alert(page);

            $(".page").hide();

            switch (page) {
            case "#list":
                $("#listPage").show();
                break;
            case "#add":
                $("#addPage").show();
                break;
            }
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
	
	// You may want to trigger the hashchange event when the page loads
    $(window).trigger("hashchange");
	
	$("#listForm select").on("change", function() {
		console.log("Hey man");
		// change the select box
		var select = $("#schoolFilter").val();
		
		$("#departmentFilter").empty();		
		
		switch(select) {
			case 1:	// SSCI
				var html = "<option value=\"1\">Division of Life Science</option>";
				html += "<option value=\"2\">Department of Chemistry</option>";
				html += "<option value=\"3\">Department of Mathematics</option>";
				html += "<option value=\"4\">Department of Physics</option>";
				html += "<option value=\"5\">Department of Ocean Science</option>";
				$("#schoolFilter").html(html);
				break;
			case 2: // SENG
				var html = "<option value=\"1\">Department of Chemical and Biological Engineering</option>";
				html += "<option value=\"2\">Department of Civil and Environmental Engineering</option>";
				html += "<option value=\"3\">Department of Computer Science and Engineering</option>";
				html += "<option value=\"4\">Department of Electronic and Computer Engineering</option>";
				html += "<option value=\"5\">Department of Industrial Engineering and Decision Analytics</option>";
				html += "<option value=\"6\">Department of Mechanical and Aerospace Engineering</option>";
				$("#schoolFilter").html(html);
				break;
			case 3: // SBM
				var html = "<option value=\"1\">Department of Accounting</option>";
				html += "<option value=\"2\">Department of Economics</option>";
				html += "<option value=\"3\">Department of Finance</option>";
				html += "<option value=\"4\">Department of Information Systems, Business Statistics and Operation Management</option>";
				html += "<option value=\"5\">Department of Management</option>";
				html += "<option value=\"6\">Department of Marketing</option>";
				$("#schoolFilter").html(html);
				break;
			case 4: // SHSS
				var html = "<option value=\"1\">Division of Humanities</option>";
				html += "<option value=\"2\">Division of Social Science</option>";
				$("#schoolFilter").html(html);
				break;
			case 5: // IPO
				var html = "<option value=\"1\">Division of Environment & Sustainability</option>";
				html += "<option value=\"2\">Division of Public Policy</option>";
				html += "<option value=\"3\">Dual Degree Program in Technology and Management</option>";
				html += "<option value=\"4\">BSc in Risk Management and Business Intelligence Program</option>";
				html += "<option value=\"5\">BSc in Environmental Management and Technology Program</option>";
				html += "<option value=\"6\">BSc in Individualized Interdisciplinary Major Program (IIM)</option>";
				html += "<option value=\"7\">MPhil/PhD in Environmental Science, Policy and Management Program, MSc / PGD in Environmental Science and Management Program</option>";
				$("#schoolFilter").html(html);
				break;
		}

		// load the list
        var query = $("#listForm").serialize();

        $.get("list.php", query, function(data) {
            var html = "<div class='row'>";
            $(data).find("school").each(function(i, school) {
                $(school).find("staff").each(function(i, staff) {
                    staff = $(staff);

                    html += "<div class='staff col-4 col-md-3 col-lg-2'>";

                    if (staff.find("image").text() != "") {
                        html += "<div class='image'><img src='" + staff.find("image").text() + "' class='w-75' alt='Image'></div>";
                    }

                    html += "<div class='name'>" + staff.find("name").text() + "</div>";

					html += "<div class='title'>" + staff.find("title").text() + "</div>";
					
                    html += "<div class='research'>";
                    pokemon.find("area").each(function(i, area) {
                        if (i > 0) html += ", ";
                         html += "<span class='area'>" + $(area).text() + "</span>";
                    });
                    html += "</div>";

                    html += "</div>";
                });
            });
            html += "</div>";
            $("#listContent").html(html);
        })
        .fail(function() {
            alert("Unknown error!");
        });
    });

    $("#listForm select:first").trigger("change");

    $("#addForm").on("submit", function() {
        var query = $("#addForm").serialize();

        $.get("add.php", query, function(data) {
            if ($(data).find("error").length) {
                alert($(data).find("error").text());
            }
            else
				window.location.hash = "#list";
        })
            .fail(function() {
                alert("Unknown error!");
             });

        return false;
    });

    </script>
	
	<style>
    /* Set up your own styles for the navbar and the Pokémon list */
    .navbar {
        /*margin: 1em;
        border: 2px darkgray solid;
        border-radius: 1em;*/
        background:
    }
    .navbar-brand img {
        height: 80px;
        margin-right: 40px;
    }
    .container h2 {
        text-align: center;
    }
    .pokemon {
        padding: 1em;
    }
    .pokemon .name {
        text-align: center;
        font-size: 120%;
        font-weight: bold;
        color: darkgray;
    }
    .pokemon .image {
        text-align: center;
    }
    .pokemon .types {
        text-align: center;
    }
    .pokemon .type {
        font-size: 90%;
        font-weight: bold;
    }
    </style>
	
</head>

<body>
    <!--navbar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
			<img src = "images/hkust-logo.svg" alt = "">
		</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <!--<li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>-->
                <li class="nav-item">
                    <a class="nav-link" href="#list">List</a>
                </li>
				<li class="nav-item">
                    <a class="nav-link" href="#add">Add</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
            <!--signout function button dun modify start-->
            <form class="form-inline my-2 my-lg-0">
                <button type="button" class="btn btn-outline-primary" id="signout"><i class="fas fa-sign-out-alt mr-2"></i> Sign Out</button>
            </form>
             <!--signout function button dun modify end-->
        </div>
    </nav>
	
	<!--<div class="container rounded bg-white" style="width: 20rem">
		<div class="row">
			<div class="col p-3 text-center">
				<h4>Main Page</h4>
			</div>
		</div>
		<div class="row">
			<div class="col text-center mb-3">
				<i class="far fa-smile"></i>
				Hi, !
			</div>
		</div>
	</div>-->
	
	<!-- This is the listing page -->
	<div id="listPage" class="container page pb-3" style="display: none">
      <h2>Faculty Members List</h2>

      <!-- Add the form for listing the Pokémon -->
      <form id="listForm">
        <div class="form-row">
          <div class="form-group col-6 col-md-4 col-lg-3 offset-md-2 offset-lg-3">
            <label for="schoolFilter">School</label>
            <select required class="form-control" id="schoolFilter" name="generation">
              <option value="">- All -</option>
              <option value="1">School of Engineering</option>
              <option value="2">School of Science</option>
              <option value="3">School of Business and Management</option>
              <option value="4">School of Humanities and Social Science</option>
              <option value="5">Interdisciplinary Programs Office</option>
            </select>
          </div>
          <div class="form-group col-6 col-md-4 col-lg-3">
            <label for="DepartmentFilter">Department</label>
            <select required class="form-control" id="departmentFilter" name="type">
              <option value="">- Nil -</option>
            </select>
          </div>
        </div>
      </form>
      <div id="listContent">
      </div>
    </div>
	
	<!-- This is the adding page -->
	<div id="addPage" class="container page pb-3" style="display: none">
      <h2>Adding a New Faculty Member</h2>

      <!-- Add the form for a new Pokémon here -->
      <form id="addForm">
        <div class="form-group">
          <label for="nationalNumber">National number</label>
          <input type="number" min="1" required class="form-control" id="nationalNumber" name="nationalNumber" placeholder="Enter national number">
        </div>
        <div class="form-group">
          <label for="pokemonName">Pokémon name</label>
          <input type="text" required class="form-control" id="pokemonName" name="pokemonName" placeholder="Enter Pokémon name">
        </div>
        <div class="form-group">
          <label for="imageAddress">Image address</label>
          <input type="url" required class="form-control" id="imageAddress" name="imageAddress" placeholder="Enter image address">
        </div>
        <div class="form-group">
          <label for="pokemonType">Pokémon type(s)</label>
          <select required multiple class="form-control" id="pokemonType" name="pokemonType[]">
            <option>Normal</option>
            <option>Fire</option>
            <option>Water</option>
            <option>Electric</option>
            <option>Grass</option>
            <option>Ice</option>
            <option>Fighting</option>
            <option>Poison</option>
            <option>Ground</option>
            <option>Flying</option>
            <option>Psychic</option>
            <option>Bug</option>
            <option>Rock</option>
            <option>Ghost</option>
            <option>Dragon</option>
            <option>Dark</option>
            <option>Steel</option>
            <option>Fairy</option>
          </select>
        </div>
        <div class="form-group">
          <label for="generation">Generation</label>
          <select required class="form-control" id="generation" name="generation">
            <option value="1">Generation 1</option>
            <option value="2">Generation 2</option>
            <option value="3">Generation 3</option>
            <option value="4">Generation 4</option>
            <option value="5">Generation 5</option>
            <option value="6">Generation 6</option>
            <option value="7">Generation 7</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Add the Pokémon</button>
      </form>
    </div>
</body>
</html>
