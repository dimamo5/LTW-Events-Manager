<?php


function login($username, $password)
{  
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
    $stmt=$db->prepare("SELECT * FROM User WHERE loginId=:username");
    $stmt->bindParam(':username',$username,PDO::PARAM_STR);
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
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);
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
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt=$db->prepare("SELECT Event.*,Photo.path,UserEvent.confirm FROM UserEvent,Event,Photo WHERE UserEvent.idUser=:userId AND Event.idEvent=UserEvent.idEvent AND Event.idPhoto=Photo.idPhoto
                        AND UserEvent.idEvent NOT IN(SELECT Event.idEvent FROM Event WHERE Event.idOwner=:userId);");
   
    $stmt->bindParam(':userId',$_SESSION["userId"],PDO::PARAM_INT);
    
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}

function getEvensAdmin(){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);

    $stmt=$db->prepare("SELECT Event.*,Photo.path FROM Event,Photo WHERE Event.idOwner=:userId AND Event.idPhoto=Photo.idPhoto");
    $stmt->bindParam(':userId',$_SESSION["userId"],PDO::PARAM_INT);
    
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;   
}

function getEvent($id){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);

    $stmt=$db->prepare("SELECT Event.*,Photo.path FROM Event,Photo WHERE Event.idEvent=:id AND Event.idPhoto=Photo.idPhoto");
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result[0];
}

function hasAccess($id){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);

    $stmt=$db->prepare("SELECT * FROM UserEvent WHERE idUser=:id AND idEvent=:idEvent");
    $stmt->bindParam(':id',$_SESSION["userId"],PDO::PARAM_INT);
    $stmt->bindParam(':idEvent',$id,PDO::PARAM_INT);
    
    $stmt->execute();  
    $result = $stmt->fetchAll();
    
    if(count($result)>0){
        return true;
    }else return false;  
}

function isPublic($id){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);

    $stmt=$db->prepare("SELECT * FROM Event WHERE idEvent=:idEvent AND public=1");
    $stmt->bindParam(':idEvent',$id,PDO::PARAM_INT);
    
    $stmt->execute();  
    $result = $stmt->fetchAll();
    
    if(count($result)>0){
        return true;
    }else return false;  
}

function goesEvent($idEvent,$idUser){
     $pathDatabase='sqlite:'.__DIR__.'/event.db';
     $db = new PDO($pathDatabase);

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
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);

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
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);
    
  
    //apaga evento
    $stmt=$db->prepare("DELETE FROM Event WHERE idEvent=:idEvent;");
    $stmt->bindParam(':idEvent',$id,PDO::PARAM_INT);
    
    $result=$stmt->execute();  
    if($result==0){
        return false;
    }
    
    //apaga userEvents
    $stmt=$db->prepare("DELETE FROM UserEvent WHERE UserEvent.idEvent=:idEvent;");
    $stmt->bindParam(':idEvent',$id,PDO::PARAM_INT);
    
    $result=$stmt->execute();  
    if($result==0){
        return false;
    }
        
    //delete photos
    $stmt=$db->prepare("DELETE FROM Photo WHERE Photo.idPhoto IN 
                       (SELECT EventPhoto.idPhoto FROM EventPhoto WHERE EventPhoto.idEvent=:idEvent);");
    $stmt->bindParam(':idEvent',$id,PDO::PARAM_INT);
  
    $result=$stmt->execute();
    if($result==0){
        return false;
    }
        
    //delete eventPhotos
    $stmt=$db->prepare("DELETE FROM EventPhoto WHERE EventPhoto.idEvent=:idEvent;");
    $stmt->bindParam(':idEvent',$id,PDO::PARAM_INT);
  
    $result=$stmt->execute();
    if($result==0){
        return false;
    }
    
    //apaga comments      
    $stmt=$db->prepare("DELETE FROM Comment WHERE Comment.idPost IN 
                       (SELECT Post.idPost FROM Post Where Post.idEvent=:idEvent);");
    $stmt->bindParam(':idEvent',$id,PDO::PARAM_INT);
    
    $result=$stmt->execute();   
    if($result==0){
        return false;
    }
    
    //apaga posts        
    $stmt=$db->prepare("DELETE FROM Post WHERE Post.idEvent=:idEvent;");
    $stmt->bindParam(':idEvent',$id,PDO::PARAM_INT);
    
    $result=$stmt->execute();
    if($result==0){
        return false;
    }
    
    return true;      
}

function editEvent($id,$description,$nameEvent,$creationDate,$endDate,$local,$type){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);

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
     $pathDatabase='sqlite:'.__DIR__.'/event.db';
     $db = new PDO($pathDatabase);
     $stmt=$db->prepare("SELECT User.idUser,User.name FROM User;");
     $stmt->execute();  
     $result = $stmt->fetchAll();
     if($result>0){
        return $result;
    }else return false;
}

