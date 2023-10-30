<?php
session_start(); // počnite sesiju
require_once("funkcije.php");

$kon = konektujSe();
$errorMessage = "";

if(isset($_POST['bris_btn'])) {
    $selectedStudentID = $_POST['student_id'];
    if ($selectedStudentID === "") {
        $errorMessage = "Nije odabran nijedan student.";
    } else {
        izvrsiUpit("DELETE FROM student WHERE ID = $selectedStudentID");
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Brisanje studenta</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="icon" type="image/png" href="logo.png">
</head>
<body>
    <h1>Brisanje studenta</h1>
    <div id="mainPart">
    <form action="bris.php" name="f1" method="post" id="dataForm">
    <label for="student_id">Odaberite studenta za brisanje:</label>
    <select name="student_id">
        <option value="">Odaberi studenta</option>
        <?php
        $result = $kon->query("SELECT ID, Ime, Prezime FROM student");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["ID"] . "'>" . $row["Ime"] . " " . $row["Prezime"] . "</option>";
            }
        }
        ?>
    </select>
    <br/><br/><input type="submit" class="action-button" name="bris_btn" value="Obriši" />
    <p style="color: red; margin-top: 10px;"><?php echo $errorMessage; ?></p>
    </form>
    </div>
</body>
</html>
