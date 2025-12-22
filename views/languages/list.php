<?php

require_once("../../controllers/language/language.php");
// Datos simulados (normalmente vendrían de la BD)
$languages = getAllLanguages();

// Parámetros para la vista genérica
$title = "Listado de Idiomas";
$column = "Nombre";
$data = $languages;
$urlNew = "create.php";
$urlEdit = "update.php";
$urlErase = "../../controllers/language/language.php?action=delete";

// Cargar la vista genérica
include "../templateList.php";