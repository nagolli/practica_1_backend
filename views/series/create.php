<?php
require_once("../../controllers/series/series.php");
require_once("../../controllers/platform/platform.php");
require_once("../../controllers/director/director.php");
// Parámetros para la vista genérica
$title = "Nueva Serie";
$create = true;
$platforms = getAllPlatforms();
$directors = getAllDirectors();
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
        "title" => "Director",
        "type" => "select",
        "currValue" => "",
        "values" => $directors,
        "id" => "idDirector"
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