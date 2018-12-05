<?php
require_once 'core/init.php';

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
                'username' => array('required' => true),
                'password' => array('required' => true)
        ));

        if($validation->passed()) {
            $user = new User();

            //$remember = (Input::get('remember') === 'on') ? true : false;
            $remember = true;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            // SELECT * FROM users where username = INPUT::getusername
            // is `verified` == 1
            //$arr_where = array("username" => Input::get('username'), "verified" => "1");
            //$arr_where = array("username", "=", Input::get('username'));
            $Dbo = DB::getInstance();
            $pdo = $Dbo->getConnection();

            $stmt = $pdo->prepare("SELECT `verified` FROM `users` WHERE `username`=:uname");
            $current_username = Input::get('username');
            $stmt->bindParam(":uname", $current_username, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);

            if($login && ($results["verified"] == 1)){
                Redirect::to('index.php');
            }
            else if ($results["verified"] == 0){
                echo '<p> Account not verified, please use verification link sent via email<p>';
            }
            else {
                echo '<p> Sorry, logging in failed.<p>';
            }

        } else {
            foreach($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}


?>

<!DOCTYPE html>
<html>
<body>
<div id="container">
    <div id="header">

        <title>InnuendO</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </div>
<form action ="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username"  autocomplete="off">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" autocomplete="off">
    </div>

    <div class="field">
        <label for="remember">
        <input type="checkbox" name="remember" id="remember"> Remember me
        </label>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Log In">
</form>

    <div class="footer">
        © 2018 tbenedic Benedict Builds
    </div>
</div>
</body>
</html>