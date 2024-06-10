<?php
session_start();
// Verifica se os usuário está logado
if(!isset($_SESSION["usuario_id"])){
    // Se Sessão com Login não existir
    header("Location: ../index.php"); //Redireciona para index
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Construir local pra trazer os dados banco -->
    <div>
        <h2>Painel do Usuário</h2>
        <p>
            Bem vindo, <?php echo $_SESSION["usuario_nome"]; ?>
        </p>
        <p>
            <a href="../config/logout.php">Sair</a>
            <a href="cadastrar_noticia.php">Cadastrar Noticias</a>
        </p>
    </div>
</body>
</html>