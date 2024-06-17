<?php
require_once("../config/database.php");

$noticia_id = $_GET['id'];

$sql = "Select * from noticias where id = :noticia_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":noticia_id", $noticia_id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$row){
    header("Location: painel.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Notícia</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
 
<body>
    <section class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Editar Notícia</h2>
                <?php
                    if ($row) {
                        $tituloAtual = $row['titulo'];
                        $noticiaAtual = $row['noticia'];
                        $imagemAtual = $row['imagem'];
 
                        // Exibe o formulário preenchido com as informações atuais
                        echo '<form action="../config/processar_editar_noticia.php" method="POST" enctype="multipart/form-data">';
                        echo '<div class="form-group">';
                        echo '<label for="titulo">Título:</label>';
                        echo '<input type="text" class="form-control" id="titulo" name="titulo" value="' . htmlspecialchars($tituloAtual) . '" required>';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label for="noticia">Notícia:</label>';
                        echo '<textarea class="form-control" id="noticia" name="noticia" rows="5" required>' . htmlspecialchars($noticiaAtual) . '</textarea>';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label for="imagem">Imagem:</label>';
                        echo '<input type="file" class="form-control" id="imagem" name="imagem">';
                        echo '</div>';
                        echo '<input type="hidden" name="id" value="' . $noticia_id . '">';
                        echo '<input type="hidden" name="imagem_atual" value="' . htmlspecialchars($imagemAtual) . '">';
                        echo '<button type="submit" class="btn btn-primary">Salvar Alterações</button>';
                        echo '</form>';
                    } else {
                        echo '<p>Notícia não encontrada.</p>';
                    }
                ?>
 
            </div>
        </div>
    </section>
 
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
 
</html>