<?php
require '../configdb.php';

session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../login.php");
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <link rel="stylesheet" href="/css/style.css" />
   
    <link rel="stylesheet" href="/css/bootstrap-grid.css">
    
</head>

<body>

    <?php require '../scripts/_navbar.php'; ?>
    <section id="content">
        <div class="container">
            <div class="row">

                <?php
                $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

                $sql = "SELECT Produto.id, Produto.nome, Produto.descricao, Produto.preco, Produto.url_img_prdt, Categoria.nome AS categoria_nome FROM Produto JOIN Categoria ON Produto.categoria_id = Categoria.id WHERE Produto.id = $id";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Seu código aqui
                ?>
                        <div class="col-md-9 produto">
                            <div class="produto border">
                                <h2>
                                    <?php echo $row['nome']; ?>
                                    


                                </h2>
                                <tr>
                                    <h2>Preco</h2>
                                    <h4>€<?php echo $row['preco']; ?></h4>

                                    <h4>Categoria</h4>
                                    <dd><?php echo $row['categoria_nome']; ?></dd>

                                    <td>
                                        <?php if ($row['url_img_prdt']) { ?>
                                            <img src="<?php echo $row['url_img_prdt']; ?>" class="img-fluid" alt="<?php echo $row['nome']; ?>">
                                        <?php } else { ?>
                                            <img src="/img/imagem.png" alt="<?php echo $row['nome']; ?>">
                                        <?php } ?>

                                        <td>
                                    <a href="/chat/produtochat.php"  class="btn btn-sm btn-success"  >Contactar</a>
                                    </td>
                                        

                                    </td>

                                    <dt>Descricao</dt>
                                    <td><?php echo $row['descricao']; ?></td>

                                </tr>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<div class='col-md-9'><h2>Nenhum produto encontrado</h2></div>";
                }
                ?>
            </div>
        </div>     

    </section>

    <main></main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    
</body>

</html>