function getUser($userId){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);
    $stmt=$db->prepare("SELECT * FROM User WHERE User.idUser=:userid");
    $stmt->bindParam(':userid',$userId,PDO::PARAM_INT);
    
    $stmt->execute(); 
    $result = $stmt->fetchAll();
    
     if($result>0){
        return $result[0];
    }else return false;    
}
function getUserEventName($name,$eventId){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);

    $name="%".$name."%";

    $stmt=$db->prepare("SELECT User.idUser,User.name FROM User WHERE name LIKE :name AND idUser NOT IN(SELECT idUser FROM UserEvent WHERE idEvent=:eventId)");
    $stmt->bindParam(':eventId',$eventId,PDO::PARAM_INT);
    $stmt->bindParam(':name',$name,PDO::PARAM_STR);
    
    $stmt->execute(); 
    $result = $stmt->fetchAll();   
        return $result;
}

function addUser($eventId,$idUser){
     $pathDatabase='sqlite:'.__DIR__.'/event.db';
     $db = new PDO($pathDatabase);

    $stmt=$db->prepare("INSERT INTO UserEvent(idUser,idEvent,confirm) VALUES(:idUser,:idEvent,0)");
    $stmt->bindParam(':idUser',$idUser,PDO::PARAM_STR);
    $stmt->bindParam(':idEvent',$eventId,PDO::PARAM_STR);
    	
	$result=$stmt->execute();  
    
    if($result>0){
        return $result;
    }else return false;    
}

function removeUser($eventId,$idUser){
     $pathDatabase='sqlite:'.__DIR__.'/event.db';
     $db = new PDO($pathDatabase);

    $stmt=$db->prepare("DELETE FROM UserEvent WHERE idUser=:idUser,idEvent=:idEvent)");
    $stmt->bindParam(':idUser',$idUser,PDO::PARAM_STR);
    $stmt->bindParam(':idEvent',$eventId,PDO::PARAM_STR);
    	
	$result=$stmt->execute();  
    
    if($result>0){
        return $result;
    }else return false;    
}

function getUserImagePath($userId){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);
    $stmt=$db->prepare("SELECT Photo.path FROM Photo,User WHERE Photo.idPhoto=User.idPhoto AND User.idUser=:userid");
    $stmt->bindParam(':userid',$userId,PDO::PARAM_INT);
    
    $stmt->execute(); 
    $result = $stmt->fetchAll();
    
     if($result>0){
        return $result[0][0];
    }else return false;   
}
 
function getUser2($userId){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);
    $stmt=$db->prepare("SELECT * FROM User WHERE idUser=:userid;");
    $stmt->bindParam(':userid',$userId,PDO::PARAM_INT);
    
    $stmt->execute(); 
    $result = $stmt->fetch();
    return $result;
}


