<?php
require_once('../connect.php');
if (isset($_POST['submit'])) {
    // Incoming data handler
    $username = $_POST['naam'];
    $password = $_POST['wachtwoord'];
    $email = $_POST['email'];
    $leeftijd = $_POST['leeftijd'];

    // naam checker
    $checkSql = "SELECT COUNT(*) FROM user WHERE Naam = :naam";
    $checkStmt = $connect->prepare($checkSql);
    $checkStmt->bindParam(":naam", $username);
    $checkStmt->execute();
    $userExists = $checkStmt->fetchColumn();

    if ($userExists) {
        // if naam bestaat
        header("Location:../login.php");
        exit();
    }

    // if naam niet bestaat
    $insertSql = "INSERT INTO user (Naam, Wachtwoord, Email, Leeftijd) 
                  VALUES (:naam, :wachtwoord, :email, :leeftijd)";
    $insertStmt = $connect->prepare($insertSql);
    $insertStmt->bindParam(":naam", $username);
    $insertStmt->bindParam(":wachtwoord", $password);
    $insertStmt->bindParam(":email", $email);
    $insertStmt->bindParam(":leeftijd", $leeftijd);

    $insertStmt->execute();

    header("Location:../login.php");
    exit();
} else {
    header("Location:../login.php");
    exit();
}
?>
