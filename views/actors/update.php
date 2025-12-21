<?php

require_once("../../controllers/actor/actor.php");
// Datos simulados (normalmente vendrían de la BD)
// Parámetros para la vista genérica

$info = getActor($_POST['id']);
$title = "Editar Actor";
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
        "title" => "Apellidos",
        "type" => "text",
        "currValue" => $info["surnames"],
        "values" => [],
        "id" => "surname"
    ],
    [
        "title" => "Fecha de Nacimiento",
        "type" => "date",
        "currValue" => $info["birthDate"],
        "values" => [],
        "id" => "birthDate"
    ],
    [
        "title" => "Nacionalidad",
        "type" => "text",
        "currValue" => $info["nationality"],
        "values" => [],
        "id" => "nationality"
    ]
];
$urlCancel = "list.php";
$urlSubmit = "../../controllers/actor/actor.php?action=update";

if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?= $_GET['error'] ?>
    </div>
<?php endif;

// Cargar la vista genérica
include "../templateForm.php";