<?php
require_once "database.php";

$query = "SELECT * FROM appointment WHERE date = '$timestamp' AND time = '$time';";

$result = mysqli_query($db, $query);

$appointment = mysqli_fetch_assoc($result);

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Details afspraak Back-end Building Block</title>
</head>
<body>
<div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
    <h1>This is a test of PHPMailer.</h1>

    <p>Bedankt voor het maken van een afspraak, <?= ucfirst($appointment['first']) ?></p>
    <p>Uw reservering vindt plaats op
        <strong><?= strtolower(date('j' . " " . 'F' . " " . 'Y', $timestamp)); ?></strong> om
        <strong><?= $time ?></strong>
    </p>

    <div class="google-maps" align="center">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2459.64788121356!2d4.405760315785935!3d51.940375979708634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5cacb178af7d9%3A0xfe359f1b553edfc7!2sMelbournestraat+76%2C+3047+BJ+Rotterdam!5e0!3m2!1snl!2snl!4v1516005818625"
                width="700" height="500" frameborder="0" style="border:0"></iframe>
    </div>
</div>
</body>
</html>
