
<?php
require_once("../../controllers/language/language.php");
// Parámetros para la vista genérica

$info = getLanguage($_POST['id']);
$title = "Editar Idioma";
$create = false;
$data = [
    [
        "title" => "Nombre",
        "type" => "text",
        "currValue" => $info["name"],
        "values" => [],
        "id" => "name"
    ],
    [
        "title" => "Código ISO",
        "type" => "text",
        "currValue" => $info["iso_code"],
        "values" => [],
        "id" => "iso_code"
    ]
];
$urlCancel = "list.php";
$urlSubmit = "../../controllers/language/language.php?action=update";

if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?= $_GET['error'] ?>
    </div>
<?php endif;

// Cargar la vista genérica
include "../templateForm.php";
