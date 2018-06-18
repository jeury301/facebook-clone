<?php 
    require_once "../functions.php";
    db_connect();

    $sql = "INSERT INTO users (username, password, location) VALUES (?, ?, ?)";
    $statement = $conn->prepare($sql);
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $statement->bind_param('sss', $_POST['username'],$hashed_password, $_POST['location']);

    if($statement->execute()){
        redirect_to("/index.php?registered=true");
    } else{
        echo "Error: " . $conn->error;
    }
?>