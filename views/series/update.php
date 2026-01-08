<?php
require_once("../../controllers/series/series.php");
require_once("../../controllers/platform/platform.php");
require_once("../../controllers/director/director.php");
require_once("../../controllers/actor/actor.php");
require_once("../../controllers/language/language.php");
// Parámetros para la vista genérica

// Aceptar id por POST (desde lista) o por GET (tras redirección con error)
$id = $_POST['id'] ?? $_GET['id'] ?? null;
if ($id === null || $id === '') {
    header("Location: list.php");
    exit;
}
// Si venimos por GET, propagar el id a POST para que lo recoja el TemplateForm
if (!isset($_POST['id']) && isset($_GET['id'])) {
    $_POST['id'] = $_GET['id'];
}

$info = getSeries($id);
$title = "Editar Serie";
$create = false;
$platforms = getAllPlatforms();
$directors = getAllDirectors();
$actors = getAllActors();
$languages = getAllLanguages();
$data = [
    [
        "title" => "Titulo",
        "type" => "text",
        "currValue" => $info["title"],
        "values" => [],
        "id" => "title"
    ],
    [
        "title" => "Plataforma",
        "type" => "select",
        "currValue" => $info["idPlatform"],
        "values" => $platforms,
        "id" => "idPlatform"
    ],
    [
        "title" => "Idioma original",
        "type" => "select",
        "currValue" => $info["idAudioLanguageOriginal"],
        "values" => $languages,
        "id" => "idLanguageOriginal"
    ],
    [
        "title" => "Otros idiomas de audio",
        "type" => "multiSelect",
        "currValue" => $info["idAudioLanguages"],
        "values" => $languages,
        "id" => "idAudioLanguages"
    ],
    [
        "title" => "Otros idiomas de subtitulos",
        "type" => "multiSelect",
        "currValue" => $info["idSubtitleLanguages"],
        "values" => $languages,
        "id" => "idSubtitleLanguages"
    ],
    [
        "title" => "Director",
        "type" => "select",
        "currValue" => $info["idDirector"],
        "values" => $directors,
        "id" => "idDirector"
    ],
    [
        "title" => "Protagonista",
        "type" => "select",
        "currValue" => $info["idActorProtagonist"],
        "values" => $actors,
        "id" => "idActorProtagonist"
    ],
    [
        "title" => "Actores",
        "type" => "multiSelect",
        "currValue" => $info["idActors"],
        "values" => $actors,
        "id" => "idActors"
    ]
];
$urlCancel = "list.php";
$urlSubmit = "../../controllers/series/series.php?action=update";

if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">    
        <?= $_GET['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php endif;

// Cargar la vista genérica
include "../templateForm.php";
