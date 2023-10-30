<?php
session_start(); // počnite sesiju
require_once("funkcije.php");

$errorMessage = ""; // Inicijalizujemo varijablu za poruku o grešci

if(isset($_POST['unos_btn'])) {
    $id = $_POST['id'];
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $adresa = $_POST['adresa'];
    $grad = $_POST['grad'];

    // Provjera praznih polja
    if (empty($id) || empty($ime) || empty($prezime) || empty($adresa) || empty($grad)) {
        $errorMessage = "Sva polja moraju biti popunjena.";
    } else {
        // Validacija ID-a ako već postoji u bazi
        $kon = konektujSe();
        $result = $kon->query("SELECT * FROM student WHERE ID = $id");
        if ($result->num_rows > 0) {
            $errorMessage = "Student sa unesenim ID već postoji.";
        } else {
            // Dodavanje novog studenta u bazu
            izvrsiUpit("INSERT INTO student (ID, Ime, Prezime, Adresa, Grad) VALUES ('$id', '$ime', '$prezime', '$adresa', '$grad')");

            // Preusmjeravanje na index.php nakon unosa
            header("Location: index.php");
            exit();
        }
    }
}

$podaci = array(
    'id' => '',
    'ime' => '',
    'prezime' => '',
    'adresa' => '',
    'grad' => ''
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Unos studenta</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="icon" type="image/png" href="logo.png">
</head>
<body>
    <h1>Unos novog studenta</h1>
    <div id="mainPart">
    <form action="unos.php" name="f1" method="post" id="dataForm">
    <br/>ID: <input type="text" name="id" value="<?php echo $podaci['id']; ?>" />
    <br/><br/>Ime: <input type="text" name="ime" value="<?php echo $podaci['ime']; ?>" />
    <br/><br/>Prezime: <input type="text" name="prezime" value="<?php echo $podaci['prezime']; ?>" />
    <br/><br/>Adresa: <input type="text" name="adresa" value="<?php echo $podaci['adresa']; ?>" />
    <br/><br/>Grad: <input type="text" name="grad" value="<?php echo $podaci['grad']; ?>" />
    <br/><br/><input type="submit" class="action-button" name="unos_btn" value="Unesi" />
    <p style="color: red; margin-top: 10px;"><?php echo $errorMessage; ?></p>
    </form>
    
    </div>
</body>
</html>
