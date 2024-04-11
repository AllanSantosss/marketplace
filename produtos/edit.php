<?php

$erro = isset($_GET["error"]) ? $_GET["error"] : null;

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    require '../configdb.php';

    $sql = $conn->prepare("SELECT * FROM Produto WHERE id = ?");
    $sql->bind_param("i", $_GET["id"]);
    $sql->execute();
    $resultproduto = $sql->get_result();
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

                <?php if (!empty($erro)) { ?>
                    <p class="alert alert-danger"><?php echo $erro; ?></p>
                <?php } ?>


                <?php

                if ($resultproduto->num_rows > 0) {


                    while ($rowproduto = $resultproduto->fetch_assoc()) {
                ?>

                        <div class="col-md-9">
                            <h2>Edicao de produto</h2>

                            <div class="form-group row" style="margin-bottom: 30px !important;">

                                <form action="/produtos/update.php" style="margin-bottom: 50px;" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $rowproduto['id']; ?>">
                                    <div class="form-group row" style="margin-bottom: 15px !important;">
                                        <label for="nome" class="col-sm-2 col-form-label">Nome</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $rowproduto['nome']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row" style="margin-bottom: 15px !important;">
                                        <label for="imagem" class="col-sm-2 col-form-label">Imagem Atual</label>
                                        <div class="col-sm-10">
                                            <?php if ($rowproduto['url_img_prdt']) { ?>
                                                <img src="<?php echo $rowproduto['url_img_prdt']; ?>" alt="<?php echo $row['nome']; ?>">
                                            <?php } else { ?>
                                                <img src="/img/imagem.png" alt="<?php echo $row['nome']; ?>">
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="form-group row" style="margin-bottom: 15px !important;">
                                        <label for="imagem" class="col-sm-2 col-form-label">Nova Imagem</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-contro-file" id="imagem" name="url_img_prdt">
                                        </div>
                                    </div>

                                    <div class="form-group row" style="margin-bottom: 15px !important;">
                                        <label for="preco" class="col-sm-2 col-form-label">Preco</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="preco" name="preco" value="<?php echo $rowproduto['preco']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row" style="margin-bottom: 15px !important;">
                                        <label for="categoria" class="col-sm-2 col-form-label">Categoria</label>
                                        <div class="col-sm-10">

                                            <select class="form-control" name="categoria_id" id="categoria">
                                                <?php
                                                $sql = "SELECT * FROM Categoria order by id;";

                                                $resultcategoria = $conn->query($sql);

                                                if ($resultcategoria->num_rows > 0) {
                                                    while ($rowcategoria = $resultcategoria->fetch_assoc()) {
                                                ?>

                                                        <option <?php echo ($rowproduto["categoria_id"] == $rowcategoria["id"]) ? "selected" : "" ?> value="<?php echo $rowcategoria['id']; ?>"><?php echo $rowcategoria['nome']; ?></option>

                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <option value="">Nenhuma categoria encontrada</option>
                                                <?php
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group row" style="margin-bottom: 15px !important;">
                                        <label for="descricao" class="col-sm-2 col-form-label">Descricao</label>
                                        <div class="col-sm-10">
                                            <textarea name="descricao" id="descricao" cols="80" rows="06"><?php echo $rowproduto['descricao']; ?></textarea>
                                        </div>
                                    </div>


                                    <div class="d-flex justify-content-between align-items-center">
                                        <p></p>
                                        <input type="submit" value="Atualizar" class="btn btn-success">
                                    </div>
                            </div>
                            </form>
                        </div>
            </div>
    <?php
                    }
                }


    ?>
    </section>

    <main></main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->

</body>

</html>