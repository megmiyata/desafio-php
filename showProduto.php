<?php 

    if(empty ($_GET['id'])){
        header('Location: indexProdutos.php');
    }

    include('header.php');

    $produtosJson = file_get_contents('./includes/produtos.json');

    $arrayProdutos = json_decode($produtosJson, true);

    $produtos = $arrayProdutos[$_GET['id']];
?>

    <div class="container">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Produto</th>
                    <th>Descrição do Produto</th>
                    <th>Preço</th>
                    <th>Foto</th>
                    <th>Excluir produto</th>

                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="v-align"><?php echo $produtos['id'] ?></td>
                    <td class="v-align"><?php echo $produtos['nomeProduto'] ?></td>
                    <td class="v-align"><?php echo $produtos['descricaoProduto'] ?></td>
                    <td class="v-align"><?php echo $produtos['preco'] ?></td>
                    <td class="v-align"> <img width="100" src="assets/img/<?php echo $produtos['foto'] ?>"></td>
                    <td>
                        <a class="btn btn-primary" href="http://localhost/desafio-php/removeProduto.php?id=<?= $produtos['id'] ?>">Excluir</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
</body>
</html>

