<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title> 
    <link rel="stylesheet" href="<?=URLROOT?>/css/home/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>

  <body>
    <div class="container">
      <div class="wrapper">
        <div class="title"><span>Register Now</span></div>
        
        <form method="post">

        <?php if(!empty($errors)):?>
            <div class="alert alert-danger">
                <?= implode("<br>", $errors)?>
            </div>
        <?php endif ;?>
            
            <div class="row">
                <i class="fas fa-user"></i>
                <input name="name" type="text" placeholder="Name" required>
            </div>

          <div class="row">
            <i class="fas fa-user"></i>
            <input name="email" type="text" placeholder="Email" required>
          </div>

          <div class="row">
            <i class="fas fa-lock"></i>
            <input name="password" type="password" placeholder="Password" required>
          </div>

          <div class="row">
                <i class="fas fa-user"></i>
                <input name="school" type="text" placeholder="school" required>
            </div>

            <div class="row">
                <i class="fas fa-user"></i>
                <input name="grade" type="text" placeholder="grade" required>
            </div>
          
          <div class="pass"><a href="#">Forgot password?</a></div>
          <div class="row button">
            <input type="submit" value="Register">
          </div>
          <div class="signup-link">Member? <a href="<?=URLROOT?>/login">Login now</a></div>
        
          <a href="<?=URLROOT?>/home">Home</a></li>
        
        </form>
      </div>
    </div>

    

  

  </body>
</html>