<?php
function konektujSe(){
    $host='localhost';
    $user='root';
    $pass='';
    $baza='crud_baza';
    $kon=new mysqli($host, $user, $pass, $baza);
    if($kon->connect_error) die($kon->connect_error);
    return $kon;
}

function otvoriBazu($imeBaze){
    $kon=konektujSe();
    if($kon){
        mysqli_select_db($kon, $imeBaze);
        return $kon;
    } else {
        return NULL;
    }
}

function izvrsiUpit($upit){
    $kon=otvoriBazu("crud_baza");
    if($kon){
        $rez=$kon->query($upit);
        if(!$rez) die($kon->error);
        return $rez;
    }
    return NULL;
}

function procitajSlog($uslov){
    $kon = otvoriBazu("crud_baza");
    if($uslov == 0){
        $upit = "SELECT * FROM student";
    } else {
        $upit = "SELECT * FROM student WHERE ID='".$uslov."'";
    }
    $rezultat = izvrsiUpit($upit);
    return $rezultat->fetch_array(MYSQLI_ASSOC);
}
?>
