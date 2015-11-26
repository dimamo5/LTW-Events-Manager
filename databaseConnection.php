<?php
function login($username, $password)
{  
    $db = $db = new PDO('sqlite:event.db');
    $query = "SELECT * FROM User WHERE loginId='";
    $query .= $username . "';";
       
    $stmt = $db->prepare($query);
	$stmt->execute();  
	$result = $stmt->fetchAll();
    if(count($result)==0){
        return false;
    }
    
    $password_db = $result[0]['password'];
    $user_id = $result[0]['idUser'];
    
    $password = hash('sha512', $password);
    
    $db=NULL;
       
    if ($password_db == $password) {
        $_SESSION['userId'] = $user_id;
        return true;
    } else return false;
}

function login_check()
{
    if (isset($_SESSION['userId'])) {
        return true;
    } else return false;

}

function getMyEvents(){
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("SELECT Event.* FROM UserEvent,Event WHERE idUser=:userId AND Event.idEvent=UserEvent.idEvent");
    $stmt->bindParam(':userId',$_SESSION["userId"],PDO::PARAM_INT);
    
	$stmt->execute();  
	$result = $stmt->fetchAll();
    return $result;
}

function getEvent($id){
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("SELECT * FROM Event WHERE idEvent=:id");
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    
	$stmt->execute();  
	$result = $stmt->fetchAll();
    return $result[0];
}

function hasAccess($id){
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("SELECT * FROM UserEvent WHERE idUser=:id AND idEvent=:idEvent");
    $stmt->bindParam(':id',$_SESSION["userId"],PDO::PARAM_INT);
    $stmt->bindParam(':idEvent',$id,PDO::PARAM_INT);
    
	$stmt->execute();  
	$result = $stmt->fetchAll();
    
    if(count($result)>0){
        return true;
    }else return false;
    
    
}



?>