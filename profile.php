<?php require_once "functions.php"; ?>
<?php 
  db_connect();

  $sql = "SELECT id, username, status, profile_image_url, location FROM users WHERE username = ?";
  $statement = $conn->prepare($sql);
  $statement->bind_param('s', $_GET['username']);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($id, $username, $status, $profile_image_url, $location);
  $statement->fetch();

?>
<?php include "header.php" ?>
  <!-- main -->
  <main class="container">
    <div class="row">
      <div class="col-md-3">
        <!-- edit profile -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>Edit profile</h4>
            <form method="post" action="php/edit-profile.php">
              <div class="form-group">
                <input class="form-control" type="text" name="status" placeholder="Status" value="<?php echo $status?>">
              </div>
              <div class="form-group">
                <input class="form-control" type="text" name="location" placeholder="Location" value="<?php echo $location?>">
              </div>

              <div class="form-group">
                <input class="btn btn-primary" type="submit" name="update_profile" value="Save">
              </div>
            </form>
          </div>
        </div>
        <!-- ./edit profile -->
      </div>
      <div class="col-md-6">
        <!-- user profile -->
        <div class="media">
          <div class="media-left">
            <img src="img/my_avatar.png" class="media-object" style="width: 128px; height: 128px;">
          </div>
          <div class="media-body">
            <h2 class="media-heading"><?php echo $username?></h2>
            <p>Status: <?php if($status){echo $status;}else{echo "No status yet!";}?>, Location: <?php echo $location?></p>
          </div>
        </div>
        <!-- user profile -->

        <hr>

        <!-- timeline -->
        <div>
           <!-- post -->
          <?php 
              $sql = "SELECT * FROM posts WHERE user_id = {$id} ORDER BY created_at DESC";
              $result = $conn->query($sql);

              if($result->num_rows >0){
                  while($post = $result->fetch_assoc()){
          ?>
          <div class="panel panel-default">
            <div class="panel-body">
              <p><?php echo $post['content'];?></p>
            </div>
            <div class="panel-footer">
              <span>posted <?php echo $post['created_at'];?> by <?php echo $username;?></span> 
              <span class="pull-right"><a class="text-danger" href="php/delete-post.php?id=<?php echo $post['id'] ?>">[delete]</a></span>
            </div>
          </div>
          <?php 
              }
            } else {
          ?>
          <p class="text-danger">No posts! yet! </p>
          <?php 
            }
            $conn->close();
          ?>
          <!-- ./post -->
        </div>
        <!-- ./timeline -->
      </div>
      <div class="col-md-3">
        <!-- friends -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>Friends</h4>
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
