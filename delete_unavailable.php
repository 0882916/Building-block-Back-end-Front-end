<?php
session_start();

//If session doesnt exsist, redirect to login page else require appointments
if (!isset($_SESSION['username'])) {
    header('Location: login.php');

} else {

    require_once "includes/database.php";

    $id = $_GET['id'];

    $query = "DELETE FROM unavailable WHERE id='$id'";

    mysqli_query($db, $query);

    mysqli_close($db);

    header('Location: admin.php');
}

?>