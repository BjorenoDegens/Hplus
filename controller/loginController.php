<?php
// @todo een if statement maken bij de klant die ingelogt is of die de rol coach of user heeft.
require_once("../connect.php");
if (isset($_POST['submit'])) {
    // Incoming data handler
    $naam = $_POST['naam'];
    $wachtwoord = $_POST['wachtwoord'];

    // Sql query
    $sql = "SELECT * FROM user WHERE Naam = :naam AND Wachtwoord = :wachtwoord";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(":naam", $naam);
    $stmt->bindParam(":wachtwoord", $wachtwoord);
    $stmt->execute();

    //Heading Handler
    if ($stmt->rowCount() > 0) {
//        Persoon is ingelogt
//        if ()
        header("Location:../register.php");
        exit();
    } else {
//        Persoon heeft foute waardes ingevuld
        header("Location:../login.php");
        exit();
    }
}else {
    header("Location:../register.php");
    exit();
}
