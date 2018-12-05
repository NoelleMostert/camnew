<?php

require_once 'core/init.php';
//generate new random password

//$newpass = "Makerandom";

//update pass where email is = email

//on successful update send email

//888888888888888888888888888888888888888


//    $len = 8;
//    $strength = true;
//
//    $salt = 1;
//    $rand_bytes = openssl_random_pseudo_bytes($len, $strength);
//
//    // $user = new User();
//
//    // $user->update()

    $dbo = DB::getInstance();

    $arr_wheres = array("username", "=", $username);

    $res = $dbo->get('users', $arr_wheres);
    $info = (array)$res->results()[0];
    var_dump($info["activation_key"]);


//
//    $user->create(array(
//        'username' => Input::get('username'),
//        'password' => Hash::make($rand_bytes, $salt),
//        'email' => Input::get('email'),
//        'joined' => date('Y-m-d H:i:s'),
//        'group_type' => 1,
//        'verified' => 0,
//        'activation_key' => $rand_bytes
//    ));
//    $link = "localhost:8080/Camagru/forgot.php?token=".$key;
//    $to = Input::get('email');
//    $subject = "Innuendo Forgot Password";
//    $message = "This is your activation link: ".$link;
//    $headers = "FROM: noreply@innuendo.com";
//    if(!mail($to, $subject, $message, $headers)) {
//        echo "Mail error.";
//        exit();
//    }
//    Session::flash('home', 'You have been registered, please check your email and verify your account');
//
//    Redirect::to('index.php');
//} catch (Exception $e) {
//    die($e->getMessage());
//}

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


        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Log In">
    </form>

    <div class="footer">
        © 2018 tbenedic Benedict Builds
    </div>
</div>
</body>
</html>