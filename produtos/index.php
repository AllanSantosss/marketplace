<?php
require '../configdb.php';

session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../login.php");
    exit();
}

if(isset($_POST["mensagem"])){

    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sql = $conn->prepare("INSERT INTO Mensagens(remetente_id, destinatario_id, produto_id, mensagem, timestamp) VALUES (?,?,?,?,?)");
    $sql->execute($mensagem);
    exit();

}


?>

<!doctype html>
<html lang="en">

<head>
    <title>Produtos</title>

    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />   
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    
    <link rel="stylesheet" href="/css/style.css" />
    
    <link rel="stylesheet" href="/css/bootstrap-grid.css">
    <link rel="stylesheet" href="/css/chat.css" />
    
</head>

<body>

    <?php require '../scripts/_navbar.php'; ?>



    <section id="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h2 class="d-flex justify-content-between align-items-center">
                        Os Meus produtos
                        <a href="/produtos/new.php" class="btn btn-success">Novo produto</a>
                    </h2>


                    <div class="table-responsive">
                        <table class="table text-center">
                            <tr>
                                <th>ID</th>
                                <th>FOTO</th>
                                <th>NOME</th>
                                <th>PRECO</th>
                                <th>CATEGORIA</th>
                                <th>ACOES</th>

                            </tr>
                            <?php

                            $userId = $_SESSION["id"];

                            $sql = "SELECT Produto.id, produto.url_img_prdt, Produto.nome, Produto.preco, Categoria.nome AS categoria_nome FROM Produto JOIN Categoria ON Produto.categoria_id = Categoria.id WHERE Produto.user_id = $userId ORDER BY Produto.id;";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td class="align-middle"><?php echo $row["id"]; ?></td>
                                        <td class="align-middle">
                                            <?php if ($row["url_img_prdt"]) { ?>
                                                <img src="<?php echo $row['url_img_prdt']; ?>" class="produto-img" alt="">
                                            <?php } else { ?>
                                                <img src="/img/imagem.png" class="produto-img" alt="<?php echo $row['nome']; ?> ">
                                            <?php } ?>
                                        </td>
                                        <td class="align-middle"><?php echo $row["nome"]; ?></td>
                                        <td class="align-middle">€<?php echo $row["preco"]; ?></td>
                                        <td class="align-middle"><?php echo $row["categoria_nome"]; ?></td>
                                        <td class="align-middle">
                                            <a href="/produtos/show.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-primary">Mostrar</a>
                                            <a href="/produtos/edit.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-warning">Editar</a>
                                            <a href="/produtos/delete.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Voce realmente deseja excluir este produto: <?php echo $row['nome']; ?> ?');">Excluir</a>

                                        </td>

                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='3'>Não existêm resultados para esta pesquisa</td></tr>";
                            }

                            ?>


                        </table>                        
                    </div>
                </div>
                
            </div>
        </div>         

    </section> 

    <main></main>



    <?php
    require "../scripts/_footer.php";
    ?>


    <!-- Bootstrap JavaScript Libraries -->
   

</body>

</html>