<?php
session_start();

//If session doesnt exsist, redirect to login page else require appointments
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
} else {
    require_once 'includes/database.php';

    //Creating variable for user name
    $user = $_SESSION['username'];

    //variable timestamp
    $timestamp = time();

    //Creating query for deleting appointments that
    //are surpassed by current timestamp upon refresh
    $queryDelete = "DELETE FROM appointment WHERE date < '$timestamp'";
    $deleteResult = mysqli_query($db, $queryDelete);
    $queryDelete2 = "DELETE FROM unavailable WHERE date_one < '$timestamp'";
    $deleteResult2 = mysqli_query($db, $queryDelete2);

    //Creating query to select from appointment, and looping through to create
    //an array put in appointmentResult for showing all apppointments
    $queryAppointment = "SELECT * FROM appointment";
    $appointmentResult = mysqli_query($db, $queryAppointment);
    //Loop through the result to create a custom array
    while ($row = mysqli_fetch_assoc($appointmentResult)) {
        $appointments[] = $row;
    }

    //Creating query to select from unavailable, and looping through to create
    //an array put in unavailableResult for showing all unavailable dates
    $queryUnavailable = "SELECT * FROM unavailable";
    $unavailableResult = mysqli_query($db, $queryUnavailable);

    //Loop through the result to create a custom array
    while ($row = mysqli_fetch_assoc($unavailableResult)) {
        $unavailables[] = $row;
    }

    //Submitting date(s)
    if (isset($_POST['submit'])) {

        require_once 'includes/database.php';

        //Creating variables
        $dateOne = mysqli_real_escape_string($db, $_POST['dateone']);
        $dateTwo = mysqli_real_escape_string($db, $_POST['datetwo']);

        //Converting date string from variables to timestamp
        $timestampOne = strtotime($dateOne);
        $timestampTwo = strtotime($dateTwo);

        require_once 'includes/admin_date-validation.php';

        if (empty($error)) {
            if (empty($timestampTwo)) {
                //Insert timestamps into unavailable database
                $query = "INSERT INTO unavailable(date_one, date_two) 
                  VALUES ('$timestampOne',$timestampOne)";

                mysqli_query($db, $query);

                header('Location: admin.php');

            } else {
                //Insert timestamps into unavailable database
                $query = "INSERT INTO unavailable(date_one, date_two) 
                  VALUES ('$timestampOne','$timestampTwo')";

                mysqli_query($db, $query);

                header('Location: admin.php');
            }
        }
    }
}

//If the logout button is clicked - end session
if (isset($_POST['logout'])) {
    session_unset();
    header('Location: login.php');
}

mysqli_close($db);

?>

<!doctype html>
<html lang="en">
<head>
    <title>Afspraken inzage</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/admin.style.css"/>
    <link rel="stylesheet" type="text/css" href="css/navbar.style.css"/>
    <link rel="stylesheet" type="text/css" href="js/jquery-ui-1.12.1/jquery-ui.css"/>

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
            <?php }} ?>
        </table>
    </div>

    <div class="table-two-name">
        <a>Afwezigheid<?= isset($dateErrors) ? $dateErrors['Datum ongeldig of datum in veld een is na datum veld twee'] : ''; ?></a>
    </div>

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
        <div class="unavailable-overview">
            <table>
                <?php
                if (isset($unavailables)){
                foreach ($unavailables as $unavailable) { ?>
                    <tr>
                        <td class="left">Vanaf <?= strtolower(date('j' . " " . 'F' . " " . 'Y',
                                $unavailable['date_one']));?></td>
                        <td class="middle"> tot en
                            met <?= strtolower(date('j' . " " . 'F' . " " . 'Y',
                                $unavailable['date_two']));?></td>
                        <td class="right"><a href="delete_unavailable.php?id=<?= $unavailable['id']; ?>"><img
                                        src="icons/delete.png"></a>
                        </td>
                    </tr>
                <?php }} ?>
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

<script type="text/javascript">

    $('.datepicker').datepicker({
        inline: true,
        dateFormat: "dd-mm-yy",
        minDate: new Date()
    });

</script>

</body>
</html>