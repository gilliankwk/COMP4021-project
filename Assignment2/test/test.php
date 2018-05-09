<?php
$xml = new DOMDocument();
$xml->preserveWhiteSpace = true; // remove whitespace nodes 
$xml->load("Prof.xml");
$specialnode;
$specialimage;
        $names=$xml->getElementsByTagName("EnglishName");
        foreach($names as $node){
            if($node->nodeValue=="Chan, Kit Yu Karen"){
                error_log(print_r("start debug",true));
                error_log(print_r($node->nodeValue,true));
                error_log(print_r($node->parentNode->nodeValue,true));
                error_log(print_r($node->parentNode->parentNode->nodeValue,true));
                echo"start debug"."<br>";
                echo $node->nodeValue."<br>";
                echo $node->parentNode->nodeValue."<br>";
                echo $node->parentNode->parentNode->nodeValue."<br>";
                $specialnode=$node->parentNode->parentNode;
                break;
            }
        }
echo "hahahaha<br>";
echo $specialnode->nodeValue."<br>";
echo $specialnode->childNodes->item(0)->nodeValue."<br>";
echo $specialnode->childNodes->item(1)->nodeValue."<br>";
echo $specialnode->childNodes->item(2)->nodeValue."<br>";
echo $specialnode->childNodes->item(3)->nodeValue."<br>";
echo $specialnode->childNodes->item(4)->nodeValue."<br>";
echo $specialnode->childNodes->item(5)->nodeValue."<br>";
echo $specialnode->childNodes->item(6)->nodeValue."<br>";
echo $specialnode->childNodes->item(7)->nodeValue."<br>";
echo $specialnode->childNodes->item(8)->nodeValue."<br>";
echo $specialnode->childNodes->item(9)->nodeValue."<br>";
        $specialimage=$specialnode->childNodes->item(4)->nodeValue;
echo $specialimage."<br>";

?>