<?php
require 'configdb.php';

session_start();

?>
<!doctype html>
<html lang="en">

<head>
    <title>Market Place</title>

    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="/css/style.css" />
    
    
</head>

<body>

    <?php require 'scripts/_navbar.php'; ?>

    <section id="content" class="pb-4">
        <div class="container">
            <div class="row">
                <?php include 'scripts/_sidebar.php'; ?>
                <div class="col-md-9">
                    <h2>Produtos</h2>
                    <div class="row">
                        <?php   
                                             

                        //$sql = "SELECT Produto.id, Produto.nome, Produto.descricao, Produto.preco, Produto.url_img_prdt, Categoria.nome AS categoria_nome FROM Produto JOIN Categoria ON Produto.categoria_id = Categoria.id ORDER BY Produto.id;";
                        
                        $result = $conn->query($sql);
                        if(isset($_GET["categoria_id"])){
                            $categoria_id = $_GET["categoria_id"];
                        
                            // Se categoria_id estiver presente, busca apenas os produtos dessa categoria
                            $sql = "SELECT Produto.id, Produto.nome, Produto.descricao, Produto.preco, Produto.url_img_prdt, Categoria.nome AS categoria_nome 
                            FROM Produto 
                            JOIN Categoria ON Produto.categoria_id = Categoria.id 
                            WHERE Categoria.id = $categoria_id 
                            ORDER BY Produto.id";
                        } else {
                            // Se categoria_id não estiver presente, busca todos os produtos
                            $sql = "SELECT Produto.id, Produto.nome, Produto.descricao, Produto.preco, Produto.url_img_prdt, Categoria.nome AS categoria_nome FROM Produto JOIN Categoria ON Produto.categoria_id = Categoria.id ORDER BY Produto.id;";
                        }
                        
                        $result = $conn->query($sql);                        
                        

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <div class="col-md-4 produto d-flex">
                                    <div class="produto border mb-4 d-flex flex-column h-100">
                                        <h2><?php echo $row['nome']; ?></h2>
                                        <dl>
                                            <dt>Preço</dt>
                                            <dd>€ <?php echo $row['preco']; ?></dd>
                                            <dt>Categoria</dt>
                                            <dd><?php echo $row['categoria_nome']; ?></dd>
                                            <dt>Imagem</dt>
                                            <dd>
                                                <?php if ($row['url_img_prdt']) : ?>
                                                    <img src="<?php echo $row['url_img_prdt']; ?>" alt="<?php echo $row['nome']; ?>" class="img-fluid">
                                                <?php else : ?>
                                                    <img src="/img/imagem.png" alt="<?php echo $row['nome']; ?>" class="img-fluid">
                                                <?php endif ?>
                                            </dd>
                                            <dt>Descrição</dt>
                                            <dd><?php echo substr($row['descricao'], 0, 140) . "..."; ?></dd>
                                        </dl>
                                        <a href="/produtos/show.php?id=<?php echo $row['id']; ?>" class="btn btn-success mt-auto">Saber mais</a>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<p>Não existem resultados para esta pesquisa</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main></main>

    <?php include 'scripts/_footer.php';  ?>

    <!-- Bootstrap JavaScript Libraries -->
    

</body>

</html>