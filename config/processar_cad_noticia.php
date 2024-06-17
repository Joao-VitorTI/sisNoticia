<?php
session_start();
// Verifica se os usuário está logado
if(!isset($_SESSION["usuario_id"])){
    // Se Sessão com Login não existir
    header("Location: ../index.php"); //Redireciona para index
    exit();
}

require_once("../config/database.php");

// Captura e sanatiza os dados
$titulo = htmlspecialchars($_POST['titulo'], ENT_QUOTES, "UTF-8");
$noticia = htmlspecialchars($_POST['noticia'], ENT_QUOTES, "UTF-8");

// Processamento da imagem
$imagem_temp = $_FILES["imagem"]["tmp_name"];
// Captura a extensão da imagem
$extensao = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
// Gera um nome unico
$nome_imagem = uniqid().".".$extensao;

// Move a imagem da pasta temporaria para a pasta que queremos
move_uploaded_file($imagem_temp,"../perfil/img/".$nome_imagem);

// Cadastrar no banco de dados a noticia

try{
    $stmt = $conn->prepare("INSERT INTO noticias (titulo,noticia,imagem) values (:titulo,:noticia,:imagem)");
    $stmt->bindParam(":titulo",$titulo);
    $stmt->bindParam(":noticia",$noticia);
    $stmt->bindParam(":imagem",$nome_imagem);
    $stmt->execute();

    echo "Noticia Cadastrada com sucesso !";
    echo "<meta http-equiv='refresh' content='5;../perfil/cadastrar_noticia.php'>";
}catch(PDOException $e){
    echo "Erro ao Cadastrar a Notica ".$e->getMessage();
}