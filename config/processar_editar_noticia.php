<?php
// Inclui o arquivo de configuração e conexão com o banco de dados
require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $noticia_id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $noticia = $_POST['noticia'];
    $imagem_atual = $_POST['imagem_atual'];
 
    // Verifica se foi enviado um novo arquivo de imagem
    if ($_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../perfil/img/';  // Substitua pelo caminho correto
       
        // Gera um nome único para a imagem usando uniqid()
        $nome_unico = uniqid();
        $nova_imagem = $nome_unico . '_' . $_FILES['imagem']['name'];
        $uploadPath = $uploadDir . $nova_imagem;
 
        move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadPath);

        // Atualiza a imagem no banco de dados
        $sqlUpdateImagem = "UPDATE noticias SET imagem = :imagem WHERE id = :id";
        $stmtUpdateImagem = $conn->prepare($sqlUpdateImagem);
        $stmtUpdateImagem->bindParam(':imagem', $nova_imagem);
        $stmtUpdateImagem->bindParam(':id', $noticia_id);
        $stmtUpdateImagem->execute();

        // Remove a imagem anterior, se existir
        if (!empty($imagem_atual) && file_exists($uploadDir . $imagem_atual)) {
            unlink($uploadDir . $imagem_atual);
        }
    }

    // Atualiza os outros campos da notícia
    $sql = "UPDATE noticias SET titulo = :titulo, noticia = :noticia WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':noticia', $noticia);
    $stmt->bindParam(':id', $noticia_id);
   
    if ($stmt->execute()) {
        header("Location: ../perfil/painel.php");  // Redireciona para a página do painel
        exit();
    } else {
        echo "Erro ao atualizar a notícia.";
    }
}
?>