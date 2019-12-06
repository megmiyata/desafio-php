<?php 

    if(empty ($_GET['id'])){
        header('Location: indexProdutos.php');
    }

    include('header.php');

    $produtosJson = file_get_contents('./includes/produtos.json');

    $arrayProdutos = json_decode($produtosJson, true);

    $produtos = $arrayProdutos[$_GET['id']];

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
    $valueDescricao = "";

    
    if($_POST) {
        if(empty($_POST['nomeProduto'])) { 
            $erro_nomeProduto = true; 
            $classNomeProduto = "is-invalid"; 
        } else {
            $valueNomeProduto = $_POST['nomeProduto'];
        }
    
        if(empty($_POST['preco'])) {
            $erro_preco = true;
            $classPreco = "is-invalid"; 
        } else {
            $valuePreco = $_POST['preco'];
        }

        if(!$erro_nomeProduto && !$erro_preco) {

            if($_FILES['foto']['error'] == 0) {
                $nomeFoto = $_FILES['foto']['name'];
                $caminhoTmp = $_FILES['foto']['tmp_name'];

                move_uploaded_file($caminhoTmp, './assets/img/' . $nomeFoto);
            } else {
                $nomeFoto = $produtos['foto'];
            }

            $produtos = [
                'id' => $_GET['id'], 
                'nomeProduto' => $_POST['nomeProduto'],
                'descricaoProduto' => $_POST['descricaoProduto'],
                'preco' => $_POST['preco'],
                'foto' => $nomeFoto
            ];

            $arrayProdutos[$_GET['id']] = $produtos;
    
            $novoProdutosJson = json_encode($arrayProdutos);

            $salvou = file_put_contents('./includes/produtos.json', $novoProdutosJson);
            
            
            if($salvou) {
            	header('Location: indexProdutos.php'); 
            }
        }

    } else {

        $valueNomeProduto = $produtos['nomeProduto'];
        $valuePreco = $produtos['preco'];
        $valueDescricao = $produtos['descricaoProduto'];
    }

?>

    <main class="container text-center">

        <form action="" method="POST" enctype="multipart/form-data">

            <div class="row d-flex flex-column align-items-center my-3">

                <div class="form-group col-6">
                    <label for="nomeProduto">Nome do Produto</label>
                    <input type="text" class="form-control <?= $classNomeProduto ?>" name="nomeProduto" id="nomeProduto" value="<?= $valueNomeProduto //Imprime o valor atual no campo ?>">
                    <?php 
                    if($erro_nomeProduto): 
                    ?>
                    <div class="invalid-feedback">Nome do produto inválido</div>
                    <?php endif ?>  
                </div>

                <div class="form-group col-6">
                    <label for="descricaoProduto">Descrição do Produto</label>
                    <textarea id="descricaoProduto" name="descricaoProduto" class="form-control"><?php echo $valueDescricao ?></textarea>
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
    
</body>
</html>