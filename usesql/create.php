<?php
$allimgs = [];
include('dbconnection.php');

$insert = "insert into fun8meme (id, src, name, page) VALUES (NULL, ? , ? , ? )";
$img = getnewimg();
$defaultpage =0;
$stmt = $link->prepare($insert); 
$stmt->bind_param('ssi', $img["name"], $img["src"], $defaultpage);
$stmt->execute();
    
$arr1 = encjson($img);
echo  $arr1;
return $arr1;

function getnewimg(){ // get val
    $img['name'] = "";
    $img['src'] = "";

    if (isset($_POST['name'])) {
        $img['name'] = $_POST['name'];
      }

    if (isset($_POST['src'])) {
        $img['src']  = $_POST['src'];
    }

return  $img ;
}

function encjson($arr){
    return json_encode($arr);
}

?>