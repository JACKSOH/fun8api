<?php

$id = 0;
$allimgs = [];
$teststring = "";
include('../simple_html_dom.php');
include('dbconnection.php');

// Delete all the data and reset id
$del = "delete FROM fun8meme";
$link->query($del);
$reset =" alter table fun8meme auto_increment = 1";
$link->query($reset);

for( $i = 1; $i <= gettotalpages(); $i++ ) // to load all the web page
{
    $html = file_get_html('http://interview.funplay8.com/?page=' .$i);
    $divs = $html->find('"div.col-xs-6 col-sm-4"');

        foreach($divs as $div ) // to load all the img block (div block )
        {
            $imgs =  $div->find("img");
            $names =  $div->find('h6');
            $imgsrc = '';
            $imgname = '';

            foreach($imgs as $img)  // img source
            {
                $imgsrc = $img->src;
            }

            foreach($names as $name ) // img name
            {
                $imgnames = $name->find('text');
                foreach( $imgnames as $name1 )
                {
                    $imgname = strval( $name1);
                }
            } 

            // create new entry
            $insert = "insert into fun8meme (id, src, name, page) VALUES (NULL, ? , ? , ? )"; // User parameterized query
            $stmt = $link->prepare($insert); 
            $stmt->bind_param('ssi', $imgsrc, $imgname, $i);
            $stmt->execute();
        }
}

$read = "select * from fun8meme";
$result = $link->query($read);

if ($result->num_rows > 0) {
// output data of each row
    while($row = $result->fetch_assoc()) {
        // push the data to the array      
        array_push( $allimgs, [
            "id"   => $row["id"],
            "name" => $row["name"],
            "src" => $row["src"]
            
            ]);
    }
} 
$link->close();
$arr1 = encjson($allimgs);
echo $arr1;

function encjson($arr){
    return json_encode($arr);
}

function gettotalpages(){ // is just dummy 95

    return 95;
}

?>