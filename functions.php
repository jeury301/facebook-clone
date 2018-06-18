<?php 
    session_start();

    function db_connect(){
        global $conn; // db connection variable
        $db_server = "127.0.0.1"; // use 127.0.0.1 instead of localhost
        $username = "root";
        $password = "";
        $db_name = "faceclone";

        // create connection
        $conn = new mysqli($db_server, $username, $password, $db_name);
        // check connection for errors
        if ($conn->connect_error){
            die("Error: " . $conn->connect_error);
        }
        //echo '<h1 style="color: green;">Connected to db</h1>';
    }

    function redirect_to($url){
        header("Location: " . $url);
        exit();
    }

    function is_auth(){
        return isset($_SESSION['user_id']);
    }

    function check_auth(){
        if(!is_auth()){
            redirect_to("/index.php?logged_in=false");
        }
    }

?>