<?php 

    include('header.php');

?>


    <div class="container">

        <h3 class="my-3">Lista de Produtos</h3>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Produto</th>
                    <th>Descrição do Produto</th>
                    <th>Preço</th>
                    <th>Detalhes do Produto</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                    $produtosJson = file_get_contents('./includes/produtos.json');
        
                    $arrayProdutos = json_decode($produtosJson, true);

                    foreach($arrayProdutos as $produtos) { 
                        ?>
                        <tr>
                            <td><?= $produtos['id'] ?></td>
                            <td><?= $produtos['nomeProduto'] ?></td>
                            <td><?= $produtos['descricaoProduto'] ?></td>
                            <td><?= $produtos['preco'] ?></td>
                            <td>
                                <a class="btn btn-primary" href="http://localhost/desafio-php/showProduto.php?id=<?= $produtos['id'] ?>">Ver</a>
                                <a class="btn btn-primary" href="http://localhost/desafio-php/editProduto.php?id=<?= $produtos['id'] ?>">Editar</a>
                            </td>
                        </tr>
                        <?php 
                    } 
                ?>
                
            </tbody>
        </table>
    </div>
    

</body>
</html>