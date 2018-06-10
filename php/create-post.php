<?php 
    require_once "../functions.php";
    // connection to db
    db_connect();

    // sql statement to insert a new POSTS record
    // the ? indicates that the statement is expecting a parameter
    $sql = "INSERT INTO posts (content, user_id) VALUES (?, 0)";

    // preparing the connection?
    $statement = $conn->prepare($sql);

    // binding parameters to query statement
    $statement->bind_param('s', $_POST['content']);

    // executiing statement
    if($statement->execute()){
        // redirecting to home
        redirect_to("/home.php");
    } else{
        echo "Error: " . $conn.error;
    }

    // closing connection
    $conn->close()
?>