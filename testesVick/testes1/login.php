<?php
//session_start() - Cria uma sessão com base em um identificador de sessão passado por meio de uma solicitação passada pelo cookie
session_start();
//CheckUser - Olha se o usuário já está no arquivo Json
function checkUser($email, $senha, $usersExisting)
{
    foreach ($usersExisting as $user) {
        if ($user['email'] === $email && $user['senha'] === $senha) {
            return $user;
        }
    }
    return null;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $usersExisting = [];
    if (file_exists("usersJson.json")) {
        $usersExisting = json_decode(file_get_contents("usersJson.json"), true);
    }
}
if (isset($_POST["login"])) {
    $user = checkUser($email, $senha, $usersExisting);
    if ($user) {  
        $_SESSION["user"] = $user;
        $_SESSION["existing"] = $usersExisting;
        header("Location: index.php");
    } else {
        echo "Senha ou email incorretos";
    }
}
//Caso usuário aperte o botão para cadastrar
if (isset($_POST["cadastro"])) {
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Location: cadastro.php");
    exit(); 
}
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="./style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tela-login</title>
</head>
<body>
    <div class="bloco-login">
        <h1>
            <div class="ItensLogin">
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required><br><br>
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" required><br>
                    <h1>
                        <input class="iniciar" type="submit" name="login" value="Login">
                </form>
                <p>Ainda não possui cadastro?</p>
                <form action="cadastro.php" method="post">
                    <input class="iniciar" type="submit" value="Cadastrar">
                </form>
            </div>
    </div>
</body>
</html>
