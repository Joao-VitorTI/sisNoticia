<?php
session_start();
// Verifica se o usuário está logado
if(!isset($_SESSION["usuario_id"])){
    // Se Sessão com Login não existir
    header("Location: ../index.php");// Redireciona para index
    exit();
}

// Busca no banco de dados as noticias
try{
    require_once('../config/database.php');
    $sql = "Select * from noticia";
    $resul = $conn->query($sql);
}catch(PDOException $e){
    echo "Erro no banco de dados".$e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Construir local para trazer os dados do banco -->
    <div>
        <h2>Painel do Usuário</h2>
        <p>
            Bem Vindo,<?php echo $_SESSION["usuario_nome"];?>
        </p>
        <p>
            <a href="../config/logout.php">Sair</a>
            <a href="cadastrar_noticia.php">Cad Noticia</a>
        </p>
        <hr>
        <h3>Noticias : </h3>
        <ul>
            <?php
            // Exibe as notícias 
            while($row = $resul->fetch(PDO::FETCH_ASSOC))
            {
                echo "<li>";
                echo "<strong>Titulo:</strong>".$row['titulo']."<br>";
                echo "<strong>Notícia:</strong>".$row['noticia']."<br>";
                echo "<img src='img/".$row['imagem']."'>";
                echo "<br>";
                echo "<a href='editar_noti.php?id=".$row['id']."'>Editar</a>";
                echo "<a href='excluir_noti.php?id=".$row['id']."'>Excluir</a>";
                echo "</li><br><hr>";
            }
            ?>
        </ul>
    </div>
</body>
</html>