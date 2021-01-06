<?php
    require_once("core/init.php");

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
        
       $validate = new Validate();
       $validation = $validate->check($_POST, array(
        'user_name' => array(
            'required' => true,
            'min' => 2,
            'max' => 20,
            'unique' => 'users'
        ),
        'user_pass' => array(
            'required' => true,
            'min' => 6
        ),
        'password_again' => array(
            'required' => true,
            'matches' => 'user_pass'
        ),
        'user_first' => array(
            'required' => true,
            'min' => 2,
            'max' => 20
        )
       ));

       if ($validation->passed()) {
           $user = new User();

            $salt = Hash::salt(32);

           try {
            $user->create(array(
                'user_name' => Input::get('user_name'),
                'user_pass' => Hash::make(Input::get('user_pass'), $salt),
                'salt' => $salt,
                'user_first' => Input::get('user_first'),
                'date_joined' => date('Y-m-d H:i:s'),
                'user_group' => 1
              ));
            Session::flash('success', 'zostałeś zarejestrowany');
            Redirect::to('index.php');
           } catch (Exception $e) {
               die($e->getMessage());
           }
           
       }else{
            foreach ($validation->errors() as $error) {
                echo $error, '<br>'; 
            }
       }
    }
    }
?>

<form action="" method="post">

    <div class="field">
        <label for="username">username</label>
        <input type="text" name="user_name" value="<?php echo Input::get('user_name'); ?>">
    </div>

    <div class="field">
        <label for="user_pass">password</label>
        <input type="text" name="user_pass" >
    </div>

    <div class="field">
        <label for="password_again">password repeat</label>
        <input type="text" name="password_again">
    </div>

    <div class="field">
        <label for="user_first">user_first</label>
        <input type="text" name="user_first" value="<?php echo Input::get('user_first'); ?>">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" name="submit">

</form>