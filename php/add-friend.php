<?php 
    require_once "../functions.php";
    db_connect();

    $sql = "INSERT INTO friend_requests (user_id, friend_id) VALUES (?, ?)";
    // sending a new friend request
    $friend_request = $conn->prepare($sql);
    $friend_request->bind_param('ii', $_SESSION['user_id'], $_GET['uid']);
   
    if($friend_request->execute()){
        redirect_to("/home.php?request_sent=true");
    } else{
        echo "Error: " . $conn.error;
    }
    $conn->close()
?>