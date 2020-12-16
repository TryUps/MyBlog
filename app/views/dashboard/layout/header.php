<?php

  $fullname = MyB\Text::surname(htmlspecialchars_decode($user->fullname));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, viewport-fit=cover">
  <title>My Dashboard</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="nofollow, noindex">
  <meta name="googlebot" content="index,follow">
  <meta http-equiv="x-dns-prefetch-control" content="on">
  <base href="<?= \MyB\Permalink::base(); ?>/dash/" />
  <link rel="dns-prefetch" href="//ajax.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com"> 
  <link rel="preconnect" href="https://cdnjs.cloudflare.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
