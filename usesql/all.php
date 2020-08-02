<?php
$id = 0;
$allimgs = [];
$teststring = "";
include('dbconnection.php');

$read = "select * from fun8meme";
$result = $link->query($read);

if ($result->num_rows > 0) {
// output data of each row
    while($row = $result->fetch_assoc()) {

        // push the data to the array      
        array_push( $allimgs, [
            "id"   => $row["id"],
            "name" => $row["name"],
            "src" => $row["src"],
            "page" =>$row["page"],
            "requestCount" =>$row["requestCount"]
            ]);

        // update the request count once retrieve
        $update = 'update fun8meme set requestCount = ? where id=? ';
        $stmt = $link->prepare( $update ); 
        $id = $row["id"];
        $updatedCount = $row["requestCount"] + 1;
        $stmt->bind_param('ii', $updatedCount , $id );
        $stmt->execute();
    }
} 
$link->close();
$arr1 = encjson($allimgs);
echo $arr1;
return $arr1;


function encjson($arr){
    return json_encode($arr);
}


?>