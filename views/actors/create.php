<?php

require_once("../../controllers/actor/actor.php");
// Datos simulados (normalmente vendrían de la BD)
// Parámetros para la vista genérica
$title = "Nuevo Actor";
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
        "title" => "Apellidos",
        "type" => "text",
        "currValue" => "",
        "values" => [],
        "id" => "surname"
    ],
    [
        "title" => "Fecha de Nacimiento",
        "type" => "date",
        "currValue" => "",
        "values" => [],
        "id" => "birthDate"
    ],
    [
        "title" => "Nacionalidad",
        "type" => "text",
        "currValue" => "",
        "values" => [],
        "id" => "nationality"
    ]
];
$urlCancel = "list.php";
$urlSubmit = "../../controllers/actor/actor.php?action=create";

if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?= $_GET['error'] ?>
    </div>
<?php endif;

// Cargar la vista genérica
include "../templateForm.php";