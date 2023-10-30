<?php
session_start(); // počnite sesiju

require_once("funkcije.php");

$trenutni_id = $_SESSION['podaci']['id'];

$poslednji_id = izvrsiUpit("SELECT max(ID) as max_id FROM student")->fetch_assoc()['max_id'];

if ($trenutni_id < $poslednji_id) {
    $sljedeci_slog = izvrsiUpit("SELECT * FROM student WHERE ID > $trenutni_id ORDER BY ID ASC LIMIT 1")->fetch_assoc(); 

    $podaci['id'] = $sljedeci_slog['ID'];
    $podaci['ime'] = $sljedeci_slog['Ime'];
    $podaci['prezime'] = $sljedeci_slog['Prezime'];
    $podaci['adresa'] = $sljedeci_slog['Adresa'];
    $podaci['grad'] = $sljedeci_slog['Grad'];

    // Postavljanje vrijednosti u sesiju
    $_SESSION['podaci'] = $podaci;
}

// Preusmjeravanje na index.php
header("Location: index.php");
exit();
?>
