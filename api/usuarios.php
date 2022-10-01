<?php
include_once("../models/usuario.php");

//Listar
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $id = (isset($_GET["id"])) ? $_GET["id"] : 0;

    if ($id == 0){
        $list = Usuario::list();

        header("HTTP/1.1 200 OK");
        echo json_encode($list);
    } else {
        $usuario = Usuario::getbyId($id);

        header("HTTP/1.1 200 OK");
        echo json_encode($usuario[0]);
    }
    exit();
}

// Gravar
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $usuario = new Usuario();

    $usuario->id = $_POST["id"];
    $usuario->nome = $_POST["nome"];
    $usuario->email = $_POST["email"];
    $usuario->senha = $_POST["senha"];
    $usuario->status = $_POST["status"];

    $$usuario->id = $usuario->save();

    header("HTTP/1.1 200 OK");
    echo json_encode($usuario);
    exit();
}

// Atualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $usuario = new Usuario();

    $usuario->id = $_GET["id"];
    $usuario->nome = $_GET["nome"];
    $usuario->email = $_GET["email"];
    $usuario->senha = $_GET["senha"];
    $usuario->status = $_GET["status"];

    $usuario->id = $usuario->save();

    header("HTTP/1.1 200 OK");
    echo json_encode($usuario);
    exit();
}

//Excluir
if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    Usuario::delete($_GET['id']);

    header("HTTP/1.1 200 OK");
    echo json_encode(array('status'=>'Registro Excluido'));

	exit();
}


?>