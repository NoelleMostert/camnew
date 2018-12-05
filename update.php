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
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 50,
                'unique' => 'users'
            )
        ));
        if($validation->passed()) {
            try{
                $user->update(array(
                    'username' => Input::get('username')
                ));
                Session::flash('home', 'Your details have been updated');
                Redirect::to('index.php');
            }
            catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach ($validation->errors() as $error) {
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
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo escape($user->data()->username); ?>" autocomplete="off">

        <input type="submit" value="Update">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

    </div>
</form>

<ul>
    <li><a href="logout.php">Log Out</a></li>
</ul>

<div class="footer">
    © 2018 tbenedic Benedict Builds
</div>