<?php
header("content-type: text/xml");

echo "<?xml version=\"1.0\"?>\n";

// Read the XML file into a DOM structure
$xml = new DOMDocument();
$xml->preserveWhiteSpace = false; // remove whitespace nodes 
$xml->load("Prof.xml");

// Retrieve the POST request values
$eName = $_POST["add-EnglishName"];
$cName = $_POST["add-ChineseName"];	// optional
error_log(print_r($cName,true));
$title = $_POST["add-head"];
$dept = $_POST["add-department"];
$sku = $_POST["add-school"];

$array = array();
for($x = 0; $x < 10; $x++) {
	if($_POST["add-area-".$x] != null) {
		$area = $_POST["add-area-".$x];
		array_push($array, $area);
	}
}

$tel = $_POST["add-telephone"];	// optional
$mail = $_POST["add-email"];
$page = $_POST["add-homepage"];
$img = $_FILES["add-image"];
error_log(print_r($img["name"],true));

function validateFields() {
	global $xml, $names, $eName; 
	
	// Check if the name has been taken
    $names = $xml->getElementsByTagName("EnglishName");
    foreach ($names as $node) {
        if ($node->nodeValue == trim($eName)) {
            return "Name already exists!";
        }
    }
	return null;
}

// Validate name of new Prof: EnglishName only
$error = validateFields();

// Show the error or add the new Prof
if(error != null) {
	// Show the error
    echo "<error>" . $error . "</error>";
}
else {
	$target = $xml->getElementsByTagName("staffs");
	
	// Add new prof
	$prof = $xml->createDocumentFragment();
	$nameNode = "<name>";
	$nameNode .= "<EnglishName>$eName</EnglishName>";
	if($cName != null) {
		$nameNode .= "<ChineseName>$cName</ChineseName>";
	}
	$nameNode .= "</name>";
	
	$positions = "<positions>";
	$positions .= "<position>";
	$positions .= "<head>$title</head>";
	$positions .= "<department>$dept</department>";
	$positions .= "<school>$sku</school>";
	$positions .= "</position>";
	$positions .= "</positions>";
	
	$researcharea = "<researchAreas>";
	foreach($array as $node) {
		//if($node != null) {
		$researcharea .= "<area>$node</area>";
		//}
	}
	$researcharea .= "</researchAreas>";
	
	$contact = "<contact>";
	if($tel != null) {
		$contact .= "<telephone>$tel</telephone>";
	}
	$contact .= "<email>$mail</email>";
	$contact .= "<homepage>$page</homepage>".
	$contact .= "</contact>";	
	
	$image = "<image>$img</image>";
	move_uploaded_file(img["name"], "data-pic/".trim($eName));
	
	$prof->appendXML("<staff>$nameNode $positions $researcharea $contact $image</staff>");
	$target->appendChild($prof);
	
	$xml->save("Prof.xml");
	
	// Show success
    echo "<success/>";
}
?>