<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, viewport-fit=cover">
  <title>Login – MyBlog</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="nofollow, noindex">
  <meta http-equiv="x-dns-prefetch-control" content="on">
  <base href="<?=\MyB\Permalink::base();?>">
  <link rel="dns-prefetch" href="//ajax.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com"> 
  <link rel="preconnect" href="https://cdnjs.cloudflare.com">
  <link rel="preconnect" href="https://www.googletagmanager.com">
  <link rel="preconnect" href="https://www.google-analytics.com">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <link rel="stylesheet" href="./dash/assets/css/reset.css">
  <link rel="stylesheet" href="./dash/assets/css/login.v2.css">
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body id="myb_signin">
  <main class="signin_page">
    <section class="box">
      <div class="box-header">
        <a class="logo" href="https://tryups.github.io/myblog/" title="MyBlog Official Website">
          <img src="./dash/assets/images/Logo@2x.png" alt="MyBlog Logo" id="MyBlog">
        </a>
        <div class="divider"></div>
        <h1 class="title">Sign In</h1>
      </div>
      <div class="box-content">
        <form action="<?=\MyB\Permalink::base('signin');?>" id="myb__login_form" method="POST">
          <div class="area">
            <i class="far fa-envelope"></i>
            <input type="text" name="user" id="myb_email" placeholder="email" required>
            <label for="myb_email">Email</label>
          </div>
          <div class="area last">
            <i class="fas fa-key"></i>
            <input type="password" name="pass" id="myb_password" placeholder="email" required>
            <label for="myb_password">Password</label>
          </div>
          <div class="checkbox">
            <input type="checkbox" name="" id="session_check">
            <label for="session_check">Manter sessão iniciada neste dispositivo.</label>
          </div>
          <button type="submit" class="submit">
            <span>Sign in...</span>
          </button>
        </form>
      </div>
    </section>
  </main>
  <script src="./dash/assets/js/dash_login.js"></script>
</body>
</html>