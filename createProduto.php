<?php 

    include('header.php');

    //Declarando variáveis com o valor padrão delas
    $erro_nomeProduto = false; 
    $erro_preco = false;
    $erro_foto = false;
    $mostrarMensagens = false;
    $nomeFoto = "";
    $classNomeProduto = ""; 
    $valueNomeProduto = "";
    $classPreco = "";
    $valuePreco = "";
    $classFoto = "";
    $valueFoto = "";

    //Validando se houve envio do formulário
    if($_POST) {
        //Verificando se o campo nomeProduto veio vazio (empty = tá vazio?)
        if(empty($_POST['nomeProduto'])) { 
            //Se estiver vazio define que existe um erro e atribui a uma variável uma classe de erro do bootstrap
            $erro_nomeProduto = true; 
            $classNomeProduto = "is-invalid"; //Armazena a classe de erro do bootstrap caso tenha erro
        } else {
            //Se não estiver vazio coloca o valor do $_POST em uma variável
            $valueNomeProduto = $_POST['nomeProduto'];
        }
    
        if(empty($_POST['preco'])) {
            $erro_preco = true;
            $classPreco = "is-invalid"; 
        } else {
            $valuePreco = $_POST['preco'];
        }

        if(empty($_FILES['foto']['size'])) {
            $erro_foto = true;
            $classFoto = "is-invalid";
        } else {
            $valueFoto = $_FILES['foto'];
        }

        //Verificando se não existe erros
        if(!$erro_nomeProduto && !$erro_preco && !$erro_foto) {

            //Verificando se houve erro no carregamento da imagem através do input
            if($_FILES['foto']['error'] == 0) {
    
                //Criando variável para guadar o valor que eu quero e usar em outros lugares usando a variável
                $nomeFoto = $_FILES['foto']['name'];
                $caminhoTmp = $_FILES['foto']['tmp_name'];
    
                //Move o arquivo do local temporário para a pasta desejada
                //Recebe 2 parametros, (caminho temporário, caminho pra onde ele vai . nome do arquivo)
                move_uploaded_file($caminhoTmp, './assets/img/' . $nomeFoto);
            }
            
            //Pegando todo conteúdo do arquivo json
            $produtosJson = file_get_contents('./includes/produtos.json');
    
            //Pegando o que era json e transformando em array
            $arrayProdutos = json_decode($produtosJson, true);

            //Criando o id
            //Se $arrayProdutos estiver vazio 
            if(empty ($arrayProdutos)) {
                $id = 1;
            } else {
                //end() é uma função do php que pega o último índice do array passado como parâmetro
                $id = end($arrayProdutos) ['id'] + 1; 
            }
            
            //Prevenindo a malandragem e pegando as informações dos novos produtos
            $novoProduto = [
                'id' => $id, 
                'nomeProduto' => $_POST['nomeProduto'],
                'descricaoProduto' => $_POST['descricaoProduto'],
                'preco' => $_POST['preco'],
                'foto' => $nomeFoto
            ];

            //Adicionando itens novos no array antigo
            $arrayProdutos[$id] = $novoProduto;
    
            //Transformando o array em json e adicionando em uma variável nova
            $novoProdutosJson = json_encode($arrayProdutos);
    
            //Salvando no arquivo json
            $salvou = file_put_contents('./includes/produtos.json', $novoProdutosJson);
            
            //Se salvou alguma coisa, redireciona pra tela inicial
            if($salvou) {
            	header('Location: indexProdutos.php'); 
            }
        }

    }

?>

    <main class="container text-center">

        <form action="" method="POST" enctype="multipart/form-data">

            <div class="row d-flex flex-column align-items-center my-3">

                <div class="form-group col-6">
                    <label for="nomeProduto">Nome do Produto</label>
                    <input type="text" class="form-control <?= $classNomeProduto //Imprime a classe de erro do bootstrap ?>" name="nomeProduto" id="nomeProduto" value="<?= $valueNomeProduto //Imprime o valor atual no campo ?>">
                    <?php 
                    //Verificando se tem algum erro no preenchimento do campo para imprimir o erro
                    if($erro_nomeProduto): 
                    ?>
                    <div class="invalid-feedback">Nome do produto inválido</div>
                    <?php endif ?>  
                </div>

                <div class="form-group col-6">
                    <label for="descricaoProduto">Descrição do Produto</label>
                    <textarea id="descricaoProduto" name="descricaoProduto" class="form-control"></textarea>
                </div>

                <div class="form-group col-6">
                    <label for="preco">Preço</label>
                    <input type="number" class="form-control <?php echo $classPreco ?>" name="preco" id="preco" value="<?php echo $valuePreco ?>">
                    <?php if($erro_preco): ?>
                    <div class="invalid-feedback">Preço inválido</div>
                    <?php endif ?>  
                </div>

                <div class="custom-file col-6">
                    <input name="foto" type="file" class="custom-file-input <?php echo $classFoto ?>" id="foto" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="foto">Selecione a foto</label>
                    <?php if($erro_foto): ?>
                    <div class="invalid-feedback">Foto inválida</div>
                    <?php endif ?>  
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar produto</button>

        </form>

    </main>
    
    <footer></footer>
</body>
</html>