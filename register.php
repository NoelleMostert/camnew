<?php
require_once 'core/init.php';

if(Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'email' => array(
                'required' => true,
                //'email_format' => "/^[a-zA-Z]w+(.w+)*@w+(.[0-9a-zA-Z]+)*.[a-zA-Z]{2,4}$/"
                //come back for additional validation criteria
            ),
            'password' => array(
                'required' => true,
                'strength' => "/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/",
                //Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit
                'min' => 8
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            )
        ));

        if ($validation->passed()) {
            $user = new User();

            $salt = 1;

            try {
                $len = 10;
                $strength = true;
                $rand_bytes = openssl_random_pseudo_bytes($len, $strength);
                $key = base64_encode(Input::get('username')."delimitstring".$rand_bytes);
                $user->create(array(
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'email' => Input::get('email'),
                    'joined' => date('Y-m-d H:i:s'),
                    'group_type' => 1,
                    'verified' => 0,
                    'activation_key' => $rand_bytes
                ));
                $link = "localhost:8080/Camagru/verify.php?token=".$key;
                $to = Input::get('email');
                $subject = "Innuendo User Verification eMail";
                $message = "This is your activation link: ".$link;
                $headers = "FROM: noreply@innuendo.com";
                if(!mail($to, $subject, $message, $headers)) {
                    echo "Mail error.";
                    exit();
                }
                Session::flash('home', 'You have been registered, please check your email and verify your account');

                Redirect::to('index.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            //output errors
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}
?>

<!--
Include php in value tag, allows for remembering text
-->



<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username'));?>" autocomplete="off">
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo escape(Input::get('email'));?>">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" value="" id="password">
    </div>

    <div class="field">
        <label for="password_again">Confirm Password</label>
        <input type="password" name="password_again" value="" id="password_again">
    </div>
    <!--generating token inside our page-->
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Register">

</form>

<div class="footer">
    © 2018 tbenedic Benedict Builds
</div>