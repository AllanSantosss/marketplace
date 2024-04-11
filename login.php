

<?php 
require "configdb.php";

session_start();

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $sql = $conn->prepare("SELECT * FROM Usuarios WHERE email LIKE ? AND confirmed = 1;");
    $sql->bind_param("s", $_POST["email"]);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (password_verify($_POST["password"], $row["senha"])) {
                session_start();
                $_SESSION["id"] = $row["id"];
                $_SESSION["email"] = $row["email"];
                header("Location: /index.php");
                exit();
            } else {
                echo "Senha incorreta.";
            }
        }
    } else {
        echo "Usuário não encontrado ou conta não confirmada.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="/css/style.css" />
    <title>Login</title>
    
</head>
<body>
    <div class="form-container">

    <?php if (!(isset($_POST["email"]) && isset($_POST["password"]))) { ?>

        
        <form action="#" method="POST">
        <h3>Login</h3>
        <input id="email" type="email" name="email" required placeholder="introduzir email" class="box">
        <input id="password" type="password" name="password" required placeholder="Introduzir password" class="box">
        <input type="submit" name="submit" class="btn btn-success" value="Login">
        <p>Ainda nao tem uma conta? <a href="register.php">Registe-se aqui</a></p>
        </form>
        <?php } else {
            
       
        }

        
        ?>
    </div>
    
    
</body>
</html>