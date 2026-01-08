<?php

require_once("../../controllers/actor/actor.php");
$actors = getAllActors();

// Parámetros para la vista genérica
$title = "Listado de Actores";
$column = "Nombre";
$data = $actors;
$urlNew = "create.php";
$urlEdit = "update.php";
$urlErase = "../../controllers/actor/actor.php?action=delete";

// Cargar la vista genérica
include "../templateList.php";