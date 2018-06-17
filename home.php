<?php require_once "functions.php"; ?>
<?php include "header.php" ?>
  
  <?php 
    db_connect();
  ?>
  <!-- main -->
  <main class="container">
    <?php if(isset($_GET["request_sent"])): ?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Hurray!</strong> Your friend request has been sent!
      </div>
    <?php endif; ?>

    <?php if(isset($_GET["request_canceled"])): ?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Hurray!</strong> Your friend request has been canceled!
      </div>
    <?php endif; ?>

    <?php if(isset($_GET["is_message"])): ?>
      <div class="alert alert-<?php echo $_GET['level']?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Hurray!</strong> <?php echo $_GET['message']?>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-md-3">
        <!-- profile brief -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4><?php echo $_SESSION['user_username']?></h4>
            <p>
              <?php 
                $sql_current_user = "SELECT status FROM users WHERE id = {$_SESSION['user_id']}";
                $current_user = $conn->query($sql_current_user);
                
                if($current_user->num_rows > 0){
                      while($final_user = $current_user->fetch_assoc()){
                        echo $final_user['status'];
                  }
                }
              ?>
            </p>
          </div>
        </div>
        <!-- ./profile brief -->

        <!-- friend requests -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>Friend Requests</h4>
            <ul>
              <?php 
                $sql_friend_requests = "SELECT id, username, (SELECT COUNT(*) FROM friend_requests WHERE friend_requests.user_id = users.id AND friend_requests.friend_id = {$_SESSION['user_id']}) as is_request FROM users HAVING is_request = 1";
                $result_friend_requests = $conn->query($sql_friend_requests);

                if($result_friend_requests->num_rows > 0){
                  while($curr_friend_request = $result_friend_requests->fetch_assoc()){
                    ?>
                    <li>
                      <a href="profile.php?username=<?php echo $curr_friend_request['username'];?>"><?php echo $curr_friend_request['username'];?></a> 
                      <a class="text-success" href="php/accept-request.php?friend_id=<?php echo $curr_friend_request['id'];?>&friend_username=<?php echo $curr_friend_request['username'];?>">[accept]</a> 
                      <a class="text-danger" href="php/decline-request.php?friend_id=<?php echo $curr_friend_request['id'];?>">[decline]</a>
                    </li>
                  <?php 
                  }
                } else{
                  ?>
                  <p>No friend request!</p>  
                <?php
                }
                ?>
            </ul>
          </div>
        </div>
        <!-- ./friend requests -->
      </div>
      <div class="col-md-6">
        <!-- post form -->
        <form method="post" action="php/create-post.php">
          <div class="input-group">
            <input class="form-control" type="text" name="content" placeholder="Make a post...">
            <span class="input-group-btn">
              <button class="btn btn-success" type="submit" name="post">Post</button>
            </span>
          </div>
        </form><hr>
        <!-- ./post form -->

        <!-- feed -->
        <div>
          <!-- post -->
          <?php 
              $sql = "SELECT * FROM posts ORDER BY created_at DESC";
              $result = $conn->query($sql);

              if($result->num_rows >0){
                  while($post = $result->fetch_assoc()){
          ?>
          <div class="panel panel-default">
            <div class="panel-body">
              <p><?php echo $post['content'];?></p>
            </div>
            <div class="panel-footer">
              <span>posted <?php echo $post['created_at'];?> by 
                <?php 
                    // printing the user that made this post!
                    $sql_user = "SELECT username FROM users WHERE id = {$post['user_id']}";
                    $result_user = $conn->query($sql_user);

                    if($result_user->num_rows > 0){
                      while($user = $result_user->fetch_assoc()){
                        echo $user['username'];
                      }
                    }
                ?></span>
              <?php 
                if($post['user_id'] == $_SESSION['user_id']){
                ?>
                  <span class="pull-right"><a class="text-danger" href="php/delete-post.php?id=<?php echo $post['id'] ?>">[delete]</a></span> 
              <?php
                }
              ?> 
            </div>
          </div>
          <?php 
              }
            } else {
          ?>
          <p class="text-danger">No posts! yet! </p>
          <?php 
            }
          ?>
          <!-- ./post -->
        </div>
        <!-- ./feed -->
      </div>
      <div class="col-md-3">
      <!-- add friend -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>Add friend</h4>
            <?php 
                $sql = "SELECT id, username, (SELECT COUNT(*) FROM friends WHERE friends.user_id = users.id AND friends.friend_id = {$_SESSION['user_id']}) AS is_friend, (SELECT COUNT(*) FROM friend_requests WHERE friend_requests.user_id = {$_SESSION['user_id']} AND friend_requests.friend_id = users.id) AS request_sent, (SELECT COUNT(*) FROM friend_requests WHERE friend_requests.user_id = users.id AND friend_requests.friend_id = {$_SESSION['user_id']}) AS has_request FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend = 0 AND has_request=0";
                $result = $conn->query($sql);

                if($result->num_rows > 0){
                  ?><ul><?php 
                      while($fc_user = $result->fetch_assoc()){
                          ?>
                          <li>
                              <a href="profile.php?username=<?php echo $fc_user['username']; ?>"><?php echo $fc_user['username']; ?></a>
                          <?php
                          if($fc_user['request_sent'] != 1){
                            ?>
                              <a href="php/add-friend.php?uid=<?php echo $fc_user['id']?>">[add]</a>
                          <?php
                          } else{
                            ?>
                              <a class="text-danger" href="php/cancel-request.php?uid=<?php echo $fc_user['id']?>">[cancel request]</a>
                          <?php
                          }
                          ?>
                        </li>
                      <?php 
                      }
                      ?>
                    </ul>
                <?php
                } else {
                ?>
                  <p class="text-center">No users to add!</p>
                <?php
                }
                ?>        
          </div>
        </div>
        <!-- ./add friend -->

        <!-- friends -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>Friends</h4>
            <?php 
              $friends_sql = "SELECT * FROM friends WHERE user_id = {$_SESSION['user_id']}";
              $friends_result = $conn->query($friends_sql);

              if($friends_result->num_rows > 0 ){
            ?>  <ul>
            <?php
                while($current_friend = $friends_result->fetch_assoc()){
            ?>    
                  <li>
                    <?php 
                      $friend_sql = "SELECT * FROM users WHERE id = {$current_friend['friend_id']}";
                      $friend_result = $conn->query($friend_sql);
                      $friend_info = $friend_result->fetch_assoc();
                    ?>
                    <a href="profile.php?username=<?php echo $friend_info['username']; ?>">
                      <?php echo $friend_info['username']; ?>
                    </a>
                    <a class="text-danger" href="php/remove-friend.php?friend_id=<?php echo $current_friend['friend_id']?>">[unfriend]</a>
                  </li>
                <?php
                }
                ?>
                </ul>
            <?php
            }
            ?>
          </div>
        </div>
        <!-- ./friends -->
      </div>
    </div>
  </main>
  <!-- ./main -->
<?php include "footer.php" ?>
