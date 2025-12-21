<?php
require_once("../../controllers/platform.php");
// Parámetros para la vista genérica
$title = "Nueva Plataforma";
$create = true;
$data = [
    [
        "title" => "Nombre",
        "type" => "text",
        "currValue" => "",
        "values" => [],
        "id" => "name"
    ]
];
$urlCancel = "list.php";
$urlSubmit = "../../controllers/platform.php?action=create";

if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?= $_GET['error'] ?>
    </div>
<?php endif;

// Cargar la vista genérica
include "../templateForm.php";