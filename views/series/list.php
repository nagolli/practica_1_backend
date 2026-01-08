<?php
require_once("../../controllers/series/series.php");
$series = getAllSeries();

// Parámetros para la vista genérica
$title = "Listado de Series";
$column = "Título";
$data = $series;
$urlNew = "create.php";
$urlEdit = "update.php";
$urlErase = "../../controllers/series/series.php?action=delete";

// Cargar la vista genérica
//include "../templateList.php";
include "../templateList.php";