<?php 

    include('headerLogin.php');

    session_start(); // sempre na primeira linha e usar em todos os arquivos que vão usar sessão

    $erro = "";
    $classEmail = "";
    $valueEmail = "";
    $classSenha = "";

    if($_POST) {
        $usuariosJson = file_get_contents('./includes/usuarios.json');
        $usuariosArray = json_decode($usuariosJson, true);

        // se $usuariosArray não for vazia entra no foreach
        if(!empty($usuariosArray)) {
            foreach($usuariosArray as $usuario) {
                if($_POST['email'] == $usuario['email'] && password_verify($_POST['senha'], $usuario['senha'])) {
                    // essa linha irá definir a sessão usuraio
                    $_SESSION['usuario'] = $usuario; //definindo uma sessão pro usuario e guardando a informação dele
                    // essa linha irá redirecionar o usuario para o index.php
                    return header('Location: indexProdutos.php');
                } 
            } 
            $erro = 'Usuário e senha não coincidem';
        // senão 
        } else {
            $erro = "Nenhum usuário cadastrado";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script defer src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" 
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" 
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script defer src="https://kit.fontawesome.com/c9300953f9.js" crossorigin="anonymous"></script>
</head>
<body>
    <main class="container text-center">
        <form action="" method="POST">

            <div class="row d-flex flex-column align-items-center my-5 px-5">

                <div class="form-group col-6">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?= $valueEmail ?>">
                </div>

                <div class="form-group col-6">
                    <label for="exampleInputPassword1">Senha</label>
                    <input type="password" name="senha" class="form-control" id="senha">
                </div>

                <p class="text-danger"><?php echo $erro ?></p>

                <button type="submit" class="btn btn-primary mb-3">Entrar</button>
            </div>


        </form>
    </main>
</body>
</html>