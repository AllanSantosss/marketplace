<?php


require '../configdb.php';

session_start();

$erro = isset($_GET["error"]) ? $_GET["error"] : null ;

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
</head>

<body>

    <?php require '../scripts/_navbar.php'; ?>



    <section id="content">
        <div class="container" style="margin-top: 100px;">
            <div class="row">

            <?php if (!empty($erro)) { ?>
            <p class="alert alert-danger"><?php echo $erro; ?></p>
            <?php } ?>

                
                <div class="col-md-9">
                    <h2>Cadastro de produtos</h2>

                    <div class="form-group row" style="margin-bottom: 30px !important;">

                        <form style="margin-bottom: 50px;" action="/produtos/create.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group row" style="margin-bottom: 15px !important;">
                                <label for="nome" class="col-sm-2 col-form-label">Nome</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nome" name="nome">
                                </div>
                            </div>

                            <div class="form-group row" style="margin-bottom: 15px !important;">

                                <label for="imagem" class="col-sm-2 col-form-label">Imagem</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-contro-file" id="imagem" name="imagem">
                                </div>
                            </div>

                            <div class="form-group row" style="margin-bottom: 15px !important;">
                                <label for="preco" class="col-sm-2 col-form-label">Preco</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="preco" name="preco">
                                </div>
                            </div>

                            <div class="form-group row" style="margin-bottom: 15px !important;">
                                <label for="categoria" class="col-sm-2 col-form-label">Categoria</label>
                                <div class="col-sm-10">

                                    <select class="form-control" name="categoria_id" id="categoria">
                                        <?php
                                        $sql = "SELECT * FROM Categoria order by id;";

                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                        ?>

                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['nome']; ?></option>
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
                                    <textarea name="descricao" id="descricao" cols="80" rows="05"></textarea>
                                </div>
                            </div>


                            <div class="d-flex justify-content-between align-items-center" >
                                <p></p>
                                <input type="submit" value="cadastrar" class="btn btn-success">
                            </div>
                        </form>

                    </div>

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