<?php

    require_once("../../models/actors.php");

    function getActor($id): array {
        $actor = Actor::getActor($id);
        return [
            "id" => $actor->getId(),
            "name" => $actor->getName(),
            "surnames" => $actor->getSurnames(),
            "birthDate" => $actor->getBirthDate(),
            "nationality" => $actor->getNationality(),
        ];
    }

    function getAllActors(): array {
        $data = Actor::getAllActors();
        //Devuelve array de arrays asociativos con id, nombre y apellidos
        //Se debe transformar para que devuelva id y nombre completo en 'nombre'
        $result = [];
        foreach($data as $actor) {
            $result[] = [
                "id" => $actor['id'],
                "name" => $actor['name'] . ' ' . $actor['surnames']
            ];
        }
        return $result;
    }

    function createActor($name, $surnames, $birthDate, $nationality): string { 
        $actor = new Actor(0, $name);
        return $actor->set($name, $surnames, $birthDate, $nationality);
    }

    function updateActor($id, $name, $surnames, $birthDate, $nationality): string { 
        $actor = Actor::getActor($id);
        return $actor->set($name, $surnames, $birthDate, $nationality);
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? null;
    switch ($action) {
        case "create":
            $name = $_POST['name'] ?? '';
            $surnames = $_POST['surname'] ?? '';
            $birthDate = $_POST['birthDate'] ?? '21-12-2025';
            $nationality = $_POST['nationality'] ?? '';
            $result = createActor($name, $surnames, $birthDate, $nationality);
            if ($result === "OK") {
                header("Location: ../../views/actors/list.php?success=" . urlencode("Se ha creado correctamente el actor"));
            } else {
                header("Location: ../../views/actors/create.php?error=" . urlencode($result));
            }
            break;
        case "update":
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $surnames = $_POST['surname'] ?? '';
            $birthDate = $_POST['birthDate'] ?? '21-12-2025';
            $nationality = $_POST['nationality'] ?? '';
            $result = updateActor($id, $name, $surnames, $birthDate, $nationality);
            if ($result === "OK") {
                header("Location: ../../views/actors/list.php?success=" . urlencode("Se ha actualizado correctamente el actor"));
            } else {
                header("Location: ../../views/actors/update.php?error=" . urlencode($result));
            }
            break;

        case "delete":
            $id = $_POST['id'] ?? '';
            $result = Actor::deleteActor($id);
            if($result === "OK") {
                 header("Location: ../../views/actors/list.php?success=" . urlencode("Se ha eliminado correctamente el actor"));
            } else {
                header("Location: ../../views/actors/list.php?error=" . urlencode($result));
            }
    }
}