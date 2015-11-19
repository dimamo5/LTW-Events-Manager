<?php
function login($username, $password)
{
    $db = $db = new PDO('sqlite:news.db');
    $query = "SELECT * FROM users WHERE loginId='";
    $query .= $username . "';";
    
    $stmt = $db->prepare($query);
	$stmt->execute();  
	$result = $stmt->fetchAll();
    
    $password_db = $result['password'];
    $user_id = $result['idUser'];
    
    $password = hash('sha512', $password);
    
    $db=NULL;
    echo("nice manda");
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
    
    $db = $db = new PDO('sqlite:eventDatabase.db');
    $query = "SELECT * FROM users WHERE idUser='";
    $query .= $userID . "';";
    
    $stmt = $db->prepare($query);
	$stmt->execute();  
	$result = $stmt->fetchAll();
    
    $password_db = $result['password'];
    $user_id = $result['idUser'];
    
    $db=NULL;
    
    if ($password === $password_db) {
        echo("checaBem");
        return true;
    } else {
        return false;
    }
    
}
?>