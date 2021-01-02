<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, viewport-fit=cover">
  <title>Sign up – MyBlog Dashboard</title>
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
  <link rel="stylesheet" href="./dash/assets/css/register.css">
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body id="myb_register">
  <main class="non-centered">
    <section class="box">
      <div class="box-header">
        <a class="logo" href="https://tryups.github.io/myblog/" title="MyBlog Official Website">
          <img src="./dash/assets/images/Logo@2x.png" alt="MyBlog Logo" id="MyBlog">
        </a>
        <div class="divider"></div>
        <h1 class="title">Sign Up</h1>
      </div>
      <div class="box-content">
        <form action="<?=\MyB\Permalink::base('signup');?>" id="myb__register_form" method="POST">
          <div class="area area-2">
            <div class="sub-area">
              <input type="text" name="" id="" placeholder="firstname" required>
              <label for="">Firstname</label>
            </div>
            <div class="sub-area">
              <input type="text" name="" id="" placeholder="lastname" required>
              <label for="">Lastname</label>
            </div>
          </div>
          <div class="area">
            <input type="text" name="" id="" placeholder="lastname" required>
            <label for="">Username</label>
          </div>
          <div class="area">
            <input type="email" name="" id="" placeholder="lastname" required>
            <label for="">Email</label>
          </div>
          <div class="area">
            <label for="">Birthdate</label>
            <custom-selector>
              
            </custom-selector>
          </div>
          <div class="area">
            <input type="password" name="" id="" placeholder="lastname" required>
            <label for="">Password</label>
          </div>
        </form>
      </div>
    </section>
  </main>
</body>
</html>