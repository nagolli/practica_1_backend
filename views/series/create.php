<?php
require_once("../../controllers/series/series.php");
require_once("../../controllers/platform/platform.php");
require_once("../../controllers/director/director.php");
require_once("../../controllers/actor/actor.php");
require_once("../../controllers/language/language.php");
// Parámetros para la vista genérica
$title = "Nueva Serie";
$create = true;
$platforms = getAllPlatforms();
$directors = getAllDirectors();
$actors = getAllActors();
$languages = getAllLanguages();
$data = [
    [
        "title" => "Titulo",
        "type" => "text",
        "currValue" => "",
        "values" => [],
        "id" => "title"
    ],
    [
        "title" => "Plataforma",
        "type" => "select",
        "currValue" => "",
        "values" => $platforms,
        "id" => "idPlatform"
    ],
    [
        "title" => "Idioma original",
        "type" => "select",
        "currValue" => [],
        "values" => $languages,
        "id" => "idLanguageOriginal"
    ],
    [
        "title" => "Otros idiomas de audio",
        "type" => "multiSelect",
        "currValue" => [],
        "values" => $languages,
        "id" => "idAudioLanguages"
    ],
    [
        "title" => "Otros idiomas de subtitulos",
        "type" => "multiSelect",
        "currValue" => [],
        "values" => $languages,
        "id" => "idSubtitleLanguages"
    ],
    [
        "title" => "Director",
        "type" => "select",
        "currValue" => "",
        "values" => $directors,
        "id" => "idDirector"
    ],
    [
        "title" => "Protagonista",
        "type" => "select",
        "currValue" => "",
        "values" => $actors,
        "id" => "idActorProtagonist"
    ],
    [
        "title" => "Actores de reparto",
        "type" => "multiSelect",
        "currValue" => "",
        "values" => $actors,
        "id" => "idActors"
    ]
];
$urlCancel = "list.php";
$urlSubmit = "../../controllers/series/series.php?action=create";

if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">    
        <?= $_GET['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php endif;

// Cargar la vista genérica
include "../templateForm.php";