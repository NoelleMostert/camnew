<?php
    include_once 'core/init.php';
    header('Content-Type: text/html');
    if(Session::exists('home')) {
        echo '<p>' .Session::flash('home') . '<p>';
    }
    $user = new User();

   // <!-- stop php code -->
  //  <p>Hello <a href="#"><?php echo escape($user->data()->username)
?>
<!DOCTYPE html><html>
<body>
<div id="container">
<div id="header">

    <title>InnuendO</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">

</div>
<?php if($user->isLoggedIn()){ ?>


<!--<div class="navbar">-->
<!--    <h1 align="center">InnuendO</h1>-->
<!--    <ul>-->
<!--        <li><a href="logout.php">Log Out</a></li>-->
<!--        <li><a href="update.php">Update Details</a></li>-->
<!--        <li><a href="changepass.php">Change Password</a></li>-->
<!--    </ul>-->
<!--</div>-->

<!--    Trying out a new header-->
    <div class="header">
        <a href="#default">InnuendO</a>
        <div class="header-right">
            <a href="update.php">Update Details</a>
            <a href="changepass.php">Change Password</a>
            <a href="logout.php">Log Out</a>
        </div>
    </div>
    <!--    Trying out a new header-->

<div align="center" class="top-container">
    <div class="contained">
        <video autoplay="true" id="video">
            Stream not available...
        </video>
        <img class="videoElement overlays" id="preview_img" src="" alt="" style="display: none"></>
    <div>
    <div class="overlays" >
                <img id="imgid" alt = ""  class="final_overlay"/>
    </div>
        <div class="overlay overlays">
                <img id="img2id" alt = ""  class="final_overlay"/>
        </div>
    </div>
    </div>

    <div>
        <button class="btn-dark" id="camera_on">
            Cam
        </button>

        <div class="upload-btn-wrapper">
        <button class="btn-dark">
            Upload
        </button>
        <input data-buttonText="Your label here." type="file" id="filetag" accept=".jpg, .gif, .png, .jpeg" />
        </div>
    </div>

    <button id="photo-button" class="btn btn-dark">
        Capture
    </button>

    <select id="photo-filter" class="select">
        <option value="none">Normal</option>
        <option value="grayscale(100%)">Grayscale</option>
        <option value="sepia(100%)">Sepia</option>
        <option value="invert(100%)">Invert</option>
        <option value="hue-rotate(90deg)">Hue</option>
        <option value="blur(10px)">Blur</option>
        <option value="contrast(200%)">Contrast</option>
        <option value="rotateY(180deg)">Flip</option>
    </select>


    <!-- Testing out the photo reel -->
    <div id="super" class="super">
        <table>
            <tr>
                <td><img src="./img/layers/banana.png"  onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/bubbly.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/burito.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/cactus.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/corn.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/gerkin.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/cucumber.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/eggplant.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/eggs.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/flashlight.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/hotdog.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/kiwi.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/litchi.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/popsicle.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/rooster.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/sausage.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/sharpie.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/tinkie.png" onclick="overlay(this.src)" alt=""></td>
                <td><img src="./img/layers/walnut.png" onclick="overlay(this.src)" alt=""></td>
            </tr>
        </table>
    </div>
    <!-- End of Test-->
    <button id="clear-button" class="btn btn-light">
        Clear
    </button>

    <canvas id="canvas"></canvas>
</div>


<form id="form" method="post"

<div class="bottom-container">
    <div id="photos"></div>
</div>

<script src="js/main.js"></script>

<?php
}
else{
    echo '<p> You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
}
?>
<div class="footer">
    © 2018 tbenedic Benedict Builds
</div>
</div>
</body>
</html>
