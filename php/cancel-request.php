<?php
    require_once '../functions.php';
    db_connect();

    $sql = "DELETE FROM friend_requests WHERE user_id = ? AND friend_id = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param('ii', $_SESSION['user_id'], $_GET['uid']);

    if($statement->execute()){
        redirect_to("/home.php?request_canceled=true");
    } else{
        echo "Error: " .  $conn->error;
    }

    $conn->close();
?>