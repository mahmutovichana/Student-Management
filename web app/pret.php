<?php
session_start(); // počnite sesiju

require_once("funkcije.php");

$trenutni_id = $_SESSION['podaci']['id'];

if ($trenutni_id > 1) {
    $prethodni_slog = izvrsiUpit("SELECT * FROM student WHERE ID < $trenutni_id ORDER BY ID DESC LIMIT 1")->fetch_assoc(); 

    $podaci['id'] = $prethodni_slog['ID'];
    $podaci['ime'] = $prethodni_slog['Ime'];
    $podaci['prezime'] = $prethodni_slog['Prezime'];
    $podaci['adresa'] = $prethodni_slog['Adresa'];
    $podaci['grad'] = $prethodni_slog['Grad'];

    // Postavljanje vrijednosti u sesiju
    $_SESSION['podaci'] = $podaci;
}

// Preusmjeravanje na index.php
header("Location: index.php");
exit();
?>
