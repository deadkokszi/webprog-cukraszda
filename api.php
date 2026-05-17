<?php

header("Content-Type: application/json; charset=utf-8");
$conn = mysqli_connect("localhost","root","","cukraszda");
mysqli_set_charset($conn,"utf8");
$method = $_SERVER['REQUEST_METHOD'];

if($method == "GET"){
    $sql = "SELECT * FROM suti";
    $result = mysqli_query($conn,$sql);
    $adatok = [];
    while($row = mysqli_fetch_assoc($result)){
        $adatok[] = $row;
    }
    echo json_encode($adatok,JSON_UNESCAPED_UNICODE);
}

if($method == "POST"){
    $data = json_decode(file_get_contents("php://input"));
    $nev = $data->nev;
    $tipus = $data->tipus;
    $dijazott = $data->dijazott;

    $sql = "INSERT INTO suti(nev,tipus,dijazott)
            VALUES('$nev','$tipus','$dijazott')";
            
    mysqli_query($conn,$sql);
    echo json_encode(["uzenet"=>"Siker"]);
}

if($method == "DELETE"){
    $id = $_GET['id'];
    $sql = "DELETE FROM suti WHERE id=$id";
    mysqli_query($conn,$sql);
    echo json_encode(["uzenet"=>"Torolve"]);
}

if($method == "PUT"){
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;
    $nev = $data->nev;
    $tipus = $data->tipus;
    $dijazott = $data->dijazott;

    $sql = "UPDATE suti
            SET nev='$nev',
            tipus='$tipus',
            dijazott='$dijazott'
            WHERE id=$id";

    mysqli_query($conn,$sql);
    echo json_encode(["uzenet"=>"Modositva"]);
}

?>