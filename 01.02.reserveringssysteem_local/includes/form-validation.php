<?php

//Input validation and generating errors
$errors = [];

if ($rowA > 0) {
    $errors['taken'] = 'Tijdsstip reeds gereserveerd';
}
if ($rowU > 0) {
    $errors['taken'] = 'Datum onbeschikbaar';
}
if ($timestamp < time()) {
    $errors['date'] = 'Datum is al geweest';
}
if ($timestamp == 0) {
    $errors['date'] = 'Vul een datum in';
}
if ($first == "") {
    $errors['first'] = 'Mag niet leeg zijn';
}
if ($last == "") {
    $errors['last'] = 'Mag niet leeg zijn';
}
if ($company == "") {
    $errors['company'] = 'Mag niet leeg zijn';
}
if (empty($phone) || !is_numeric($phone) && strlen($phone) < 8) {
        $errors['phone'] = 'Ongeldig telefoonnummer';
}
if ($email == "" && $phone == "") {
    $errors['atleastone'] = 'Email of telefoonnummer verplicht';
}
