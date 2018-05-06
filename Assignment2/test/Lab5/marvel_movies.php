<?php
// Read the XML file into a DOM structure
$xml = new DOMDocument();
$xml->preserveWhiteSpace = false; // remove whitespace nodes 
$xml->load("marvel_movies.xml");

// Read all the movie nodes
$movie_nodes = $xml->getElementsByTagName("movie");

// Retrieve the search term and orderby term
$search = $_GET["s"];
$orderby = $_GET["orderby"];

// Create the movies array
$movies = [];

// For each movie node, convert it to a PHP array
foreach ($movie_nodes as $node) { 
    $search_exists = false;

    $movie = [];
    foreach ($node->childNodes as $child) {
        if ($child->nodeName == "ratings") {
            $movie["ratings"] = [];
            foreach ($child->childNodes as $grandchild) {
                $movie["ratings"][$grandchild->nodeName] = $grandchild->nodeValue;
            }
        }
        else {
            $movie[$child->nodeName] = $child->nodeValue;

            // Look for the search term in every node value
            if ($search != NULL && stripos($child->nodeValue, $search) !== false)
                $search_exists = true;
        }
    }

    // Only add the matching movies
    if ($search == NULL || $search_exists) {
        // Define the sort order and add the movie
        switch ($orderby) {
        case "title":
            $movies[$movie["title"]] = $movie;
            ksort($movies);
            break;
        case "box-office":
            $movies[$movie["box-office"]] = $movie;
            krsort($movies);
            break;
        default:
            $movies[] = $movie;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lab 5: Marvel Movies</title>
    <meta charset="utf-8">
    <meta name="viewport" 
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        // Construct the URL without the query string
        var url = window.location.protocol + "//" + window.location.host + window.location.pathname;

        // Find the query string and parameters
        var qstring = window.location.search.substring(1);
        var pairs = qstring.split("&");
        var params = {};
        for (var i = 0; i < pairs.length; i++) {
            pairs[i] = pairs[i].split("=");
            params[pairs[i][0]] = pairs[i][1];
        }

        // Set up the event handlers
        // The following code considers both search term and orderby parameters

        $("#sort-by-title").on("click", function() {
            window.location = url + "?orderby=title" + (params["s"]? "&s=" + params["s"] : "");
            return false;
        });

        $("#sort-by-box-office").on("click", function() {
            window.location = url + "?orderby=box-office" + (params["s"]? "&s=" + params["s"] : "");
            return false;
        });

        $("#reset-sort-order").on("click", function() {
            window.location = url + (params["s"]? "?s=" + params["s"] : "");
            return false;
        });

        $("#search-button").on("click", function() {
            var search = $("#search-box").val().trim();
            window.location = url + "?s=" + search + (params["orderby"]? "&orderby=" + params["orderby"] : "");
            return false;
        });

        $("#clear-button").on("click", function() {
            window.location = url + (params["orderby"]? "?orderby=" + params["orderby"] : "");
            return false;
        });
    });
    </script>
    <style>
    .navbar-brand img {
        float: left;
        height: 30px;
        margin-right: 1em;
    }
    .movie {
        border: 1px solid lightgray;
        border-radius: 0.5em;
        box-shadow: 1px 1px 4px lightgray;
        margin: 0.25em;
        overflow: hidden;
    }
    .movie img {
        width: 50%;
        margin-left: 0.5em;
    }
    .movie .info {
        padding: 0.5em;
    }
    .movie .year {
        color: gray;
    }
    .movie .box-office {
        margin-top: 0.5em;
        font-weight: bold;
        font-size: 80%;
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">
        <img src="marvel-logo.png" alt="">
        Marvel Movies
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Sorting
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" id="sort-by-title" href="#">Sort by Title</a>
              <a class="dropdown-item" id="sort-by-box-office" href="#">Sort by Box Office</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" id="reset-sort-order" href="#">Reset Sort Order</a>
            </div>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" id="search-box" type="search" placeholder="Search" aria-label="Search" value="<?= $search; ?>">
          <button class="btn btn-outline-success my-2 my-sm-0" id="search-button" type="submit">Search</button>
          <button class="btn btn-outline-info ml-1 my-2 my-sm-0" id="clear-button">Clear</button>
        </form>
      </div>
    </nav>
    <div class="container" >
        <div class="row">
            <?php foreach ($movies as $movie) { ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="movie clearfix">
                        <img src="posters/<?= $movie["poster"] ?>" class="img-responsive float-right" alt="Poster">
                        <div class="info">
                            <div class="title"><?= $movie["title"] ?></div>
                            <div class="year">(<?= $movie["year"] ?>)</div>
                            <div class="box-office">Box office: <?= $movie["box-office"] ?>M</div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>