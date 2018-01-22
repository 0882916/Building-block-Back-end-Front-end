<?php
require_once "includes/database.php";


//Looping through a table machine to show results in dropdown
$querydbM = "SELECT * FROM machine";
$resultM = mysqli_query($db, $querydbM);

while ($rowM = mysqli_fetch_assoc($resultM)) {
    $machines[] = $rowM;
}

//Fetching all unavailable dates from unavailable to make those dates unselectable
//in the datepicker
$querydbUdatepicker = "SELECT * FROM unavailable";
$resultUdatepicker = mysqli_query($db, $querydbUdatepicker);

while ($rowUdatepicker = mysqli_fetch_assoc($resultUdatepicker)) {
    $unavailableOne[] = $rowUdatepicker['date_one'];
    $unavailableTwo[] = $rowUdatepicker['date_two'];

//    var_dump($rowUdatepicker['date_one']);
//    var_dump($rowUdatepicker['date_two']);
}


if (isset($_POST['submit'])) {

    //Creating variables
    $date = mysqli_real_escape_string($db, $_POST['date']);
    $time = mysqli_real_escape_string($db, $_POST['time']);
    $size = mysqli_real_escape_string($db, $_POST['size']);
    $type = mysqli_real_escape_string($db, $_POST['type']);
    $first = mysqli_real_escape_string($db, $_POST['first']);
    $last = mysqli_real_escape_string($db, $_POST['last']);
    $company = mysqli_real_escape_string($db, $_POST['company']);
    $email = mysqli_real_escape_string($db, $_POST['mail']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $comment = mysqli_real_escape_string($db, $_POST['comment']);

    //Converting date to timestamp
    $timestamp = strtotime($date);

    //Checking if combination $date and $time exsist in database appointment
    $querydbA = "SELECT * FROM appointment WHERE date = '$timestamp' AND time = '$time'";
    $resultA = mysqli_query($db, $querydbA);
    $rowA = mysqli_fetch_assoc($resultA);

    //Checking if $date exsist in database unavailable
    $querydbU = "SELECT * FROM unavailable WHERE date_one <= '$timestamp' AND date_two >= '$timestamp'";
    $resultU = mysqli_query($db, $querydbU);
    $rowU = mysqli_fetch_assoc($resultU);

    //File with validation properties
    require_once "includes/form-validation.php";

    //If combination $date and $time non-existant and $date doesn't exsist in unavailable
    //and no $errors given insert into database
    if (empty($errors)) {
        $query = "INSERT INTO appointment(date,time,size,type,first,last,company,email,phone,comment) 
                          VALUES('$timestamp','$time','$size','$type','$first','$last','$company','$email','$phone','$comment')";
        $result = mysqli_query($db, $query);

        //If inserting into appointment went right
        if ($result) {
            header("Location: confirm.php?date=$timestamp&time=$time");
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Maak een afspraak</title>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/reservering.style.css"/>
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

<div class="container-title">
    <h2>Contact</h2>
    <p>Maak een afspraak om de show room of onze sushi-robots
        te bekijken door het formulier in te vullen.</p>
</div>

<div class="container">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
          enctype="multipart/form-data">
        <div class="appointment">
            <div class="subject-header">

                <label class="title-appointment">AFSPRAAK</label>
            </div>

            <div class="data-field">
                <label for="date">Datum</label>
                <input name="date" class="datepicker" value="<?= isset($date) ? $date : ''; ?>">
            </div>

            <div class="data-field">
                <label for="time">Tijdstip
                    <select name="time" id="time" onchange="showfield(this.options[this.selectedIndex].value)">
                        <option value="10:00-12:00"
                                selected="selected"><?= isset($time) ? $time : '10:00-12:00'; ?></option>
                        <option value="12:00-14:00">12:00-14:00</option>
                        <option value="14:00-16:00">14:00-16:00</option>
                        <option value="16:00-18:00">16:00-18:00</option>
                    </select>
                </label>
            </div>

            <div class="data-field">
                <label for="size">Personen
                    <select name="size" id="size" onchange="showfield(this.options[this.selectedIndex].value)">
                        <option value="Enkel persoon"
                                selected="selected"><?= isset($size) ? $size : 'Enkel persoon'; ?></option>
                        <option value="Twee personen">Twee personen</option>
                        <option value="Drie personen">Drie personen</option>
                        <option value="Vier  personen">Vier personen</option>
                    </select>
                </label>
            </div>

            <div class="data-field">
                <label for="type">Machine
                    <select name="type" id="type" onchange="showfield(this.options[this.selectedIndex].value">

                        <?php
                        foreach ($machines
                                 as $machine) { ?>
                            <option value="<?= $machine['type']; ?>"
                                    selected="selected"><?= isset($type) ? $machine['type'] : $machine['type']; ?>
                            </option>
                        <?php } ?>

                    </select>
                </label>
            </div>

            <div class="data-field">
                <label for="comment">Opmerking
                    <input id="comment" type="text" name="comment" value="<?= isset($comment) ? $comment : ''; ?>"
                           placeholder="200 karakters max">
                </label>
            </div>
        </div>

        <div class="contact">
            <div class="subject-header">
                <label class="title-contact">CONTACT</label>
            </div>
            <div class="data-field">
                <label for="first">Voornaam</label>
                <input id="first" type="text" name="first" value="<?= isset($first) ? $first : ''; ?>"
                       placeholder="<?= isset($errors['first']) ? $errors['first'] : '' ?>"/>
            </div>
            <div class="data-field">
                <label for="last">Achternaam</label>
                <input id="last" type="text" name="last" value="<?= isset($last) ? $last : ''; ?>"
                       placeholder="<?= isset($errors['last']) ? $errors['last'] : '' ?>"/>
            </div>
            <div class="data-field">
                <label for="companyname">Bedrijf</label>
                <input id="companyname" type="text" name="company" value="<?= isset($company) ? $company : ''; ?>"
                       placeholder="<?= isset($errors['company']) ? $errors['company'] : '' ?>"/>
            </div>
            <div class="data-field">
                <label for="email">E-mail</label>
                <input id="email" type="email" name="mail" value="<?= isset($email) ? $email : ''; ?>"
                       placeholder="<?= isset($errors['atleastone']) ? $errors['atleastone'] : '' ?>"/>
            </div>
            <div class="data-field">
                <label for="phone">Telefoon</label>
                <input id="phone" type="text" name="phone" value="<?= isset($phone) ? $phone : ''; ?>"
                       placeholder="<?= isset($errors['phone']) ? $errors['phone'] : '';
                       isset($errors['atleastone']) ? $errors['atleastone'] : '' ?>"
            </div>

            <input class="submit" name="submit" type="submit" value="Submit">
            <span class="errors-two"><?= isset($errors['taken']) ? $errors['taken'] : '' ?></span>
            <span class="errors"><?= isset($errors['date']) ? $errors['date'] : '' ?></span>

    </form>

</div>
</div>

<div class="container-footer">
    <p>Voor vragen kunt u uiteraard altijd bellen of mailen.</p>
    <div class="off-form-information">
        <div class="info-left">
            <h4>Telefoon</h4>
            <p>Nederland: 010 340 0705<br>
                België: 02 588 7705<br>
                Duitsland: 0531 2625 1950<br>
            </p>
        </div>
        <div class="info-right">
            <h4>Adres</h4>
            <p>Melbournestraat 76a<br>
                3047 BJ Rotterdam
                info@boconsushiconcepts.com
            </p>
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
        beforeShowDay: $.datepicker.noWeekends,
        minDate: new Date()
    });
</script>
</body>
</html>