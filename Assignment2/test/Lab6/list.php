<?php
header("content-type: text/xml");

// Read the XML file into a DOM structure
$xml = new DOMDocument();
$xml->preserveWhiteSpace = false; // remove whitespace nodes 
$xml->load("pokemon.xml");

// Retrieve the GET request values
$generation = $_GET["generation"];
$type       = $_GET["type"];

// Remove the non-matching generations
if ($generation != null) {
    $generations = $xml->getElementsByTagName("generation");
    for ($i = $generations->count() - 1; $i >= 0; $i--) {
        $node = $generations->item($i);
        if ($node->getAttribute("num") != $generation) {
            $node->parentNode->removeChild($node);
        }
    }
}

// Remove the non-matching types
if ($type != null) {
    $pokemon = $xml->getElementsByTagName("pokemon");
    for ($i = $pokemon->count() - 1; $i >= 0; $i--) {
        $node = $pokemon->item($i);

        $found = false;
        $types = $node->getElementsByTagName("type");
        foreach ($types as $typeNode) {
            if ($typeNode->nodeValue == $type) $found = true;
        }
        if (!$found) {
            $node->parentNode->removeChild($node);
        }
    }
}

echo $xml->saveXML();
?>
