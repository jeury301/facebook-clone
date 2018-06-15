<?php 
    require_once "../functions.php";
    db_connect();

    $sql = "DELETE FROM friends WHERE user_id = ? AND friend_id = ?";
    // removing friend from list of friends
    $remove_friend = $conn->prepare($sql);
    $remove_friend->bind_param('ss', $_SESSION['user_id'], $_GET['friend_id']);
    // removing myself as a friend
    $remove_me_as_friend = $conn->prepare($sql);
    $remove_me_as_friend->bind_param('ss', $_GET['friend_id'], $_SESSION['user_id']);

    if($remove_friend->execute() and $remove_me_as_friend->execute()){
        if(isset($_GET['is_profile'])){
            redirect_to("/profile.php?username=" . $_SESSION['user_username']);
        } else{
            redirect_to("/home.php");
        }
    } else{
        echo "Error: " . $conn->error;
    }

    $conn->close();
?>