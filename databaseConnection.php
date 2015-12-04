<?php
function login($username, $password)
{  
    $db = new PDO('sqlite:event.db');
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

function register($username,$password,$email,$name,$birthdate){
    $db = new PDO('sqlite:event.db');
    
    $stmt=$db->prepare("SELECT * FROM User WHERE loginId=:username");
    $stmt->bindParam(':username',$username,PDO::PARAM_STR);
    $stmt->execute(); 
    $result = $stmt->fetchAll();
    if(count($result)>0){
        return "username taken";
    }
    
    $stmt=$db->prepare("SELECT * FROM User WHERE email=:email");
    $stmt->bindParam(':email',$email,PDO::PARAM_STR);
    $stmt->execute(); 
    $result = $stmt->fetchAll();
    if(count($result)>0){
        return "email taken";
    }
    
    $password = hash('sha512', $password);
    
    $stmt=$db->prepare("INSERT INTO User(loginId,password,email,name,birthday,idPhoto)
    VALUES(:username,:password,:email,:name,:birthday,1)");
    $stmt->bindParam(':username',$username,PDO::PARAM_STR);
    $stmt->bindParam(':password',$password,PDO::PARAM_STR);
    $stmt->bindParam(':email',$email,PDO::PARAM_STR);
    $stmt->bindParam(':name',$name,PDO::PARAM_STR);
    $stmt->bindParam(':birthday',$birthday,PDO::PARAM_STR);
    $stmt->execute();
    
    return "success";
}


function login_check()
{
    if (isset($_SESSION['userId'])) {
        return true;
    } else return false;

}

function getEventsInvited(){
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("SELECT Event.* FROM UserEvent,Event WHERE UserEvent.idUser=:userId AND Event.idEvent=UserEvent.idEvent 
                        AND UserEvent.idEvent NOT IN(SELECT Event.idEvent FROM Event WHERE Event.idOwner=:userId);");
   
    $stmt->bindParam(':userId',$_SESSION["userId"],PDO::PARAM_INT);
    
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}

function getEvensAdmin(){
    
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("SELECT Event.* FROM Event WHERE Event.idOwner=:userId");
    $stmt->bindParam(':userId',$_SESSION["userId"],PDO::PARAM_INT);
    
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;   
}

function getEvent($id){
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("SELECT Event.*,Photo.path FROM Event,Photo WHERE Event.idEvent=:id AND Event.idPhoto=Photo.idPhoto");
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

function goesEvent($idEvent,$idUser){
     $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("SELECT * FROM UserEvent WHERE idUser=:idUser AND idEvent=:idEvent AND confirm=1");
    $stmt->bindParam(':idUser',$_SESSION["userId"],PDO::PARAM_INT);
    $stmt->bindParam(':idEvent',$idEvent,PDO::PARAM_INT);
    
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

function getUser($userId){
    $db = new PDO('sqlite:event.db');
    $stmt=$db->prepare("SELECT * FROM User WHERE User.idUser=:userid");
    $stmt->bindParam(':userid',$userId,PDO::PARAM_INT);
    
    $stmt->execute(); 
    $result = $stmt->fetchAll();
    
     if($result>0){
        return $result[0];
    }else return false;    
}
function getUserEventName($name,$eventId){
    $db = new PDO('sqlite:event.db');

    $name="%".$name."%";

    $stmt=$db->prepare("SELECT User.idUser,User.name FROM User WHERE name LIKE :name AND idUser NOT IN(SELECT idUser FROM UserEvent WHERE idEvent=:eventId)");
    $stmt->bindParam(':eventId',$eventId,PDO::PARAM_INT);
    $stmt->bindParam(':name',$name,PDO::PARAM_STR);
    
    $stmt->execute(); 
    $result = $stmt->fetchAll();   
        return $result;
}

function addUser($eventId,$idUser){
     $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("INSERT INTO UserEvent(idUser,idEvent,confirm) VALUES(:idUser,:idEvent,0)");
    $stmt->bindParam(':idUser',$idUser,PDO::PARAM_STR);
    $stmt->bindParam(':idEvent',$eventId,PDO::PARAM_STR);
    	
	$result=$stmt->execute();  
    
    if($result>0){
        return $result;
    }else return false;    
}

function removeUser($eventId,$idUser){
     $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("DELETE FROM UserEvent WHERE idUser=:idUser,idEvent=:idEvent)");
    $stmt->bindParam(':idUser',$idUser,PDO::PARAM_STR);
    $stmt->bindParam(':idEvent',$eventId,PDO::PARAM_STR);
    	
	$result=$stmt->execute();  
    
    if($result>0){
        return $result;
    }else return false;    
}

function getUserImagePath($userId){
    $db = new PDO('sqlite:event.db');
    $stmt=$db->prepare("SELECT Photo.path FROM Photo,User WHERE Photo.idPhoto=User.idPhoto AND User.idUser=:userid");
    $stmt->bindParam(':userid',$userId,PDO::PARAM_INT);
    
    $stmt->execute(); 
    $result = $stmt->fetchAll();
    
     if($result>0){
        return $result[0][0];
    }else return false;   
}
 
function getUser2($userId){
    $db = new PDO('sqlite:event.db');
    $stmt=$db->prepare("SELECT * FROM User WHERE idUser=:userid;");
    $stmt->bindParam(':userid',$userId,PDO::PARAM_INT);
    
    $stmt->execute(); 
    $result = $stmt->fetch();
    return $result;
}


function getUsersEvent($eventId){
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("SELECT User.idUser,User.name FROM User,UserEvent WHERE idEvent=:eventId AND User.idUser=UserEvent.idUser;");
    $stmt->bindParam(':eventId',$eventId,PDO::PARAM_INT);
    
    $stmt->execute(); 
    $result = $stmt->fetchAll(); 
    
    if($result>0){
        return $result;
    }else{
         return false;
    }
}

function getEventSearch($string){
    $db = new PDO('sqlite:event.db');

    $string = "%".$string."%"; 

    $stmt=$db->prepare("SELECT Event.* FROM Event,User,UserEvent WHERE User.idUser=:userId AND UserEvent.idUser=:userId AND Event.idEvent=UserEvent.idEvent AND Event.nameEvent LIKE :search
                        UNION SELECT Event.* FROM Event WHERE Event.public=1 AND Event.nameEvent LIKE :search GROUP BY Event.idEvent;");
   
    $stmt->bindParam(':search',$string, PDO::PARAM_STR);
    $stmt->bindParam(':userId',$_SESSION['userId'], PDO::PARAM_INT);
    
    $stmt->execute(); 
    $result = $stmt->fetchAll(); 
    
    if($result>0){
        return $result;
    }else{
         return false;
    }    
}


function createEvent($description,$nameEvent,$creationDate,$hour,$endDate,$local,$type,$public,$photoId,$ownerId){
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("INSERT INTO 
    Event(nameEvent,creationDate,endDate,local,public,type,description,hour,idPhoto,idOwner)
    VALUES(:nameEvent,:creationDate,:endDate,:local,:public,:type,:description,:hour,:photoId,:ownerId)");
    $stmt->bindParam(':nameEvent',$nameEvent,PDO::PARAM_STR);
    $stmt->bindParam(':description',$description,PDO::PARAM_STR);
    $stmt->bindParam(':creationDate',$creationDate,PDO::PARAM_STR);
    $stmt->bindParam(':hour',$hour,PDO::PARAM_STR);
    $stmt->bindParam(':public',$public,PDO::PARAM_BOOL);
    $stmt->bindParam(':endDate',$endDate,PDO::PARAM_STR);
    $stmt->bindParam(':local',$local,PDO::PARAM_STR);
    $stmt->bindParam(':type',$type,PDO::PARAM_STR);
    $stmt->bindParam(':ownerId',$ownerId,PDO::PARAM_STR);
    $stmt->bindParam(':photoId',$photoId,PDO::PARAM_STR);
    
    $result=$stmt->execute();  
    $lastId=$db->lastInsertId("idEvent");
    
    return $lastId;
}

function addPhoto($path){
     $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("INSERT INTO Photo(path,uploadDate)
    VALUES(:path,date('now'))");
    $stmt->bindParam(':path',$path,PDO::PARAM_STR);
        
    $result=$stmt->execute();  
    $lastId=$db->lastInsertId("idPhoto");
    
    return $lastId;
}

function getAllPosts($id){
     $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("SELECT * FROM Post WHERE idEvent=:id");
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}

function getAllComments($id){
    $db = new PDO('sqlite:event.db');

    $stmt=$db->prepare("SELECT * FROM Comment WHERE idPost=:id");
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}

function addComment($idPost,$idUser,$comment){
    $db = new PDO('sqlite:event.db');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->prepare("INSERT INTO Comment(idPost,idUser,commentText) VALUES(:idPost,:idUser,:comment)");
    $stmt->bindParam(':idPost',$idPost,PDO::PARAM_STR);
    $stmt->bindParam(':idUser',$_SESSION['userId'],PDO::PARAM_STR);
    $stmt->bindParam(':comment',$comment,PDO::PARAM_STR);

    $result=$stmt->execute();  

    return "success";
}
?>