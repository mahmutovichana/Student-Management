<?php
session_start(); // počnite sesiju

require_once("funkcije.php");

$prvi_slog = izvrsiUpit("SELECT * FROM student ORDER BY ID ASC LIMIT 1")->fetch_assoc(); 

$podaci['id'] = $prvi_slog['ID'];
$podaci['ime'] = $prvi_slog['Ime'];
$podaci['prezime'] = $prvi_slog['Prezime'];
$podaci['adresa'] = $prvi_slog['Adresa'];
$podaci['grad'] = $prvi_slog['Grad'];

// Postavljanje vrijednosti u sesiju
$_SESSION['podaci'] = $podaci;

// Preusmjeravanje na index.php
header("Location: index.php");
exit();
?>
