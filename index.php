<?php require_once "functions.php"; ?>
<?php include "header.php" ?>

  <!-- main -->
  <main class="container">
  <h1 class="text-center">Welcome to FaceClone! <br><small>A simple Facebook clone.</small></h1>

    <div class="row">
      <div class="col-md-6">
        <h4>Login to start enjoying unlimited fun!</h4>

        <?php if(isset($_GET["registered"])): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Hurray!</strong> You have registered. Please login. 
          </div>
        <?php endif; ?>

        <?php if(isset($_GET["login_error"])): ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Sorry!</strong> The information you entered does not match our records. 
          </div>
        <?php endif; ?>


        <!-- login form -->
        <form method="post" action="php/login.php">
          <div class="form-group">
            <input class="form-control" type="text" name="username" placeholder="Username">
          </div>

          <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Password">
          </div>

          <div class="form-group">
            <input class="btn btn-primary" type="submit" name="login" value="Login">
          </div>
        </form>
        <!-- ./login form -->
      </div>
      <div class="col-md-6">
        <h4>Don't have an account yet? Register!</h4>

        <!-- register form -->
        <form method="post" action="php/register.php">
          <div class="form-group">
            <input class="form-control" type="text" name="username" placeholder="Username">
          </div>

          <div class="form-group">
            <input class="form-control" type="text" name="location" placeholder="Location">
          </div>

          <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Password">
          </div>

          <div class="form-group">
            <input class="btn btn-success" type="submit" name="register" value="Register">
          </div>
        </form>
        <!-- ./register form -->
      </div>
    </div>
  </main>
  <!-- ./main -->
<?php include "footer.php" ?>
