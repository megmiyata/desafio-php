<?php 

    if(empty ($_GET['id'])){
        header('Location: createUsuario.php');
    }

    include('header.php');

    $usuariosJson = file_get_contents('./includes/usuarios.json');

    $arrayUsuarios = json_decode($usuariosJson, true);

    unset($arrayUsuarios[$_GET['id']]);

    $usuariosJson = json_encode($arrayUsuarios);

    $salvou = file_put_contents('./includes/usuarios.json', $usuariosJson );
            
    if($salvou) {
        header('Location: createUsuario.php'); 
    }
?>
