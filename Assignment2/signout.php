<?php
session_start();
$option=$_GET["option"];

if($option=="0"){//normal signout
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

header("Location: signin.php");
    
}elseif($option=="1"){//remember sign out keep remember ajax
    if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();
    header("content-type: application/json");
    $output["status"]="success";
    print json_encode($output);
    
    
}else{//remember signout not remember
    if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
setcookie("username", "haha" , time() - (86400 * 30), '/');
session_destroy();

header("Location: signin.php");
}
?>
