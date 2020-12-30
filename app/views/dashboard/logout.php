<?php
  use MyB\User as User;
  use MyB\Permalink as Link;

  if(User::logout()){
    Link::go('/signin?go=/dash/');
  }else{
    Link::go('/dash/');
  }
?>