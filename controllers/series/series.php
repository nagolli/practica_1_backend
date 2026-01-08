<?php

    require_once("../../models/series.php");

    function getSeries($id): array {
        $series = Series::getSeries($id);
        return [
            "id" => $series->getId(),
            "title" => $series->getTitle(),
            "idPlatform" => $series->getIdPlatform(),
            "idDirector" => $series->getIdDirector(),
            "idActors" => $series->getIdActors(),
            "idActorProtagonist" => $series->getIdActorProtagonist(),
            "idAudioLanguages" => $series->getIdAudioLanguages(),
            "idSubtitleLanguages" => $series->getIdSubtitleLanguages(),
            "idAudioLanguageOriginal" => $series->getIdAudioLanguageOriginal(),
            "idSubtitleLanguageOriginal" => $series->getIdSubtitleLanguageOriginal()
        ];
    }

    function getAllSeries(): array {
        $data = Series::getAllSeries();
        //Devuelve array de arrays asociativos con id, nombre y apellidos
        //Se debe transformar para que devuelva id y nombre completo en 'nombre'
        $result = [];
        foreach($data as $series) {
            $result[] = [
                "id" => $series['id'],
                "name" => $series['title']
            ];
        }
        return $result;
    }

    function createSeries($title, $idPlatform, $idDirector, $idActors, $idActorProtagonist, $idAudioLanguages, $idSubtitleLanguages, $idAudioLanguageOriginal, $idSubtitleLanguageOriginal): string { 
        $series = new Series(0, $title, $idPlatform, $idDirector, $idActors, $idActorProtagonist, $idAudioLanguages, $idSubtitleLanguages, $idAudioLanguageOriginal, $idSubtitleLanguageOriginal);
        return $series->set($title, $idPlatform, $idDirector, $idActors, $idActorProtagonist, $idAudioLanguages, $idSubtitleLanguages, $idAudioLanguageOriginal, $idSubtitleLanguageOriginal);
    }

    function updateSeries($id, $title, $idPlatform, $idDirector, $idActors, $idActorProtagonist, $idAudioLanguages, $idSubtitleLanguages, $idAudioLanguageOriginal, $idSubtitleLanguageOriginal): string { 
        $series = Series::getSeries($id);
        return $series->set($title, $idPlatform, $idDirector, $idActors, $idActorProtagonist, $idAudioLanguages, $idSubtitleLanguages, $idAudioLanguageOriginal, $idSubtitleLanguageOriginal);
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? null;
    switch ($action) {
        case "create":
            $title = $_POST['title'] ?? '';
            //$idPlatform = $_POST['idPlatform'] ?? 0;
            // true si tiene un valor no vacio (no es '', 0, null)
            $idPlatform = !empty($_POST['idPlatform']) ? $_POST['idPlatform'] : 0;
            //$idDirector = $_POST['idDirector'] ?? 0;
            $idDirector = !empty($_POST['idDirector']) ? $_POST['idDirector'] : 0;
            $idActors = !empty($_POST['idActors']) ? $_POST['idActors'] : [];
            $idActorProtagonist = !empty($_POST['idActorProtagonist']) ? $_POST['idActorProtagonist'] : '';
            $idAudioLanguages = !empty($_POST['idAudioLanguages']) ? $_POST['idAudioLanguages'] : [];
            $idSubtitleLanguages = !empty($_POST['idSubtitleLanguages']) ? $_POST['idSubtitleLanguages'] : [];
            $idLanguageOriginal = !empty($_POST['idLanguageOriginal']) ? $_POST['idLanguageOriginal'] : '';

            $result = createSeries($title, $idPlatform, $idDirector, $idActors, $idActorProtagonist, $idAudioLanguages, $idSubtitleLanguages, $idLanguageOriginal, $idLanguageOriginal);
            if ($result === "OK") {
                header("Location: ../../views/series/list.php?success=" . urlencode("Se ha creado correctamente la serie"));
            } else {
                header("Location: ../../views/series/create.php?error=" . urlencode($result));
            }
            break;
        case "update":
            $id = $_POST['id'] ?? '';
            $title = $_POST['title'] ?? '';
            //$idPlatform = $_POST['idPlatform'] ?? 0;
            // true si tiene un valor no vacio (no es '', 0, null)
            $idPlatform = !empty($_POST['idPlatform']) ? $_POST['idPlatform'] : 0;
            //$idDirector = $_POST['idDirector'] ?? 0;
            $idDirector = !empty($_POST['idDirector']) ? $_POST['idDirector'] : 0;
            $idActors = !empty($_POST['idActors']) ? $_POST['idActors'] : [];
            $idActorProtagonist = !empty($_POST['idActorProtagonist']) ? $_POST['idActorProtagonist'] : '';
            $idAudioLanguages = !empty($_POST['idAudioLanguages']) ? $_POST['idAudioLanguages'] : [];
            $idSubtitleLanguages = !empty($_POST['idSubtitleLanguages']) ? $_POST['idSubtitleLanguages'] : [];
            $idLanguageOriginal = !empty($_POST['idLanguageOriginal']) ? $_POST['idLanguageOriginal'] : '';
            $result = updateSeries($id, $title, $idPlatform, $idDirector, $idActors, $idActorProtagonist, $idAudioLanguages, $idSubtitleLanguages, $idLanguageOriginal, $idLanguageOriginal);
            if ($result === "OK") {
                header("Location: ../../views/series/list.php?success=" . urlencode("Se ha actualizado correctamente la serie"));
            } else {
                header("Location: ../../views/series/update.php?error=" . urlencode($result));
            }
            break;

        case "delete":
            $id = $_POST['id'] ?? '';
            Series::deleteSeries($id);
            header("Location: ../../views/series/list.php?success=" . urlencode("Se ha eliminado correctamente la serie"));
            break;
    }
}