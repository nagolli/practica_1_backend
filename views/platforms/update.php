<?php
require_once("../../controllers/platform.php");

$info = getPlatform($_POST['id']);
$title = "Editar Plataforma";
$create = false;
$data = [
    [
        "title" => "Nombre",
        "type" => "text",
        "currValue" => $info["name"],
        "values" => [],
        "id" => "name"
    ]
];
$urlCancel = "list.php";
$urlSubmit = "../../controllers/platform.php?action=update";

if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?= $_GET['error'] ?>
    </div>
<?php endif;

// Cargar la vista genérica
include "../templateForm.php";