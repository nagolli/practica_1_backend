<?php

require_once("../../controllers/actor/actor.php");
// Datos simulados (normalmente vendrían de la BD)
$actors = getAllActors();

// Parámetros para la vista genérica
$title = "Listado de Actores";
$column = "Nombre";
$data = $actors;
$urlNew = "create.php";
$urlEdit = "editarActor.php";
$urlErase = "borrarActor.php";

// Cargar la vista genérica
include "../templateList.php";