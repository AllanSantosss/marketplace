
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../configdb.php';

    $nome = $_POST["nome"];
    $preco = $_POST["preco"];
    $categoria_id = $_POST["categoria_id"];
    $descricao = $_POST["descricao"];
    $id = $_POST["id"];

    if (!empty($_FILES["url_img_prdt"]["name"])) {

        $target_dir = "../img/produtos/";
        $target_file = $target_dir . basename($_FILES["url_img_prdt"]["name"]);
        $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["url_img_prdt"]["tmp_name"]);
        if ($check === false) {
            header("Location: /produtos/new.php?Imagem invalida");
            exit(0);
        }

        /*
        if (file_exists($target_file)) {
            header("Location: /produtos/new.php?error=file_exists");
            exit(0);
        }
        */

        if ($_FILES["url_img_prdt"]["size"] > 500000) {
            header("Location: /produtos/new.php?Arquivo muito grande");
            exit(0);
        }

        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($extension, $allowed_extensions)) {
            header("Location: /produtos/new.php?Tipo de arquivo invalido");
            exit(0);
        }

        if (!move_uploaded_file($_FILES["url_img_prdt"]["tmp_name"], $target_file)) {
            header("Location: /produtos/new.php?Erro no carregamento do arquivo");
            exit(0);
        }
    } else {
        header("Location: /produtos/new.php?error=Nenhum arquivo selecionado");
        exit(0);
    }

    if($return !== true) {
        header ("Location: /produtos/new.php?error=" . implode(";", $return));
        exit(0);
    }

    $sql = $conn->prepare("UPDATE Produto SET nome = ?, descricao = ?, url_img_prdt = ?, preco = ?, categoria_id = ? WHERE id = ?");
    if ($sql === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    $sql->bind_param("sssidi", $nome, $descricao, $target_file, $preco, $categoria_id, $id);

    if ($sql->execute()) {
        header("Location: /produtos/index.php");
        exit();
    } else {
        echo "Erro ao executar a consulta: " . $sql->error;
    }

    $sql->close();
    $conn->close();
}
?>