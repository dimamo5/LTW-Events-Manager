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

function isAdmin($idEvent,$idAdmin){
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("SELECT * FROM Event WHERE idOwner=:idAdmin AND idEvent=:idEvent;");
    $stmt->bindParam(':idAdmin',$idAdmin,PDO::PARAM_INT);
    $stmt->bindParam(':idEvent',$idEvent,PDO::PARAM_INT);
    
	$stmt->execute();  
	$result = $stmt->fetchAll();
    
    if(count($result)>0){
        return true;
    }else return false;
}

function deleteEvent($id){
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("DELETE FROM Event WHERE idEvent=:idEvent;");
    $stmt->bindParam(':idEvent',$id,PDO::PARAM_INT);
	
	$result=$stmt->execute();  
    if($result>0){
        $stmt2=$db->prepare("DELETE FROM UserEvent WHERE idEvent=:idEvent");
        $stmt2->bindParam(':idEvent',$id,PDO::PARAM_INT);
        $result2=$stmt2->execute();
        if($result2>0){
            return true;
        }
    }
}

function editEvent($id,$description,$nameEvent,$creationDate,$endDate,$local,$type){
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("UPDATE Event SET nameEvent=:nameEvent,description=:description,creationDate=:creationDate,endDate=:endDate,local=:local,type=:type WHERE idEvent=:idEvent");
    $stmt->bindParam(':idEvent',$id,PDO::PARAM_INT);
    $stmt->bindParam(':nameEvent',$nameEvent,PDO::PARAM_STR);
    $stmt->bindParam(':description',$description,PDO::PARAM_STR);
    $stmt->bindParam(':creationDate',$creationDate,PDO::PARAM_STR);
    $stmt->bindParam(':endDate',$endDate,PDO::PARAM_STR);
    $stmt->bindParam(':local',$local,PDO::PARAM_STR);
    $stmt->bindParam(':type',$type,PDO::PARAM_STR);
	
	$result=$stmt->execute();  
    if($result>0){
        return true;
    }else{
         return false;
    }
}

function getUsers(){
     $db = new PDO('sqlite:event.db');
     $stmt=$db->prepare("SELECT User.idUser,User.name FROM User;");
     $stmt->execute();  
     $result = $stmt->fetchAll();
     if($result>0){
        return $result;
    }else return false;
}

function getUsersEvent($eventId){
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("SELECT User.id,User.name,UserEvent.confirm FROM User,UserEvent WHERE idEvent=:eventId AND User.idUser=UserEvent.idUser;");
    $stmt->bindParam(':eventId',$eventId,PDO::PARAM_INT);
    
    $stmt->execute(); 
    $result = $stmt->fetchAll(); 
    
    if($result>0){
        return $result;
    }else{
         return false;
    }
}

function createEvent($description,$nameEvent,$creationDate,$endDate,$local,$type,$public,$ownerId){
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("INSERT INTO Event(nameEvent,creationDate,endDate,local,public,type,description,idPhoto,idOwner)
    VALUES(:nameEvent,:creationDate,:endDate,:local,:public,:type,:description,1,:ownerId)");
    $stmt->bindParam(':nameEvent',$nameEvent,PDO::PARAM_STR);
    $stmt->bindParam(':description',$description,PDO::PARAM_STR);
    $stmt->bindParam(':creationDate',$creationDate,PDO::PARAM_STR);
    $stmt->bindParam(':public',$public,PDO::PARAM_BOOL);
    $stmt->bindParam(':endDate',$endDate,PDO::PARAM_STR);
    $stmt->bindParam(':local',$local,PDO::PARAM_STR);
    $stmt->bindParam(':type',$type,PDO::PARAM_STR);
    $stmt->bindParam(':ownerId',$ownerId,PDO::PARAM_STR);
	
	$result=$stmt->execute();  
    $lastId=$db->lastInsertId("idEvent");
    
    return $lastId;
}

?>