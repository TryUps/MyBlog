<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, viewport-fit=cover">
  <title>Login – MyBlog</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="nofollow, noindex">
  <meta http-equiv="x-dns-prefetch-control" content="on">
  <link rel="dns-prefetch" href="//ajax.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com"> 
  <link rel="preconnect" href="https://cdnjs.cloudflare.com">
  <link rel="preconnect" href="https://www.googletagmanager.com">
  <link rel="preconnect" href="https://www.google-analytics.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;700;900&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <link rel="stylesheet" href="./dash/assets/css/reset.css">
  <link rel="stylesheet" href="./dash/assets/css/login.css">
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <main class="loginpage">
    <section class="loginbox">
      <div class="box-header">
        <h1>MyBlog</h1>
        <h3>Signin</h3>
      </div>
      <form method="POST" class="myb__loginform">
        <div class="user_email">
          <input type="text" name="user" id="user" required>
          <label for="user" class="for-small">
            Email address
            <small>Or your username</small>
          </label>
        </div>
        <div class="user_pass">
          <input type="password" name="pass" id="pass" required>
          <label for="pass">
            Password
          </label>
        </div>
        <div>
          <input type="hidden" name="go" value="<?=(isset($_GET['go']) ? $_GET['go'] : null)?>">
        </div>
        <button type="submit" class="ico-btn" id="signin">
          <i class="fas fa-sign-in-alt"></i>
          <span>Sign In</span>
        </button>
      </form>
    </section>
    <section class="register">
      <div class="box-header">
        <h1>Or continue with...</h1>
      </div>
    </section>
  </main>
  <script src="./dash/assets/js/dash_login.js"></script>
</body>
</html>