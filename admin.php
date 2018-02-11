<?php
session_start();

//If user is not logged in redirect to login.php
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
} else {
    require_once 'includes/database.php';

    //Creating variable for user name
    $user = $_SESSION['username'];
    $timestamp = time();

    //If timestamp appointment < current timestamp delete appointment
    $query = "DELETE FROM appointment WHERE date < '$timestamp'";
    $result = mysqli_query($db, $query);

    //If timestamp unavailable < current timestamp delete unavailable
    $query = "DELETE FROM unavailable WHERE date_two < '$timestamp'";
    $result = mysqli_query($db, $query);

    //Fetching all appointments from database and create array
    $query = "SELECT * FROM appointment";
    $result = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $appointments[] = $row;
    }

    //Fetching all unavailables from database and create array
    $query = "SELECT * FROM unavailable";
    $result = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $unavailables[] = $row;
    }

    //Submitting date(s)
    if (isset($_POST['submit'])) {
        require_once 'includes/database.php';

        //Creating variables
        $dateOne = mysqli_real_escape_string($db, $_POST['dateone']);
        $dateTwo = mysqli_real_escape_string($db, $_POST['datetwo']);

        //Converting date string to timestamp
        $timestampOne = strtotime($dateOne);
        $timestampTwo = strtotime($dateTwo);

        require_once 'includes/admin_date-validation.php';

        if (empty($error)) {
            //When input second date is empty, second date becomes first date
            if (empty($timestampTwo)) {
                //Insert dates into unavailable database
                $query = "INSERT INTO unavailable(date_one, date_two) 
                  VALUES ('$timestampOne',$timestampOne)";

                mysqli_query($db, $query);
                header('Location: admin.php');

            } else {
                //Insert dates into unavailable database
                $query = "INSERT INTO unavailable(date_one, date_two) 
                  VALUES ('$timestampOne','$timestampTwo')";

                mysqli_query($db, $query);
                header('Location: admin.php');
            }
        }
    }
}

//If the logout button is clicked end SESSION
if (isset($_POST['logout'])) {
    session_unset();
    header('Location: login.php');
}

mysqli_close($db);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="stylesheet" type="text/css" href="css/admin.style.css"/>
    <link rel="stylesheet" type="text/css" href="css/navbar.style.css"/>
    <link rel="stylesheet" type="text/css" href="js/jquery-ui-1.12.1/jquery-ui.css"/>
    <title>Afspraken inzage</title>
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
          enctype="multipart/form-data">
        <div class="data-submit">
            <input id="logout" type="submit" name="logout" value="logout"/>
        </div>
    </form>

    <div class="welcome">
        <p>Welkom, Peter</p>
    </div>

    <div class="table-name">
        <a>Afspraken</a>
    </div>

    <!--Table showing all made appointments-->
    <div class="appointments">
        <table>
            <thead>
            <tr>
                <th class="medium">Tijdstip</th>
                <th class="medium">Datum</th>
                <th class="large">Bedrijfsnaam</th>
                <th class="medium">Telefoon nr.</th>
                <th class="large">Email</th>
                <th> </th>
            </tr>
            </thead>
            <?php
            if (isset($appointments)) {
                foreach ($appointments as $appointment) { ?>
                    <tr>
                        <td><?= $appointment['time']; ?></td>
                        <td><?= date('j' . " " . 'M' . " " . 'Y', $appointment['date']); ?></td>
                        <td><?= ucfirst($appointment['company']); ?></td>
                        <td><?= $appointment['phone']; ?></td>
                        <td><?= $appointment['email']; ?></td>
                        <td class="icon"><a href="detail.php?id=<?= $appointment['id']; ?>"><img
                                        src="icons/details.png"></a></td>
                        <td class="icon"><a href="delete_appointment.php?id=<?= $appointment['id']; ?>"><img
                                        src="icons/delete.png"></a>
                        </td>
                    </tr>
                <?php }
            } ?>
        </table>
    </div>

    <div class="table-name">
        <a>Afwezigheid</a>
    </div>

    <!--Form for unavailable date input-->
    <div class="unavailable">
        <div class="unavailable-container">
            <form class="unavailable-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                  enctype="multipart/form-data">

                <label for="dateone">Datum
                    <input class="datepicker" name="dateone" value=""> -
                    <input class="datepicker" name="datetwo" value="">
                </label>

                <input id="submit" name="submit" type="submit" value="Submit">
                <span class="errors"><?= isset($error['invalid']) ? $error['invalid'] : '' ?></span><br>
                <span class="errors"><?= isset($error['past']) ? $error['past'] : '' ?></span>

            </form>
        </div>

        <!--Table showing all unavailable dates-->
        <div class="unavailable-table">
            <table>
                <?php
                if (isset($unavailables)) {
                    foreach ($unavailables as $unavailable) { ?>
                        <tr>
                            <td class="left">Vanaf <?= strtolower(date('j' . " " . 'F' . " " . 'Y',
                                    $unavailable['date_one'])); ?></td>
                            <td class="middle"> tot en
                                met <?= strtolower(date('j' . " " . 'F' . " " . 'Y',
                                    $unavailable['date_two'])); ?></td>
                            <td class="right"><a href="delete_unavailable.php?id=<?= $unavailable['id']; ?>"><img
                                            src="icons/delete.png"></a>
                            </td>
                        </tr>
                    <?php }
                } ?>
            </table>
        </div>
    </div>
</div>

<footer>
    <strong>Bocon Sushi Concepts</strong>,
    Melbournestraat 76a, NL-3047 BJ Rotterdam,
    <a href="mailto:info@boconsushiconcepts.com">info@boconsushiconcepts.com</a>
</footer>

<script src="js/jquery-ui-1.12.1/external/jquery/jquery.js"></script>
<script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>

<!--JavaScript for the calender-->
<script type="text/javascript">
    $('.datepicker').datepicker({
        inline: true,
        dateFormat: "dd-mm-yy",
        minDate: new Date()
    });
</script>
</body>
</html>