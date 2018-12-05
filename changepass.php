<?php
require_once 'core/init.php';

$user = new User();

$salt = 1;
if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST,array(
           'password_current' => array(
               'required' => true,
               'min' => 8
           ),
            'password_new' => array(
                'required' => true,
                'min' => 8,
                'strength' => "/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/",
                //Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit
            ),
            'password_new_again' => array(
                'required' => true,
                'min' => 8,
                'matches' => 'password_new'
            )
        ));

        if($validation->passed()) {

            if(Hash::verify($user->data()->password, Input::get('password_current'))) {
                $user->update(array(
                    'password' => Hash::make(Input::get('password_new'))
                ));

                Session::flash('home', 'Your password has been changed!');
                Redirect::to('index.php');
            }
            else {
                echo 'Your current password is wrong';
            }
        }
        else {
            foreach($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }



    }
}

?>

<div id="header">

    <title>InnuendO</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">

</div>

<form action="" method="post">

    <div class="field">
        <label for="password_current">Current Password</label>
        <input type="password" name="password_current" id="password_current">
    </div>

    <div class="field">
        <label for="password_new">New Password</label>
        <input type="password" name="password_new" id="password_new">
    </div>

    <div class="field">
        <label for="password_new_again">Confirm Password</label>
        <input type="password" name="password_new_again" id="password_new_again">
    </div>

    <input type="submit" value="Change">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>

<ul>
    <li><a href="logout.php">Log Out</a></li>
</ul>

<div class="footer">
    © 2018 tbenedic Benedict Builds
</div>
