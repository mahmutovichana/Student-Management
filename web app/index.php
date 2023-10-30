<?php
session_start(); // Početi sesiju
require_once("funkcije.php");
// Provjeriti postoji li vrijednost 'podaci' u sesiji
if(isset($_SESSION['podaci'])) {
    $podaci = $_SESSION['podaci'];
} else {
    // Postaviti prazne vrijednosti ako ne postoji
    $podaci = array(
        'id' => '',
        'ime' => '',
        'prezime' => '',
        'adresa' => '',
        'grad' => ''
    );
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>WEB CRUD Aplikacija</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="icon" type="image/png" href="logo.png">

</head>
<body>
    <h1>Student Management System</h1>
    <div id="mainPart">
    <form action="index.php" name="f1" method="post" id="dataForm">
    <br/>ID: <input type="text" name="id" value="<?php echo $podaci['id']; ?>" />
    <br/><br/>Ime: <input type="text" name="ime" value="<?php echo $podaci['ime']; ?>" />
    <br/><br/>Prezime: <input type="text" name="prezime" value="<?php echo $podaci['prezime']; ?>" />
    <br/><br/>Adresa: <input type="text" name="adresa" value="<?php echo $podaci['adresa']; ?>" />
    <br/><br/>Grad: <input type="text" name="grad" value="<?php echo $podaci['grad']; ?>" />
    </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Adresa</th>
                <th>Grad</th>
            </tr>
            <?php
            $kon = konektujSe();
            $result = $kon->query("SELECT * FROM student");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["Ime"] . "</td><td>" . $row["Prezime"] . "</td><td>" . $row["Adresa"] . "</td><td>" . $row["Grad"] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align: center;'>Nema rezultata</td></tr>";
            }
            $kon->close();
            ?>
        </table>
        <div id="buttons">
            <form action="prvi.php" method="post">
                <input type="submit" class="action-button" name="prvi" value="Prvi" />
            </form>
            <form action="pret.php" method="post">
                <input type="submit" class="action-button" name="pret" value="Prethodni" />
            </form>
            <form action="unos.php" method="post">
                <input type="submit" class="action-button" name="unos" value="Unos" />
            </form>
            <form action="azur.php" method="post">
                <input type="submit" class="action-button" name="azur" value="Ažuriranje" />
            </form>
            <form action="bris.php" method="post">
                <input type="submit" class="action-button" name="bris" value="Brisanje" />
            </form>
            <form action="sljed.php" method="post">
                <input type="submit" class="action-button" name="sljed" value="Sljedeći" />
            </form>
            <form action="zadnji.php" method="post">
                <input type="submit" class="action-button" name="zadnji" value="Zadnji" />
            </form>
        </div>


    </div>


</body>
</html>

