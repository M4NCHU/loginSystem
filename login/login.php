<?php
    require_once("core/init.php");

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
        
       $validate = new Validate();
       $validation = $validate->check($_POST, array(
        'user_name' => array(
            'required' => true,
        ),
        'user_pass' => array(
            'required' => true
        )
       ));

       if ($validation->passed()) {
           $user = new User();

           $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('user_name'),Input::get('user_pass'), $remember);

           if ($login) {
            Redirect::to('index.php');
           } else{
               echo "fail";
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
        <input type="password" name="user_pass" >
    </div>

    <div class="field">
        <label for="user_pass">Remember me</label>
        <input type="checkbox" name="remember" >
    </div>


    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" name="submit">

</form>