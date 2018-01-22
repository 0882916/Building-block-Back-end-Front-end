<?php
$dateError = [];
if (empty($timestampOne)) {
    $error['invalid'] = 'Ongeldige invoer';
}

if ($timestampOne < time()+1) {
    $error['invalid'] = 'Ongelidge invoer';
}

if ($timestampOne > $timestampTwo && $timestampTwo > time()) {
    $error['past'] = 'Datum veld een moet eerder zijn dan datum veld twee';
}