<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Expiration Reminder</title>
     <link rel="icon" href="favicon.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="css/master.css">
    <script src="https://kit.fontawesome.com/7163735c82.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <nav class="nav bg-light mb-4 justify-content-between">
        <div class="navbar-brand text-danger ml-4"><h4><i class="fas fa-asterisk"></i>  Expiration Reminder</h4></div>
          <div><p><?php echo $message;?></p></div>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" name="logoutform">
            <button class="btn btn-danger btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</button>
          </form>

          <div class="nav mr-4">
            <div><p><?php if(isset($errMessage)){ echo '<p class="text-danger">'. $errMessage .'</p>';}; ?></p></div>
            <div><p><?php if(isset($fillOutAllFields)){ echo '<p class="text-danger">'. $fillOutAllFields .'</p>';}; ?></p></div>
            <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user text-danger"></i></span>
                </div>
                <input type="text" name="username" class="form-control" placeholder="Username">
              </div>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-lock text-danger"></i></span>
                </div>
                <input type="password" name="password" class="form-control" placeholder="Password">
              </div>
              <input type="hidden" name="loginform">
              <button class="btn btn-danger ml-2" type="submit" name="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
            </form>
        </div>
    </nav>
    </body>
    </html>
