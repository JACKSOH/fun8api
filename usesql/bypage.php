<?php

$allimgs = [];
include('dbconnection.php');
$page = getpage();
if( $page !== 0)
{
    $read = "select * from fun8meme where page = ". $page;
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
    echo ( sizeof($allimgs) == 0 ? printerror() : $arr1);
    return $arr1;
}
else{
    printerror();
}

function printerror(){
    echo "<p>"."Failed in finding the page <br> Make sure number not exceed the maximum page OR it is a valid numberic form.";
}

function getpage(){ // get val
    $page = 0;
    if (isset($_GET['page'])) {
        $page = intval($_GET['page']);
      }
return $page;
}

function encjson($arr){
    return json_encode($arr);
}

?>