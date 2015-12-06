<?php
include_once('header.php');
include_once('utils.php');

if(!isset($_GET["search_text"])){
    displaySearchError();
}
else if( strlen($_GET["search_text"]) == 0){
    displaySearchError();
}
else{
    $results=getEventSearch($_GET["search_text"]);
    
    if(count($results)==0)
    displaySearchError();
    
    foreach($results as $result) {
        getEventCard($result,false);
    }
}

require 'footer.php';
?>