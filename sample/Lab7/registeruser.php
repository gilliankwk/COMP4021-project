<?php
// Read the JSON file
$users = file_get_contents("users.json");
$users = json_decode($users, true);

// Get and trim the input fields if necessary
$username = trim($_POST["username"]);
$firstname = trim($_POST["firstname"]);
$lastname = trim($_POST["lastname"]);
$password = $_POST["password"];
$confirm = $_POST["confirm"];

// Check the username
if (array_key_exists($username, $users))
    $output["error"] = "Duplicate username exists!";

// Check all fields
elseif (empty($username) || empty($firstname) ||
        empty($lastname) || empty($password))
    $output["error"] = "Not all data has been submitted!";

// Check all fields
elseif ($password != $confirm)
    $output["error"] = "Passwords do not match!";

// Add the user
else {
    // Add the user to the JSON object and save it
    $users[$username]["firstname"] = $firstname;
    $users[$username]["lastname"] = $lastname;
    $users[$username]["password"] = $password;

    file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));

    // Set up the session
    session_start();
    $_SESSION["username"] = $username;

    $output["success"] = "";
}

header("content-type: application/json");

print json_encode($output);
?>
