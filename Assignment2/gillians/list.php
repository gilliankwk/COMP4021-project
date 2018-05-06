<?php
header("content-type: text/xml");

// Read the XML file into a DOM structure
$xml = new DOMDocument();
$xml->preserveWhiteSpace = false; // remove whitespace nodes 
$xml->load("professor.xml");

// Retrieve the GET request values
$school = $_GET["school"];
$department = $GET["department"];

// Remove the non-matching schools
if ($school != null) {
    $schools = $xml->getElementsByTagName("generation");
    for ($i = $schools->count() - 1; $i >= 0; $i--) {
        $node = $schools->item($i);
        if ($node->getAttribute("num") != $school) {
            $node->parentNode->removeChild($node);
        }
    }
}

// Remove the non-matching departments
if ($department != null) {
    $staff = $xml->getElementsByTagName("staff");
    for ($i = $pokemon->count() - 1; $i >= 0; $i--) {
        $node = $staff->item($i);

        $found = false;
        $departments = $node->getElementsByTagName("department");
        foreach ($departments as $departmentNode) {
            //if ($departmentNode->nodeValue == $department)
			if ($departmentNode->getAttribute("code") == $department)
				$found = true;
        }
        if (!$found) {
            $node->parentNode->removeChild($node);
        }
    }
}

echo $xml->saveXML();
?>