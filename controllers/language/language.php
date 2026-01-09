<?php

    require_once("../../models/languages.php");

    function getLanguage($id): array {
        $language = Language::getLanguage($id);
        return [
            "id" => $language->getId(),
            "name" => $language->getName(),
            "iso_code" => $language->getIsoCode(),
        ];
    }

    function getAllLanguages(): array {
        $data = Language::getAllLanguage();
        //Devuelve array de arrays asociativos con id, nombre y apellidos
        //Se debe transformar para que devuelva id y nombre completo en 'nombre'
        $result = [];
        foreach($data as $language) {
            $result[] = [
                "id" => $language['id'],
                "name" => $language['name'],
            ];
        }
        return $result;
    }

    function createLanguage($name, $iso_code): string { 
        $language = new Language(0, $name);
        return $language->set($name, $iso_code);
    }

    function updateLanguage($id, $name, $iso_code): string { 
        $language = Language::getLanguage($id);
        return $language->set($name, $iso_code);
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? null;
    switch ($action) {
        case "create":
            $name = $_POST['name'] ?? '';
            $iso_code = $_POST['iso_code'] ?? '';
            $result = createLanguage($name, $iso_code);
            if ($result === "OK") {
                header("Location: ../../views/languages/list.php?success=" . urlencode("Se ha creado correctamente el idioma"));
            } else {
                header("Location: ../../views/languages/create.php?error=" . urlencode($result));
            }
            break;
        case "update":
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $iso_code = $_POST['iso_code'] ?? '';
            $result = updateLanguage($id, $name, $iso_code);
            if ($result === "OK") {
                header("Location: ../../views/languages/list.php?success=" . urlencode("Se ha actualizado correctamente el idioma"));
            } else {
                header("Location: ../../views/languages/update.php?id=" . $id . "&error=" . urlencode($result));
            }
            break;

        case "delete":
            $id = $_POST['id'] ?? '';
            $result = Language::deleteLanguage($id);
            if ($result === "OK") {
                header("Location: ../../views/languages/list.php?success=" . urlencode("Se ha eliminado correctamente el idioma"));
            } else {
                header("Location: ../../views/languages/list.php?error=" . urlencode($result));
            }
            break;
    }
}