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
    <script>
    function confirmDelete() {
        return confirm("¿Seguro que quieres borrar este registro?");
    }
</script>
</head>
<body class="bg-light">

<div class="container mt-5">

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_GET['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_GET['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

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
                    <td><?= $row["name"] ?></td>
                    <td>
                        <form action="<?= $urlEdit ?>" method="POST">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        </form>
                    </td>
                    <td>
                        <form action="<?= $urlErase ?>" method="POST" onsubmit="return confirmDelete()">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Borrar</a>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</html>