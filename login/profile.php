<?php
    require_once("core/init.php");
      if (!$username = Input::get('user_name')) {
        Redirect::to('index.php');
      } else {
          $user = new User($username);
          if (!$user->exists()) {
            Redirect::to(404);
          } else {
            $data = $user->_data;
          }
      }

      ?>

        <ul>

          <li><a href="logout.php">logout</a></li>
          <li><a href="update.php">update details</a></li>
          <li><a href="changepass.php">changepass</a></li>
          

        </ul>
      