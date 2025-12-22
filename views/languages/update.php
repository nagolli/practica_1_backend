
<?php
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

$info = getLanguage($id);
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
