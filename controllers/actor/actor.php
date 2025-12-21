<?php
    require_once("../../models/actors.php");

    function getAllActors(): array {
        $data = Actor::getAllActors();
        //Devuelve array de arrays asociativos con id, nombre y apellidos
        //Se debe transformar para que devuelva id y nombre completo en 'nombre'
        $result = [];
        foreach($data as $actor) {
            $result[] = [
                "id" => $actor['id'],
                "nombre" => $actor['name'] . ' ' . $actor['surnames']
            ];
        }
        return $result;
    }

    function createActor($name, $surnames, $birthDate, $nationality): string { 
        $actor = new Actor(0, $name, $surnames);
        $return = $actor->set($name, $surnames, $birthDate, $nationality);
        return $return;
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    print_r($_POST);
    $action = $_GET['action'] ?? null;
    switch ($action) {
        case "create":
            $name = $_POST['name'] ?? '';
            $surnames = $_POST['surname'] ?? '';
            $birthDate = $_POST['birthDate'] ?? '21-12-2025';
            $nationality = $_POST['nationality'] ?? '';
            $result = createActor($name, $surnames, $birthDate, $nationality);
            if ($result === "OK") {
                header("Location: ../../views/actors/list.php");
            } else {
                header("Location: ../../views/actors/create.php?error=" . urlencode($result));
            }
            break;
        case "delete":
            $id = $_POST['id'] ?? '';
            Actor::deleteActor($id);
            header("Location: ../../views/actors/list.php");
            break;
    }
}