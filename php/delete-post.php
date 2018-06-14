<?php 
    require_once "../functions.php";
    db_connect(); // connecting to db

    $sql = "DELETE FROM posts WHERE id = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("i", $_GET['id']);

    if($statement->execute()){
        if(isset($_GET['is_profile'])){

            redirect_to("/profile.php?username=" . $_GET['username']);
        } else{
            redirect_to("/home.php");
        }
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
?>