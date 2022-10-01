<?php
include_once("../models/perfil.php");


//Listar
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $id = (isset($_GET["id"])) ? $_GET["id"] : 0;
    //$id = $_GET["id"];

    if ($id == 0){
        $list = Perfil::list();

        header("HTTP/1.1 200 OK");
        echo json_encode($list);
    } else {
        $perfil = Perfil::getbyId($id);

        header("HTTP/1.1 200 OK");
        echo json_encode($perfil[0]);
    }
    exit();
}

// Gravar
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $perfil = new Perfil();

    $perfil->id = $_POST["id"];
    $perfil->descricao = $_POST["descricao"];

    $perfil->id = $perfil->save();

    header("HTTP/1.1 200 OK");
    echo json_encode($perfil);
    exit();
}

// Atualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $perfil = new Perfil();

    $perfil->id = $_GET["id"];
    $perfil->descricao = $_GET["descricao"];

    $perfil->id = $perfil->save();

    header("HTTP/1.1 200 OK");
    echo json_encode($perfil);
    exit();
}

//Excluir
if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    Perfil::delete($_GET['id']);

    header("HTTP/1.1 200 OK");
    echo json_encode(array('status'=>'Registro Excluido'));

	exit();
}


?>