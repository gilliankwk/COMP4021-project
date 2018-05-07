<?php
header("content-type: text/xml");

echo "<?xml version=\"1.0\"?>\n";

// Read the XML file into a DOM structure
$xml = new DOMDocument();
$xml->preserveWhiteSpace = false; // remove whitespace nodes 
$xml->load("Prof.xml");

// Retrieve the GET request values
$eName = $_POST["add-EnglishName"];
$cName = $_POST["add-ChineseName"];	// optional
$title = $_POST["add-head"];
$sku = $_POST["add-school"];
$dept = $_POST["add-department"];

$array = array();
$x = 0;
while(isset($_POST["area"]) && is_array($_POST["area"])) {
	$rearea = $_POST["area"][$x];
	array_push($array, $rearea);
	$x++;
}
print_r($array);

$tel = $_POST["add-telephone"];	// optional
$mail = $_POST["add-email"];
$page = $_POST["add-homepage"];
$image = $_FILES["add-image"];



function validateFields() {
	global $xml, $name; 
	
	// Check if the name has been taken
    $names = $xml->getElementsByTagName("EnglishName");
    foreach ($names as $node) {
        if ($node->nodeValue == trim($name)) {
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
	// Add new prof
	$prof = $xml->createDocumentFragment();
	$nameNode = "<name>";
	$nameNode .= "<EnglishName>$eName</EnglishName>";
	if($cName != null) {
		$nameNode .= "<ChineseName>$cName</ChineseName>";
	}
	$nameNode .= "</name>";
	
	$prof->appendXML("");
	
	$xml->save("Prof.xml");
	
	// Show success
    echo "<success/>";
}

?>