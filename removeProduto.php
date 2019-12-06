<?php 

    if(empty ($_GET['id'])){
        header('Location: indexProdutos.php');
    }

    include('header.php');

    $produtosJson = file_get_contents('./includes/produtos.json');

    $arrayProdutos = json_decode($produtosJson, true);

    unlink('./assets/img/' . $arrayProdutos[$_GET['id']]['foto']);

    unset($arrayProdutos[$_GET['id']]);

    $produtosJson = json_encode($arrayProdutos);

    $salvou = file_put_contents('./includes/produtos.json', $produtosJson );
            
    //Se salvou alguma coisa, redireciona pra tela inicial
    if($salvou) {
        header('Location: indexProdutos.php'); 
    }
?>
