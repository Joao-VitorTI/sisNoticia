<?php
require_once("../config/database.php");

$noticia_id = $_GET['id'];

try{
    $sql = "DELETE FROM noticias where id = :noticia_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":noticia_id",$noticia_id,PDO::PARAM_INT);
    $stmt->execute();

    header("Location: painel.php");
    exit();
}catch(PDOException $e){
    echo "Erro no banco de dados".$e->getMessage();
}