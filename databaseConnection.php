<?php
function login($username, $password)
{
    $db = $db = new PDO('sqlite:event.db');
    $query = "SELECT * FROM User WHERE loginId='";
    $query .= $username . "';";
    
    echo $query;
    
    $stmt = $db->prepare($query);
	$stmt->execute();  
	$result = $stmt->fetchAll();
    var_dump($result);
    
    $password_db = $result[0]['password'];
    $user_id = $result[0]['idUser'];
    
    $password = hash('sha512', $password);
    
    $db=NULL;
   
    
    if ($password_db == $password) {
        $_SESSION['userId'] = $user_id;
        $_SESSION['password'] = $password;
        echo("funca");
        return true;
    } else return false;
}

function login_check()
{
    if (isset($_SESSION['userId'], $_SESSION['password'])) {
        $userId = $_SESSION['userId'];
        $password = $_SESSION['password'];
    } else return false;

}
?>