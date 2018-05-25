<?php
session_start();

//password_hash($password, PASSWORD_DEFAULT);
//password_verify($password, $user['password']);

if (isset($_POST['submit'])) {

    require_once 'includes/database.php';
    require_once 'includes/login-validation.php';

    $username = mysqli_real_escape_string($db, $_POST['username']);

    $pass = mysqli_real_escape_string($db, $_POST['password']);
    $passConfirm = mysqli_real_escape_string($db, $_POST['password-confirm']);

    if ($pass == $passConfirm && !empty($pass)) {
        $hash = password_hash("$pass", PASSWORD_DEFAULT);

        $query = "INSERT INTO users(user_name, user_pass) VALUES ('$username', '$hash')";

        $result = mysqli_query($db, $query);

        if ($result) {
            header('Location: login.php');
        }
    }
}
?>


<!doctype html>
<html lang="en">
<head>

    <title>login pagina</title>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/login.style.css"/>
    <link rel="stylesheet" type="text/css" href="css/navbar.style.css"/>

</head>
<body>

<header>
    <div class="navigation">
        <div class="logo">
            <a href="index.php">
                <img src="http://boconsushiconcepts.com/wp-content/themes/bocon/images_temp/logo.png">
            </a>
        </div>

        <div class="menu">
            <ul class="menu-item">
                <li><a href="index.php">home</a></li>
                <li><a href="http://boconsushiconcepts.com/about/">about</a></li>
                <li><a href="http://boconsushiconcepts.com/machines-2/">machines</a></li>
                <li><a href="http://boconsushiconcepts.com/food-2/">food</a></li>
                <li><a href="http://boconsushiconcepts.com/concepts/">concepts</a></li>
                <li><a href="http://boconsushiconcepts.com/news/">news</a></li>
                <li><a href="reservering.php">contact</a></li>
            </ul>
        </div>

        <div class="language">
            <ul>
                <li class="flag-nl">
                    <img src="http://boconsushiconcepts.com/wp-content/plugins/sitepress-multilingual-cms/res/flags/nl.png"
                         alt="nl" title="Nederlands">
                </li>

                <li class="flag-en">
                    <img src="http://boconsushiconcepts.com/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                         alt="en" title="English">
                </li>

                <li class="flag-fr">
                    <img src="http://boconsushiconcepts.com/wp-content/plugins/sitepress-multilingual-cms/res/flags/fr.png"
                         alt="fr" title="Français">
                </li>

                <li class="flag-de">
                    <img src="http://boconsushiconcepts.com/wp-content/plugins/sitepress-multilingual-cms/res/flags/de.png"
                         alt="de" title="Deutch">
                </li>
            </ul>
        </div>
    </div>

</header>

<div class="border"></div>

<div class="login-frame">
    <div class="sub-logo">
        <img src="http://boconsushiconcepts.com/wp-content/themes/bocon/images_temp/logo.png">
    </div>
    <div class="login-wrapper">
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
              enctype="multipart/form-data">

            <div class="data-field">
                <label for="username"></label>
                <input type="text" name="username"
                       placeholder="<?= isset($errors['user']) ? $errors['user'] : 'username' ?>"
                       value="<?= isset($username) ? $username : ''; ?>"/>
            </div>

            <div class="data-field">
                <label for="password"></label>
                <input type="password" name="password"
                       placeholder="<?= isset($errors['pass']) ? $errors['pass'] : 'password' ?>"
                       value="<?= isset($pass) ? $pass : ''; ?>"/>
            </div>


            <div class="data-field">
                <label for="password-confirm"></label>
                <input type="password" name="password-confirm"
                       placeholder="<?= isset($errors['identical']) ? $errors['identical'] : ' confirm password' ?>"
                       value=""/>
            </div>

            <div class="data-submit">
                <input type="submit" name="submit" value="login"/>
            </div>
        </form>
    </div>
</div>


<footer>
    <strong>Bocon Sushi Concepts</strong>,
    Melbournestraat 76a, NL-3047 BJ Rotterdam,
    <a href="mailto:info@boconsushiconcepts.com">info@boconsushiconcepts.com</a>
</footer>

</body>
</html>
