<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Form</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="<?=URLROOT?>/css/home/forms.css">

  </head>
  <body>
    <section class="container">
      <header>Log in</header>

      <form method="post" class="form">
    
        <div class="input-box">
          <label>Email Address</label>
          <input name="email" type="text" placeholder="Enter email address" required />
        </div>

        <div class="input-box">
            <label>Password</label>
            <input name="password" type="password" placeholder="Enter password" required />
        </div>

        <button>Submit</button>
      </form>
    </section>
    <style>
      body {
        background-image: url('<?=URLROOT?>/images/img1.jpg');
      }
    </style>
  </body>
</html>