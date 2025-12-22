<?php
require_once("../../controllers/language/language.php");
// Parámetros para la vista genérica
$title = "Nuevo Idioma";
$create = true;
$data = [
    [
        "title" => "Nombre",
        "type" => "text",
        "currValue" => "",
        "values" => [],
        "id" => "name"
    ],
    [
        "title" => "Código ISO",
        "type" => "text",
        "currValue" => "",
        "values" => [],
        "id" => "iso_code"
    ]
];
$urlCancel = "list.php";
$urlSubmit = "../../controllers/language/language.php?action=create";

if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?= $_GET['error'] ?>
    </div>
<?php endif;

// Cargar la vista genérica
include "../templateForm.php";