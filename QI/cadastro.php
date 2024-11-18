<?php 
if($_SERVER ['REQUEST_METHOD']== 'POST')
if(isset($_POST['submit']))
{
   
    session_start();
    //loop para pegar a chave e o valor.
    foreach ($_POST as $chave => $valor){ 
      $_SESSION[$chave] = $valor;
    }
    include_once('sqlConnection.php');

    $erro = [];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
   
    $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
    } else{
        $erro[] = "Preencha o email corretamente ";
       
    }

  
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_URL);
    if(strlen($senha) < 6 and strlen($senha) > 12){
        $erro[] = "Preencha a senha corretamente ";
        
    }else{
       
    }


    htmlspecialchars($nome);
    if(strlen($nome) != 0){
       
    }else{
      $erro[] = "Preencha o nome.";
    }


      function validaCpf ($cpf){
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) != 11){
          $erro[] = "CPF inválido!";
          return false;
        }
        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
            $soma += $cpf * $j;
            $resto = $soma % 11;
        if ($cpf != ($resto < 2 ? 0 : 11 - $resto)){
            $erro[] = "CPF inválido!";
           return false;
        }
        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf * $j;
            $resto = $soma % 11;
        return $cpf == ($resto < 2 ? 0 : 11 - $resto);
}
validaCpf($cpf);

if (count($erro) == 0){
    $result = mysqli_query($connection, "INSERT INTO Cadastro (nome_usuario,telefone_usuario, cpf_usuario, email_usuario, senha_usuario)
        VALUES ('$nome','$telefone','$cpf','$email','$senha')");
        
        header('location:login.html');
}else{
    
}
}


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>

    <div class="background">
        <div class="logo">
            <img src="LOGO.png">
        </div>
        <div class="container">
            
            <form class="formulario" action="cadastro.php" method="POST">
                <h1>Cadastre-se</h1>
                <div class="input-group">
                    <label for="nome">Nome Completo *</label>
                    <input type="text" id="nome" name="nome" required>
                </div>

                <div class="input-group">
                    <label for="cpf">Cpf *</label>
                    <input type="cpf" id="Cpf" name="cpf" required>
                </div>

                <div class="input-group">
                    <label for="nome">Telefone *</label>
                    <input type="number" id="Telefone" name="telefone" required>
                </div>

                <div class="input-group">
                    <label for="email">E-mail *</label>
                    <input type="text" id="email" name="email" required>
                </div>

                <div class="input-group">
                    <label for="password">Crie uma Senha *</label>
                    <input type="password" id="password" name="senha" required>
                </div>
               
                <div class="input-group">
                <input type="submit"name= "submit" class="button" value="Cadastrar" id="submit">
            
                </div>

                <div class="input-login">
                    <a href="login.html">Já possuo Login > </a>
                </div>
            </form>
        </div>
       </div>
       <div class="input-p">
        <p>2024. QUEM_INDICA. </p> 
       <a href="creditos.pdf" style="color: white;">CREDITOS.</a> 
       <a href="termos-de-privacidade.pdf" style="color: white;">TERMOS DE PRIVACIDADE. </a> </div>
</body>
</html>