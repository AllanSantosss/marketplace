<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require 'configdb.php';
$error_message = "";
$success_message = "";
if (
    isset($_POST["username"]) && isset($_POST["email"])
    && isset($_POST["password"]) && isset($_POST["conf_password"])
) {
    //Verificar se o utilizador existe com mesmo nome
    $verify_username = $conn->prepare("SELECT * FROM Usuarios WHERE username Like ?;");
    $verify_username->bind_param("s", $_POST["username"]);
    $verify_username->execute();
    $result = $verify_username->get_result();
    if ($result->num_rows > 0) {
        $error_message = $error_message . "O utilizador já existe!! <br>";
    }
    //Verificar se o utilizador existe com mesmo email
    $verify_mail = $conn->prepare("SELECT * FROM Usuarios WHERE email Like ?;");
    $verify_mail->bind_param("s", $_POST["email"]);
    $verify_mail->execute();
    $result = $verify_mail->get_result();
    if ($result->num_rows > 0) {
        $error_message = $error_message . "O email já se encontra registrado!!<br>";
    }

    if ($_POST["conf_password"] != $_POST["password"]) {
        $error_message = $error_message . "As passwords não combinam!!<br>";
    }

    if ($error_message == "") {
        // Cálculo do hash da senha
        $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        // Código único para futura validação da conta
        $code = substr(md5(uniqid(mt_rand(), true)), 0, 20);

        #Preparo a query de insert e não desbloqueio o user ainda
        $sql = $conn->prepare("INSERT INTO Usuarios(username,nome,email,senha,confirmed,confirmation_code) VALUES (?,?,?,?,?,?);");
        $bool = 0;
        $sql->bind_param("ssssis", $_POST["username"], $_POST["nome"], $_POST["email"], $hashed_password, $bool, $code);
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.sapo.pt';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'allansantos@sapo.pt';                     //SMTP username
            $mail->Password   = 'TesteAula123!';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('allansantos@sapo.pt', 'Mailer');
            $mail->addAddress($_POST["email"], $_POST["username"]);     //Add a recipient  


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Confirma a tua conta';
            $mail->Body    = '<a href="http://localhost/confirmaccount.php?useremail=' . $_POST["email"] . '&confirm_code=' . $code . '">Confirma a tua conta</a>';

            $mail->send();
        } catch (Exception $e) {
            $error_message = $error_message . "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
        }


        if ($sql->execute()) {
            $success_message = "Confirme a sua conta de email";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="/css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="/css/style.css" />
</head>

<body>
    <div class="form-container">
        <form action="" method="POST">
            <h3>Registe-se agora</h3>
            <input type="text" name="username" required placeholder="Insira o Username" class="box">
            <input type="email" name="email" required placeholder="Insira o email" class="box">
            <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" name="password" required placeholder="Insira a password" class="box">
            <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" name="conf_password" required placeholder="confirme a password" class="box">
            <input type="submit" name="submit" class="btn btn-success" value="register now">
            <p>Ja tem uma conta? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>

</html>