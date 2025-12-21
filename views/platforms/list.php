<?php
require_once("../../controllers/platform.php");
$platforms = getAllPlatforms();

// Parámetros para la vista genérica
$title = "Listado de Plataformas";
$column = "Nombre";
$data = $platforms;
$urlNew = "create.php";
$urlEdit = "update.php";
$urlErase = "../../controllers/platform.php?action=delete";

// Cargar la vista genérica
include "../templateList.php";