<?php
include_once('header.php');
include_once('utils.php');

if(!isset($_GET["search_text"])){
    echo "Enter a search term in the box above.";
}
else if( strlen($_GET["search_text"]) == 0){
    echo "Enter a search term in the box above.";
}
else{
    $results=getEventSearch($_GET["search_text"]);
    
    foreach($results as $result) {
        getEventCard($result,false);
    }
}

require 'footer.php';
?>