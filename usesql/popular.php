<?php
$allimgs = [];
include('dbconnection.php');

$read = "select f8.* FROM fun8meme f8
        INNER JOIN (SELECT MAX(requestCount) AS rc FROM fun8meme ) groupedf8
        on f8.requestCount = groupedf8.rc";
$result = $link->query($read);
if (!$result) {
    trigger_error('Invalid query: ' . $link->error);
}
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

        }
}
    
$link->close();
$arr1 = encjson($allimgs);
 echo ( sizeof($allimgs) == 0 ? printerror() : $arr1);
return $arr1;

function encjson($arr){
    return json_encode($arr);
}

?>