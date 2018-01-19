<?php
session_start();

$appointments = [];

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
} else {
    $user = $_SESSION['username'];

    require_once 'includes/database.php';

    $query = "SELECT * FROM appointment WHERE id=$_GET[id]";

    $result = mysqli_query($db, $query);

    //Loop through the result to create a custom array
    $appointments = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $appointments[] = $row;
    }
    mysqli_close($db);
}

if (isset($_POST['logout'])) {
    session_unset();
    header('Location: login.php');
}


?>

<!doctype html>
<html lang="en">
<head>
    <title>Detail</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/detail.style.css"/>
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
                <li><a href="reservering.php">about</a></li>
                <li><a href="reservering.php">machines</a></li>
                <li><a href="reservering.php">food</a></li>
                <li><a href="reservering.php">concepts</a></li>
                <li><a href="reservering.php">news</a></li>
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

<div class="container">

    <div class="data-submit">
        <input id="logout" type="submit" name="logout" value="logout"/>
    </div>

    <form class="session" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
          enctype="multipart/form-data">

    </form>

    <?php foreach ($appointments

    as $appointment) { ?>

    <div class="table-name">
        <a><?= ucfirst($appointment['first']); ?> </a>
        <a><?= ucfirst($appointment['last']); ?> van</a>
        <a><?= ucfirst($appointment['company']); ?></a>
    </div>

    <div class="appointments">

        <table>
            <tr>
            <tr>
                <th>Details</th>
                <td><?= $appointment['type']; ?> <br>
                    <?= $appointment['size']; ?> <br> <br>
                    <?= $appointment['time']; ?>,
                    <?= date('j'." ".'M'." ".'Y', $appointment['date']); ?> <br> <br>
                    <?= $appointment['comment']; ?>
                </td>
            </tr>
            <tr>
                <th>E-mail</th>
                <td><?= $appointment['email']; ?>
                </td>
            </tr>
            <tr>
                <th>Telefoon</th>
                <td><?= $appointment['phone']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <div class="back">
        <a href="admin.php">terug</a>
    </div>
</div>

<footer>
    <strong>Bocon Sushi Concepts</strong>,
    Melbournestraat 76a, NL-3047 BJ Rotterdam,
    <a href="mailto:info@boconsushiconcepts.com">info@boconsushiconcepts.com</a>
</footer>

</body>
</html>
