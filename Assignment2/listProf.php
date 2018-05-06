<?php
//output will be XML
header("content-type: text/xml");

//reading XML
$xml = new DOMDocument();
$xml->preserveWhiteSpace=false;
$xml->load("Prof.xml");

//retrieve the Get Request values
$name =$_GET["searchname"];
$research=$_GET["searchresearch"];
$department=$_GET["department"];
$school=$_GET["school"];

//filtering by removing non necessary fragment
if($school != "---all---"){
    $staffs=$xml->getElementsByTagName("staff");//return staff list
    for($i=$staffs->count()-1;$i>=0;$i--){
        $staff=$staffs->item($i);
        $positions=$staff->childNodes->item(1)->childNodes;//accessing positions
        $isschool=false;
        for($j=0;$j<$positions->count();$j++){
            $value=$positions->item($j)->childNodes->item(2)->nodeValue;
            if($value==$school){//accessing school
                $isschool=true;    
            }
        }
        if($isschool==false){
            $staff->parentNode->removeChild($staff);
        }
    }    
}
if($department != null){
     $staffs=$xml->getElementsByTagName("staff");//return staff list
    for($i=$staffs->count()-1;$i>=0;$i--){
        $staff=$staffs->item($i);
        $positions=$staff->childNodes->item(1)->childNodes;//accessing positions
        $isdepartment=false;
        for($j=0;$j<$positions->count();$j++){
            if($positions->item($j)->childNodes->item(1)->nodeValue==$department){//accessing department
                $isdepartment=true;
            }
        }
        if(!$isdepartment){
            $staff->parentNode->removeChild($staff);
        }
    }
}
if($research != null){
      $staffs=$xml->getElementsByTagName("staff");//return staff list
    for($i=$staffs->count()-1;$i>=0;$i--){
        $staff=$staffs->item($i);
        $researcharea=$staff->childNodes->item(2)->childNodes;//accessing researchareas
        $isresearch=false;
        for($j=0;$j<$researcharea->count();$j++){
            if(strpos($researcharea->item($j)->nodeValue,$research)!==false){//accessing englishname
                $isresearch=true;
            }
        }
        if(!$isresearch){
            $staff->parentNode->removeChild($staff);
        }
    }
}

if($name != null){
     $staffs=$xml->getElementsByTagName("staff");//return staff list
    for($i=$staffs->count()-1;$i>=0;$i--){
        $staff=$staffs->item($i);
        $names=$staff->childNodes->item(0)->childNodes;//accessing name
        $isname=false;
        for($j=0;$j<$names->count();$j++){
            if(strpos($names->item($j)->nodeValue,$name)!==false){//accessing englishname
                $isname=true;
            }
        }
        if(!$isname){
            $staff->parentNode->removeChild($staff);
        }
    }
}

//check selection sending breadcomb and page info with school department and number of records left
$records = $xml->getElementsByTagName("staff");
$recordnumber=$records->length;
$metadata =$xml->createDocumentFragment();
$metadata->appendXML("<meta><breadcrumb><school>".$school."</school><department>".$department."</department><name>".$name."</name><research>".$research."</research></breadcrumb><numberofrecord>".$recordnumber."</numberofrecord></meta>");
$rootnode=$xml->getElementsByTagName("staffs")[0];
$rootnode->appendChild($metadata);

echo $xml->saveXML();
?>