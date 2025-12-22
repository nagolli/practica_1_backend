<?php

require_once("../../controllers/director/director.php");
// Datos simulados (normalmente vendrían de la BD)
$directors = getAllDirectors();

// Parámetros para la vista genérica
$title = "Listado de Directores";
$column = "Nombre";
$data = $directors;
$urlNew = "create.php";
$urlEdit = "update.php";
$urlErase = "../../controllers/director/director.php?action=delete";

// Cargar la vista genérica
include "../templateList.php";