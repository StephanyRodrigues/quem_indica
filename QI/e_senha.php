<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Valida se todos os campos necessários foram enviados
    $email = $_POST['email'] ?? null;
    $novaSenha = $_POST['nova_senha'] ?? null;
    $confirmaSenha = $_POST['confirma_senha'] ?? null;

    if (!$email || !$novaSenha || !$confirmaSenha) {
        echo "Por favor, preencha todos os campos.";
    } elseif ($novaSenha !== $confirmaSenha) {
        echo "As senhas não coincidem.";
    } else {
        try {
            // Verifica se o e-mail existe
            $sql = "SELECT * FROM cadastro WHERE email_usuario = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                // Atualiza a senha no banco
                $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT); // Criptografia
                $updateSql = "UPDATE cadastro SET senha_usuario = ? WHERE email_usuario = ?";
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->execute([$novaSenhaHash, $email]);

                echo "";
            } else {
                echo "Usuário não encontrado.";
            }
        } catch (PDOException $e) {
            echo "Erro ao processar a solicitação: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senha</title>
    <link rel="stylesheet" href="e_senha.css">
</head>
<body>
    <div class="background">
        <div class="logo">
            <img src="LOGO.png">
        </div>
        <div class="container">
            <form class="formulario" action="#" method="POST">
                <h1>Redefinir Senha</h1>
                
                <div class="input-group">
                    <label for="email">E-mail *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="nova_senha">Nova Senha *</label>
                    <input type="password" id="nova_senha" name="nova_senha" required>
                                </div>
                <div class="input-group">
                    <label for="password">Confirme Nova Senha *</label>
                    <input type="password" id="confirma_senha" name="confirma_senha" required>
                </div>
                
                <div class="input-button">
                    <input type="submit" value="Redefinir Senha" class="button" >
                </div>
                <div class="input-esenha">
                    <a href="index.php"> Login > </a>
                </div>
                
            </form>
        </div>
        </div>
        <div class="input-p">
            <p>2024. QUEM_INDICA. </p> 
           <p><a href="creditos.pdf" style="color: white;">CREDITOS.</a> </p>
           <a href="termos-de-privacidade.pdf" style="color: white;">TERMOS DE PRIVACIDADE. </a> </div>
</body>
</html>
