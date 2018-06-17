<? 
    require_once '../functions.php';
    db_connect();

    // removing friend-request
    $sql_remove_request = "DELETE FROM friend_requests WHERE user_id = ? AND friend_id = ?";
    $remove_request = $conn->prepare($sql_remove_request);
    $remove_request->bind_param('ii', $_GET['friend_id'], $_SESSION['user_id']);

    if($remove_request->execute()){
        redirect_to('/home.php?is_message=true&level=success&message=Friend request from ' . $_GET['friend_username'] . ' has been declined!');
    } else{
        echo "Error: " . $conn->error;
    }

    $conn->close();
?>