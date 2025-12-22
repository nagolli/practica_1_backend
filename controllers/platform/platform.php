<?php
    require_once("../../models/platforms.php");

    function getPlatform($id): array {
        $platform = Platform::getPlatform($id);
        return [
            "id" => $platform->getId(),
            "name" => $platform->getName()
        ];
    }

    function getAllPlatforms(): array {
        return Platform::getAllPlatforms();
    }

    function createPlatform($name): string { 
        $platform = new Platform(0, $name);
        return $platform->set($name);
    }

    function updatePlatform($id, $name): string { 
        $platform = Platform::getPlatform($id);
        return $platform->set($name);
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? null;
    switch ($action) {
        case "create":
            $name = $_POST['name'] ?? '';
            $result = createPlatform($name);
            if ($result === "OK") {
                header("Location: ../../views/platforms/list.php?success=" . urlencode("Se ha creado correctamente la plataforma"));
            } else {
                header("Location: ../../views/platforms/create.php?error=" . urlencode($result));
            }
            break;
        case "update":
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $result = updatePlatform($id, $name);
            if ($result === "OK") {
                header("Location: ../../views/platforms/list.php?success=" . urlencode("Se ha actualizado correctamente la plataforma"));
            } else {
                header("Location: ../../views/platforms/update.php?error=" . urlencode($result));
            }
            break;

        case "delete":
            $id = $_POST['id'] ?? '';
            Platform::deletePlatform($id);
            header("Location: ../../views/platforms/list.php?success=" . urlencode("Se ha eliminado correctamente la plataforma"));
            break;
    }
}