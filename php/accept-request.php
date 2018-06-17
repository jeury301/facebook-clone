<?php 
    require_once '../functions.php';
    db_connect();

    // removing friend-request
    $sql_remove_request = "DELETE FROM friend_requests WHERE user_id = ? AND friend_id = ?";
    $remove_request = $conn->prepare($sql_remove_request);
    $remove_request->bind_param('ii', $_GET['friend_id'], $_SESSION['user_id']);

    // accepting friend request
    $sql_accept_request = "INSERT INTO friends (user_id, friend_id) VALUES (?, ?)";
    $accept_request = $conn->prepare($sql_accept_request);
    $accept_request->bind_param('ii', $_SESSION['user_id'], $_GET['friend_id']);

    // making me a new friend
    $sql_make_friend = "INSERT INTO friends (user_id, friend_id) VALUES (?, ?)";
    $make_friend = $conn->prepare($sql_make_friend);
    $make_friend->bind_param('ii', $_GET['friend_id'], $_SESSION['user_id']);

    if($accept_request->execute() and 
       $remove_request->execute() and
       $make_friend->execute()){
        redirect_to('/home.php?is_message=true&level=success&message=You and ' . $_GET['friend_username'] . ' are now friends!');
    } else{
        echo "Error: " . $conn->error;
    }

    $conn->close();
?>