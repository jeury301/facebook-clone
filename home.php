<?php require_once "functions.php"; ?>
<?php include "header.php" ?>
  
  <?php 
    db_connect();
  ?>
  <!-- main -->
  <main class="container">
    <div class="row">
      <div class="col-md-3">
        <!-- profile brief -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>nicholaskajoh</h4>
            <p>I love to code!</p>
          </div>
        </div>
        <!-- ./profile brief -->

        <!-- friend requests -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>friend requests</h4>
            <ul>
              <li>
                <a href="#">johndoe</a> 
                <a class="text-success" href="#">[accept]</a> 
                <a class="text-danger" href="#">[decline]</a>
              </li>
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
            <h4>add friend</h4>
            <?php 
                $sql = "SELECT id, username, (SELECT COUNT(*) FROM friends WHERE friends.user_id = users.id AND friends.friend_id = {$_SESSION['user_id']}) AS is_friend FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend = 0";
                $result = $conn->query($sql);

                if($result->num_rows > 0){
                  ?><ul><?php 
                      while($fc_user = $result->fetch_assoc()){
                        ?> 
                        <li>
                          <a href="profile.php?username=<?php echo $fc_user['username']; ?>"><?php echo $fc_user['username']; ?></a>
                          <a href="php/add-friend.php?uid=<?php echo $fc_user['id']?>">[add]</a>
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
                $conn->close();
                ?>        
          </div>
        </div>
        <!-- ./add friend -->

        <!-- friends -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>friends</h4>
            <ul>
              <li>
                <a href="#">peterpan</a> 
                <a class="text-danger" href="#">[unfriend]</a>
              </li>
            </ul>
          </div>
        </div>
        <!-- ./friends -->
      </div>
    </div>
  </main>
  <!-- ./main -->
<?php include "footer.php" ?>
