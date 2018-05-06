<?php
//output will be XML

header("content-type: text/xml");
//reading XML
$xml = new DOMDocument();
$xml->preserveWhiteSpace=false;
$xml->load("Prof.xml");

//retrieve the Get Request values
$name =$_GET["searchname"];


//find out the node that hold that staff with $name
$names=$xml->getElementsByTagName("EnglishName");
$specialNameNode;
foreach($names as $node){
    if($node->nodeValue==$name){
        $specialNameNode=$node;
        break;
    }
}
$specialNode=$specialNameNode->parentNode->parentNode;

$specialNode->parentNode->removeChild($specialNode);

$xml->save("Prof.xml");
echo"<success>yes</success>"
?>