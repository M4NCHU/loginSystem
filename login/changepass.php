<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
  Redirect::to('index.php');
}

if(Input::exists()) {
  if(Token::check(Input::get('token'))) {

    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'password_current' => array(
          'required' => true,
          'min'      => 6,
          'max'      => 50
      ),
      'password_new' => array(
        'required' => true,
        'min'      => 6,
        'max'      => 50
    ),
    'password_new_again' => array(
        'required' => true,
        'min'      => 6,
        'matches'  => 'password_new'
    ),
    ));

    if($validation->passed()) {

        if (Hash::make(Input::get('password_current'),$user->data()->salt) !== $user->data()->user_pass) {
            echo "your current password is wrong";
        } else {
            $salt = Hash::salt(32);
            $user->update(array(
                'user_pass' => Hash::make(Input::get('password_new'), $salt),
                'salt' => $salt
              ));

              Session::flash('home', 'Your details have been updated');
                Redirect::to('index.php');
        }

    } else {
      foreach($validation->errors() as $error) {
        echo $error, '<br>';
      }
    }

  }
}

?>

<form action="" method="post">
  <div class="field">
    <label for="password_current">Current Password</label>
    <input type="password" name="password_current" id="password_current" />
  </div>
  <div class="field">
    <label for="password_new">New Password</label>
    <input type="password" name="password_new" id="password_new" />
  </div>
  <div class="field">
    <label for="password_new_again">New Password Again</label>
    <input type="password" name="password_new_again" id="password_new_again" />
  </div>
  <input type="submit" value="Change Password" />
  <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
</form>


