<?php
//sends a user that to index if he messes up typing url manually
if (!isset($_GET['date']) && !isset($_GET['time'])) {
    header('Location: index.php');
    exit;
}

//require 'vendor/autoload.php';
require_once "includes/database.php";

$timestamp = $_GET['date'];
$time = $_GET['time'];

$query = "SELECT * FROM appointment WHERE date = '$timestamp' AND time = '$time';";

$result = mysqli_query($db, $query);

if (mysqli_num_rows($result) == 1) {

    $appointment = mysqli_fetch_assoc($result);

} else {
    header('Location: index.php');
    exit;
}

require 'class/class.phpmailer.php';
$mail = new PHPMailer;
$mail->IsSMTP();        //Sets Mailer to send message using SMTP
$mail->Host = 'smtp-mail.outlook.com';  //Sets the SMTP hosts
$mail->Port = '587';        //Sets the default SMTP server port
$mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
$mail->Username = 'boconsushiconcepts@outlook.com';     //Sets SMTP username
$mail->Password = 'BoconSushi';     //Sets SMTP password
$mail->SMTPSecure = 'tls';       //Sets connection prefix. Options are "", "ssl" or "tls"
$mail->From = "boconsushiconcepts@outlook.com";     //Sets the From email address for the message
$mail->FromName = $appointment['first'];    //Sets the From name of the message
$mail->AddAddress('boconsushiconcepts@outlook.com', 'Name');//Adds a "To" address
$mail->AddCC($appointment['email'], $appointment['first']); //Adds a "Cc" address
$mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
$mail->IsHTML(true);       //Sets message type to HTML
$mail->Subject = "Afspraak showroom";    //Sets the Subject of the message
$mail->Body = "Uw afspraak vindt plaats op ".strtolower(date('j' . " " . 'F' . " " . 'Y',$appointment['date']))." op ".$appointment['time']."<br>"."We kijken uit naar uw bezoek"."<br>"."<br>"."M.v.g,"."<br>"."BoconSushiConcepts";    //An HTML or plain text message body
if($mail->Send())        //Send an Email. Return true on success or false on error
{
    $error = '<label class="text-success">Thank you for contacting us</label>';
}
else
{
    $error = '<label class="text-danger">There is an Error</label>';
}

?>

<!doctype html>
<html lang="en">
<head>
    <title>Confirm</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/navbar.style.css"/>
    <link rel="stylesheet" type="text/css" href="css/confirm.style.css"/>

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

<div class="confirm">
    <h3>Bedankt voor het maken van een afspraak, <?= ucfirst($appointment['first']) ?></h3>
    <h3>Uw reservering vindt plaats op
        <strong><?= strtolower(date('j' . " " . 'F' . " " . 'Y', $timestamp)); ?></strong> om
        <strong><?= $time ?></strong>
    </h3>
</div>

<div class="google-maps">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2459.64788121356!2d4.405760315785935!3d51.940375979708634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5cacb178af7d9%3A0xfe359f1b553edfc7!2sMelbournestraat+76%2C+3047+BJ+Rotterdam!5e0!3m2!1snl!2snl!4v1516005818625"
            width="700" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>

<div class="confirm">
    <p>Als u een bevestiging via mail wilt, vul dan hier uw E-mail in
    <form>
        <input name="mail" value="<?= $appointment['email'] ?>"/><input id="send" name="send" type="submit" value="Send"/>
    </form>
    </p>
</div>


<footer>
    <strong>Bocon Sushi Concepts</strong>,
    Melbournestraat 76a, NL-3047 BJ Rotterdam,
    <a href="mailto:info@boconsushiconcepts.com">info@boconsushiconcepts.com</a>
</footer>
</body>
</html>
