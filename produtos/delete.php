<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    // Conecte-se ao banco de dados
    require '../configdb.php';

    // Prepare a instrução SQL
    $sql = $conn->prepare("DELETE FROM Produto WHERE id = ?;");

    // Vincule o valor do campo 'nome' do formulário à instrução SQL
    $sql->bind_param("i", $_GET["id"]);

    // Execute a instrução SQL
    if ($sql->execute()) {
        header("Location: /produtos/index.php");
    } else {
        echo "Erro: " . $sql->error;
    }

    // Feche a conexão
    $conn->close();
    }

?>