<?php

    require_once("../../models/directors.php");

    function getDirector($id): array {
        $director = Director::getDirector($id);
        return [
            "id" => $director->getId(),
            "name" => $director->getName(),
            "surnames" => $director->getSurnames(),
            "birthDate" => $director->getBirthDate(),
            "nationality" => $director->getNationality(),
        ];
    }

    function getAllDirectors(): array {
        $data = Director::getAllDirectors();
        //Devuelve array de arrays asociativos con id, nombre y apellidos
        //Se debe transformar para que devuelva id y nombre completo en 'nombre'
        $result = [];
        foreach($data as $director) {
            $result[] = [
                "id" => $director['id'],
                "name" => $director['name'] . ' ' . $director['surnames']
            ];
        }
        return $result;
    }

    function createDirector($name, $surnames, $birthDate, $nationality): string { 
        $director = new Director(0, $name);
        return $director->set($name, $surnames, $birthDate, $nationality);
    }

    function updateDirector($id, $name, $surnames, $birthDate, $nationality): string { 
        $director = Director::getDirector($id);
        return $director->set($name, $surnames, $birthDate, $nationality);
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? null;
    switch ($action) {
        case "create":
            $name = $_POST['name'] ?? '';
            $surnames = $_POST['surname'] ?? '';
            $birthDate = $_POST['birthDate'] ?? '21-12-2025';
            $nationality = $_POST['nationality'] ?? '';
            $result = createDirector($name, $surnames, $birthDate, $nationality);
            if ($result === "OK") {
                header("Location: ../../views/directors/list.php");
            } else {
                header("Location: ../../views/directors/create.php?error=" . urlencode($result));
            }
            break;
        case "update":
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $surnames = $_POST['surname'] ?? '';
            $birthDate = $_POST['birthDate'] ?? '21-12-2025';
            $nationality = $_POST['nationality'] ?? '';
            $result = updateDirector($id, $name, $surnames, $birthDate, $nationality);
            if ($result === "OK") {
                header("Location: ../../views/directors/list.php");
            } else {
                header("Location: ../../views/directors/update.php?error=" . urlencode($result));
            }
            break;

        case "delete":
            $id = $_POST['id'] ?? '';
            Director::deleteDirector($id);
            header("Location: ../../views/directors/list.php");
            break;
    }
}