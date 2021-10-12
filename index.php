<?php
include("actions/auth/config.php");
include('actions/auth/userClass.php');
$userClass = new userClass();

$errorMsgLogin='';
if(empty($_POST['usernameEmail']) || empty($_POST['password'])){
  $errorMsgLogin="Please enter a username and password.";
}
/* Login Form */
if (!empty($_POST['loginSubmit']))
{
$usernameEmail=$_POST['usernameEmail'];
$password=$_POST['password'];
if(strlen(trim($usernameEmail))>1 && strlen(trim($password))>1 )
{
$uid=$userClass->userLogin($usernameEmail,$password);
if($uid)
{
$url=BASE_URL.'home.php';
header("Location: $url"); // Page redirecting to home.php
}
else
{
$errorMsgLogin="Please enter a valid username and password.";
}
}
}
?>

  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

      <title>Expiration Reminder</title>
       <link rel="icon" href="favicon.png" type="image/png" sizes="16x16">
      <link rel="stylesheet" href="css/master.css">
      <script src="https://kit.fontawesome.com/7163735c82.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
      <nav class="nav bg-light mb-4">
        <div class="navbar-brand text-danger ml-4"><h4><i class="fas fa-asterisk"></i>  Expiration Reminder</h4></div>
    </nav>
    <div class="container login">
      <h3 class="text-danger"><i class="fas fa-sign-in-alt"></i> Login</h3>
      <form method="post" action="" name="login">
        <div class="row">
          <div class="col">
            <label><i class="fas fa-user"></i> Username</label>
            <input type="text" class="form-control" name="usernameEmail" autocomplete="off" />
          </div>
          <div class="col">
            <label><i class="fas fa-lock"></i> Password</label>
            <input type="password" class="form-control" name="password" autocomplete="off"/>
          </div>
        </div>
        <div class="text-danger"><?php echo $errorMsgLogin; ?></div>
        <input type="submit" class="btn btn-danger btn-sm" name="loginSubmit" value="Login">
      </form>
      </div>
    </div>

      <?php require 'footer.php'; ?>

      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
  </html>
