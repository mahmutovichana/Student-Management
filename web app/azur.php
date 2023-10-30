<?php
session_start(); // počnite sesiju
require_once("funkcije.php");

$errorMessage = ""; // Inicijalizujemo varijablu za poruku o grešci

$kon = konektujSe();
$studenti = $kon->query("SELECT * FROM student");

if(isset($_POST['azuriranje_btn'])) {
    $id = $_POST['studenti'];
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $adresa = $_POST['adresa'];
    $grad = $_POST['grad'];

    // Provjera praznih polja
    if (empty($ime) || empty($prezime) || empty($adresa) || empty($grad)) {
        $errorMessage = "Sva polja moraju biti popunjena.";
    } else {
        // Ažuriranje podataka odabranog studenta
        izvrsiUpit("UPDATE student SET Ime='$ime', Prezime='$prezime', Adresa='$adresa', Grad='$grad' WHERE ID=$id");

        // Preusmjeravanje na index.php nakon ažuriranja
        header("Location: index.php");
        exit();
    }
}

$podaci = array(
    'ime' => '',
    'prezime' => '',
    'adresa' => '',
    'grad' => ''
);

if(isset($_POST['studenti']) && $_POST['studenti'] !== "") {
    $selectedStudentID = $_POST['studenti'];
    $selectedStudent = $kon->query("SELECT * FROM student WHERE ID = $selectedStudentID")->fetch_assoc();
    $podaci['ime'] = $selectedStudent['Ime'];
    $podaci['prezime'] = $selectedStudent['Prezime'];
    $podaci['adresa'] = $selectedStudent['Adresa'];
    $podaci['grad'] = $selectedStudent['Grad'];
} else {
    $errorMessage = "Nije odabran nijedan student.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ažuriranje studenta</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="icon" type="image/png" href="logo.png">
</head>
<body>
    <h1>Ažuriranje podataka studenta</h1>
    <div id="mainPart">
    <form action="azur.php" name="f1" method="post" id="dataForm">
    <br/>Studenti:
    <select name="studenti" onchange="this.form.submit()">
        <option value="">Odaberi studenta</option>
        <?php 
        while ($row = $studenti->fetch_assoc()) { 
            $selected = ($selectedStudentID == $row['ID']) ? 'selected' : '';
        ?>
            <option value="<?php echo $row['ID']; ?>" <?php echo $selected; ?>><?php echo $row['Ime'] . " " . $row['Prezime']; ?></option>
        <?php } ?>
    </select>
    <br/><br/>Ime: <input type="text" name="ime" value="<?php echo $podaci['ime']; ?>" />
    <br/><br/>Prezime: <input type="text" name="prezime" value="<?php echo $podaci['prezime']; ?>" />
    <br/><br/>Adresa: <input type="text" name="adresa" value="<?php echo $podaci['adresa']; ?>" />
    <br/><br/>Grad: <input type="text" name="grad" value="<?php echo $podaci['grad']; ?>" />
    <br/><br/><input type="submit" class="action-button" name="azuriranje_btn" value="Ažuriraj" />
    <p style="color: red; margin-top: 10px;"><?php echo $errorMessage; ?></p>
    </form>
    
    </div>
</body>
</html>
