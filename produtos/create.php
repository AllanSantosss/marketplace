<?php

require '../configdb.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $preco = $_POST["preco"];
    $categoria_id = $_POST["categoria_id"];
    $descricao = $_POST["descricao"];
    $userId = $_SESSION["id"];

    

    if (!empty($_FILES["imagem"]["name"])) {

        $target_dir = "../img/produtos/";
        $target_file = $target_dir . basename($_FILES["imagem"]["name"]);
        $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["imagem"]["tmp_name"]);
        if ($check === false) {
            header("Location: /produtos/new.php?error=invalid_image");
            exit();
        }
        /*
        if (file_exists($target_file)) {
            header("Location: /produtos/new.php?error=file_exists");
            exit(0);
        }
        */
        if ($_FILES["imagem"]["size"] > 500000) {
            header("Location: /produtos/new.php?error=file_too_large");
            exit();
        }

        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($extension, $allowed_extensions)) {
            header("Location: /produtos/new.php?error=invalid_extension");
            exit();
        }

        if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
            header("Location: /produtos/new.php?error=file_upload_failed");
            exit();
        }
    } else {
        header("Location: /produtos/new.php?error=no_file_selected");
        exit();
    }

    if(isset($return) && $return !== true) {
        header ("Location: /produtos/new.php?error=" . implode(";", $return));
        exit();
    }

    $sql = $conn->prepare("INSERT INTO Produto(nome, descricao, url_img_prdt, preco, categoria_id, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param("sssdis", $nome, $descricao, $target_file, $preco, $categoria_id, $userId);

    if ($sql->execute()) {
        header("Location: /produtos");
    } else {
        echo "Erro: " . $sql->error;
    }
}

$conn->close();

?>
