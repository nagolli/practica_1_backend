<?php
// templateList.php
// Espera: $title, $column, $data, $urlNew, $urlEdit, $urlErase
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><?=$title?></h2>
        <a href=<?=$urlNew?> class="btn btn-primary">Nuevo</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th><?= $column ?></th>
                <th style="width: 120px;">Editar</th>
                <th style="width: 120px;">Borrar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><?= $row["nombre"] ?></td>
                    <td>
                        <a href="<?= $urlEdit ?>?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    </td>
                    <td>
                        <a href="<?= $urlErase ?>?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>