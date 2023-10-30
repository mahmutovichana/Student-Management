<?php
session_start(); // počnite sesiju

require_once("funkcije.php");

$poslednji_slog = izvrsiUpit("SELECT * FROM student ORDER BY ID DESC LIMIT 1")->fetch_assoc(); 

$podaci['id'] = $poslednji_slog['ID'];
$podaci['ime'] = $poslednji_slog['Ime'];
$podaci['prezime'] = $poslednji_slog['Prezime'];
$podaci['adresa'] = $poslednji_slog['Adresa'];
$podaci['grad'] = $poslednji_slog['Grad'];

// Postavljanje vrijednosti u sesiju
$_SESSION['podaci'] = $podaci;

// Preusmjeravanje na index.php
header("Location: index.php");
exit();
?>
