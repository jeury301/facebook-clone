<?php 
    require_once "../functions.php";
    db_connect();

    $sql = "INSERT INTO friends (user_id, friend_id) VALUES (?, ?)";
    // adding new friend to current user
    $add_friend = $conn->prepare($sql);
    $add_friend->bind_param('ss', $_SESSION['user_id'], $_GET['uid']);
    // adding current user as a friend
    $make_me_friend = $conn->prepare($sql);
    $make_me_friend->bind_param('ss', $_GET['uid'], $_SESSION['user_id']);

    if($add_friend->execute() and $make_me_friend->execute()){
        redirect_to("/home.php");
    } else{
        echo "Error: " . $conn.error;
    }
    $conn->close()
?>