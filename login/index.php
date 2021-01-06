<?php
    require_once("core/init.php");
      if (Session::exists('success')) {
        echo Session::flash('success');
      }

      $user = new User(); 
      if ($user->isLoggedIn()) { ?>
        <p>cześć <a href=""><?php echo $user->data()->user_name; ?></a> </p>

        <ul>

          <li><a href="logout.php">logout</a></li>
          <li><a href="update.php">update details</a></li>
          <li><a href="changepass.php">changepass</a></li>
          

        </ul>
      <?php 

  if($user->hasPermission('admin')) {
    echo '<p>You are a Moderator!</p>';
  } else {
    echo '<p>You are a standard user.</p>';
  }
} else{
        echo 'musisz sie zalogowac do serwisu <a href="login.php">login</a>';
      }
?>