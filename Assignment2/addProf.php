<?php
header("content-type: application/json");

// Read the XML file into a DOM structure
$xml = new DOMDocument();
$xml->preserveWhiteSpace = true; // remove whitespace nodes 
$xml->load("Prof.xml");

// Retrieve the GET request values
$eName = trim($_POST["add-EnglishName"]);
$cName = trim($_POST["add-ChineseName"]);	// optional
$tel = $_POST["add-telephone"];	// optional
$mail = trim($_POST["add-email"]);
$page = trim($_POST["add-homepage"]);//optional
$area;
for($i=0;$i<10;$i++){
    if(isset($_POST["add-area-".$i])){
        $area[$i]=$_POST["add-area-".$i];
    }
}
$title;
$dept;
$sku;
for($i=0;$i<5;$i++){
    if(isset($_POST["add-head-".$i])){
        $title[$i]=$_POST["add-head-".$i];
    }
    if(isset($_POST["add-department-".$i])){
        $dept[$i]=$_POST["add-department-".$i];
    }
    if(isset($_POST["add-school-".$i])){
        $sku[$i]=$_POST["add-school-".$i];
    }
}

function validateFields() {
	global $xml, $names,$eName; 
	// Check if the name has been taken
    $names = $xml->getElementsByTagName("EnglishName");
    foreach ($names as $node) {
        //if ($node->nodeValue == )
        if ($node->nodeValue == $eName) {
            return "Name already exists!";
        }
    }
	return null;
}

// Validate name of new Prof: EnglishName only
$error = validateFields();

// Show the error or add the new Prof
if($error != null) {
	// Show the error
    error_log(print_r("not success".$error,true));
    $output["success"]="not success";
    echo json_encode($output);
}else {
	$target = $xml->getElementsByTagName("staffs")->item(0);
	// Add new prof
	$staff = $xml->createDocumentFragment();
	//name
    $namenode="<EnglishName>".$eName."</EnglishName><ChineseName>";
    if($cName!=""){
        $namenode.=$cName;
    }
    $namenode.="</ChineseName>";
    error_log(print_r($namenode,true));
    //position
    $posnode="";
    for($i=0;$i<count($title);$i++){
        $posnode.="<position><head>".$title[$i]."</head><department>".$dept[$i]."</department><school>".$sku[$i]."</school></position>";
    }
    //research area
    $areanode="";
    for($i=0;$i<count($area);$i++){
        $areanode.="<area>".$area[$i]."</area>";
    }
    //contact
    $contactnode="<telephone>";
    if($tel!=""){
        $contactnode.=$tel;
    }
    $contactnode.="</telephone><email>".$mail."</email><homepage>";
    if($page!=""){
        $contactnode.=$page;
    }
    $contactnode.="</homepage>";
    //image
    if(isset($_FILES['file']['name'])){
        $filename = $_FILES['file']['name'];
        error_log(print_r("file uploaded",true));
    }else{
        $status="error";
        $info="file upload error";
        error_log(print_r("file was not uploaded",true));
    }
/* Getting File size */
    if(isset($_FILES['file']['size'])){
        $filesize = $_FILES['file']['size'];
        error_log(print_r("file uploaded",true));
    }else{
        $status="error";
        $info="file upload error";
        error_log(print_r("file was not uploaded",true));
    }
    $src = "data-pic/".$eName.".jpg";
    $location = "data-pic/".$filename."jpg";
    error_log(print_r($_FILES['file']['name'],true));
    if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
        error_log(print_r($location,true));
       $src = "data-pic/".$eName.".jpg";
    
    // checking file is image or not
        if(is_array(getimagesize($location))){
            chmod($location, 0755);
            rename($location, "data-pic/".$eName.".jpg");//rename the file as username
            
        }else{
            $status="error";
            $info="file type error";
        }
    
    }else{
        error_log(print_r("file was not uploaded",true));
    }
    //wrap all up
    error_log(print_r($namenode,true));
    error_log(print_r($posnode,true));
    error_log(print_r($areanode,true));
    $staff->appendXML("<staff><name>$namenode</name><positions>$posnode</positions><researchAreas>$areanode</researchAreas><contact>$contactnode</contact><image>$src</image></staff>");
	$target->appendChild($staff);
    //file
    
	$xml->save("Prof.xml");
	
	// Show success
    $output["success"]="success";
    echo json_encode($output);
}
?>