function getUsersEvent($eventId){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);

    $stmt=$db->prepare("SELECT User.idUser,User.name,UserEvent.confirm FROM User,UserEvent WHERE idEvent=:eventId AND User.idUser=UserEvent.idUser;");
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
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);

    $string = "%".$string."%"; 

    $stmt=$db->prepare("SELECT Event.*,Photo.path AS path FROM Event,User,UserEvent,Photo WHERE User.idUser=:userId AND UserEvent.idUser=:userId AND Event.idPhoto=Photo.idPhoto AND Event.idEvent=UserEvent.idEvent AND Event.nameEvent LIKE :search
                        UNION SELECT Event.*,Photo.path AS path FROM Event,Photo WHERE Event.public=1 AND Event.idPhoto=Photo.idPhoto AND Event.nameEvent LIKE :search GROUP BY Event.idEvent;");
   
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


function createEvent($nameEvent,$description,$creationDate,$hour,$endDate,$local,$type,$public,$photoId,$ownerId){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);

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
     $pathDatabase='sqlite:'.__DIR__.'/event.db';
     $db = new PDO($pathDatabase);

    $stmt=$db->prepare("INSERT INTO Photo(path,uploadDate)
    VALUES(:path,date('now'))");
    $stmt->bindParam(':path',$path,PDO::PARAM_STR);
        
    $result=$stmt->execute();  
    $lastId=$db->lastInsertId("idPhoto");
    
    return $lastId;
}

function addPhotoEvent($eventId,$photoId){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
     $db = new PDO($pathDatabase);

    $stmt=$db->prepare("INSERT INTO EventPhoto VALUES(:eventId,:photoId)");
    $stmt->bindParam(':eventId',$eventId,PDO::PARAM_INT);
    $stmt->bindParam(':photoId',$photoId,PDO::PARAM_INT);
        
    $result=$stmt->execute();  
    
     if($result>0){
        return $result;
    }else{
         return false;
    } 
}

function getAllPosts($id){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);

    $stmt=$db->prepare("SELECT * FROM Post WHERE idEvent=:id");
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}

function getAllComments($id){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);

    $stmt=$db->prepare("SELECT * FROM Comment WHERE idPost=:id");
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}

function addComment($idPost,$idUser,$comment){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->prepare("INSERT INTO Comment(idPost,idUser,commentText) VALUES(:idPost,:idUser,:comment)");
    $stmt->bindParam(':idPost',$idPost,PDO::PARAM_STR);
    $stmt->bindParam(':idUser',$_SESSION['userId'],PDO::PARAM_STR);
    $stmt->bindParam(':comment',$comment,PDO::PARAM_STR);

    $result=$stmt->execute();  

    return "success";
}

function acceptInvite($eventId,$idUser){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $db->prepare("UPDATE UserEvent SET confirm=1 WHERE idEvent=:idEvent AND idUser=:idUser");
    $stmt->bindParam(':idEvent',$eventId,PDO::PARAM_INT);
    $stmt->bindParam(':idUser',$idUser,PDO::PARAM_INT);
    
     $result=$stmt->execute();
    
     if($result>0){
        return $result;
    }else{
         return false;
    } 
}

function declineInvite($eventId,$idUser){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $db->prepare("UPDATE UserEvent SET confirm=-1 WHERE idEvent=:idEvent AND idUser=:idUser");
    $stmt->bindParam(':idEvent',$eventId,PDO::PARAM_INT);
    $stmt->bindParam(':idUser',$idUser,PDO::PARAM_INT);
    
     $result=$stmt->execute();
    
     if($result>0){
        return $result;
    }else{
         return false;
    } 
}

function autoInvite($eventId,$idUser){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $db->prepare("INSERT INTO UserEvent(idEvent,idUser,confirm) VALUES(:idEvent,:idUser,1)");
    $stmt->bindParam(':idEvent',$eventId,PDO::PARAM_INT);
    $stmt->bindParam(':idUser',$idUser,PDO::PARAM_INT);
    
     $result=$stmt->execute();
    
     if($result>0){
        return $result;
    }else{
         return false;
    }  
}

function getPhotoPath($eventId){
    $pathDatabase='sqlite:'.__DIR__.'/event.db';
    $db = new PDO($pathDatabase);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $db->prepare("SELECT Photo.path FROM Photo,EventPhoto WHERE Photo.idPhoto=EventPhoto.idPhoto AND idEvent=:idEvent");
    $stmt->bindParam(':idEvent',$eventId,PDO::PARAM_INT);
    $stmt->execute();
    $result=$stmt->fetchAll();
    
    return $result;
}



?>