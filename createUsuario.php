<?php 

    include('header.php');

    //Declarando variáveis com o valor padrão delas
    $erro_nomeUsuario = false; 
    $erro_email = false;
    $erro_senha = false;
    $mostrarMensagens = false;
    $classNomeUsuario = "";
    $valueNomeUsuario = "";
    $classEmail = "";
    $valueEmail = "";
    $classSenha = "";

    if($_POST) {
        //Verificando se o campo nomeUsuario veio vazio (empty = tá vazio?)
        if(empty($_POST['nomeUsuario'])) { 
            //Se estiver vazio define que existe um erro e atribui a uma variável uma classe de erro do bootstrap
            $erro_nomeUsuario = true;
            $classNomeUsuario = "is-invalid";
        } else {
            //Se não estiver vazio coloca o valor do $_POST em uma variável
            $valueNomeUsuario = $_POST['nomeUsuario'];
        }
    
        if(empty($_POST['email'])) {
            $erro_email = true;
            $classEmail = "is-invalid";
        } else {
            $valueEmail = $_POST['email'];
        }

        if(empty($_POST['senha']) || empty($_POST['confirmaSenha']) || $_POST['senha'] != $_POST['confirmaSenha'] || strlen($_POST['senha']) < 6) {
            $erro_senha = true;
            $classSenha = "is-invalid";
        } 

        $usuariosJson = file_get_contents('./includes/usuarios.json');
        $usuariosArray = json_decode($usuariosJson, true);

        if(!$erro_email && !$erro_senha) {
            if(empty ($usuariosArray)) {
                $id = 1;
            } else {
                //end() é uma função do php que pega o último índice do array passado como parâmetro
                $id = end($usuariosArray) ['id'] + 1; 
            }
            $novoUsuario = [
                'id' => $id,
                'nome' => $_POST['nomeUsuario'],
                'email' => $_POST['email'],
                'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT)
            ];
    
            $usuariosArray[$id] = $novoUsuario;
    
            $novoUsuariosJson = json_encode($usuariosArray);
    
            $cadastrou = file_put_contents('./includes/usuarios.json', $novoUsuariosJson);
    
            if($cadastrou) {
                $valueNomeUsuario = "";
                $valueEmail = "";
            }
        }
    }
?>

    <div class="container">
        <div class="row mt-3">

            <aside class="col-6">
                
                <h3 class="text-center">Lista de usuários</h3>

                <table class="table col-10">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $usuariosJson = file_get_contents('./includes/usuarios.json');
                
                            $arrayUsuarios = json_decode($usuariosJson, true);

                            foreach($arrayUsuarios as $usuario) { 
                                ?>
                                <tr>
                                    <td><?= $usuario['nome'] ?></td>
                                    <td><?= $usuario['email'] ?></td>
                                    <td>
                                        <a class="btn btn-primary" href="http://localhost/desafio-php/editUsuario.php?id=<?= $usuario['id'] ?>">Editar</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="http://localhost/desafio-php/removeUsuario.php?id=<?= $usuario['id'] ?>">Excluir</a>
                                    </td>
                                </tr>
                                <?php 
                            } 
                        ?>
                        
                    </tbody>
                </table>
            </aside>

            <main class="col-6">

                <h3 class="text-center">Cadastro de usuários</h3>

                <form action="" method="POST">

                    <div class="row d-flex flex-column align-items-center my-3">

                        <div class="form-group col-10">
                            <label for="nomeUsuario">Nome</label>
                            <input type="text" class="form-control <?= $classNomeUsuario ?>" name="nomeUsuario" id="nomeUsuario" value="<?= $valueNomeUsuario ?>">
                            <?php if($erro_nomeUsuario): ?>
                            <div class="invalid-feedback">Nome inválido</div>
                            <?php endif ?>  
                        </div>

                        <div class="form-group col-10">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control <?= $classEmail ?>" name="email" id="email" value="<?= $valueEmail ?>">
                            <?php if($erro_email): ?>
                            <div class="invalid-feedback">Email inválido</div>
                            <?php endif ?> 
                        </div>

                        <div class="form-group col-10">
                            <label for="exampleInputPassword1">Senha</label>
                            <input type="password" name="senha" class="form-control <?= $classSenha ?>" id="senha">
                            <small id="help" class="form-text text-muted">Mínimo 6 caracteres</small>
                            <?php if($erro_senha): ?>
                            <div class="invalid-feedback">Senha inválida</div>
                            <?php endif ?> 
                        </div>

                        <div class="form-group col-10">
                            <label for="exampleInputPassword1">Confirmar senha</label>
                            <input type="password" name="confirmaSenha" class="form-control <?= $classSenha ?>" id="senha">
                            <?php if($erro_senha): ?>
                            <div class="invalid-feedback">Senha inválida</div>
                            <?php endif ?> 
                        </div>

                        <button type="submit" class="btn btn-primary mb-3">Cadastrar</button>
                    </div>

                </form>
            </main>

        </div>
    </div>


    <footer></footer>
    
</body>
</html>